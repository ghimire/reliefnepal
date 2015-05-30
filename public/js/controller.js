define([
    'base.app', 'jquery', 'underscore', 'backbone', 'marionette',
    'js/apps/dashboard/views/view',
    'js/apps/organization/views/list', 'js/apps/organization/views/change', 'js/apps/organization/views/show',
    'js/apps/activity/views/list', 'js/apps/activity/views/change', 'js/apps/activity/views/show',
    'js/apps/user/views/list', 'js/apps/user/views/change', 'js/apps/user/views/show',
    'js/models/organization', 'js/models/user', 'js/models/activity'
  ],
    function (
      App, $, _, Backbone, Marionette,
      DashboardView,
      OrganizationListView, OrganizationChangeView, OrganizationShowView,
      ActivityListView, ActivityChangeView, ActivityShowView,
      UserListView, UserChangeView, UserShowView,
      OrganizationModels, UserModels, ActivityModels
    ) {
    return Backbone.Marionette.Controller.extend({
      initialize:function (options) {
        //App.headerRegion.show(new HeaderView());
      },

      invalid_route: function(){
        Backbone.history.navigate('#', {trigger: true});
      },

      index:function () {
        Backbone.history.navigate('#organizations', {trigger: true});
      },

      dashboard:function () {
        var dashboardLayout = new DashboardView();
        $.when(
          App.mainRegion.show(dashboardLayout)
        ).then(function(){
            App.page.hideLoader();
        });
      },

      organizations:function () {
        var organizations = new OrganizationModels.Organizations();
        organizations.fetch().then(function(){
          App.mainRegion.showAnimated(new OrganizationListView({collection: organizations}), {animationType: 'fadeIn'});
        });
      },
      organizations_add:function () {
        var organization = new OrganizationModels.Organization();
        App.mainRegion.showAnimated(new OrganizationChangeView({model: organization}), {animationType: 'scaleOut'});
      },
      organizations_edit:function (org_id) {
        var organization = new OrganizationModels.Organization({id: org_id});
        organization.fetch().then(function(){
          App.mainRegion.showAnimated(new OrganizationChangeView({model: organization}), {animationType: 'scaleOut'});
        });
      },
      organizations_show:function (org_id) {
        var organization = new OrganizationModels.Organization({id: org_id});
        organization.fetch().then(function(){
          App.mainRegion.showAnimated(new OrganizationShowView({model: organization}), {animationType: 'scaleIn'});
        });
      },

      activities:function (org_id) {
        var activities = new ActivityModels.Activities({org_id: org_id});
        activities.fetch().then(function(){
          App.mainRegion.showAnimated(new ActivityListView({collection: activities, org_id: org_id}), {animationType: 'fadeIn'});
        });
      },
      activities_add:function (org_id) {
        var activity = new ActivityModels.Activity({org_id: org_id});
        App.mainRegion.show(new ActivityChangeView({model: activity, org_id: org_id}));
      },
      activities_edit:function (org_id, activity_id) {
        var activity = new ActivityModels.Activity({org_id: org_id, id: activity_id});
        activity.fetch().then(function(){
            App.mainRegion.show(new ActivityChangeView({model: activity, org_id: org_id}));
        });
      },
      activities_show:function (org_id, activity_id) {
        var activity = new ActivityModels.Activity({org_id: org_id, id: activity_id});
        activity.fetch().then(function(){
          App.mainRegion.show(new ActivityShowView({model: activity}));
        });
      },

      users:function () {
        var users = new UserModels.Users();
        users.fetch().then(function(){
          App.mainRegion.show(new UserListView({collection: users}));
        });
      },
      users_add:function () {
        var user = new UserModels.User();
        App.mainRegion.show(new UserChangeView({model: user}));
      },
      users_edit:function (user_id) {
        var user = new UserModels.User({id: user_id});
        user.fetch().then(function(){
          App.mainRegion.show(new UserChangeView({model: user}));
        });
      },
      users_show:function (user_id) {
        var user = new UserModels.User({id: user_id});
        user.fetch().then(function(){
          App.mainRegion.show(new UserShowView({model: user}));
        });
      }

    });
});