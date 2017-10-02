<?php

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $this->db->truncate('articles');
        $this->db->query("DELETE FROM sqlite_sequence WHERE name='articles';");

        $data = [
            'id' => 1,
            'title_es' => 'Title es test 1',
            'title_en' => 'Title en test 1',
            'content_es' => 'Content es test 1',
            'content_en' => 'Content en test 1',
            'date' => date('Y-m-d'),
            'main_pic' => 'Main-pic1.jpg',
            'slug_es' => 'title-es-slug-1',
            'slug_en' => 'title-en-slug-1',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ];
        $this->db->insert('articles', $data);

        $data = [
            'id' => 2,
            'title_es' => 'Title es test 2',
            'title_en' => '',
            'content_es' => 'Content es test 2',
            'content_en' => '',
            'date' => date('Y-m-d'),
            'main_pic' => 'Main-pic2.jpg',
            'slug_es' => 'title-es-slug-2',
            'slug_en' => '',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ];
        $this->db->insert('articles', $data);

        $data = [
            'id' => 3,
            'title_es' => '',
            'title_en' => 'Title en test 3',
            'content_es' => '',
            'content_en' => 'Content en test 3',
            'date' => date('Y-m-d'),
            'main_pic' => 'Main-pic3.jpg',
            'slug_es' => '',
            'slug_en' => 'title-en-slug-3',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ];
        $this->db->insert('articles', $data);
    }
}
