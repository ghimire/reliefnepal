define(
  [
    'jquery',
    'underscore',
    'backbone', 'backbone.validation'
  ], function($, _, Backbone) {
    var BaseModels = {};

    BaseModels.Model = Backbone.Model.extend({
      initialize: function() {
        _.bindAll(this, 'url');
      },
      filters: {},
      setFilters: function(filters) {
        this.filters = _.extend({}, this.filters, filters);
        return this;
      },
      idAttribute: 'id',
      url: function() {
        var
          filters = (
            $.isFunction(this.filters) ?
              this.filters() :
              this.filters
          ),
          baseUrl = (
            $.isFunction(this.baseUrl) ?
              this.baseUrl() :
              this.baseUrl
          );

        return baseUrl +
          (this.get(this.idAttribute) || this[this.idAttribute] || '') + '?' +
          $.param(_.extend({}, filters));
      },
      parse: function(data) {
        // The id must be set here to work with Backbone's isNew().
        this.id = data[this.idAttribute];
        return data;
      }
    });

    BaseModels.Collection = Backbone.Collection.extend({
      initialize: function() {
        _.bindAll(this, 'url');
      },

      filters: {},

      setFilters: function(filters) {
        this.filters = _.extend({}, this.filters, filters);
        return this;
      },

      url: function() {
        var
          filters = (
            $.isFunction(this.filters) ?
              this.filters() :
              this.filters
          ),
          baseUrl = (
            $.isFunction(this.baseUrl) ?
              this.baseUrl() :
              this.baseUrl
          );

        return baseUrl + '?' + $.param(_.extend({}, filters));
      },

      save: function(opts) {
        // Send a PUT request to the server replacing the collection.
        var collection = this;

        collection.sync('update', collection, _.extend({}, opts, {
          success: function(models) {
            collection.each(function(model, i) { model.set(models[i]); });
            (opts && opts.success ? opts.success : function() {})();
          }
        }));
      },

      parse: function(data) {
        if(!data) return [];
        this.total = data.total;
        return data.data;
      },

      reverse: function(data) {
        this.models = this.models.reverse();
      },

      hasNext: function(cbs) {
        return (this.current_page !== this.last_page);
      }

    });

    return BaseModels;
  }
);
