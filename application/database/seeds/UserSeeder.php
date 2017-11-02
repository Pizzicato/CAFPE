<?php

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->truncate('users');
        $this->db->query("DELETE FROM sqlite_sequence WHERE name='users';");

        $data = array(
            'id' => 1,
            'ip_address' => '127.0.0.1',
            'username' => 'test',
            'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
            'salt' => '',
            'email' => 'admin@admin.com',
            'activation_code' => '',
            'forgotten_password_code' => null,
            'created_on' => '1268889823',
            'last_login' => '1268889823',
            'active' => '1',
            'first_name' => 'Admin',
            'last_name' => 'istrator',
            'company' => 'ADMIN',
            'phone' => '0',
        );
        $this->db->insert('users', $data);

        $this->db->truncate('groups');
        $this->db->query("DELETE FROM sqlite_sequence WHERE name='groups';");

        // Dumping data for table 'groups'
        $data = array(
            array(
                'id' => '1',
                'name' => 'admin',
                'description' => 'Administrator'
            ),
            array(
                'id' => '2',
                'name' => 'members',
                'description' => 'General User'
            )
        );
        $this->db->insert_batch('groups', $data);

        $this->db->truncate('users_groups');
        $this->db->query("DELETE FROM sqlite_sequence WHERE name='users_groups';");
        // Dumping data for table 'users_groups'
        $data = array(
            array(
                'id' => '1',
                'user_id' => '1',
                'group_id' => '1',
            ),
            array(
                'id' => '2',
                'user_id' => '1',
                'group_id' => '2',
            )
        );
        $this->db->insert_batch('users_groups', $data);
    }
}
