define( [
    'base.app', 'backbone', 'marionette', 'jquery', 'underscore',
    'js/models/activity',
    'text!../templates/overview_content.utpl', 'text!../templates/overview_item.utpl',
    'bootstrap.datatables'
  ],
  function(
    App, Backbone, Marionette, $, _,
    Models,
    template, item_template
  ) {

    var ItemView = Backbone.Marionette.ItemView.extend({
      model: new Models.Activity(),
      template: _.template(item_template),
      tagName: 'tr',

      events: {

      },

      initialize: function(options){
        _.extend(this, options);
      },

      templateHelpers: function () {
        return {
          model: this.model,
          show_url: function(){
            return '#/organizations/' + this.model.org_id + '/activities/' + this.id;
          },
          edit_url: function(){
            return '#/organizations/' + this.model.org_id + '/activities/' + this.id + '/edit';
          }
        };
      }
    });

    var ListView =  Backbone.Marionette.CompositeView.extend({
      template: _.template(template),
      childView: ItemView,
      childViewContainer: 'tbody',

      events: {
      },

      templateHelpers: function () {
        return {
          collection: this.collection
        };
      },

      onRender: function(){
        App.page.scrollTop();
        this.$el.find('.dataTable').dataTable({
          "bPaginate": false,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": false,
          "bAutoWidth": false
        });
      }

    });

    return ListView;
  });