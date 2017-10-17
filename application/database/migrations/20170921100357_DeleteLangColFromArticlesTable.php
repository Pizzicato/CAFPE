<?php
/**
 * Migration: DeleteLangColFromArticlesTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2017/09/21 10:03:57
 */
class Migration_DeleteLangColFromArticlesTable extends CI_Migration
{
    public function up()
    {
        $table = 'articles';
        $tmp_table = 'articles_tmp';

        // get table creation statement
        $query = $this->db->select('sql')
                ->where('type', 'table')
                ->where('name', 'articles')
                ->get('sqlite_master');
        $articles_creation_sql = $query->row()->sql;
        // remove lang column from statement
        $articles_creation_sql = preg_replace('/"lang".*\,/', '', $articles_creation_sql);;

        // get field and remove lang column
        $fields = $this->db->list_fields($table);
        $fields = implode(', ', array_diff($fields, ['lang']));

        // rename table to temporal name, recreate table, insert data, remove temporal table
        $this->db->trans_start();
        $this->dbforge->rename_table($table, $tmp_table);
        $this->db->query($articles_creation_sql);
        $this->db->query("INSERT INTO {$table} SELECT {$fields} FROM {$tmp_table};");
        $this->dbforge->drop_table($tmp_table);
        $this->db->trans_complete();
    }

    public function down()
    {
        $col = array(
                'lang' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 3
                )
        );

        $this->dbforge->add_column('articles', $col);
    }
}
