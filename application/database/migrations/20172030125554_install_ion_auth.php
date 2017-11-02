<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Install_ion_auth extends CI_Migration
{
    public function up()
    {
        // Drop table 'groups' if it exists
        $this->dbforge->drop_table('groups', true);

        // Table structure for table 'groups'
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
                'auto_increment' => true
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
            ),
            'description' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            )
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('groups');

        // Drop table 'users' if it exists
        $this->dbforge->drop_table('users', true);

        // Table structure for table 'users'
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
                'auto_increment' => true
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '16'
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '80',
            ),
            'salt' => array(
                'type' => 'VARCHAR',
                'constraint' => '40'
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'activation_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
            ),
            'forgotten_password_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
            ),
            'forgotten_password_time' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
                'null' => true
            ),
            'remember_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => true
            ),
            'created_on' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
            ),
            'last_login' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
                'null' => true
            ),
            'active' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'unsigned' => true,
                'null' => true
            ),
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
            ),
            'company' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true
            )

        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('users');


        // Drop table 'users_groups' if it exists
        $this->dbforge->drop_table('users_groups', true);

        // Table structure for table 'users_groups'
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
                'auto_increment' => true
            ),
            'user_id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true
            ),
            'group_id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true
            )
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('users_groups');

        // Drop table 'login_attempts' if it exists
        $this->dbforge->drop_table('login_attempts', true);

        // Table structure for table 'login_attempts'
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
                'auto_increment' => true
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '16'
            ),
            'login' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ),
            'time' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => true,
                'null' => true
            )
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('login_attempts');
    }

    public function down()
    {
        $this->dbforge->drop_table('users', true);
        $this->dbforge->drop_table('groups', true);
        $this->dbforge->drop_table('users_groups', true);
        $this->dbforge->drop_table('login_attempts', true);
    }
}
