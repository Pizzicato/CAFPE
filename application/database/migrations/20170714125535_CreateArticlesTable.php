<?php
/**
 * Migration: CreateArticlesTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2017/07/14 12:55:35
 */
class Migration_CreateArticlesTable extends CI_Migration
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
                'constraint' => 150,
                'NULL' => true
            ),
            'lang' => array(
                'type' => 'VARCHAR',
                'constraint' => 3
            ),
            'slug_es' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true
            ),
            'slug_en' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true
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
        $this->dbforge->create_table('articles');
        $sql = "CREATE INDEX IF NOT EXISTS slug_index ON articles (slug_en);";
        $sql = "CREATE INDEX IF NOT EXISTS slug_index ON articles (slug_es);";
        $this->db->query($sql);
    }

    public function down()
    {
        // Dropping a table
        $this->dbforge->drop_table('articles', true);
    }
}
