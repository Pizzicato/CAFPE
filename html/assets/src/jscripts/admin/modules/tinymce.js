'use strict';

// Import TinyMCE
import tinymce from 'tinymce/tinymce';

// A theme is also required
import 'tinymce/themes/modern/theme';

// Any plugins you want to use has to be imported
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/code';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';

import get_lang from '../../shared/modules/lang.js'

const lang = get_lang();

const conf = {
    branding: false,
    menubar: false,
    resize: false,
    image_advtab: true,
    plugins: ["fullscreen code link image"],
    toolbar: "fullscreen code | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | link unlink image",
    // plugins: ["fullscreen code link image responsivefilemanager"],
    // toolbar: "fullscreen code | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | link unlink image responsivefilemanager",
    // external_filemanager_path: "/filemanager/",
    // filemanager_title: "FileManager",
    // external_plugins: {
    //     "filemanager": "/filemanager/plugin.min.js"
    // },
    language: lang,
    skin_url: process.env.PUBLIC_PATH + 'skins/lightgray'
};

const translations = {
    es: {
        "Fullscreen": "Pantalla completa",
        "Source code": "C\u00f3digo fuente",
        "Undo": "Deshacer",
        "Redo": "Rehacer",
        "Bold": "Negrita",
        "Italic": "It\u00e1lica",
        "Underline": "Subrayado",
        "Align left": "Alinear a la izquierda",
        "Align center": "Alinear al centro",
        "Align right": "Alinear a la drecha",
        "Justify": "Justificar",
        "Insert\/edit link": "Insertar\/editar enlace",
        "Insert link": "Insertar enlace",
        "Remove link": "Quitar enlace",
        "Insert\/edit image": "Insertar\/editar imagen",
        "Insert file": "Insertar fichero"
    }
};

export default function my_tinymce(selector) {
    const elements = document.querySelectorAll(selector);
    conf.selector = selector;
    // webpack: copy skins folder to destination assets
    require.context('file-loader?name=[path][name].[ext]&context=node_modules/tinymce!tinymce/skins',true,/.*/);
    tinymce.addI18n('es', translations.es);
    tinymce.init(conf);
};
