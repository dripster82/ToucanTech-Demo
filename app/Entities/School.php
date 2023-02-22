<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class School extends Entity
{
	use \Tatter\Relations\Traits\EntityTrait;

    protected $table            = 'schools';
    protected $primaryKey       = 'id';
	
	protected $casts = [
		'name'			=> 'string'
	];

	public function addMember($id) {
		if(gettype($id) == "object" && $id::class == Member::class )
			$id = $id->id;

		$this->_add('members', [$id]);

		return $this;
	}
}