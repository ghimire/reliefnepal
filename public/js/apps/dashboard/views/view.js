define( [
    'base.app',
    'backbone',
    'marionette', 'jquery', 'underscore',
    'text!../templates/dashboard.utpl',
    'imagesloaded'
  ],
    function(
      App, Backbone, Marionette, $, _, template
    ) {
        return Backbone.Marionette.LayoutView.extend( {
            template: _.template(template),

            events: {

            },

            regions: {

            }
        });
});