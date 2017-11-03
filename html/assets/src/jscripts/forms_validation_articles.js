var title_es_msg, title_en_msg, content_es_msg, content_en_msg, no_title_content_msg;

switch (window.location.pathname.split("/")[1]) {
    case 'en':
        title_es_msg = "If content in Spanish is filled, title is required";
        content_es_msg = "If title in Spanish is filled, content is required";
        title_en_msg = "If content in English is filled, title is required";
        content_en_msg = "If content in English is filled, title is required";
        no_title_content_msg = "Article title and content have to be filled in in at least one of the available languages";
        break;
    case 'es':
        title_es_msg = "Si hay contenido en español, el título es obligatorio";
        content_es_msg = "Si hay título en español, el contenido es obligatorio";
        title_en_msg = "Si hay título en inglés, el contenido es obligatorio";
        content_en_msg = "Si hay contenido en inglés, el título es obligatorio";
        no_title_content_msg = "Título y contenido de la noticia han de ser completados en al menos un lenguage";
        break;
}

$(function() {
    $('#article-form').validate({
        rules: {
            date: "required",
            title_es: {
                required: "#content_es:filled"
            },
            content_es: {
                required: "#title_es:filled"
            },
            title_en: {
                required: "#content_en:filled"
            },
            content_en: {
                required: "#title_en:filled"
            }
        },
        messages: {
            title_es: {
                required: title_es_msg
            },
            content_es: {
                required: content_es_msg
            },
            title_en: {
                required: title_en_msg
            },
            content_en: {
                required: content_en_msg
            }
        }
    });

    $('#article-form').submit(function(event) {
        // don't submit if none of the title and content fields are filled,
        if (!$('#title_es').val() &&
            !$('#content_es').val() &&
            !$('#title_en').val() &&
            !$('#content_en').val()
        ) {
            event.preventDefault();
            // insert error in form if not present
            if (!$(".general-error").length) {
                $(
                    '<div class="general-error">' +
                    no_title_content_msg +
                    '</div>'
                ).insertBefore($("fieldset").first());
            }
        }
        // remove potential error element
        else if ($(".general-error").length) {
            $('.general-error').remove();
        }
    });
});
