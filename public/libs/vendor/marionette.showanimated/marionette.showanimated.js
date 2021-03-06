/**
 * Created by marcinkrysiak on 25/02/15, modified by Prak ghimire.praksh@gmailcom
 */

_.extend(Marionette.Region.prototype, {

  animationType: 'default',

  attachHtml: function (view) {

    var self = this,
      newView = view;

    switch(this.animationType) {

      case 'flipLeft':
        self.el.innerHTML = ''; //from the original attachHtml method
        TweenMax.set(newView.$el, {rotationY: 90});
        self.el.appendChild(newView.el); //from the original attachHtml method
        TweenMax.to(newView.$el, 0.5, {rotationY: 0, ease: Power2.easeOut});
        break;

      case 'flipRight':
        self.el.innerHTML = ''; //from the original attachHtml method
        TweenMax.set(newView.$el, {rotationY: -90});
        self.el.appendChild(newView.el); //from the original attachHtml method
        TweenMax.to(newView.$el, 0.5, {rotationY: 0, ease:Power2.easeOut});
        break;

      case 'slideLeft':
        self.el.innerHTML = ''; //from the original attachHtml method
        TweenMax.set(newView.$el.children(), {left:'110%'});
        self.el.appendChild(newView.el); //from the original attachHtml method
        TweenMax.to(newView.$el.children(), 0.5, {left:0, ease:Power2.easeInOut});
        break;

      case 'slideRight':
        self.el.innerHTML = ''; //from the original attachHtml method
        TweenMax.set(newView.$el.children(), {left:'-110%'});
        self.el.appendChild(newView.el); //from the original attachHtml method
        TweenMax.to(newView.$el.children(), 0.5, {left:0, ease:Power2.easeInOut});
        break;

      default:
        this.el.innerHTML = '';
        this.el.appendChild(view.el);
    }

    this.animationType = 'default';
  },

  showAnimated: function(view, options) {

    options = options || {};
    this.animationType = options.animationType || 'default';
    //options.preventDestroy = true;
    var oldView = this.currentView;
    this.show( view, _.extend(options, { preventDestroy: true }) );
    //destroy oldView if not preventDestroy = true
    if ( !options.preventDestroy ) {
      oldView.destroy();
    }

  }
});