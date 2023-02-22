<?php

namespace App\Entities;


use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class MemberTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $namespace = 'App';
    protected $seed = 'DemoData';

    public function testCanSaveEntity()
    {
    	$school = model('SchoolModel')->where('name', 'School 1')->first();
    	$data = ["name"=>"James Bond", "email_address" => "bond@license.kill"];

    	$memberModel = model('MemberModel');
        $model = new Member;
        $model->name = $data["name"];
        $model->email_address = $data["email_address"];

        $memberModel->save($model);

        $member = model('MemberModel')->where('name', $data["name"])->first();

        $this->assertSame($member->name, $data["name"]);
        $this->assertSame($member->email_address, $data["email_address"]);
    }

    public function testAddSchoolById()
    {
        $school = model('SchoolModel')->where('name', 'Uni 1')->first();
        $member = model('MemberModel')->where('name', 'Simon Doe')->first();

        $this->assertCount(1, $member->schools);

        $member->addSchool($school->id);

        $member_reloaded = model('MemberModel')->where('name', 'Simon Doe')->first();

        $this->assertCount(2, $member_reloaded->schools);
        $this->assertSame($member_reloaded->schools[1]->id, $school->id);
    }

    public function testAddSchoolByClass()
    {
        $school = model('SchoolModel')->where('name', 'Uni 1')->first();
        $member = model('MemberModel')->where('name', 'Simon Doe')->first();

        $this->assertCount(1, $member->schools);

        $member->addSchool($school);

        $member_reloaded = model('MemberModel')->with('schools')->where('name', 'Simon Doe')->first();

        $this->assertCount(2, $member_reloaded->schools);
        $this->assertSame($member_reloaded->schools[1]->id, $school->id);
    }

    public function testCasting() {
    	$data = ["name"=>1234, "email_address" => 5678];

        $model = new Member;
        $model->fill($data);

        $this->assertIsString($model->name);
        $this->assertIsString($model->email_address);
    }
}
