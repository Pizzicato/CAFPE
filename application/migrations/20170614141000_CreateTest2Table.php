<?php
/**
 * Migration: CreateTestTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2017/06/14 13:54:16
 */
class Migration_CreateTest2Table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field(array(
			'test2_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE
			),
			'test2_title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'test2_author' => array(
				'type' =>'VARCHAR',
				'constraint' => '100',
				'default' => 'King of Town',
			),
			'test2_description' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
		));
		$this->dbforge->add_key('test2_id', TRUE);
		$this->dbforge->create_table('test2');

		// Adding a Column to a Table
		$fields = array(
			'preferences' => array('type' => 'TEXT')
		);
		$this->dbforge->add_column('test2', $fields);
	}

	public function down()
	{
		// Dropping a table
		$this->dbforge->drop_table('test2');
	}

}
