$(function() {
    $('#article-form').validate({
        focusInvalid: false,
        focusCleanup: true,
        errorElement: "div",
        errorClass: "invalid",
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
                required: "If content is filled title has to be as well"
            }
        }
    });
});
