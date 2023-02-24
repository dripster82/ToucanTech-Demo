<?php

namespace App\Controllers\Schools;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class ExportControllerTest extends CIUnitTestCase
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
        $result = $this->get('schools/export');

        $result->assertIsOK();
        $this->assertCloseEnough($result->response()->getContentLength(), 252, 'File size not as expected', 20);
    }
}
