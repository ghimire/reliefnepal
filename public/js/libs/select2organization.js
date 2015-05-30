define(['jquery', 'bootstrap.select2'], function($) {
  var url = '/api/organizations';

  var select2Organization = function(options) {
    this.select2($.extend({
      allowClear: true,
      minimumInputLength: 3,
      id: function(data){
        return data.id;
      },
      ajax: {
        url: function(){
          return options.url || url
        },
        dataType: 'json',
        data: function(term, page) {
          return {
            q: term,
            page: page || 1
          };
        },
        results: function(data, page) {
          return {results: data.data};
        }
      },
      formatSelection: function(model) {
        return model.name;
      },
      formatResult: function(model) {
        return model.name;
      }
    }, options));
    return this;
  };

  $.fn.extend({ select2Organization:  select2Organization });
});