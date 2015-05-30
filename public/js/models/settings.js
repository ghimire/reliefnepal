define([
    "jquery", "underscore", "backbone",
    "js/models/base"
  ],
  function(
    $, _, Backbone,
    BaseModels
  ) {

    var Models = {};

    Models.Settings = BaseModels.Model.extend({
      baseUrl: '/api/settings',
      model: new BaseModels.Model(),

      fetchSettings: function($key){
        var model = this;
        model.url = $key?(model.baseUrl += '/' + $key):model.baseUrl;
        var promise = new $.Deferred();
        model.fetch().then(function(){
          if($key) {
            model[$key] = model;
          }
          promise.resolve(model);
        });
        return promise;

        /** Sample Usage
          var view = this;
          this.fetchSettings('states').then(function(states){
            console.log(states.toJSON());
          });
        **/
      }

    });

    return Models;
  }

);