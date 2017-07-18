<?php
/**
 * Migration: CreateUsersTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2017/07/14 12:55:35
 */
class Migration_CreateNewsTable extends CI_Migration
{
    public function up()
    {
        // Creating a table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INTEGER',
                'constraint' => 11,
                'auto_increment' => true
            ),
            'title_es' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'title_en' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'content_es' => array(
                'type' => 'TEXT'
            ),
            'content_en' => array(
                'type' => 'TEXT'
            ),
            'date' => array(
                'type' => 'TEXT'
            ),
            'main_pic' => array(
                'type' => 'VARCHAR',
                'constraint' => 150
            ),
            'lang' => array(
                'type' => 'VARCHAR',
                'constraint' => 3
            ),
            'created_at' => array(
                'type' => 'TEXT',
                'NULL' => true
            ),
            'updated_at' => array(
                'type' => 'TEXT',
                'NULL' => true
            )
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('news');
    }

    public function down()
    {
        // Dropping a table
        $this->dbforge->drop_table('news', true);
    }
}
