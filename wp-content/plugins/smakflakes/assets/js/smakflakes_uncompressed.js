/**
 * Smakflakes
 * @author Yury Vasilyev
 * Copyright (c) 2014 by Yury Vasilyev (aka iamMakep)
 */
(function($) {    
	$.fn.smakflakes = function(method) {
		var helpers = {
			flks_image: null,fi_width: 0,fi_height: 0,last_flakesfile: '',last_flaketype: '',last_flakecolor: {r:null,g:null,b:null},last_flakeshadow_color: {r:null,g:null,b:null},colors_random: null,rainbowstep: 0,rainbowclr: 0,issnow: true,w_height: 0,w_width: 0,canvas: null,context: null,fbody: null,flakes: new Array(),global_fdspeed: 1,global_windspeed: 0,
			last_stopfall: false,
			compareRGBs: function (rgb1,rgb2) {
				if (rgb1.r != rgb2.r) return false;
				if (rgb1.g != rgb2.g) return false;
				if (rgb1.b != rgb2.b) return false;
				return true;
				},
			genereateRGBstring: function (rgb) {
				var tmp = rgb.r + ', ' + rgb.g + ', ' + rgb.b;
				return tmp;
				},
			inRad: function (num) { return num * Math.PI / 180; },
			getRandomArbitary: function (min, max) { return Math.random() * (max - min) + min; },
			getRandomInt: function (min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }
        }
        var methods = {
            init : function(options) {
				this.smakflakes.settings = $.extend({}, this.smakflakes.defaults, options);
                return this.each( function() {
					helpers.field = $(this);
					helpers.w_height = $(window).height();
					helpers.w_width = $(window).width();
					helpers.last_stopfall = $(this).smakflakes.settings.stopfall;
					if (typeof($(this).smakflakes.settings.flakeopacity) == 'string') {
						if ($(this).smakflakes.settings.flakeopacity == 'random') $(this).smakflakes.settings.flakeopacity = 0;
						}
					else if (typeof($(this).smakflakes.settings.flakeopacity) == 'number') {
							if ($(this).smakflakes.settings.flakeopacity <= 0) $(this).smakflakes.settings.flakeopacity = 0;
							if ($(this).smakflakes.settings.flakeopacity >= 1) $(this).smakflakes.settings.flakeopacity = 1;
							}
					else $(this).smakflakes.settings.flakeopacity = 0;
					if ($(this).smakflakes.settings.flakescount <= 0) $(this).smakflakes.settings.flakescount = 1;
					helpers.last_flakesfile = $(this).smakflakes.settings.flakesfile;
					if ($(this).smakflakes.settings.flakesfile != '') {
						var tmpimg = new Image();
						tmpimg.onload = function() {
							helpers.flks_image = tmpimg;
							helpers.fi_width = helpers.flks_image.width;
							helpers.fi_height = helpers.flks_image.height;
							if ((helpers.fi_width % helpers.fi_height) != 0) {
								helpers.flks_image = null;
								helpers.fi_width = 0;
								helpers.fi_height = 0;
								$(this).smakflakes.settings.flakesfile = '';
								helpers.last_flakesfile = $(this).smakflakes.settings.flakesfile;
								}
							else {
								updateImageInfo();
								helpers.last_flakesfile = $(this).smakflakes.settings.flakesfile;
								}
							};
						tmpimg.src = $(this).smakflakes.settings.flakesfile;
						}
					if ($(this).smakflakes.settings.flakesize > 30) $(this).smakflakes.settings.flakesize = 30;
					if ($(this).smakflakes.settings.flakesize < 1) $(this).smakflakes.settings.flakesize = 1;
					$(this).smakflakes.settings.flakesize = $(this).smakflakes.settings.flakesize + 3;
					$(this).smakflakes.settings.flakesize += 2;
					var tmp_canvas = $('<canvas />', {id: 'flkscnvs'});
					tmp_canvas.attr({'width': helpers.w_width-2 + 'px' ,'height': helpers.w_height-2 + 'px'  });
					tmp_canvas.css({
						'position': 'fixed',
						'z-index': 99999,
						'pointer-events': 'none'
						});
					helpers.canvas = tmp_canvas;
					helpers.context = $(helpers.canvas)[0].getContext('2d');
					helpers.field.prepend(helpers.canvas);
					$(this).smakflakes.settings.falspeed = $(this).smakflakes.settings.falspeed;
					if ($(this).smakflakes.settings.falspeed < 1) $(this).smakflakes.settings.falspeed = 1;
					if ($(this).smakflakes.settings.falspeed > 30) $(this).smakflakes.settings.falspeed = 30;
					$(this).smakflakes.settings.wind = $(this).smakflakes.settings.wind;
					if ($(this).smakflakes.settings.wind < -3) $(this).smakflakes.settings.wind = -3;
					if ($(this).smakflakes.settings.wind > 3) $(this).smakflakes.settings.wind = 3;
					var sw = $('<div>', {id: 'snow_switch'});
						sw.html('*');
					sw.css({
						'z-index': 99999,'position': 'fixed','width': 'auto','height': 'auto','padding-top': '6px','padding-bottom': '0px','padding-left': '9px','padding-right': '9px'
					});
					switch($(this).smakflakes.settings.onoffpos){
						case 'top right': sw.css({'right': '5px','top': '5px', 'left': 'auto', 'bottom': 'auto'}); sw.show(); break;
						case 'top left': sw.css({'left': '5px','top': '5px', 'right': 'auto', 'bottom': 'auto'}); sw.show(); break;
						case 'bottom right': sw.css({'right': '5px','bottom': '5px', 'left': 'auto', 'top': 'auto'}); sw.show(); break;
						case 'bottom left': sw.css({'left': '5px','bottom': '5px', 'right': 'auto', 'top': 'auto'}); sw.show(); break;
						case 'none': sw.hide(); break;
						default: sw.css({'right': '5px','top': '5px', 'left': 'auto', 'bottom': 'auto'}); sw.show(); break;
						}
					helpers.field.append(sw);
					$(window).resize(function() {
						helpers.w_height = $(window).height();
						helpers.w_width = $(window).width();
						tmp_canvas.attr({'width': helpers.w_width-2 + 'px' ,'height': helpers.w_height-2 + 'px'  });
						});
					$('#snow_switch').click(function(){
						if (helpers.issnow) {
							helpers.issnow = false;
							$(this).addClass('snowoff');
							}
						else {
							helpers.issnow = true;
							$(this).removeClass('snowoff');
							}
						});
					function firstInitFlakes() {
						helpers.colors_random = new Array('204, 45, 33','204, 172, 44','113, 204, 48','121, 204, 193','70, 95, 204','182, 84, 204','204, 204, 182','0, 164, 204','204, 12, 67');
						for (var i = 0; i< $(this).smakflakes.settings.flakescount; i++) {
							var one_flake = {scale: 1,sizeXY: 0,left: 0,top: 0,axisx_forfal: 0,maxvectorX: 0,vectorX: 0,incX: 0,speed: 0,opacity: 0,opacity_mode: 0,tmp_opacity: 0,color: '',shadowcolor: '',shadowopacity: 0.1,shadowopacity_mode: 0.1,tmp_shadowopacity: 0.1,imgindex: 0,imgangle: 0,imgangle_spch: 0,imgangle_vector: 0,imgangle_max: 0,live: false};
							var size = 10, opy = 1;
							opy = helpers.getRandomArbitary(0.2,1);
							one_flake.opacity = opy;
							one_flake.sizeXY = size;
							if (helpers.getRandomInt(0,100) >= 50) one_flake.scale = (-1) * helpers.getRandomArbitary (0.01,0.4);
							else one_flake.scale = helpers.getRandomArbitary (0,0.2);
							one_flake.opacity_mode = one_flake.opacity;
							one_flake.shadowopacity_mode = one_flake.shadowopacity;
							var color = '', shadowcolor = '';
							helpers.last_flaketype = $(this).smakflakes.settings.flaketype;
							switch($(this).smakflakes.settings.flaketype) {
								case 'lighter': color = '255, 255, 255'; shadowcolor = color; break;
								case 'darker': color = '255, 255, 255'; shadowcolor = '0, 0, 0'; 
									one_flake.shadowopacity_mode = one_flake.shadowopacity += 0.3; 
									if (one_flake.shadowopacity_mode > 1) one_flake.shadowopacity_mode = 1;
									one_flake.opacity_mode = one_flake.opacity + 0.3;
									if (one_flake.opacity_mode > 1) one_flake.opacity_mode = 1;
									break;
								case 'varicolored': color = helpers.colors_random[helpers.getRandomInt(0,helpers.colors_random.length-1)]; shadowcolor = color; break;
								case 'colored':
									color = helpers.genereateRGBstring($(this).smakflakes.settings.flakecolor);
									shadowcolor = helpers.genereateRGBstring($(this).smakflakes.settings.flakeshadow_color);
									one_flake.shadowopacity_mode = one_flake.shadowopacity + 0.3; 
									if (one_flake.shadowopacity_mode > 1) one_flake.shadowopacity_mode = 1;
									break;
								deafult: color = '255, 255, 255'; shadowcolor = color; break;
							}
							if (one_flake.shadowopacity > 1) one_flake.shadowopacity = 1;
							one_flake.tmp_shadowopacity = one_flake.shadowopacity;
							one_flake.tmp_opacity = one_flake.opacity;
							one_flake.color = color;
							one_flake.shadowcolor = shadowcolor;
							var chance = helpers.getRandomInt(0,1000);
							if ((chance >= 0)&&(chance <= 25)) one_flake.live = false;
							else one_flake.live = true;
							one_flake.maxvectorX = helpers.getRandomInt(25,50);
							one_flake.speed = helpers.getRandomArbitary(0.5,4);
							one_flake.axisx_forfal = helpers.getRandomInt(10, helpers.w_width - one_flake.sizeXY - 10);
							one_flake.left = one_flake.axisx_forfal;
							one_flake.top = (-1) * helpers.getRandomInt(0, helpers.w_height);
							one_flake.imgangle_max = helpers.getRandomInt(5,60);
							one_flake.imgangle_spch = helpers.getRandomArbitary(0.5,5);
							one_flake.imgangle_vector = (helpers.getRandomInt(0,100) >= 50) ? -1 : 1;
							helpers.flakes.push(one_flake);
							}
						}
					firstInitFlakes();
					function updateImageInfo() {
						if (helpers.flks_image != null) {
							var maxindx = Math.floor(helpers.fi_width / helpers.fi_height) - 1;
							$.each(helpers.flakes, function(indx, elem){
								elem.imgindex = helpers.getRandomInt(0, maxindx);
								});
							}
						}
					setInterval(function() {
						if (helpers.last_stopfall != $(this).smakflakes.settings.stopfall) {
							helpers.issnow = !$(this).smakflakes.settings.stopfall;
							helpers.last_stopfall = $(this).smakflakes.settings.stopfall;
							}
						helpers.context.clearRect(0, 0, helpers.w_width, helpers.w_height);
						if ((helpers.last_flakesfile != $(this).smakflakes.settings.flakesfile)) {
							if ($(this).smakflakes.settings.flakesfile == '') {
								helpers.flks_image = null;
								helpers.fi_width = 0;
								helpers.fi_height = 0;
								helpers.last_flakesfile = $(this).smakflakes.settings.flakesfile;
								}
							else {
							var tmpimg = new Image();
							tmpimg.onload = function() {
								helpers.flks_image = tmpimg;
								helpers.fi_width = helpers.flks_image.width;
								helpers.fi_height = helpers.flks_image.height;
								if ((helpers.fi_width % helpers.fi_height) != 0) {
									helpers.flks_image = null;
									helpers.fi_width = 0;
									helpers.fi_height = 0;
									$(this).smakflakes.settings.flakesfile = '';
									helpers.last_flakesfile = $(this).smakflakes.settings.flakesfile;
									}
								else {
									updateImageInfo();
									helpers.last_flakesfile = $(this).smakflakes.settings.flakesfile;
									}
								};
								tmpimg.src = $(this).smakflakes.settings.flakesfile;
							}
							}
						$.each(helpers.flakes, function(indx, e){
							if (!(helpers.issnow)) {
								if ((e.tmp_opacity <= 0) && (e.tmp_shadowopacity <= 0)) {
									e.tmp_opacity = 0;
									e.tmp_shadowopacity = 0;
									return;
									}
								else {
									e.tmp_opacity -= 0.05;
									e.tmp_shadowopacity -= 0.02;
									if (e.tmp_opacity < 0) e.tmp_opacity = 0;
									if (e.tmp_shadowopacity < 0) e.tmp_shadowopacity = 0;
									}
								}
							else {
								if (e.tmp_opacity < e.opacity) e.tmp_opacity += 0.02;
								else e.tmp_opacity = e.opacity;
								if (e.tmp_shadowopacity < e.shadowopacity) e.tmp_shadowopacity += 0.01;
								else e.tmp_shadowopacity = e.shadowopacity;
								}
							if (!(e.live)) {
								var chance = helpers.getRandomInt(0,1000);
								if ((chance >= 0)&&(chance <= 25)) {
									if ($(this).smakflakes.settings.wind < 0)
										e.axisx_forfal = helpers.getRandomInt(100 + Math.abs($(this).smakflakes.settings.wind) * 25, helpers.w_width + 200 + Math.abs($(this).smakflakes.settings.wind) * 25);
									else if ($(this).smakflakes.settings.wind > 0) 
											e.axisx_forfal = helpers.getRandomInt((-1) * (Math.abs($(this).smakflakes.settings.wind) * 25 + 200), helpers.w_width - (100 + Math.abs($(this).smakflakes.settings.wind) * 25));
										 else e.axisx_forfal = helpers.getRandomInt(10, helpers.w_width - 10);

									if (helpers.flks_image == null)
										e.top = (-2) * (e.scale + $(this).smakflakes.settings.flakesize);
									else 
										e.top = (-2) * (helpers.fi_height);
									e.left = e.axisx_forfal;
									e.live = true;
									e.vectorX = 0;
									e.speed = helpers.getRandomArbitary(0.5,4);
									}
								}
							else {
								if (
									((helpers.flks_image == null) && ((parseInt(e.left) >= (-1) * (e.scale + $(this).smakflakes.settings.flakesize)) && (parseInt(e.left) <= (helpers.w_width)))) ||
									((helpers.flks_image != null) && ((parseInt(e.left) >= (-1) * helpers.fi_height) && (parseInt(e.left) <= (helpers.w_width))))
									){
										var local_opacity = 0, local_sopacity = 0;
										if (!(helpers.issnow)) {
											local_opacity = e.tmp_opacity;
											local_sopacity = e.tmp_shadowopacity;
											}
										else {
											if	(e.tmp_opacity < e.opacity) local_opacity = e.tmp_opacity;
											else local_opacity = e.opacity;
											if	(e.tmp_shadowopacity < e.shadowopacity) local_sopacity = e.tmp_shadowopacity;
											else local_sopacity = e.shadowopacity;
											}
										if (helpers.flks_image == null) {
											helpers.context.beginPath();
											helpers.context.shadowBlur = 5;
											helpers.context.shadowOffsetX = 0;
											helpers.context.shadowOffsetY = 0;
											if ($(this).smakflakes.settings.randomsize == true) helpers.context.arc(e.left + Math.floor(e.sizeXY * (e.scale + ($(this).smakflakes.settings.flakesize/10)) / 2), e.top + Math.floor(e.sizeXY * (e.scale + ($(this).smakflakes.settings.flakesize/10)) / 2), e.sizeXY * (e.scale + ($(this).smakflakes.settings.flakesize/10)) / 2 , 0, 2 * Math.PI);
											else helpers.context.arc(e.left + Math.floor(e.sizeXY * ($(this).smakflakes.settings.flakesize/10) / 2), e.top + Math.floor(e.sizeXY * ($(this).smakflakes.settings.flakesize/10) / 2), e.sizeXY * ($(this).smakflakes.settings.flakesize/10) / 2 , 0, 2 * Math.PI);
											if ($(this).smakflakes.settings.flaketype != helpers.last_flaketype) {
												$.each(helpers.flakes,function(indx, elm){
													var tmp_color = '', tmp_shadowcolor = ''; 
													switch($(this).smakflakes.settings.flaketype) {
														case 'lighter': tmp_color = '255, 255, 255'; tmp_shadowcolor = tmp_color;
															elm.shadowopacity_mode = elm.shadowopacity;
															elm.opacity_mode = elm.opacity;
															break;
														case 'darker': tmp_color = '255, 255, 255'; tmp_shadowcolor = '0, 0, 0';
															elm.shadowopacity_mode = elm.shadowopacity + 0.3; 
															if (elm.shadowopacity_mode > 1) elm.shadowopacity_mode = 1;
															elm.opacity_mode = elm.opacity + 0.3;
															if (elm.opacity_mode > 1) elm.opacity_mode = 1;
															break;
														case 'varicolored': tmp_color = helpers.colors_random[helpers.getRandomInt(0,helpers.colors_random.length-1)]; tmp_shadowcolor = tmp_color; 
															elm.shadowopacity_mode = elm.shadowopacity;
															elm.opacity_mode = elm.opacity;
															break;
														case 'colored':
															elm.shadowopacity_mode = elm.shadowopacity + 0.3; 
															if (elm.shadowopacity_mode > 1) elm.shadowopacity_mode = 1;
															elm.opacity_mode = elm.opacity;
															break;
														case 'rainbow_shadow':
															elm.opacity_mode = elm.opacity + 0.3;
															if (elm.opacity_mode > 1) elm.opacity_mode = 1;
															break;
														deafult: tmp_color = '255, 255, 255'; tmp_shadowcolor = tmp_color; 
															elm.shadowopacity_mode = elm.shadowopacity;
															elm.opacity_mode = elm.opacity;
															break;
														}
													elm.tmp_opacity = elm.opacity_mode;
													elm.tmp_shadowopacity = elm.shadowopacity_mode;

													elm.shadowcolor = tmp_shadowcolor;
													elm.color = tmp_color;
													});
												helpers.last_flaketype = $(this).smakflakes.settings.flaketype;
												}
											var tmp_color = '', tmp_shadowcolor = '';
											if($(this).smakflakes.settings.flaketype == 'colored') {
												tmp_color = helpers.genereateRGBstring($(this).smakflakes.settings.flakecolor);
												tmp_shadowcolor = helpers.genereateRGBstring($(this).smakflakes.settings.flakeshadow_color);
												}
											if (($(this).smakflakes.settings.flaketype == 'rainbow_shadow') || ($(this).smakflakes.settings.flaketype == 'rainbow')) {
												var my_tmpClr = '';
												switch(helpers.rainbowstep) {
													case 0: 
														if (Math.floor(helpers.rainbowclr) < 255) helpers.rainbowclr += 0.1;
														else helpers.rainbowstep++;
														my_tmpClr = '255, 0, '+Math.floor(helpers.rainbowclr);
														break;
													case 1:
														if (Math.floor(helpers.rainbowclr) > 0) helpers.rainbowclr -= 0.1;
														else helpers.rainbowstep++;
														my_tmpClr = Math.floor(helpers.rainbowclr) + ', 0, 255';
														break;
													case 2:
														if (Math.floor(helpers.rainbowclr) < 255) helpers.rainbowclr += 0.1;
														else helpers.rainbowstep++;
														my_tmpClr = '0, '+Math.floor(helpers.rainbowclr)+', 255';
														break;
													case 3:
														if (Math.floor(helpers.rainbowclr) > 0) helpers.rainbowclr -= 0.1;
														else helpers.rainbowstep++;
														my_tmpClr = '0, 255, '+Math.floor(helpers.rainbowclr);
														break;
													case 4:
														if (Math.floor(helpers.rainbowclr) < 255) helpers.rainbowclr += 0.1;
														else helpers.rainbowstep++;
														my_tmpClr = Math.floor(helpers.rainbowclr) + ', 255, 0';
														break;
													case 5:
														if (Math.floor(helpers.rainbowclr) > 0) helpers.rainbowclr -= 0.1;
														else helpers.rainbowstep = 0;
														my_tmpClr = '255, '+ Math.floor(helpers.rainbowclr) +', 0';
														break;
													default: break;
													}
												if ($(this).smakflakes.settings.flaketype == 'rainbow_shadow') {
													tmp_shadowcolor = my_tmpClr;
													tmp_color = '255, 255, 255';
													}
												else {
													tmp_shadowcolor = '50, 50, 50';
													tmp_color = my_tmpClr;
													}
												}
											if ( ($(this).smakflakes.settings.flaketype == 'rainbow') || 
												 ($(this).smakflakes.settings.flaketype == 'rainbow_shadow') ||
												 ($(this).smakflakes.settings.flaketype == 'colored')){
												helpers.context.shadowColor = 'rgba('+tmp_shadowcolor+','+local_sopacity+')';
												helpers.context.fillStyle = 'rgba('+tmp_color+','+local_opacity+')';
												}
											else {
												helpers.context.shadowColor = 'rgba('+e.shadowcolor+','+local_sopacity+')';
												helpers.context.fillStyle = 'rgba('+e.color+','+local_opacity+')';
												}
											helpers.context.fill();
											helpers.context.closePath();
											}
										else {
											helpers.context.save();
											helpers.context.globalAlpha = local_opacity;
											helpers.context.shadowColor = 'rgba(0,0,0,0)';
											helpers.context.translate(parseInt(e.left + helpers.fi_height/2), parseInt(e.top + helpers.fi_height/2));
											switch($(this).smakflakes.settings.firotation) {
												case 'cw': 
													if (e.imgangle >= 360) e.imgangle = 0;
													e.imgangle += helpers.getRandomInt(2,10);
													break;
												case 'ccw': 
													if (e.imgangle <= 0) e.imgangle = 360;
													e.imgangle -= helpers.getRandomInt(2,10);
													break;
												case 'toandfro': 
													if (Math.abs(e.imgangle) >= e.imgangle_max) {
														if (e.imgangle < 0) e.imgangle_vector = 1;
														else e.imgangle_vector = -1;
														}
													e.imgangle += e.imgangle_vector * e.imgangle_spch;
													break;
												case 'none': e.imgangle = 0; break;
												default: e.imgangle = 0; break;
												}
											helpers.context.rotate(helpers.inRad(e.imgangle));
											helpers.context.drawImage(helpers.flks_image,parseInt(e.imgindex * helpers.fi_height), 0, parseInt(helpers.fi_height), parseInt(helpers.fi_height), /*parseInt(e.left),parseInt(e.top)*/ parseInt((-1)*(helpers.fi_height/2)), parseInt((-1)*(helpers.fi_height/2)) ,parseInt(helpers.fi_height),parseInt(helpers.fi_height));
											helpers.context.restore();
											}
										}
								e.axisx_forfal = e.axisx_forfal + $(this).smakflakes.settings.wind;
								var die = false;
								if (helpers.flks_image == null) {
									die = ((parseInt(e.top) >= parseInt(helpers.w_height)) ||
									(($(this).smakflakes.settings.wind < 0) && (parseInt(e.axisx_forfal + e.vectorX) < (-1) * Math.floor(e.sizeXY * ($(this).smakflakes.settings.flakesize/10)))) || 
									(($(this).smakflakes.settings.wind > 0) && (parseInt(e.axisx_forfal + e.vectorX) >= parseInt(helpers.w_width)))
									);
									}
								else {
									die = ((parseInt(e.top) >= parseInt(helpers.w_height)) ||
									(($(this).smakflakes.settings.wind < 0) && (parseInt(e.axisx_forfal + e.vectorX) < (-1) * parseInt(helpers.fi_height))) || 
									(($(this).smakflakes.settings.wind > 0) && (parseInt(e.axisx_forfal + e.vectorX) >= parseInt(helpers.w_width)))
									);
									}
								if (die) {
									e.live = false;
									}
								else {
									e.top = parseInt(e.top) + ($(this).smakflakes.settings.falspeed + e.speed);
									e.left =  e.axisx_forfal + e.vectorX;
									}
								var rndinc = helpers.getRandomInt(0, 100);
								if ((rndinc >= 30)&&(rndinc <= 33)) e.incX = helpers.getRandomArbitary(-1,1);
								e.vectorX += e.incX;
								if (Math.abs(e.vectorX) > e.maxvectorX) {
									if (e.vectorX < 0) e.vectorX = (-1)*e.maxvectorX;
									else e.vectorX = e.maxvectorX;
									e.incX = (-1)*e.incX;
									}
								}
							});
					}, 50);
				});
            },
			setflaketype: function(type) {
				if ($(this).smakflakes.settings.flaketype == type) return;
				switch(type){
					case 'lighter': $(this).smakflakes.settings.flaketype = 'lighter'; break;
					case 'darker': $(this).smakflakes.settings.flaketype = 'darker'; break;
					case 'varicolored': $(this).smakflakes.settings.flaketype = 'varicolored'; break;
					case 'colored': $(this).smakflakes.settings.flaketype = 'colored'; break;
					case 'rainbow': $(this).smakflakes.settings.flaketype = 'rainbow'; break;
					case 'rainbow_shadow': $(this).smakflakes.settings.flaketype = 'rainbow_shadow'; break;
					default: $(this).smakflakes.settings.flaketype = 'lighter'; break;
					}
				return $(this).smakflakes.settings.flaketype;
				},
			setflakecolor: function(clr) {
				if (!helpers.compareRGBs($(this).smakflakes.settings.flakecolor, clr)) {
					$(this).smakflakes.settings.flakecolor = clr;
					}
				return $(this).smakflakes.settings.flakecolor
				},
			setflakeshadow_color: function(clr) {
				if (!helpers.compareRGBs($(this).smakflakes.settings.flakeshadow_color, clr)) {
					$(this).smakflakes.settings.flakeshadow_color = clr;
					}
				return $(this).smakflakes.settings.flakeshadow_color
				},
			setsize: function(sz) {
				if (sz > 30) $(this).smakflakes.settings.flakesize = 30;
				if (sz < 1) $(this).smakflakes.settings.flakesize = 1;
				$(this).smakflakes.settings.flakesize = sz + 3;
				return $(this).smakflakes.settings.flakesize;
				},
			setrandomsize: function(rsz) {
				if (rsz) $(this).smakflakes.settings.randomsize = true;
				else $(this).smakflakes.settings.randomsize = false;
				return $(this).smakflakes.settings.randomsize;
				},
			setswpos: function (pos) {
				var sw = $(this).find('div#snow_switch');
				switch(pos){
					case 'top right': 
						sw.css({'right': '5px','top': '5px', 'left': 'auto', 'bottom': 'auto'}); sw.show(); 
						$(this).smakflakes.settings.onoffpos = pos;
						break;
					case 'top left': 
						sw.css({'left': '5px','top': '5px', 'right': 'auto', 'bottom': 'auto'}); sw.show(); 
						$(this).smakflakes.settings.onoffpos = pos;
						break;
					case 'bottom right': 
						sw.css({'right': '5px','bottom': '5px', 'left': 'auto', 'top': 'auto'}); sw.show(); 
						$(this).smakflakes.settings.onoffpos = pos;
						break;
					case 'bottom left': 
						sw.css({'left': '5px','bottom': '5px', 'right': 'auto', 'top': 'auto'}); sw.show();
						$(this).smakflakes.settings.onoffpos = pos;
						break;
					case 'none': $(this).smakflakes.settings.onoffpos = pos; sw.hide(); break;
					default: 
						sw.css({'right': '5px','top': '5px', 'left': 'auto', 'bottom': 'auto'}); sw.show();
						$(this).smakflakes.settings.onoffpos = pos;
						break;
					}
				return $(this).smakflakes.settings.onoffpos;
				},
			setimgflakes: function(imgfile) {
				$(this).smakflakes.settings.flakesfile = imgfile;
				return $(this).smakflakes.settings.flakesfile;
				},
			setimgrotation: function(rotation) {
				switch(rotation) {
					case 'cw':  case 'ccw': case 'toandfro': case 'none': $(this).smakflakes.settings.firotation = rotation; break;
					default: $(this).smakflakes.settings.firotation = 'none'; break;
					}
				return $(this).smakflakes.settings.firotation;
				},
			setwind: function (wind) {
				$(this).smakflakes.settings.wind = wind;
				if (typeof(wind) == 'number') {
					if (wind < -5) $(this).smakflakes.settings.wind = -5;
					if (wind > 5) $(this).smakflakes.settings.wind = 5;
					}
				else {
					if (typeof(wind) == 'string') {
						switch(wind) {
							case 'random': case 'timechange': break;
							default: $(this).smakflakes.settings.wind = wind; break;
							} 
						}
					}
				return $(this).smakflakes.settings.wind;
				},
			setfalspeed: function (falspeed) {
				$(this).smakflakes.settings.falspeed = falspeed;
				if (falspeed < 1) $(this).smakflakes.settings.falspeed = 1;
				if (falspeed > 30) $(this).smakflakes.settings.falspeed = 30;
				return $(this).smakflakes.settings.falspeed;
				},
			stopFalling: function() {
				$(this).smakflakes.settings.stopfall = true;
				return $(this).smakflakes.settings.stopfall;
				},
			startFalling: function() {
				$(this).smakflakes.settings.stopfall = false;
				return $(this).smakflakes.settings.stopfall;
				}
        }        
        if (methods[method]) { return methods[method].apply(this, Array.prototype.slice.call(arguments, 1)); } 
		else if (typeof method === 'object' || !method) { return methods.init.apply(this, arguments); } 
		else { $.error( 'Method "' +  method + '" does not exist in smakflakes plugin!'); }
    }
    $.fn.smakflakes.defaults = {stopfall: false,onoffpos: 'top right',flakescount: 60,flakesize: 1,randomsize: true,flaketype: 'darker',flakecolor: {r:255,g:255,b:255},flakeshadow_color: {r:0,g:0,b:0},falspeed: 1,wind: 0,flakesfile: '',firotation: 'toandfro'}
    $.fn.smakflakes.settings = { }
})(jQuery);