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

// Custom validations that checks if all the title and content fields are empty. This cannot
// be done using the validation library, since it uses a per field basis validation
// document.getElementById('article-form').addEventListener("submit", e => {
//     if (validArticle()) {
//         removeFormGeneralError();
//     } else {
//         e.preventDefault();
//         e.stopImmediatePropagation()
//         showFormGeneralError();
//     }
// });

// load validation library
my_validate('article-form');

function validArticle() {
    return document.getElementById('title_es').value !== '' ||
        document.getElementById('title_en').value !== '' ||
        tinymce.editors['content_es'].getContent() !== '' ||
        tinymce.editors['content_en'].getContent() !== '';
}

function showFormGeneralError() {
    if (!document.getElementsByClassName('general-error').length) {
        let errorNode = document.createElement("div");
        errorNode.className = 'general-error';
        errorNode.innerHTML = generalErrorMessage;
        document.forms[0].insertBefore(errorNode, document.getElementsByTagName("fieldset")[0]);
    }
}

function removeFormGeneralError() {
    const errorNode = document.getElementsByClassName('general-error')[0];
    if (errorNode) {
        errorNode.remove();
    }
}
