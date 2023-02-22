<?php

namespace App\Models;


use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class SchoolModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $namespace = 'App';
    protected $seed = 'DemoData';

    public function testModelFindAll()
    {
        $model = model('SchoolModel');

        // Get every row created by ExampleSeeder
        $objects = $model->findAll();

        // Make sure the count is as expected
        $this->assertCount(4, $objects);
        $this->assertInstanceOf(\App\Entities\School::class, $objects[1]);
    }

    public function testRelationshipToMembers()
    {
        $model = model('SchoolModel');

        // Get every row created by ExampleSeeder
        $object = $model
                ->with('members')
                ->where('name', 'School 2')
                ->first();

        $this->assertCount(3, $object->members);
        $this->assertInstanceOf(\App\Entities\Member::class, $object->members[0]);
        $this->assertSame($object->members[0]->name, 'Jane Doe');
        $this->assertSame($object->members[1]->name, 'Simon Doe');
        $this->assertSame($object->members[2]->name, 'Peter Jones');
    }
}
