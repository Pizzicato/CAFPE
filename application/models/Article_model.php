<?php  defined('BASEPATH') or exit('No direct script access allowed');

 class Article_model extends MY_Model
 {
    public $table = 'articles';
    public $primary_key = 'id';
    public $protected = array('id');
    public $return_as = 'array';
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
                'rules'=> array(
                            array(
                                'date_callable',
                                function ($date) {
                                    if(! $date) {
                                        $this->form_validation->set_message('date_callable', 'The date field is required');
                                        return false;
                                    }

                                    $d = DateTime::createFromFormat('Y-m-d', $date);
                                    if ($d && $d->format('Y-m-d') === $date) {
                                        return true;
                                    }

                                    $this->form_validation->set_message('date_callable', 'The date field has an invalid format (YYYY-MM-DD)');
                                    return false;
                                }
                            )
                )
            ),
            'main_pic' => array(
                'field'=>'main_pic',
                'label'=>'main_pic'
            ),
            'lang' => array(
                'field'=>'lang',
                'label'=>'lang',
                'rules'=> array(
                    'required',
                    'regex_match[/^(en|es|all)$/]',
                    array(
                        'title_lang_callable',
                        function ($lang) {
                            $is_title_undefined = (($lang === 'es' || $lang === 'all') && !$this->input->post('title_es')) ||
                                                (($lang === 'en' || $lang === 'all') && !$this->input->post('title_en'));
                            if ($is_title_undefined) {
                                $this->form_validation->set_message('title_lang_callable', 'Title is required for the selected language');
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
        $this->before_create[] = 'create_slugs';
        $this->before_create[] = 'get_main_pic';
        $this->before_update[] = 'create_slug';
        parent::__construct();
    }

    public function with_slug($slug)
    {
        $this->where('slug_es', $slug)->or_where('slug_en', $slug);
        return $this;
    }

    protected function create_slugs($data)
    {
        $data['slug_es'] = $this->create_unique_slug('slug_es', $data['title_es']);
        $data['slug_en'] = $this->create_unique_slug('slug_en', $data['title_en']);
        return $data;
     }

    protected function get_main_pic($data)
    {
        switch ($data['lang']) {
            case 'es':
            case 'all':
                $content = $data['content_es'];
                break;

            case 'en':
                $content = $data['content_en'];
                break;

            default:
                return $data;
        }
        if (preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $content, $matches)) {
            $data['main_pic'] = $matches [1][0];
        } else {
            $data['main_pic'] = null;
        }
        return $data;
    }

    private function create_unique_slug($field, $raw)
    {
        if(! is_string($raw)){
            return false;
        }

        $slug = url_title($raw, 'dash', true);
        $count = $this->db
                            ->from($this->table)
                            ->like($field, $slug, 'after')
                            ->count_all_results();

        return ($count > 0) ? ($slug . '-' . $count) : $slug;
     }
 }
