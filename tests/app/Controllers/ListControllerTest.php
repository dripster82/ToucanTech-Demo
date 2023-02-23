<?php

namespace App\Controllers\Schools;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class ListControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $setUpMethods = [
        'resetServices',
        'mockSession',
    ];

    protected $namespace = 'App';
    protected $seed     = 'DemoData';
    // protected $basePath = 'app/Database';

    public function testShowSchools()
    {
        $response = $this->get('schools');

        $response->assertIsOK();

        $response->assertSee('School 1');
        $response->assertSee('School 2');
        $response->assertSee('College 1');
        $response->assertSee('Uni 1');
        $response->assertDontSeeElement('.focused');
        $response->assertSee('Add Member to School');
    }

    public function testShowSchoolFocused()
    {
        $response = $this->get('schools/School-1');

        $response->assertIsOK();
        $response->assertSee('School 1');
        $response->assertSee('School 2');
        $response->assertSee('College 1');
        $response->assertSee('Uni 1');
        $response->assertSee('Jane Doe', '.focused');
        $response->assertDontSee('Simon Doe', '.focused');

    }
}
