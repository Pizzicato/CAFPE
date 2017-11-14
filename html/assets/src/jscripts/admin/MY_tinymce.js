var MY_tinymce = (function() {
    var lang = window.location.pathname.split("/")[1];

    var conf = {
        branding: false,
        menubar: false,
        resize: false,
        plugins: ["fullscreen code link image responsivefilemanager"],
        toolbar: "fullscreen code | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | link unlink image responsivefilemanager",
        image_advtab: true,
        external_filemanager_path: "/filemanager/",
        filemanager_title: "FileManager",
        external_plugins: {
            "filemanager": "/filemanager/plugin.min.js"
        },
        language: lang
    };
    var translations = {
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

    return {
        start: function(selector) {
            // base URL
            tinyMCE.baseURL = window.location.origin + "/assets/dist/jscripts/tinymce/";
            // add translation
            tinymce.addI18n('es', translations.es);
            // add selector to conf
            $.extend(conf, {
                selector: selector
            });
            // load tinyMCE
            tinymce.init(conf);
        }
    };

})();
