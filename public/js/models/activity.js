define([
    "jquery", "underscore", "backbone",
    "js/models/base"
  ],
  function(
    $, _, Backbone,
    BaseModels
  ) {

    var Models = {};

    Models.Activity = BaseModels.Model.extend({
      baseUrl: '/api/activities/',

      filters: function() {
        if(GLOBAL.user && !GLOBAL.user.is_admin) {
          return {
            'user_id': GLOBAL.user.id
          }
        }
      },

      defaults: {
        'id': null,
        'org_id': null,
        'name': '',
        'description': '',
        'address': 'Kathmandu 44600, Nepal'
      },

      validation: {
        'name': {required: true},
        'address': {required: true},
        'description': {required: true}
      },

      validate: function(attrs){
      },

      is_admin: function(){
        return (
          (GLOBAL.user && GLOBAL.user.roles == 'admin')
        );
      }

    });

    Models.Activities = BaseModels.Collection.extend({
      baseUrl : '/api/activities',
      model: Models.Activity,

      filters: function() {
        if(GLOBAL.user && !GLOBAL.user.is_admin) {
          return {
            'user_id': GLOBAL.user.id
          }
        }
      }

    });

    return Models;
  }

);