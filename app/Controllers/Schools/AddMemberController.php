<?php

namespace App\Controllers\Schools;

use CodeIgniter\HTTP\Response;

class AddMemberController extends BaseApiController
{
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
        // Validate initially used params
        if($this->validate($this->base_rules)) {
            $school = $this->getSchool();
            if($school != null)
            {

                // Check if we are adding a new member or assigning an existing member
                $member_id = $this->request->getPost('member');
                if($member_id == 'new')
                    $member_id = $this->createMember();

                // if not an id its and error message return
                if(!is_numeric($member_id))
                    return $member_id;

                $member =  model('MemberModel')->find($member_id);

                // check if member exists
                if($member == null)
                    return $this->return_error(
                        [
                            'member' => 'Member was not found, please check the fields and try again.'
                        ]
                    );

                // Add member to school
                if(!$school->hasMember($member_id))
                    $school->addMember($member_id);
                else
                    return $this->return_error(
                        [
                            'member' => 'Member is already assigned to '.$school->name
                        ]
                    );

                $data = [
                    'school_id'         => $school->id,
                    'member_id'         => $member->id,
                    'member_html'       => view('schools/member', ['member' => $member, 'school' => $school]),
                    'school_members'    => $this->getSchoolMembersDropdownData()
                ];

                return json_encode($data);
            }
        }

        return $this->return_error();
    }

/**
 * Create a new Member
 * 
 * @return int|string 
 */
    protected function  createMember() {
        // validate the new member params
        if($this->validate($this->new_member_rules)) {
            $name = $this->request->getPost('name');
            $email_address = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
            $member_model = model('MemberModel');

            $new_member = new \App\Entities\Member;
            $new_member->name = $name;
            $new_member->email_address = $email_address;

            // save member and return the id if successful
            if($member_model->save($new_member))
                return $member_model->getInsertID();

            return $this->return_error(
                [
                    'member' => 'Error occured while adding the new Member, please check the fields and try again.'
                ]
            );
        } else
            return $this->return_error();
    }

/**
 * Create a new Member
 * 
 * @return \App\Entities\School 
 */
    protected function getSchool() {
        $school_id = $this->request->getPost('school', FILTER_SANITIZE_NUMBER_INT);
        return model('SchoolModel')->find($school_id);
    }
}
