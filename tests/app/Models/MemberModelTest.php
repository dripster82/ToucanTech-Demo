<?php

namespace App\Models;


use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class MemberModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $namespace = 'App';
    protected $seed = 'DemoData';

    public function testModelFindAll()
    {
        $model = model('MemberModel');

        // Get every row created by ExampleSeeder
        $objects = $model->findAll();

        // Make sure the count is as expected
        $this->assertCount(4, $objects);
        $this->assertInstanceOf(\App\Entities\Member::class, $objects[1]);
    }

    public function testRelationshipToSchools()
    {
        $model = model('MemberModel');

        // Get every row created by ExampleSeeder
        $object = $model
                ->with('schools')
                ->where('name', 'Jane Doe')
                ->first();

        $this->assertInstanceOf(\App\Entities\School::class, $object->schools[0]);
        $this->assertSame($object->school[0]->name, 'School 1');
    }
}
