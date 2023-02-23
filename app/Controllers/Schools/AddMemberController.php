<?php

namespace App\Controllers\Schools;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class AddMemberController extends BaseController
{
    protected $helpers = ['form'];

    protected $base_rules = [
        'school' => [
            'rules'     => 'required|integer|greater_than[0]',
            'errors'    => [
                'required'      => 'A School is required',
                'integer'       => 'Please select a valid School',
                'greater_than'  => 'Please select a valid School'
            ]
        ],
        'member' => [
            'rules'     =>  'required|alpha_numeric',
            'errors'    => [
                'required'      => 'Please select a valid Member',
                'alpha_numeric' =>'Please select a valid Member',
            ]
        ]
    ];

    protected $new_member_rules = [
        'name' => 'required|alpha_numeric_punct',
        'email' => [
            'rules' => 'required|valid_email|is_unique[members.email_address]',
            'errors' => [
                'is_unique'  => 'Email Address already exists',
            ]
        ]
    ];

    public function index()
    {
        if($this->validate($this->base_rules)) {
            $school = $this->getSchool();
            if($school != null)
            {
                $member_id = $this->request->getPost('member');
                if($this->request->getPost('member') == 'new') {
                    //validate and save new member

                    if($this->validate($this->new_member_rules)) {
                        $member_id = $this->createMember(
                            $this->request->getPost('name'),
                            $this->request->getPost('email', FILTER_SANITIZE_EMAIL)
                        );

                        if($member_id === false) 
                            return $this->return_error(
                                [
                                    'member' => 'Error occured while adding the new Member, please check the fields and try again.'
                                ]
                            );
                    } else
                        return $this->return_error();
                    
                }
                $member =  model('MemberModel')->find($member_id);

                if($member == null)
                    return $this->return_error(
                        [
                            'member' => 'Member was not found, please check the fields and try again.'
                        ]
                    );

                if(!$school->hasMember($member_id))
                    $school->addMember($member_id);
                else
                    return $this->return_error(
                        [
                            'member' => 'Member is already assigned to '.$school->name
                        ]
                    );

            
                return json_encode([
                    'school_id'     => $school->id,
                    'member_id'     => $member->id,
                    'member_html'   => view('schools/member', ['member' => $member, 'school' => $school])
                ]);
            }
        }

        return $this->return_error();
    }

    protected function return_error($errors = []){
        $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);
        foreach($errors as $field => $message) {
            $this->validator->setError($field, $message);
        }
        return $this->validator->listErrors();
    }

    protected function  createMember($name, $email_address) {
        $member_model = model('MemberModel');
        $new_member = new \App\Entities\Member;
        $new_member->name = $name;
        $new_member->email_address = $email_address;

        if($member_model->save($new_member))
            return $member_model->getInsertID();
        else
            return false;
    }

    protected function getSchool() {
        $school_id = $this->request->getPost('school', FILTER_SANITIZE_NUMBER_INT);
        return model('SchoolModel')->find($school_id);
    }
}
