<?php

namespace App\Controllers\Schools;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class RemoveMemberController extends BaseController
{
    protected $helpers = ['form'];

    protected $base_rules = [
        'school' => 'required|integer|greater_than[0]',
        'member' => 'required|integer|greater_than[0]'
    ];

    protected $school_id;
    protected $member_id;

    public function index($school_id = null, $member_id = null)
    {
        $this->school_id = $school_id;
        $this->member_id = $member_id;
        
        if($this->validateData($this->getData(), $this->base_rules)) {
            $school = $this->getSchool();
            $member = $this->getMember();

            $errors = [];

            if($school == null)
                $errors['school'] = 'School does not exist';
            
            if($member == null)
                $errors['school'] = 'Member does not exist';

            if(count($errors) > 0)
                return $this->return_error($errors);

            if(!$school->hasMember($member->id))
                return $this->return_error(['member' => 'Member is already not assigned to '.$school->name]);

            $school->removeMember($member->id);
            
            return json_encode([
                'school_id'     => $school->id,
                'member_id'     => $member->id,
            ]);
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
    protected function getData() {
        return [
            'school' => $this->school_id,
            'member' => $this->member_id
        ];
    }

    protected function getSchool() {
        return model('SchoolModel')->with('members')->find($this->school_id);
    }

    protected function getMember() {
        return model('MemberModel')->find($this->member_id);
    }
}
