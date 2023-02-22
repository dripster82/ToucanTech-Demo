<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    use \Tatter\Relations\Traits\ModelTrait;

    protected $table            = 'members';
    protected $primaryKey       = 'id';
    protected $returnType       = \App\Entities\Member::class;
    protected $allowedFields    = ['name', 'email_address', 'school_id'];
    protected $validationRules      = [
        'name'              => 'required|alpha_numeric_space|min_length[3]',
        'email_address'     => 'required|valid_email|is_unique[members.email_address, id, {id}]',
    ];
    protected $validationMessages   = [
        'email_address' => [
            'is_unique' => 'That email address already exists.',
        ],
    ];
}
