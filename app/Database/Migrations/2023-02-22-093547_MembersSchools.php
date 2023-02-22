<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MembersSchools extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'member_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'school_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
        ]);
        $this->forge->addKey(['school_id', 'member_id'], true);
        $this->forge->addForeignKey('school_id', 'schools', 'id');
        $this->forge->addForeignKey('member_id', 'members', 'id');
        $this->forge->createTable('members_schools');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('members_schools');
        $this->db->enableForeignKeyChecks();
    }
}
