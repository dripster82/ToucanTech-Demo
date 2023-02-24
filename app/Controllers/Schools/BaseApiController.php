<?php

namespace App\Controllers\Schools;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class BaseApiController extends BaseController
{
    protected $helpers = ['form'];

/**
 * 
 * Create an array of schools and members available to be used in the add new member Member dropdown 
 * eg
 * $data = [
 *      school1_id => [member1_id, member2_id], 
 *      school2_id => [member1_id, member3_id]
 * ]
 * @return array
 */
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

/**
 * Creates the html for the validation errors
 * 
 * @return string
 */
    protected function return_error($errors = []){
        $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);
        foreach($errors as $field => $message) {
            $this->validator->setError($field, $message);
        }
        return $this->validator->listErrors();
    }
}
