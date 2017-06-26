<?php
/**
 * Migration: CreateTestTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2017/06/14 13:54:16
 */
class Migration_CreateTest3Table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field(array(
			'test3_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE
			),
			'test3_title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'test3_author' => array(
				'type' =>'VARCHAR',
				'constraint' => '100',
				'default' => 'King of Town',
			),
			'test3_description' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
		));
		$this->dbforge->add_key('test3_id', TRUE);
		$this->dbforge->create_table('test3');

		// Adding a Column to a Table
		$fields = array(
			'preferences' => array('type' => 'TEXT')
		);
		$this->dbforge->add_column('test3', $fields);
	}

	public function down()
	{
		// Dropping a table
		$this->dbforge->drop_table('test3');
	}

}
