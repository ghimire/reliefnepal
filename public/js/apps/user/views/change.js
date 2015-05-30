define( [
    'base.app', 'backbone', 'marionette', 'jquery', 'underscore', 'moment',
    'js/models/user',
    'text!../templates/change.utpl',
    'bootstrap.datepicker', 'jquery.serializejson', 'js/libs/select2organization'
  ],
  function(
    App, Backbone, Marionette, $, _, moment,
    Models,
    template
  ) {

    return Backbone.Marionette.ItemView.extend({
      template: _.template(template),

      events: {
        'click [type=password]': '_clearPassword',
        'blur [type=password]': '_refillPassword',
        'change .validate': '_preValidate',
        'blur .validate': '_preValidate',
        'keyup .validate': '_preValidate',
        'click .js-save': '_save',
        'click .js-cancel': '_cancel'
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

      _clearPassword: function(evt){
        $(evt.currentTarget).val('');
      },

      _refillPassword: function(evt){
        evt.preventDefault();
        var pw_field = $(evt.currentTarget);
        if(this.model.get('id') && !pw_field.val()){
          pw_field.val('*******');
        }
      },

      templateHelpers: function () {
        var view = this;
        return {
          moment: moment,
          model: view.model
        };
      },

      onRender: function(evt){
        this.$el.find('.datefield').datepicker({
          autoclose: true
        });
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

        view.$el.find('[name=org_id]').select2Organization({})
          .select2("data", view.model.get('organization')) || {};

      },

      _save: function(evt){
        evt.preventDefault();
        App.page.hideError();

        var view = this;
        var data = _.clone(view.$('form').serializeJSON());

        if (!data['password'] ||  /^\*+$/.test(data['password'])){
          this.model.set('password','');
          delete data['password'];
        }

        view.model.save(data, {
          success: function(model, response, xhr){
            Backbone.history.navigate('#users', {trigger: true});
          },
          error: function(model, error, options){
            App.page.scrollTop();

            var errors = _.isArray(error)?error:[];
            var message = (typeof error === 'string')?error:(error.constructor !== Array)?App.page.parseErrorText(error):'';
            App.page.showError(message, errors);
          },
          wait: true
        });
      },

      _cancel: function(evt){
        evt.preventDefault();
        Backbone.history.navigate('#users', {trigger: true});
      }

    });
  });