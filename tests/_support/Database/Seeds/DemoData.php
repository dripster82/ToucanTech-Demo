<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoData extends Seeder
{
    public function run()
    {
        $shools_data = [
            [
                'name'  => 'School 1',
            ],
            [
                'name'  => 'School 2',
            ],
            [
                'name'  => 'College 1',
            ],
            [
                'name' => 'Uni 1',
            ],
        ];
        $this->db->table('schools')->insertBatch($shools_data);

        $schools = $this->db->table('schools')->get()->getResult();
        $schools = array_combine(array_column($schools, 'name'), array_column($schools, 'id'));

        $member_data = [
            [
                'name'          => 'Jane Doe',
                'email_address' => 'jane@doe.com',
            ],
            [
                'name'          => 'Simon Doe',
                'email_address' => 'simon@doe.com',
            ],
            [
                'name'          => 'Peter Jones',
                'email_address' => 'peter@jones.com',
            ],
            [
                'name'          => 'Amy Peg',
                'email_address' => 'amy@peg.com',
            ]
        ];
        $this->db->table('members')->insertBatch($member_data);
        $members = $this->db->table('members')->get()->getResult();
        $members = array_combine(array_column($members, 'name'), array_column($members, 'id'));

        $member_schools_data = [
            [
                'member_id'     => $members['Jane Doe'],
                'school_id'     => $schools['School 1'],
            ],
            [
                'member_id'     => $members['Jane Doe'],
                'school_id'     => $schools['School 2'],
            ],
            [
                'member_id'     => $members['Simon Doe'],
                'school_id'     => $schools['School 2'],
            ],
            [
                'member_id'     => $members['Peter Jones'],
                'school_id'     => $schools['School 2'],
            ],
            [
                'member_id'     => $members['Peter Jones'],
                'school_id'     => $schools['College 1'],
            ],
            [
                'member_id'     => $members['Amy Peg'],
                'school_id'     => $schools['College 1'],
            ],
        ];
        $this->db->table('members_schools')->insertBatch($member_schools_data);
    }
}
