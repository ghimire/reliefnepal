define( [
    'base.app', 'backbone', 'marionette', 'jquery', 'underscore', 'moment',
    'js/models/activity', 'js/models/settings',
    'text!../templates/change.utpl',
    'jquery.geocomplete', 'bootstrap.datepicker', 'jquery.serializejson', 'image.uploader'
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

      initialize: function(options){
        _.extend(this, options);
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
          org_id: view.org_id,
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

        var latlng = new google.maps.LatLng(27.7000, 85.3333);
        var mapOptions = {
          zoom: 15,
          center: latlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        var marker = new google.maps.Marker({
          map: map,
          position: latlng
        });

        var options = {
          map: "#map-canvas",
          componentRestrictions: {country: "np"},
          zoom: 15,
          location: "Kathmandu 44600, Nepal",
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        $(".geocomplete").geocomplete(options)
          .bind("geocode:result", function(event, result){
            view.formatted_address = result.formatted_address;
            $(".geocomplete").val(view.formatted_address);
            console.log(result.formatted_address);
          })
          .bind("geocode:error", function(event, status){
            console.log("ERROR: " + status);
          })
          .bind("geocode:multiple", function(event, results){
            view.formatted_address = results[0].formatted_address;
            $(".geocomplete").val(results[0].formatted_address);
            console.log("Multiple: " + results.length + " results found");
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

            Backbone.history.navigate('organizations/' + view.model.org_id + '/activities', {trigger: true});
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
        window.history.back()
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