<?php

namespace App\Controllers\Schools;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\HTTP\Response;

use CodeIgniter\Test\FeatureTestTrait;


class AddMemberControllerTest extends CIUnitTestCase
{
    
    use DatabaseTestTrait, FeatureTestTrait;

    protected $setUpMethods = [
        'resetServices',
        'mockSession',
    ];

    protected $namespace = 'App';
    protected $seed     = 'DemoData';

    public function testAddMemberToASchool() {
        $data = [
            'school' => '1',
            'member' => '4'
        ];

        $result = $this->post("schools/add_member", $data);

        $school = model('SchoolModel')->find($data['school']);
        $member = model('MemberModel')->find($data['member']);

        $this->assertTrue($school->hasMember($data['member']));
        $this->assertCount(2, $school->members);
        $this->assertSame($school->members[0]->name, 'Jane Doe');
        $this->assertSame($school->members[1]->name, $member->name);
        $result->assertSee($member->name);
    }

    public function testAddNewMemberToASchool() {
        $data = [
            'school'    => '1',
            'member'    => 'new',
            'name'      => 'Billy Jean',
            'email'     => 'billy@jean.com'
        ];

        $result = $this->post("schools/add_member", $data);

        $school = model('SchoolModel')->find($data['school']);

        $this->assertCount(2, $school->members);
        $this->assertSame($school->members[0]->name, 'Jane Doe');
        $this->assertSame($school->members[1]->name, $data["name"]);
        $result->assertSee($data["name"]);
    }

    public function testValidationWhenPassingAnInvalidNewMember() {
        $data = [
            'school' => '1',
            'member' => 'new',
            'name'   => '',
            'email'  => ''
        ];
   
        $result = $this->post("schools/add_member", $data);

        $result->assertStatus(Response::HTTP_BAD_REQUEST);
        $result->assertSee('The name field is required.');
        $result->assertSee('The email field is required.');
    }

    public function testValidationWhenPassingAnInvalidNewMemberName() {
        $data = [
            'school' => '1',
            'member' => 'new',
            'name'   => '',
            'email'  => 'jeff@jone.com'
        ];
   
        $result = $this->post("schools/add_member", $data);

        $result->assertStatus(Response::HTTP_BAD_REQUEST);
        $result->assertSee('The name field is required.');
    }

    public function testValidationWhenPassingAnInvalidNewMemberEmail() {
        $data = [
            'school' => '1',
            'member' => 'new',
            'name'   => 'Jeff Jones',
            'email'  => 'jeffjone.com'
        ];
   
        $result = $this->post("schools/add_member", $data);
        
        $result->assertStatus(Response::HTTP_BAD_REQUEST);
        $result->assertSee('The email field must contain a valid email address.');
    }

    public function testValidationWhenPassingAnExistingNewMemberEmail() {
        $data = [
            'school' => '1',
            'member' => 'new',
            'name'   => 'Jeff Jones',
            'email'  => 'jane@doe.com'
        ];
   
        $result = $this->post("schools/add_member", $data);

        $result->assertStatus(Response::HTTP_BAD_REQUEST);
        $result->assertSee('Email Address already exists');
    }

    public function testValidationWhenPassingAnInvalidMember() {
        $data = [
            'school' => '1',
            'member' => '9999'
        ];

        $result = $this->post("schools/add_member", $data);

        $result->assertStatus(Response::HTTP_BAD_REQUEST);
        $result->assertSee('Member was not found, please check the fields and try again.');
    }

    public function testValidationWithNoData() {
        $data = [];
        
        $result = $this->post("schools/add_member", $data);

        $result->assertStatus(Response::HTTP_BAD_REQUEST);
        $result->assertSee('A School is required');
        $result->assertSee('Please select a valid Member');
    }
}
