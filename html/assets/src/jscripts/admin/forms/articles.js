'use strict;'

import my_pikaday from '../modules/pikaday';
import my_tinymce from '../modules/tinymce';
import my_validate from '../../shared/modules/validate';
import get_lang from '../../shared/modules/lang.js'

const lang = get_lang();
const generalErrorMessage = (lang == 'es') ?
    'Título y contenido de la noticia han de ser completados en al menos un lenguage' :
    'Article title and content have to be filled in in at least one of the available languages';

// load pikaday datepicker
my_pikaday('.datepicker');

// load TinyMCE
my_tinymce('#content_es');
my_tinymce('#content_en');

// load validation library
my_validate('article-form');
