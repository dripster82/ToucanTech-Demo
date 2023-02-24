<?php

namespace App\Controllers\Schools;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;

class AnalysisController extends BaseController
{
    protected $helpers = ['form'];
    public $error_msg = '';

    public function index()
    {
        $schools = model('SchoolModel')->with('members')->findAll();

        return view('schools/analysis_view', ['schools' => $schools]);
    }
}
