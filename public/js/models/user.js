define([
    'base.app', "jquery", "underscore", "backbone", "md5",
    "js/models/base",
    'md5'
  ],
  function(
    App, $, _, Backbone, md5,
    BaseModels
  ) {

    var Models = {};

    Models.User = BaseModels.Model.extend({
      baseUrl: '/api/users/',

      initialize: function() {
      },

      defaults: {
        'id': null,
        'org_id': null,
        'name': '',
        'email': '',
        'password': '',
        'roles': 'user',
        'last_login': null,
        'last_ip': null,
        'created_at': null,
        'updated_at': null
      },

      filters: {
      },

      validation: {
        'name': {required: true},
        'username': {required: true},
        'email': {required: true},
        'roles': {required: true}
      },

      gravatar_url: function(email){
        email = email || this.get('email');
        if(email){
          return App.page.gravatar_url(email, false);
        }
        return App.page.gravatar_url(this.id, true);
      },

      validate: function(attrs) {
        if (!attrs['id']) {
          return 'Password is required.';
        }
      }

    });

    Models.Users = BaseModels.Collection.extend({
      baseUrl : '/api/users',
      model: Models.User
    });

    return Models;
  }

);