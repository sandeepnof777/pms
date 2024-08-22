/*
 Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    config.extraPlugins = "atd-ckeditor";
    config.toolbar = 'PMS';
    config.fontSize_sizes = '9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px';
    config.contentsCss = '/3rdparty/ckeditor/contents.css';

    config.atd_api_key = 'PMS_KEY';

    config.toolbar_PMS =
            [
//                { name:'document', items:[ 'Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates' ] },
//      { name:'forms', items:[ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
//        '/',
        { name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', /*'Strike', 'Subscript', 'Superscript',*/ '-', 'RemoveFormat' ] },
        { name:'paragraph', items:[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', /*'-','Blockquote', 'CreateDiv',*/
            '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'/*, '-', 'BidiLtr', 'BidiRtl'*/ ] },
        { name:'links', items:[ 'Link', 'Unlink'/*, 'Anchor'*/ ] },
//        { name:'insert', items:[ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
        { name:'clipboard', items:[ 'Cut', 'Copy', 'Paste', 'PasteText', /*'PasteFromWord', */'-', 'Undo', 'Redo' ] },
//        { name:'editing', items:[ 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt' ] },
        {name:'spellcheck', items:[ 'atd-ckeditor' ]},
        '/',
        { name:'styles', items:[ 'Styles', 'Format', 'Font', 'FontSize' ] },
        { name:'colors', items:[ 'TextColor', 'BGColor' ] }
//        { name:'tools', items:[ 'Maximize', 'ShowBlocks', '-', 'About' ] }
    ];

    config.toolbar_Minimum = [
        { name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', /*'Strike', 'Subscript', 'Superscript',*/ '-', 'RemoveFormat' ] } ,
        { name:'links', items:[ 'Link', 'Unlink'/*, 'Anchor'*/ ] },
        {name:'spellcheck', items:[ 'atd-ckeditor' ]}
    ];
    config.toolbar_Medium = [
        { name:'basicstyles', items:[ 'Bold', 'Italic', 'Underline', /*'Strike', 'Subscript', 'Superscript',*/ '-', 'RemoveFormat', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] } ,
        { name:'links', items:[ 'Link', 'Unlink', 'Anchor' ] },
        {name:'spellcheck', items:[ 'atd-ckeditor' ]}
    ];

    config.font_names =
            'Arial/Arial;' +
                    'Helvetica;' +
                    'Times New Roman/Times New Roman, Times, serif;' +
                    'Verdana;';
    config.toolbarCanCollapse = false;
    config.removePlugins = 'elementspath';
};
