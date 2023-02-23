<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Member extends Entity
{
	use \Tatter\Relations\Traits\EntityTrait;

    protected $table            = 'members';
    protected $primaryKey       = 'id';

	protected $casts = [
		'name'			=> 'string',
		'email_address'	=> 'string'
	];

	public function addSchool($id) {
		if(gettype($id) == "object" && $id::class == School::class )
			$id = $id->id;

		$this->_add('schools', [$id]);

		return $this;
	}

	public function nameWithEmail() {
		return $this->name.' ('.$this->email_address.')';
	}
}