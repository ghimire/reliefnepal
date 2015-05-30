define([
    "jquery", "underscore", "backbone",
    "js/models/base"
  ],
  function(
    $, _, Backbone,
    BaseModels
  ) {

    var Models = {};

    Models.Organization = BaseModels.Model.extend({
      baseUrl: '/api/organizations/',

      initialize: function() {

      },

      filters: function() {
        if(GLOBAL.user && !GLOBAL.user.is_admin) {
          return {
            'user_id': GLOBAL.user.id
          }
        }
      },

      defaults: {
        'id': null,
        'slug': '',
        'name': '',
        'description': '',
        'address': '',
        'email': '',
        'phone': '',
        'facebook_url': '',
        'profile_picture': GLOBAL.DEFAULT_ORGANIZATION,
        'comment': '',
        'website': ''
      },

      validation: {
        'name': {required: true},
        'address': {required: true},
        'email': {required: true},
        'phone': {required: true, length: 10}
      },

      validate: function(attrs){
      },

      is_admin: function(){
        return (
          (GLOBAL.user && GLOBAL.user.is_admin)
        );
      },

      getUrl: function(){
        return GLOBAL.STATIC_URL + 'o/' + this.get('slug');
      }

    });

    Models.Organizations = BaseModels.Collection.extend({
      baseUrl : '/api/organizations',
      model: Models.Organization,

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