define( [
    'base.app', 'backbone', 'marionette', 'jquery', 'underscore', 'moment',
    'js/models/organization', 'js/models/settings',
    'text!../templates/change.utpl', 
    'bootstrap.datepicker', 'jquery.serializejson', 'image.uploader'
  ],
  function(
    App, Backbone, Marionette, $, _, moment,
    Models, SettingsModels,
    template
  ) {

    return Backbone.Marionette.ItemView.extend({
      template: _.template(template),

      events: {
        'change .validate': '_preValidate',
        'blur .validate': '_preValidate',
        'keyup .validate': '_preValidate',
        'click .js-save': '_save',
        'click .js-cancel': '_cancel',
        'imageUploader.confirm [data-name=profile_picture]': '_saveImage'
      },

      initialize: function(){
      },

      _preValidate: function(evt){
        var control = $(evt.currentTarget);
        var errorMessage = this.model.preValidate(control.attr('name'), control.val());
        if(errorMessage) {
          this._showInvalid(control.attr('name'), errorMessage);
        } else {
          this._showValid(control.attr('name'));
        }
      },

      _showInvalid: function(attr, error){
        this.$el.find("[name=" + attr + "]").closest('.row').addClass('has-error');
        this.$el.find("[name=" + attr + "]").parent().parent().find('.help-inline').html(error);
      },

      _showValid: function(attr){
        this.$el.find("[name=" + attr + "]").closest('.row').removeClass('has-error');
        this.$el.find("[name=" + attr + "]").parent().parent().find('.help-inline').html('');
      },

      templateHelpers: function () {
        var view = this;
        return {
          moment: moment,
          model: view.model
        };
      },

      onRender: function(evt){

      },

      onShow: function(){
        var view = this;
        Backbone.Validation.bind(this, {
          valid: function(_v, attr) {
            _v._showValid(attr);
          },
          invalid: function(_v, attr, error) {
            App.page.scrollTop();
            _v._showInvalid(attr, error);
          }
        });

        this.$profile_picture = this.$('[data-name=profile_picture]');
        this.$profile_picture.imageUploader({
          width: 500,
          height: 250
        });

      },

      _save: function(evt){
        evt.preventDefault();
        App.page.hideError();

        var view = this;
        var data = view.$('form').serializeJSON();
        if(view.$profile_picture.data('picture')){
          data.profile_picture = view.$profile_picture.data('picture');
          view.$profile_picture.imageUploader('loading');
        }

        view.model.save(data, {
          success: function(model, response, xhr){

            if(view.$profile_picture.data('picture'))
              view.$profile_picture.imageUploader('saved');

            Backbone.history.navigate('organizations', {trigger: true});
          },
          error: function(model, error, options){
            App.page.scrollTop();

            if(view.$profile_picture.data('picture'))
              view.$profile_picture.imageUploader('error', 'Error!');

            var errors = _.isArray(error)?error:[];
            var message = (typeof error === 'string')?error:(error.constructor !== Array)?App.page.parseErrorText(error):'';
            App.page.showError(message, errors);
          },
          wait: true
        });
      },

      _cancel: function(evt){
        evt.preventDefault();
        window.history.back();
      },

      _saveImage: function(evt, file) {
        var view = this;
        var reader = new FileReader();
        reader.onload = function(event){
          view.$profile_picture.data('picture', event.target.result);
        };
        reader.readAsDataURL(file);
      }


    });
  });