/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.skin = 'office2013';
    config.extraPlugins = 'oembed,widget';
    config.oembed_maxWidth = '560';
    config.oembed_maxHeight = '315';
    config.removePlugins = 'elementspath';
    config.resize_enabled = true;


    config.oembed_WrapperClass = 'embededContent';

    config.toolbar = 'PMS';
    config.fontSize_sizes = '9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px';
    config.contentsCss = '/3rdparty/ckeditor4/contents.css';
    //config.contentsCss = '/static/css/jquery.spellchecker.min.css';

    config.atd_api_key = 'PMS_KEY';

    config.toolbar_PMS = [
//                { name:'document', items:[ 'Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates' ]},
//      { name:'forms', items:[ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ]},
//        '/',
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', /*'Strike', 'Subscript', 'Superscript',*/ '-', 'RemoveFormat' ]},
        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', /*'-','Blockquote', 'CreateDiv',*/
            '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'/*, '-', 'BidiLtr', 'BidiRtl'*/ ]},
        { name: 'links', items: [ 'Link', 'Unlink'/**/ ]},
//        { name:'insert', items:[ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ]},
        { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', /*'PasteFromWord', */'-', 'Undo', 'Redo' ]},
//        { name:'editing', items:[ 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt' ]},
        '/',
        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ]},
        { name: 'colors', items: [ 'TextColor', 'BGColor' ]},
        { name: 'spellcheck', items: [ 'jQuerySpellChecker']}
    ];

    config.toolbar_PMS2 =
        [
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', /*'Strike', 'Subscript', 'Superscript',*/ '-', 'RemoveFormat' ]},
        { name: 'paragraph', items: [ 'Outdent', 'Indent', /*'-','Blockquote', 'CreateDiv',*/
            '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'/*, '-', 'BidiLtr', 'BidiRtl'*/ ]},
        { name: 'links', items: [ 'Link', 'Unlink'/**/ ]},
//        { name:'insert', items:[ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ]},
        { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', /*'PasteFromWord', */'-', 'Undo', 'Redo' ]},
//        { name:'editing', items:[ 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt' ]},
        '/',
        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ]},
        { name: 'colors', items: [ 'TextColor', 'BGColor' ]},
        { name: 'spellcheck', items: [ 'jQuerySpellChecker']}
    ];


    config.toolbar_Medium = [
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', /*'Strike', 'Subscript', 'Superscript',*/ '-', 'RemoveFormat', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ]} ,
        { name: 'links', items: [ 'Link', 'Unlink' ]},
        { name: 'spellcheck', items: [ 'jQuerySpellChecker']}
    ];
    config.toolbar_Medium2 = [
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'RemoveFormat', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ]} ,
        { name: 'links', items: [ 'Link', 'Unlink' ]},
        { name: 'styles', items: ['Font','oembed', 'html']},
        { name: 'spellcheck', items: [ 'jQuerySpellChecker']}
    ];
    config.toolbar_Medium2NL = [
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', '-', 'Outdent', 'Indent', '-', 'RemoveFormat', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ]} ,
        { name: 'links', items: [ 'Link', 'Unlink' ]},
        { name: 'styles', items: ['Font','oembed', 'html']},
        { name: 'spellcheck', items: [ 'jQuerySpellChecker']}
    ];
    config.toolbar_Minimum = [
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', /*'Strike', 'Subscript', 'Superscript',*/ '-', 'RemoveFormat' ]} ,
        { name: 'links', items: [ 'Link', 'Unlink'/**/ ]},
        { name: 'spellcheck', items: [ 'jQuerySpellChecker']}
    ];
    config.toolbar_Minimum2 = [
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', /*'Strike', 'Subscript', 'Superscript',*/ '-', 'RemoveFormat' ]} ,
        { name: 'links', items: [ 'Link', 'Unlink'/**/ ]},
        { name: 'colors', items: [ 'TextColor', 'BGColor' ]},
        { name: 'spellcheck', items: [ 'jQuerySpellChecker']}
    ];
    config.font_names =
        'Arial/Arial;' +
        'Helvetica;' +
        'Times New Roman/Times New Roman, Times, serif;' +
        'Verdana;';
    config.toolbarCanCollapse = false;

    //config.disableNativeSpellChecker = false;
    //config.removePlugins = 'contextmenu,liststyle,tabletools, elementspath';

    config.extraPlugins = 'jqueryspellchecker';
};
