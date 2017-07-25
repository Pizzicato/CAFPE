<?php  defined('BASEPATH') or exit('No direct script access allowed');

 class Article_model extends MY_Model
 {
     public $table = 'articles';
     public $primary_key = 'id';
     public $protected = array('id');
     public $rules;

     public function __construct()
     {
         $this->rules['insert'] = array(
            'title_es' => array(
                'field'=>'title_es',
                'label'=>'title_es',
                'rules'=>'trim'
            ),
            'title_en' => array(
                'field'=>'title_en',
                'label'=>'title_en',
                'rules'=>'trim'
            ),
            'content_es' => array(
                'field'=>'content_es',
                'label'=>'content_es'
            ),
            'content_en' => array(
                'field'=>'content_en',
                'label'=>'content_en'
            ),
            'date' => array(
                'field'=>'date',
                'label'=>'date',
                'rules'=>'required'
            ),
            'main_pic' => array(
                'field'=>'main_pic',
                'label'=>'main_pic'
            ),
            'lang' => array(
                'field'=>'lang',
                'label'=>'lang',
                'rules'=> array(
                    'regex_match[/^(en|es|all)$/]',
                    array(
                        'title_lang_callable',
                        function ($lang) {
                            $is_title_undefined = (($lang === 'es' || $lang === 'all') && !$this->input->post('title_es')) ||
                                                (($lang === 'en' || $lang === 'all') && !$this->input->post('title_en'));
                            if ($is_title_undefined) {
                                $this->form_validation->set_message('title_lang_callable', 'Title is required for the language selected');
                                return false;
                            } else {
                                return true;
                            }
                        }
                    )
                )
            )
        );

         $this->rules['update'] = $this->rules['insert'];
         $this->before_create[] = 'create_slug';
         $this->before_create[] = 'get_main_pic';
         $this->before_update[] = 'create_slug';
         parent::__construct();
     }

     protected function create_slug($data)
     {
         $this->load->helper('url');
         $data['slug_es'] = url_title($data['title_es'], 'dash', true);
         $data['slug_en'] = url_title($data['title_en'], 'dash', true);
         return $data;
     }

     protected function get_main_pic($data)
     {
         if (preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $data['content_es'], $matches)) {
             $data['main_pic'] = $matches [1][0];
         } else {
             $data['main_pic'] = null;
         }
         return $data;
     }
 }
