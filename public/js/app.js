define(['jquery', 'backbone', 'marionette', 'underscore', 'text!js/apps/dashboard/templates/page_error.utpl'],
    function ($, Backbone, Marionette, _, page_error_template) {
        $.ajaxSetup({
          headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        Backbone.history.on("all", function (route, router) {
          App.page.showLoader();
        });

        String.prototype.toTitleCase = function(){
          var smallWords = /^(a|an|and|as|at|but|by|en|for|if|in|nor|of|on|or|per|the|to|vs?\.?|via)$/i;

          return this.replace(/[A-Za-z0-9\u00C0-\u00FF]+[^\s-]*/g, function(match, index, title){
            if (index > 0 && index + match.length !== title.length &&
              match.search(smallWords) > -1 && title.charAt(index - 2) !== ":" &&
              (title.charAt(index + match.length) !== '-' || title.charAt(index - 1) === '-') &&
              title.charAt(index - 1).search(/[^\s-]/) < 0) {
              return match.toLowerCase();
            }

            if (match.substr(1).search(/[A-Z]|\../) > -1) {
              return match;
            }

            return match.charAt(0).toUpperCase() + match.substr(1);
          });
        };
      /*  End of Overrides  */

        var App = new Backbone.Marionette.Application();

        //Organize Application into regions corresponding to DOM elements
        //Regions can contain views, Layouts, or subregions nested as necessary
        App.addRegions({
            //headerRegion:"header",
            mainRegion: "[data-container='page']"
        });

        App.root = '/';

        App.addInitializer(function () {
            Backbone.history.start({
              pushState: false,
              root: App.root
            });
        });

        App.mainRegion.on("before:show", function(view, region, options){
          setTimeout(function(){
            App.page.hideLoader();
          }, 1);
        });

        App.page = {
          showLoader: function () {
            this.hideLoader();
            App.mainRegion.$el.append('<div class="overlay page-overlay"><i class="fa fa-refresh fa-spin" style="position: relative; top: 20%"></i></div>');
          },
          hideLoader: function () {
            App.mainRegion.$el.find('.page-overlay').remove();
          },
          showError: function (message, errors) {
            message = message || "There was an error while processing your request.";
            errors = errors || [];
            App.mainRegion.$el.prepend(_.template(page_error_template)({
              message: message,
              errors: errors
            }));
          },
          hideError: function(){
            App.mainRegion.$el.find('.page-error').remove();
          },
          show404: function (r) {
            window.location = '/404';
          },
          scrollTop: function () {
            $('body, html').animate({
              scrollTop: 0
            }, 200);
          },
          gravatar_url: function(string, identicon){
            identicon = identicon || false;
            if(!identicon){
                return 'https://s.gravatar.com/avatar/' + md5(string + '') + '.jpg?s=50&r=g';
            }
            return 'https://s.gravatar.com/avatar/' + md5(string || '') + '.jpg?s=50&d=identicon&r=g';
          },
          parseErrorText: function (response, tag) {
            var messages;
            if (response.responseJSON) {
              var errors = response.responseJSON.errors;
              messages = [];
              if (!$.isEmptyObject(errors)) {
                for (var k in errors) {
                  messages.push(
                    (k != '__all__' ? k + ' - ' : '') + errors[k].join(', ')
                  );
                }
              } else {
                messages = [response.responseJSON.message];
              }
            } else {
              messages = ["Something went wrong. Please try again."];
            }
            if (tag) {
              return ('<', '>' + messages.join(('</', '><', '>').join(tag)) + '</', '>').join(tag);
            }
            return messages.join(', ');
          }


        };

        return App;
    });