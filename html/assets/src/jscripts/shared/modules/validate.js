'use strict';

import { Validation } from 'bunnyjs/src/Validation';
import get_lang from './lang.js'

const lang = get_lang();

Validation.ui.config.classInputGroupError = 'fg-invalid';
Validation.ui.config.tagNameError = 'div';
Validation.ui.config.classError = 'fg-invalid-feedback';

if (lang === 'es') {
    Validation.lang = {
        required: "'{label}' es obligatorio",
        email: "'{label}' debe ser una dirección de email válida",
        tel: "'{label}' no es un número de teléfono válido",
        maxLength: "El tamaño de '{label}' debe ser menor que '{maxLength}'",
        minLength: "El tamaño de '{label}' debe ser mayor que '{minLength}'",
        maxFileSize: "Tamaño mimo de fichero < {maxFileSize}MB, fichero actual: {fileSize}MB",
        image: "'{label}' debe ser una imagen (JPG o PNG)",
        minImageDimensions: "'{label}' debe ser mayor que {minWidth}x{minHeight}, tamaño actual: {width}x{height}",
        maxImageDimensions: "'{label}' debe ser menor que {maxWidth}x{maxHeight}, tamaño actual: {width}x{height}",
        requiredFromList: "Selecciona '{label}' de la lista",
        confirmation: "'{label}' no es igual a '{originalLabel}'",
        minOptions: "Selecciona al menos {minOptionsCount} options"
    };
}

export default function my_validate(selector) {
    var form = document.getElementById(selector);
    Validation.init(form, true);
}
