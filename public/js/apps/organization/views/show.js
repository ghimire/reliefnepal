define( [
    'base.app', 'backbone', 'marionette', 'jquery', 'underscore', 'moment',
    'js/models/organization',
    'text!../templates/show.utpl'
  ],
  function(
    App, Backbone, Marionette, $, _, moment,
    Models,
    template
  ) {

    return Backbone.Marionette.ItemView.extend( {
      template: _.template(template),

      templateHelpers: function () {
        return {
          moment: moment,
          gravatar_url: App.page.gravatar_url,
          model: this.model,
          is_admin: (
            (GLOBAL.user && GLOBAL.user.roles == 'admin')

          )
        };
      }

    });
  });