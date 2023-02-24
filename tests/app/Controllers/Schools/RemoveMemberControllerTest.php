<?php

namespace App\Controllers\Schools;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\HTTP\Response;

use CodeIgniter\Test\FeatureTestTrait;


class RemoveMemberControllerTest extends CIUnitTestCase
{
    
    use DatabaseTestTrait, FeatureTestTrait;

    protected $setUpMethods = [
        'resetServices',
        'mockSession',
    ];

    protected $namespace = 'App';
    protected $seed     = 'DemoData';

    public function testRemoveMemberFromASchool() {
        $data = [
            'school' => '2',
            'member' => '2'
        ];

        $result = $this->delete('schools/'.$data['school'].'/remove_member/'.$data['member']);

        $school = model('SchoolModel')->find($data['school']);
        $member = model('MemberModel')->find($data['member']);

        $result->assertIsOk();

        $this->assertTrue(!$school->hasMember($data['member']));
        $this->assertCount(2, $school->members);
        $this->assertSame($school->members[0]->name, 'Jane Doe');
        $this->assertSame($school->members[1]->name, 'Peter Jones');
    }

    public function testValidationWhenPassingAnNonExistingSchool() {
        $data = [
            'school' => '99',
            'member' => '2',
        ];
   
        $result = $this->delete('schools/'.$data['school'].'/remove_member/'.$data['member']);

        $result->assertStatus(Response::HTTP_BAD_REQUEST);
        $result->assertSee('School does not exist');
    }

    public function testValidationWhenPassingAnNonExistingMember() {
        $data = [
            'school' => '1',
            'member' => '99',
        ];
   
        $result = $this->delete('schools/'.$data['school'].'/remove_member/'.$data['member']);
        $result->assertStatus(Response::HTTP_BAD_REQUEST);
        $result->assertSee('Member does not exist');
    }
}
