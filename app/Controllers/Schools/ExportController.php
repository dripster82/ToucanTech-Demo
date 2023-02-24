<?php

namespace App\Controllers\Schools;

use App\Controllers\BaseController;

class ExportController extends BaseController
{
    protected $helpers = ['form'];
    public $error_msg = '';

    public function index()
    {
      //get school data
      $schools = model('SchoolModel')->with('members')->findAll();
      $filename = 'schools_'.date('Ymd').'.csv'; 

      // create csv file in temp memory
      $file = fopen('php://temp', 'r+');
      $header = ['School', 'Name', 'Email Address']; 
      fputcsv($file, $header);
      foreach ($schools as $school) {
         foreach($school->members as $member){
            $line = [$school->name, $member->name, $member->email_address];
            fputcsv($file, $line); 
         } 
      }
      // read csv file from temp memory 
      rewind($file);
      $file_contents = stream_get_contents($file);
      fclose($file); 

      return $this->response->download($filename, $file_contents, true);
 
    }
}