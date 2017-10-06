<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Lang extends CI_Lang
{
    // current language, obtained from first segment of URI
    public $current = '';

    // translations of strings to avoid the problem that once a language is loaded it's
    // not possible to access other language translations
    // id -> dest lang -> word in other lang
    protected $translations_from_id = array(
        'news' => array(
            'en' => 'news',
            'es' => 'noticias'
        ),
        'article' => array(
            'en' => 'article',
            'es' => 'noticia'
        )
    );

    /**
     * Returns site_url() of provided URI adding to its beginning language and
     * first segment translation
     *
     * @uses site_url helper (CI_Config alias)
     *
     * @param	string|string[]	$uri URI string or an array of segments
     * @param	string	$lang language to which translate URI first segment
     * @param	string	$protocol
     * @return	string
     */
    public function site_url_lang($uri = '', $lang = '', $protocol = null)
    {
        // if lang not provided use current
        $lang = $lang ? $lang : $this->current;

        $uri = ltrim($uri, '/');
        if ($uri) {
            // separate first segment from the rest of the URI
            preg_match("/^([^\/]*)(\/.*)?$/", $uri, $m);
            $first_segment = $m[1];
            $rest = isset($m[2]) ? $m[2] : '';
            // Translate first segment to current language
            $translated_first_segment = $this->translate_from_id($first_segment, $lang);
            if($translated_first_segment) {
                $first_segment = $translated_first_segment;
            }

            // add language and possibly modified first segment to rest of URI
            $uri = $lang.'/'.$first_segment.$rest;
        }

        return site_url($uri, $protocol);
    }

    // inversion of the previous array. It's created dinamically to minimize user errors
    // origin lang -> word in other language -> id
    protected $translations_to_id = array();

    public function __construct()
    {
        parent::__construct();
        // create inversion of $translations_from_id
        $this->_invert_translations();

        $URI =& load_class('URI', 'core');
        $CONFIG =& load_class('Config', 'core');

        // get URI segment that should define the language
        $lang_uri = $URI->segment(1);

        // default language, only for home page
        if ($lang_uri === null) {
            $lang_uri = $CONFIG->item('language_abbr');
        }

        // save language if it's valid (has been defined in config file)
        if (in_array($lang_uri, $CONFIG->item('languages_abbr'))) {
            $this->current = $lang_uri;
            $CONFIG->set_item('language', $CONFIG->item('lang_uri_abbr')[$lang_uri]);
        } elseif (! is_cli()) {
            show_404();
        }
    }

    /**
     * Translates string from $orig_lang to $dest_lang
     *
     * Returns translated string or false if translation not found
     *
     * @param string $line string to translate
     * @param string $lang
     * @return mixed string or false
     */
    public function translate($line, $orig_lang, $dest_lang)
    {
        // get the id from the translations_to_id array
        if (isset($this->translations_to_id[$orig_lang][$line])) {
            $id = $this->translations_to_id[$orig_lang][$line];
        } else {
            return false;
        }

        // return translated value from translations_from_id
        return isset($this->translations_from_id[$id][$dest_lang]) ?
                    $this->translations_from_id[$id][$dest_lang] :
                    false;
    }

    /**
     * Translates string from given lang to identifier
     *
     * Returns translated string or false if translation not found
     *
     * @param string $line string to translate
     * @param string $lang
     * @return mixed string or false
     */
    public function translate_to_id($line, $lang)
    {
        return isset($this->translations_to_id[$lang][$line]) ?
                    $this->translations_to_id[$lang][$line] :
                    false;
    }

    /**
     * Translates string from identifier to given lang
     *
     * Returns translated string or false if translation not found
     *
     * @param string $line string to translate
     * @param string $lang
     * @return mixed string or false
     */
    public function translate_from_id($id, $lang)
    {
        return isset($this->translations_from_id[$id][$lang]) ?
                    $this->translations_from_id[$id][$lang] :
                    false;
    }

    /**
     * Translates string
     *
     * Returns translated string or false if translation not found
     *
     * @param string $line string to translate
     * @param string $lang
     * @param array $translations translations array (lang->origin->destination)
     * @return mixed string or false
     */
    private function _multi_lang_translate($line, $lang, $translations)
    {
        return isset($translations[$lang][$line]) ?
        $translations[$lang][$line] :
        false;
    }

    /**
    * Creates inversion of $translations_from_id
    */
    private function _invert_translations()
    {
        foreach ($this->translations_from_id as $id => $translation) {
            foreach ($translation as $lang => $word) {
                $this->translations_to_id[$lang][$word] = $id;
            }
        }
    }
}
