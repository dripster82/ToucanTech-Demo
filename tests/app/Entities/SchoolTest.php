<?php

namespace App\Entities;


use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class SchoolTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $namespace = 'App';
    protected $seed = 'DemoData';

    public function testCanSaveEntity()
    {
    	$data = ["name"=>"New School"];

    	$SchoolModel = model('SchoolModel');
        $model = new Member;
        $model->fill($data);

        $SchoolModel->save($model);
        $id = $SchoolModel->getInsertID();
        $school = $SchoolModel->find($id);

        $this->assertSame($school->name, $data["name"]);
    }

    public function testCasting() {
    	$data = ["name"=>1234];

        $model = new Member;
        $model->fill($data);

        $this->assertIsString($model->name);
    }

    public function testAddMemeberyId()
    {
        $school = model('SchoolModel')->where('name', 'School 1')->first();
        $member = model('MemberModel')->where('name', 'Simon Doe')->first();

        $this->assertCount(1, $school->members);

        $school->addMember($member->id);

        $school_reloaded = model('SchoolModel')->where('name', 'School 1')->first();

        $this->assertCount(2, $school_reloaded->members);
        $this->assertSame($school_reloaded->members[1]->id, $member->id);
    }

    public function testAddMemberByClass()
    {
        $school = model('SchoolModel')->where('name', 'School 1')->first();
        $member = model('MemberModel')->where('name', 'Simon Doe')->first();

        $this->assertCount(1, $school->members);

        $school->addMember($member);

        $school_reloaded = model('SchoolModel')->where('name', 'School 1')->first();

        $this->assertCount(2, $school_reloaded->members);
        $this->assertSame($school_reloaded->members[1]->id, $member->id);
    }
}
