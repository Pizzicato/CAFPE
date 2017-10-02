<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends Public_controller
{
    /**
     * Maps to:
     *    - site_url + pages
     *    - site_url + pages/index
     *    - site_url (default controller in routes)
     */
    public function index()
    {
    }

    /**
     * Maps to:
     *    - site_url + pages/articles
     */
    public function articles()
    {
        $this->load->model('article_model');
        $articles = $this->article_model->get_all_lang(current_lang(), 'date DESC');
        $this->data['articles'] = $articles;
    }

    /**
     * Maps to:
     *    - site_url + pages/article
     */
    public function article($slug)
    {
        $this->load->model('article_model');

        // get slug language
        $slug_lang = $this->article_model->slug_lang($slug);
        if (! $slug_lang) {
            show_404();
        }

        // find article with that slug
        $article = $this->article_model->where_slug($slug, $slug_lang)->get();
        // slug language different to current language, redirect with correct slug
        // if article available in current lang
        if ($slug_lang !== current_lang()) {
            if ($article['slug_'.current_lang()]) {
                $uri = '/article/'.$article['slug_'.current_lang()];
                redirect($uri);
            } else {
                $article = null;
            }
        }
        $this->data['article'] = $this->_clean_article_array($article);
    }

    /**
     * returns an article array with only the language dependent fields in
     * the current language, and the rest of the fields
     * @param array $article article
     * @return array
     */
    private function _clean_article_array($article)
    {
        $clean_article = [];
        foreach ($article as $field => $value) {
            $field_lang = substr($field, -3);
            // language dependent field in current lang
            if($field_lang === '_'.current_lang()) {
                $clean_article[substr($field, 0,-3)] = $value;
                continue;
            }
            // non language dependent field
            if(! preg_match('/^_es|_en/', $field_lang)) {
                $clean_article[$field] = $value;
            }
        }

        return $clean_article;
    }
}
