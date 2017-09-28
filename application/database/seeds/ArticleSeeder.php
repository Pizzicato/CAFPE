<?php

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $this->db->truncate('articles');
        $this->db->query("DELETE FROM sqlite_sequence WHERE name='articles';");

        $data = [
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
            'title_es' => 'Title es test 2',
            'title_en' => 'Title en test 2',
            'content_es' => 'Content es test 2',
            'content_en' => 'Content en test 2',
            'date' => date('Y-m-d'),
            'main_pic' => 'Main-pic2.jpg',
            'slug_es' => 'title-es-slug-2',
            'slug_en' => 'title-en-slug-2',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ];
        $this->db->insert('articles', $data);

        $data = [
            'title_es' => 'Title es test 3',
            'title_en' => 'Title en test 3',
            'content_es' => 'Content es test 3',
            'content_en' => 'Content en test 3',
            'date' => date('Y-m-d'),
            'main_pic' => 'Main-pic3.jpg',
            'slug_es' => 'title-es-slug-3',
            'slug_en' => 'title-en-slug-3',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ];
        $this->db->insert('articles', $data);
    }
}
