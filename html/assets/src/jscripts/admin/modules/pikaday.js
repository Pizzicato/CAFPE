'use strict';

// Import TinyMCE
import Pikaday from 'pikaday';
import get_lang from '../../shared/modules/lang.js'

const lang = get_lang();

const general_conf = {
    toString: function(date, format) {
        var day = ('0' + date.getDate()).slice(-2),
            month = ('0' + (date.getMonth() + 1)).slice(-2),
            year = date.getFullYear();
        return day + '-' + month + '-' + year;
    }
};

const lang_dependent_conf = {
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

export default function my_pikaday(selector) {
    // get configuration depending on current language (first segment or URI)
    const conf = lang_dependent_conf[lang];
    Object.assign(conf, general_conf);
    const elements = document.querySelectorAll(selector);

    for (var i = 0; i < elements.length; i++) {
        // disable autocomplete and set input as readonly
        elements[i].setAttribute('autocomplete', 'off');
        elements[i].readonly = true;
        conf.field = elements[i];
        // load datepicker
        new Pikaday(conf);
    }
};
