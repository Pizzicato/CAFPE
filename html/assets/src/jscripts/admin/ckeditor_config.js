var ckeditor_config = {
    language: window.location.pathname.split("/")[1],
    toolbar: [
        { name: 'document', items : [ 'Maximize','-','Source' ] },
		{ name: 'clipboard', items : [ 'Undo','Redo' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline' ] },
		{ name: 'paragraph', items : [ 'Outdent','Indent'] },
		{ name: 'insert', items : [ 'Link','Unlink','Image','Table' ] }
    ],
    customConfig: ''
};
