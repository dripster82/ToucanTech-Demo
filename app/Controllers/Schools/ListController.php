<?php

namespace App\Controllers\Schools;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class ListController extends BaseController
{
    protected $helpers = ['form'];
    public $error_msg = '';

    public function index($school_focus = null)
    {
        $school_focus_id = 0;
        $members = model('MemberModel')->with('schools')->findAll();
        $schools = model('SchoolModel')->with('members')->findAll();
        $school_names = [0=>'Select School'];
        $school_members = [];

        foreach($schools as $school){
            if(mb_url_title($school->name) == $school_focus)
                $school_focus_id = $school->id;

            $school_names[$school->id] = $school->name;
            $school_members[$school->id] = [];
            foreach($members as $member) {
                if(!$member->hasSchool($school->id))
                    $school_members[$school->id][$member->id] = $member->nameWithEmail();
            }
        }

        return view('schools/list_view', [
            'school_focus_id'   => $school_focus_id,
            'schools'           => $schools, 
            'school_names'      => $school_names,
            'school_members'    => json_encode($school_members)
        ]);
    }
}
