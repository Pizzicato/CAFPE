// Disable autocomplete in input field
var MY_Pikaday = (function() {
    var lang = window.location.pathname.split("/")[1];
    var general_conf = {
        toString: function(date, format) {
            return date.getDate()+'-'+(date.getMonth() + 1)+'-'+date.getFullYear();
        }
    };
    var lang_dependent_conf = {
        en: {
            firstDay: 0,
            i18n: {
                previousMonth: 'Previous Month',
                nextMonth: 'Next Month',
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                weekdays: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                weekdaysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
            }
        },
        es: {
            firstDay: 1,
            i18n: {
                previousMonth: 'Mes Anterior',
                nextMonth: 'Mes Siguiente',
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                weekdays: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                weekdaysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb"]
            }
        }
    };

    return {
        start: function(selector) {
            // get configuration depending on current language (first segment or URI)
            var conf = lang_dependent_conf[lang];
            $.extend(conf, general_conf);
            // disable autocomplete and set input as readonly
            $(selector).attr('autocomplete', 'off').prop("readonly", true);
            // load datepicker
            $(selector).pikaday(conf);
        }
    };

})();
