window.onload = function () {
  'use strict';

  var Cropper = window.Cropper;
  var URL = window.URL || window.webkitURL;
  var container = document.querySelector('.img-container');
  var image = container.getElementsByTagName('img').item(0);
  var uploadedImageURL;
  var options = {
    aspectRatio: 16 / 6,
    preview: '.img-preview-editor',
    ready: function (e) {
      console.log(e.type);
    },
    cropstart: function (e) {
      console.log(e.type, e.detail.action);
    },
    cropmove: function (e) {
      console.log(e.type, e.detail.action);
    },
    cropend: function (e) {
      console.log(e.type, e.detail.action);
    },
    crop: function (e) {
      
    },
    zoom: function (e) {
      console.log(e.type, e.detail.ratio);
    }
  };
  var cropper = new Cropper(image, options);
  


  $(document).on('click', ".image-editor-btn", function () {
    if (uploadedImageURL) {
      URL.revokeObjectURL(uploadedImageURL);
    }
    if (cropper) {
      cropper.destroy();
    }

    cropper = new Cropper(image, options);
   $("#LogoUploadEditor").dialog('open');

});

};
