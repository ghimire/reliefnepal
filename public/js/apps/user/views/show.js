define( [
    'base.app', 'backbone', 'marionette', 'jquery', 'underscore', 'moment',
    'js/models/user',
    'text!../templates/show.utpl'
  ],
  function(
    App, Backbone, Marionette, $, _, moment,
    Models,
    template
  ) {

    return Backbone.Marionette.ItemView.extend( {
      template: _.template(template),

      events: {
      },

      templateHelpers: function () {
        return {
          moment: moment,
          model: this.model
        };
      }

    });
  });