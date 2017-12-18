'use strict';

import {
    Validation
} from 'bunnyjs/src/Validation';
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
        minOptions: "Selecciona al menos {minOptionsCount} options",
        dependent: "'{label}' es obligatorio si '{dependentLabel}' está definido",
        allEmpty: "Los campos '{label}, {otherLabels}' no pueden estar todos vacíos"
    };
} else {
    Validation.lang.dependent = "'{label}' is required if '{dependentLabel}' is filled";
    Validation.lang.allEmpty = "The fields '{label}, {otherLabels}' cannot be all empty";
}


// custom validator that checks dependent fields, so if a field is filled, its depending field
// must be filled as well
Validation.validators.dependent = input => {
    return new Promise((valid, invalid) => {
        if (input.hasAttribute('data-validate-depends-on')) {
            const dependendsOn = document.getElementById(input.getAttribute('data-validate-depends-on'));

            if (_fieldEmpty(input)) {
                if (!_fieldEmpty(dependendsOn)) {
                    invalid({
                        dependentLabel: Validation.ui.getLabel(Validation.ui.getInputGroup(dependendsOn)).textContent
                    });
                } else {
                    valid();
                }
            } else {
                // field not empty, remove error if exists
                Validation.ui.removeErrorNode(Validation.ui.getInputGroup(input));
                valid();
            }
        } else {
            valid();
        }
    });
};

// custom validator that checks field with tag data-validate-all-empty
// and the fields listed in its value, so all cannot be empty when submitting
Validation.validators.allEmpty = input => {
    return new Promise((valid, invalid) => {
        if (input.hasAttribute('data-validate-all-empty')) {
            const inputs = _getAllEmptyAttrInputs(input);

            for (let i = 0; i < inputs.length; i++) {
                if (!_fieldEmpty(inputs[i])) {
                    valid();
                    break;
                } else if (i === inputs.length - 1) {
                    // all fields are empty
                    invalid({
                        otherLabels: _labelsFromIds(_idsFromAllEmptyAttr(input))
                    });
                }
            }
        } else {
            valid();
        }
    });
};

// Helper functions

/**
 * _fieldEmpty: Checks if a field (tinyMCE, text input, radio or checkbox) is empty

 * @param HTMLInputElement input: input field node
 */
function _fieldEmpty(input) {
    // input is a tinyMCE editor
    if (typeof tinymce !== 'undefined' && tinymce.editors[input.id]) {
        return tinymce.editors[input.id].getContent() === '';
    }
    // text input, checkbox or radio
    return (input.getAttribute('type') !== 'file' && input.value === '') ||
        ((input.type === 'radio' || input.type === 'checkbox') && !input.checked);
}

/**
 * _labelsFromIds: Returns a string of comma separated labels corresponding
 * to the given input ids
 * @param Array ids
 */
function _labelsFromIds(ids) {
    let labels = '';
    for (let i = 0; i < ids.length; i++) {
        let input = document.getElementById(ids[i]),
            separator = ', ';

        switch (i) {
            case ids.length - 2:
                separator = (lang === 'es') ? ' y ' : ' and ';
                break;
            case ids.length - 1:
                separator = '';
                break;
        }
        labels += Validation.ui.getLabel(Validation.ui.getInputGroup(input)).textContent + separator;
    }
    return labels;
}

/**
 * _getAllEmptyAttrInputs: Returns the inputs in the document that are listed in the
 * input data-validate-all-empty attribute value as ids
 * @param HTMLInputElement input: input field node with data-validate-all-empty attribute
 */
function _getAllEmptyAttrInputs(input) {
    let inputs = [input];
    const ids = _idsFromAllEmptyAttr(input);

    for (let id in ids) {
        inputs.push(document.getElementById(ids[id]));
    }
    return inputs;
}

/**
 * _idsFromAllEmptyAttr: Returns an array of ids from the ones listed in the
 * input data-validate-all-empty attribute value
 * @param HTMLInputElement input: input field node with data-validate-all-empty attribute
 */
function _idsFromAllEmptyAttr(input) {
    return input.getAttribute('data-validate-all-empty').split(', ')
}

export default function my_validate(selector) {
    const form = document.getElementById(selector);
    if (form) {
        Validation.init(form);
    }
}
