define( [
    'base.app', 'backbone', 'marionette', 'jquery', 'underscore', 'moment',
    'js/models/activity',
    'text!../templates/show.utpl',
    'jquery.geocomplete'
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
          show_url: function(){
            return '#/organizations/' + this.org_id + '/activities/' + this.id;
          },
          edit_url: function(){
            return '#/organizations/' + this.org_id + '/activities/' + this.id + '/edit';
          },
          is_admin: (
            (GLOBAL.user && GLOBAL.user.roles == 'admin')

          )
        };
      },

      onShow: function(){
        this.initializeMap();
      },

      initializeMap: function() {
        var view = this;
        var address = view.model.get('address');
        var latlng = new google.maps.LatLng(27.7000, 85.3333);
        var geocoder = new google.maps.Geocoder();

        var mapOptions = {
          zoom: 15,
          center: latlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }

    });
  });