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
        $this->before_update[] = 'create_slugs';
        parent::__construct();
    }

    public function with_slug($slug)
    {
        $this->where('slug_es', $slug)->or_where('slug_en', $slug);
        return $this;
    }

    protected function create_slugs($data)
    {
        $data['slug_es'] = $this->slug->create_uri($data['title_es'], 'slug_es');
        $data['slug_en'] = $this->slug->create_uri($data['title_en'], 'slug_en');
        echo "\nES: ".$data['title_es']." NEW SLUG: ".$data['slug_es']."\n";
        echo "EN: ".$data['title_en']." NEW SLUG: ".$data['slug_en']."\n";
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
 }
