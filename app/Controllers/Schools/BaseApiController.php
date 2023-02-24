<?php

namespace App\Controllers\Schools;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class BaseApiController extends BaseController
{
    protected $helpers = ['form'];

    protected function getSchoolMembersDropdownData() {
        $data = [];
        $schools = model('SchoolModel')->with('members')->findAll();
        $members = model('MemberModel')->with('schools')->findAll();
        foreach($schools as $school){
            $data[$school->id] = [];
            foreach($members as $member) {
                if(!$member->hasSchool($school->id))
                    $data[$school->id][$member->id] = $member->nameWithEmail();
            }
        }
        return $data;
    }

    protected function return_error($errors = []){
        $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);
        foreach($errors as $field => $message) {
            $this->validator->setError($field, $message);
        }
        return $this->validator->listErrors();
    }
}
