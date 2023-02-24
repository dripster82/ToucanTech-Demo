<?php

namespace App\Controllers\Schools;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class AnalysisControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $setUpMethods = [
        'resetServices',
        'mockSession',
    ];

    protected $namespace = 'App';
    protected $seed     = 'DemoData';
    // protected $basePath = 'app/Database';

    public function testExportReturnsSuccess()
    {
        $result = $this->get('schools/analysis');

        $result->assertIsOK();

        $result->assertSee('{ label: "School 1",  y: 1  }');
        $result->assertSee('{ label: "School 2",  y: 3  }');
        $result->assertSee('{ label: "College 1",  y: 2  }');
        $result->assertSee('{ label: "Uni 1",  y: 0  },');
    }
}
