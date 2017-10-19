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
         $config = array('table' => 'articles');

         $this->load->library('slug', $config);

        // article has to have titles and content in at least one language
        $this->rules['insert'] = array(
            'title_es_callable' => array(
                'field' => 'title_es_callable',
                'label' => 'title_es_callable',
                'rules' =>  array(
                    array(
                        'title_es_callable',
                        function () {
                            $valid_es = $this->input->post('title_es') && $this->input->post('content_es');
                            $valid_en = $this->input->post('title_en') && $this->input->post('content_en');
                            if (!$valid_es && !$valid_en) {
                                $this->form_validation->set_message('title_es_callable', lang('article_dependent_fields'));
                                return false;
                            }
                            return true;
                        }
                    )
                )
            ),
            'title_es' => array(
                'field' => 'title_es',
                'label' =>  lang('title'),
                'rules' => array('trim')
            ),
            'title_en' => array(
                'field' => 'title_en',
                'label' => lang('title'),
                'rules' => array('trim')
            ),
            'content_es' => array(
                'field' => 'content_es',
                'label' => lang('content'),
                'rules' =>  array('trim')
            ),
            'content_en' => array(
                'field' => 'content_en',
                'label' => lang('content'),
                'rules' =>  array('trim')
            ),
            'date' => array(
                'field' => 'date',
                'label' => lang('date'),
                'rules' =>  array(
                                'required',
                                array(
                                'date_callable',
                                function ($date) {
                                    if(!$date) {
                                        return true;
                                    }
                                    $d = DateTime::createFromFormat('d-m-Y', $date);
                                    if ($d && $d->format('d-m-Y') === $date) {
                                        return true;
                                    }
                                    $this->form_validation->set_message('date_callable', lang('date_invalid'));
                                    return false;
                                }
                        ))
            ),
            'main_pic' => array(
                'field' => 'main_pic',
                'label' => 'main_pic'
            )
        );

         $this->add_dynamic_rules();

         $this->rules['update'] = $this->rules['insert'];
         $this->before_create[] = 'create_slugs';
         $this->before_update[] = 'create_slugs';
         $this->before_create[] = 'get_main_pic';
         $this->before_update[] = 'get_main_pic';
         $this->before_create[] = 'date_toggle';
         $this->before_update[] = 'date_toggle';
         $this->after_get[] = 'date_toggle';
         parent::__construct();
     }

    /**
     * returns all articles with fields in given language
     * @param string $lang language
     * @return $this
     */
    public function get_all_lang($lang, $order_by = '')
    {
        $select = "
                    id,
                    title_{$lang} as title,
                    content_{$lang} as content,
                    date,
                    main_pic,
                    slug_{$lang} as slug
                ";
        $this->db->select($select, false)
                    ->where("title_{$lang} !=", '');
        if($order_by) {
            $this->db->order_by($order_by);
        }
        $query = $this->db->get($this->table);

        return $query ? $query->result_array() : false;
    }

    /**
     * add where clause to get slug in given language. If not language provided
     * searches in all slug fields
     * @param string $slug slug
     * @param string $lang language
     * @return $this
     */
    public function where_slug($slug, $lang = '')
    {
        if ($lang) {
            $this->where('slug_'.$lang, $slug);
        } else {
            $this->where('slug_es', $slug)->or_where('slug_en', $slug);
        }
        return $this;
    }

    /**
     * looks for a slug in DB, if it's found, returns its lang
     * @param string $slug slug
     * @return mixed lang or false, if not found
     */
    public function slug_lang($slug)
    {
        if($slug) {
            if($this->where('slug_es', $slug)->get()) {
                return 'es';
            } elseif ($this->where('slug_en', $slug)->get())  {
                return 'en';
            }
        }

        return false;
    }

    /**
     * Creates data slugs from titles
     * @param array $data original data
     * @return array $data modified data
     */
    protected function create_slugs($data)
    {
        $data['slug_es'] = $this->slug->create_uri($data['title_es'], 'slug_es');
        $data['slug_en'] = $this->slug->create_uri($data['title_en'], 'slug_en');
        return $data;
    }

    /**
     * Gets first picture in an article
     * @param array $data original data
     * @return array $data modified data
     */
    protected function get_main_pic($data)
    {
        if ($data['content_es']) {
            $content = $data['content_es'];
        } else {
            $content = $data['content_en'];
        }


        if (preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $content, $matches)) {
            $data['main_pic'] = $matches [1][0];
        } else {
            $data['main_pic'] = null;
        }

        return $data;
    }

    /**
     * Toggles date  in array of result(s) from DB
     * @param array $data original data
     * @return array $data modified data
     */
    protected function date_toggle($data)
    {
        // valid data, and not array of results
        if(isset($data['date'])) {
            $data['date'] = $this->_date_toggle($data['date']);
        }
        // array of results
        else {
            foreach ($data as &$record) {
                // not valid record, exit
                if(!isset($record['date'])) {
                    break;
                }
                $record['date'] = $this->_date_toggle($record['date']);
            }
        }
        return $data;
    }

    /**
     * Toggles date format YYYY-MM-DD <-> DD-MM-YYYY
     * @param array $data original data
     * @return array $data modified data
     */
    private function _date_toggle($date)
    {
        return implode(array_reverse(explode('-', $date)),'-');
    }

    /**
     * Adds rules to rules array, which depend on posted fields content
     */
    private function add_dynamic_rules()
    {
        // if aticle title is posted, corresponding language content can't be empty, and vice versa
        if ($this->input->post('title_es')) {
            array_unshift($this->rules['insert']['content_es']['rules'], 'required');
        }
        if ($this->input->post('title_en')) {
            array_unshift($this->rules['insert']['content_en']['rules'], 'required');
        }
        if ($this->input->post('content_es')) {
            array_unshift($this->rules['insert']['title_es']['rules'], 'required');
        }
        if ($this->input->post('content_en')) {
            array_unshift($this->rules['insert']['title_en']['rules'], 'required');
        }
    }
 }
