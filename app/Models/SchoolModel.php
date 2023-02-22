<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    use \Tatter\Relations\Traits\ModelTrait;

    protected $table            = 'schools';
    protected $primaryKey       = 'id';
    protected $returnType       = \App\Entities\School::class;
    protected $allowedFields    = ['name'];
    protected $validationRules      = [
        'name'              => 'required|alpha_numeric_space|min_length[3]',
    ];
}
