/*!
 * Image Uploader Plugin for Twitter Bootstrap
 *
 * Copyright 2014 FoodToEat, Phil Condreay (phil@foodtoeat.com)
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

(function($, window, document, undefined) {
  'use strict';

  var ImageUploader = function(element, opts) {
    this.$el = $(element);
    for (var option_key in ImageUploader.defaults) {
      this[option_key] = opts[option_key];
    }
    this._init();
  };

  ImageUploader.defaults = {
    'src': undefined,
    'name': 'image',
    'height': 300,
    'width': 300
  };

  ImageUploader.prototype = {
    constructor: ImageUploader,
    file_reader: (window.FileReader ? new FileReader() : undefined),

    $: function(selector) {
      return this.$el.find(selector);
    },
 
    _init: function() {
      var self = this;

      self.template = [
        '<div class="image-upload-wrapper ', (!self.file_reader ? 'no-support' : '') ,'" ',
          'style="width:',self.width ,'px; height:', self.height, 'px">',
          // Image upload container
          '<div class="overlay shadowed upload">',
            '<input type="file" name="', self.name, '" accept="image/*">',
            '<div class="bottom">',
              '<button type="button" class="btn btn-primary" data-action="upload">',
                '<span class="glyphicon glyphicon-cloud-upload"></span>',
                'Upload',
              '</button>',
            '</div>',
          '</div>',

          // Yes/No confirm dialog
          '<div class="overlay confirm-dialog">',
            '<div class="bottom">',
              '<div>',
                '<button type="button" class="btn btn-danger" data-action="upload-cancel">',
                  '<span class="glyphicon glyphicon-remove"></span>',
                '</button>',
                '<button type="button" class="btn btn-success" data-action="upload-confirm">',
                  '<span class="glyphicon glyphicon-ok"></span>',
                '</button>',
              '</div>',
            '</div>',
          '</div>',

          // Loading screen
          '<div class="overlay shadowed loader">',
            '<div class="bottom">',
              '<div class="loading-image"></div>',
            '</div>',
          '</div>',

          // Error Screen
          '<div class="overlay shadowed errored">',
            '<div class="bottom">',
              '<div data-container="error-text">Error!</div>',
              '<button class="btn btn-danger" data-action="error-ok">Ok</button>',
            '</div>',
          '</div>',

          // Error Screen
          '<div class="overlay unsupported">',
            '<div class="bottom">Your browser doesn\'t support Image Uploader</div>',
          '</div>',

          // Preview
          '<img class="preview" data-conatiner="preview">',
        '</div>'
      ].join('');

      self.$el
        .html(self.template)

        .on('click', '[data-action=upload]', function(evt) {
          evt.preventDefault();
          self.$('input[type="file"]').click();
        })

        .on('change', 'input[type="file"]', function() {
          var wrapper = self.$('.image-upload-wrapper');
          if (this.files && this.files[0]) {
            self.previewFile(this.files[0]);
            self.$el.trigger('imageUploader.change', this.files[0]);
            wrapper.addClass('confirming');
          }
        })

        .on('click', '[data-action=upload-cancel]', function(evt) {
          evt.preventDefault();
          self.$('.image-upload-wrapper').removeClass('confirming');
          self.revert();
          self.$el.trigger('imageUploader.cancel');
        })

        .on('click', '[data-action=upload-confirm]', function(evt) {
          evt.preventDefault();
          self.$('.image-upload-wrapper').removeClass('confirming');
          self.$el.trigger( 'imageUploader.confirm', self.$('input[type="file"]')[0].files[0]);
        })

        .on('click', '[data-action=error-ok]', function(evt) {
          evt.preventDefault();
          self.$('.image-upload-wrapper').removeClass('errored');
        });

      self.setFile({
        success: function() {
          self.previewFile(self.file);
        }
      });
    },

    setFile: function(cbs) {
      // Loads file from self.src.
      var self = this;
      if (!self.src) throw 'ImageUploader requires a src attribute.';

      var xhr = new XMLHttpRequest();
      xhr.open('GET', self.src, true);
      xhr.responseType = 'blob';
      xhr.onload = function() {
        if (this.status == 200) {
          self.file = this.response;
          if (cbs && 'success' in cbs) cbs.success();
        } else {
          throw 'Couldn\'t find url (' + url + ').';
        }
      };

      xhr.send();
    },

    previewFile: function(img) {
      var self = this;
      var preview = self.$('.preview');
      self.preview_file = img;

      self.file_reader.onload = function(e) {
        preview.attr('src', e.target.result);
        self.cropImage(preview);
      };

      self.file_reader.readAsDataURL(img);
    },

    cropImage: function(preview) {
      preview.css({ 'width': 'initial', 'height': 'initial' });

      var h = preview.height();
      var w = preview.width();

      var i_ratio = (h/w);
      var ratio = this.height / this.width;
      var new_h, new_w;

      if (ratio < h/w) {
        new_h = Math.floor(this.width * i_ratio);
        new_w = this.width;
      } else {
        new_h = this.height;
        new_w = Math.floor(this.height / i_ratio);
      }

      preview.css({
        'height': new_h + 'px',
        'width': new_w + 'px',
        'margin-left': -(new_w - this.width)/2 + 'px',
        'margin-top': -(new_h - this.height)/2 + 'px'
      });
    },

    loading: function() {
      this.$('.image-upload-wrapper').addClass('loading');
    },

    saved: function() {
      this.$('.image-upload-wrapper').removeClass('loading');
      this.file = this.preview_file;
    },

    error: function(html) {
      this.$('.image-upload-wrapper').removeClass('loading');
      this.$('.image-upload-wrapper').addClass('errored');
      this.revert();
      this.$el.find('[data-container=error-text]').html(html);
    },

    revert: function() {
      this.previewFile(this.file);
      this.$('input[type="file"]').val('');
    }
  };

  // jQuery plugin
  $.fn.imageUploader = function(option) {
    var args = Array.apply(null, arguments);
    args.shift();

    return this.each(function() {
      var
        $this = $(this),
        data = $this.data('imageUploader'),
        options = typeof option === 'object' && option;

      if (!data) {
        $this.data('imageUploader', (
          data = new ImageUploader(this, $.extend({}, ImageUploader.defaults, options, $this.data()))
        ));
      }

      if (typeof option === 'string') {
        data[option].apply(data, args);
      }
    });
  };
})(jQuery, window, document);