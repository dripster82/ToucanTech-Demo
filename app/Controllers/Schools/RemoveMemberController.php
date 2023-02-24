<?php

namespace App\Controllers\Schools;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class RemoveMemberController extends BaseApiController
{
    protected $base_rules = [
        'school' => 'required|integer|greater_than[0]',
        'member' => 'required|integer|greater_than[0]'
    ];

    public function index($school_id = null, $member_id = null)
    {
        $data = [
            'school' => $school_id,
            'member' => $member_id
        ];
        
        if($this->validateData($data, $this->base_rules)) {
            $school = model('SchoolModel')->with('members')->find($school_id);
            $member = model('MemberModel')->find($member_id);

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
            
            $data = [
                'school_id'         => $school->id,
                'member_id'         => $member->id,
                'school_members'    => $this->getSchoolMembersDropdownData()
            ];

            return json_encode($data);
        }

        return $this->return_error();
    }
}
