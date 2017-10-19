$.fn.datepicker.dates.en = {
    days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
    daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
    months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    today: "Today",
    clear: "Clear",
    format: "mm/dd/yyyy",
    titleFormat: "MM yyyy",
    /* Leverages same syntax as 'format' */
    weekStart: 0
};

$.fn.datepicker.dates.es = {
    days: ["Domingo" ,"Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
    daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb"],
    daysMin: ["D", "L", "M", "X", "J", "V", "S"],
    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
    today: "Hoy",
    clear: "Limpiar",
    format: "mm/dd/yyyy",
    titleFormat: "MM yyyy",
    /* Leverages same syntax as 'format' */
    weekStart: 1
};

// Disable autocomplete in input field
$('input.datepicker').attr('autocomplete', 'off');
// Configure datepicker
$('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    language: window.location.pathname.split("/")[1],
    templates: {
        leftArrow: '<i class="fa fa-arrow-left"></i>',
        rightArrow: '<i class="fa fa-arrow-right"></i>'
    }
});
