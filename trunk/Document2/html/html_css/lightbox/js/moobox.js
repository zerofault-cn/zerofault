/**
 * LightBox On MooTools Release 1.0.0
 * Modified And Bug Fixed By Zarknight
 */
var LightBox = {

	init: function(options) {
		options = Object.extend({
			resizeDuration: 500,
			initialWidth:   100,
			initialHeight:  100
		}, options || {});
		
		this.anchors = [];
		$$('a').each(function(el){
			var rel = el.getProperty('rel');
			if(rel && el.getProperty('href') && rel.test('^lightbox', 'i')) {
				el.onclick = this.click.pass(el, this);
				this.anchors.push(el);
			}
		}, this);
		
		this.overlay = new Element('div').setProperty('id', 'lbOverlay').injectInside(document.body);
		this.center  = new Element('div').setProperty('id', 'lbCenter').setStyles({width: options.initialWidth+'px', height: options.initialHeight+'px', marginLeft: '-'+(options.initialWidth/2)+'px', display: 'none'}).injectInside(document.body);
		this.image   = new Element('div').setProperty('id', 'lbImage').injectInside(this.center);
		
		this.prevLink = new Element('a').setProperties({id: 'lbPrevLink', href: '#'}).setStyle('display', 'none').injectInside(this.image);
		this.nextLink = this.prevLink.clone().setProperty('id', 'lbNextLink').injectInside(this.image);
		this.prevLink.onclick = this.previous.bind(this);
		this.nextLink.onclick = this.next.bind(this);
		
		this.bottom = new Element('div').setProperty('id', 'lbBottom').setStyle('display', 'none').injectInside(document.body);
		this.caption = new Element('div').setProperty('id', 'lbCaption').injectInside(this.bottom);
		this.number  = new Element('div').setProperty('id', 'lbNumber').injectInside(this.bottom);
		new Element('a').setProperties({id: 'lbCloseLink', href: '#'}).injectInside(this.bottom).onclick = this.overlay.onclick = this.close.bind(this);
		new Element('div').setStyle('clear', 'both').injectInside(this.bottom);
		
		var nextEffect = this.nextEffect.bind(this);
		this.fx = {
			overlay: this.overlay.effect('opacity', {duration: 500}).hide(),
			resize:  this.center.effects({duration: options.resizeDuration, onComplete: nextEffect}),
			image:   this.image.effect('opacity', {duration: 500, onComplete: nextEffect}),
			bottom:  this.bottom.effects({duration: 400, onComplete: nextEffect})
		};
		
		this.preloadPrev = new Image();
		this.preloadNext = new Image();
		
		this.eventKeyDown = this.keyboardListener.bindAsEventListener(this);
	},
	
	click: function(imageLink) {
		var imageLinkRel  = imageLink.getProperty('rel');
		var imageLinkHref = imageLink.getProperty('href');
		if(imageLinkRel.length == 8){
			return this.show(imageLinkHref, imageLink.getProperty('title'));
		}
		
		var j, elHref, imageNum;
		var images = [];
		this.anchors.each(function(el){
			elHref = el.getProperty('href');
			if(el.getProperty('rel') == imageLinkRel) {
				for(j = 0; j < images.length; j++)
					if(images[j][0] == elHref) break;
				if(j == images.length) {
					images.push([elHref, el.getProperty('title')]);
					if(elHref == imageLinkHref) imageNum = j;
				}
			}
		}, this);
		return this.open(images, imageNum);
	},
	
	show: function(url, title) {
		return this.open([[url, title]], 0);
	},

	open: function(images, imageNum) {
		this.images = images;
		this.fixes(true);
		var windowHeight = Window.getHeight();
		var scrollHeight = Window.getScrollHeight();
		this.overlay.setStyle('height', ((scrollHeight < windowHeight) ? windowHeight : scrollHeight)+'px');
		this.fx.overlay.set(0.8);
		this.top = Window.getScrollTop() + (windowHeight / 15);
		this.center.setStyles({top: this.top+'px', display: ''});
		document.addEvent('keydown', this.eventKeyDown);
		return this.changeImage(imageNum);
	},

	fixes: function(open) {
		var elements = $$('object');
		if(window.ie) elements.extend($$('select'));
		elements.each(function(el){ 
			el.setStyle('visibility',(open ? 'hidden' : '')); 
		});
	},

	keyboardListener: function(event) {
		switch(event.keyCode) {
			case 27: case 88: case 67: this.close(); break;
			case 37: case 80: this.previous(); break;	
			case 39: case 78: this.next();
		}
	},

	previous: function() {
		return this.changeImage(this.activeImage-1);
	},

	next: function() {
		return this.changeImage(this.activeImage+1);
	},

	changeImage: function(imageNum) {		
		if(this.step || (imageNum < 0) || (imageNum >= this.images.length)) return false;
		this.step = 1;
		this.activeImage = imageNum;
		
		this.prevLink.style.display = this.nextLink.style.display = 'none';
		this.bottom.setStyles({opacity: '0', height: '0px', display: 'none'});
		this.fx.image.hide();
		this.center.className = 'lbLoading';
		
		this.preload = new Image();
		this.preload.onload = this.nextEffect.bind(this);
		this.preload.src = this.images[imageNum][0];
		return false;
	},

	nextEffect: function() {
		switch(this.step++) {
		case 1:
			this.center.className = '';
			this.image.setStyles({backgroundImage: 'url('+this.images[this.activeImage][0]+')', width: this.preload.width+'px'});
			this.image.style.height = this.prevLink.style.height = this.nextLink.style.height = this.preload.height+'px';
			
			this.caption.setHTML(this.images[this.activeImage][1] || '');
			this.number.setHTML((this.images.length == 1) ? '' : 'Image '+(this.activeImage+1)+' of '+this.images.length);
			
			if(this.activeImage != 0) this.preloadPrev.src = this.images[this.activeImage - 1][0];
			if(this.activeImage != (this.images.length - 1)) this.preloadNext.src = this.images[this.activeImage + 1][0];
			if(this.center.clientHeight != this.image.offsetHeight) {
				this.fx.resize.custom({height: [this.center.clientHeight, this.image.offsetHeight]});
				break;
			}
			this.step++;
		case 2:
			if(this.center.clientWidth != this.image.offsetWidth) {
				this.fx.resize.custom({width: [this.center.clientWidth, this.image.offsetWidth], marginLeft: [-this.center.clientWidth/2, -this.image.offsetWidth/2]});
				break;
			}
			this.step++;
		case 3:
			this.bottom.setStyles({top: (this.top + this.center.clientHeight)+'px', width: this.image.style.width, marginLeft: this.center.style.marginLeft, display: ''});
			this.fx.image.custom(0, 1);
			break;
		case 4:
			this.fx.bottom.custom({opacity: [0, 1], height: [0, this.bottom.scrollHeight]});
			break;
		case 5:
			if(this.activeImage != 0) this.prevLink.style.display = '';
			if(this.activeImage != (this.images.length - 1)) this.nextLink.style.display = '';
			this.step = 0;
		}
	},

	close: function() {
		document.removeEvent('keydown', this.eventKeyDown);
		if(this.preload) {
			this.preload.onload = Class.empty;
			this.preload = null;
		}
		for(var f in this.fx) this.fx[f].clearTimer();
		this.center.style.display = this.bottom.style.display = 'none';
		this.fx.overlay.set(0);
		this.fixes(false);
		this.step = 0;
		return false;
	}
};

window.addEvent('load', function(){
	LightBox.init();
});