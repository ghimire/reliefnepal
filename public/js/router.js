define(['backbone', 'marionette'], function(Backbone, Marionette) {
   return Backbone.Marionette.AppRouter.extend({
       appRoutes: {
           "": "index",
           'organizations/add': 'organizations_add',
           'organizations/:org_id/edit': 'organizations_edit',
           'organizations/:org_id': 'organizations_show',
           'organizations': 'organizations',

           'organizations/:org_id/activities': 'activities',
           'organizations/:org_id/activities/add': 'activities_add',
           'organizations/:org_id/activities/:activity_id/edit': 'activities_edit',
           'organizations/:org_id/activities/:activity_id': 'activities_show',

           'activities_overview': 'activities_overview',

           'users': 'users',
           'users/add': 'users_add',
           'users/:user_id/edit': 'users_edit',
           'users/:user_id': 'users_show',

           '*actions': 'invalid_route'
       }
   });
});