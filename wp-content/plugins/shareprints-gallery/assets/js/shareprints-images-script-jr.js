/**
 * Shareprints Gallery
 *
 * @package   Shareprints
 * @author    JR w/Freak Plugins <jr@freakplugins.com>
 * @license   GPLv3+
 * @link      http://freakplugins.com
 * @copyright Copyright (c) 2014 Freak Plugins, LLC - All Rights Reserved
 */var shareprints={post_id:0,l10n:shareprints_images_l10n,o:null,helpers:{get_atts:null},media:null,cruncher:null,shareprints_images:{}};(function(e){shareprints.helpers.isset=function(){var e=arguments,t=e.length,n=null,r;if(t===0)throw new Error("Empty isset");n=e[0];for(i=1;i<t;i++){if(e[i]===r||n[e[i]]===r)return!1;n=n[e[i]]}return!0};shareprints.helpers.get_atts=function(t){var n={};e.each(t[0].attributes,function(e,t){t.name.substr(0,5)=="data-"&&(n[t.name.replace("data-","")]=t.value)});return n};e.fn.exists=function(){return e(this).length>0};shareprints.media={div:null,frame:null,render_timout:null,clear_frame:function(){if(!this.frame)return;this.frame.detach();this.frame.dispose();this.frame=null},type:function(){var e="thickbox";typeof wp!="undefined"&&(e="backbone");return e},init:function(){if(this.type()!=="backbone")return!1;if(!shareprints.helpers.isset(wp,"media","view","AttachmentCompat","prototype"))return!1;var t=wp.media.view.AttachmentCompat.prototype;t.sp_orig_render=t.render;t.sp_orig_dispose=t.dispose;t.className="compat-item shareprints_postbox no_box";t.render=function(){var t=this;if(t.ignore_render)return this;this.sp_orig_render();setTimeout(function(){var n=t.$el.closest(".media-modal");if(n.hasClass("shareprints-media-modal"))return;if(n.find(".media-frame-router .shareprints-expand-details").exists())return;var r=e(['<a href="#" class="shareprints-expand-details">','<span class="icon"></span>','<span class="is-closed">'+shareprints.l10n.expand_details+"</span>",'<span class="is-open">'+shareprints.l10n.collapse_details+"</span>","</a>"].join(""));r.on("click",function(e){e.preventDefault();n.hasClass("shareprints-expanded")?n.removeClass("shareprints-expanded"):n.addClass("shareprints-expanded")});n.find(".media-frame-router").append(r)},0);clearTimeout(shareprints.media.render_timout);shareprints.media.render_timout=setTimeout(function(){e(document).trigger("shareprints/setup_images",[t.$el])},50);return this};t.dispose=function(){this.sp_orig_dispose()};t.save=function(e){var t={},n={};e&&e.preventDefault();_.each(this.$el.serializeArray(),function(e){if(e.name.slice(-2)==="[]"){e.name=e.name.replace("[]","");typeof n[e.name]=="undefined"&&(n[e.name]=-1);n[e.name]++;e.name+="["+n[e.name]+"]"}t[e.name]=e.value});this.ignore_render=!0;this.model.saveCompat(t)}}};shareprints.shareprints_images={$el:null,o:{},set:function(t){e.extend(this,t);this.$input=this.$el.children('input[type="hidden"]');this.o=shareprints.helpers.get_atts(this.$el);this.o.query={};this.o.view="grid";this.$el.hasClass("view-list")&&(this.o.view="list");return this},init:function(){this.render();this.$el.find("> .thumbnails > .inner").sortable({items:"> .thumbnail",forceHelperSize:!0,forcePlaceholderSize:!0,scroll:!0,start:function(e,t){t.placeholder.width(t.placeholder.width()-4);t.placeholder.height(t.placeholder.height()-4)}})},view:function(e){this.o.view=e;this.render()},render:function(){var e=this.$el.find(".thumbnails .thumbnail").length,t=shareprints.l10n["count_"+Math.min(e,2)].replace("%d",e),n=this.$el.find(".toolbar .count");n.html(t);if(this.o.view=="list"){this.$el.addClass("view-list").removeClass("view-smaller");this.$el.find(".toolbar .active").removeClass("active");this.$el.find(".toolbar .view-list-li").addClass("active")}if(this.o.view=="smaller"){this.$el.addClass("view-smaller").removeClass("view-list");this.$el.find(".toolbar .active").removeClass("active");this.$el.find(".toolbar .view-smaller-li").addClass("active")}if(this.o.view=="grid"){this.$el.removeClass("view-list").removeClass("view-smaller");this.$el.find(".toolbar .active").removeClass("active");this.$el.find(".toolbar .view-grid-li").addClass("active")}},add:function(t){this.set({$el:shareprints.media.div});var n=this.$el.find(".tmpl-thumbnail").html();e.each(t,function(e,t){var r=new RegExp("{"+e+"}","g");n=n.replace(r,t)});this.$el.find(".thumbnails > .inner").append(n);this.render();this.$el.closest("#shareprints_gallery_images").removeClass("error")},edit:function(t){shareprints.media.div=this.$el;shareprints.media.clear_frame();shareprints.media.frame=wp.media({title:shareprints.l10n.edit,multiple:!1,button:{text:shareprints.l10n.update}});shareprints.media.frame.on("open",function(){shareprints.media.frame.content._mode!="browse"&&shareprints.media.frame.content.mode("browse");shareprints.media.frame.$el.closest(".media-modal").addClass("shareprints-media-modal shareprints-expanded");var n=shareprints.media.frame.state().get("selection"),r=wp.media.attachment(t);r.fetch();n.add(r);shareprints.media.frame.$el.on("change",".setting input, .setting textarea",function(){var n=e(this),r=n.closest(".setting").attr("data-setting");e('.shareprints-images .thumbnail[data-id="'+t+'"] .td-'+r).html(n.val())})});shareprints.media.frame.on("close",function(){shareprints.media.frame.$el.closest(".media-modal").removeClass("shareprints-media-modal")});shareprints.media.frame.open()},remove:function(e){var t=this;$thumb=this.$el.find('.thumbnails .thumbnail[data-id="'+e+'"]');$thumb.animate({opacity:0},250,function(){$thumb.remove();t.render()})},render_collection:function(){setTimeout(function(){var e=shareprints.media.div,t=shareprints.media.frame.content.get().$el;collection=shareprints.media.frame.content.get().collection||null;if(collection){var n=-1;collection.each(function(r){n++;var s=t.find(".attachments > .attachment:eq("+n+")");if(e.find('.thumbnails .thumbnail[data-id="'+r.id+'"]').exists()){r.off("selection:single");s.addClass("shareprints-selected")}})}},0)},popup:function(){var e=this;shareprints.media.div=this.$el;shareprints.media.clear_frame();shareprints.media.frame=wp.media({states:[new wp.media.controller.Library({library:wp.media.query(this.o.query),multiple:!0,title:shareprints.l10n.select,priority:20,filterable:"all"})]});shareprints.media.frame.on("content:activate",function(){var t=null,n=null;try{t=shareprints.media.frame.content.get().toolbar;n=t.get("filters")}catch(r){}if(!n)return!1;n.$el.find('option[value="uploaded"]').remove();e.render_collection();shareprints.media.frame.content.get().collection.on("reset add",function(){e.render_collection()})});shareprints.media.frame.on("select",function(){selection=shareprints.media.frame.state().get("selection");if(selection){shareprints.cruncher.val.crunchList=[];shareprints.cruncher.val.count=0;selection.each(function(t){if(e.$el.find('.thumbnails .thumbnail[data-id="'+t.id+'"]').exists())return;var n={id:t.id,title:t.attributes.title,name:t.attributes.filename,url:t.attributes.url,caption:t.attributes.caption,alt:t.attributes.alt,description:t.attributes.description,layout:t.attributes.layout};t.attributes.type!="image"&&(n.url=t.attributes.icon);t.attributes.sizes&&t.attributes.sizes[e.o.preview_size]&&(n.url=t.attributes.sizes[e.o.preview_size].url);if(!t.attributes.shareprints){shareprints.cruncher.val.crunchList[shareprints.cruncher.val.count]=t.id;shareprints.cruncher.val.count+=1}e.add(n)});shareprints.cruncher.val.crunchList.length>0&&shareprints.cruncher.crunchThumbs()}});shareprints.media.frame.open();return!1}};shareprints.cruncher={el:{gallery:!1,progressBar:!1},val:{count:0,allImages:{},crunchList:[],checking:!1},crunchThumbs:function(){shareprints.cruncher.el.gallery||(shareprints.cruncher.el.gallery=e("#shareprints_gallery_images").children(".shareprints-images").children(".thumbnails"));shareprints.cruncher.val.failures=0;if(shareprints.cruncher.val.crunchList.length){shareprints.cruncher.checkThumbs(shareprints.cruncher.val.crunchList.shift());shareprints.cruncher.val.checking=!0;shareprints.cruncher.disableButton()}},checkThumbs:function(t){shareprints.cruncher.flagLoading(t);e.ajax({type:"POST",dataType:"json",data:{imageID:t,security_seed:shareprints_images_l10n.ajax_nonce},url:shareprints_images_l10n.url+"?action=shareprints_check_thumbs",success:function(e){e==="success"?shareprints.cruncher.flagLoading(t):shareprints.cruncher.flagFailure(t,e);if(shareprints.cruncher.val.crunchList.length){shareprints.cruncher.val.checking=!0;shareprints.cruncher.progressBar(!0);shareprints.cruncher.checkThumbs(shareprints.cruncher.val.crunchList.shift())}else{shareprints.cruncher.val.checking=!1;shareprints.cruncher.progressBar(!1)}},error:function(e){shareprints.cruncher.flagFailure(t,shareprints.l10n.ajax_error);if(shareprints.cruncher.val.crunchList.length){shareprints.cruncher.val.checking=!0;shareprints.cruncher.progressBar(!0);shareprints.cruncher.checkThumbs(shareprints.cruncher.val.crunchList.shift())}else{shareprints.cruncher.val.checking=!1;shareprints.cruncher.progressBar(!1)}}})},progressBar:function(t){if(!shareprints.cruncher.el.progressBar){shareprints.cruncher.val.total=shareprints.cruncher.val.crunchList.length;shareprints.cruncher.val.progress=1;shareprints.cruncher.el.progressBar=e('<div id="shareprints_progress"><span id="perc"/><span id="bar"/></div>');shareprints.cruncher.el.gallery.parent().prepend(shareprints.cruncher.el.progressBar)}var n=shareprints.cruncher.el.progressBar.children("#bar");perc=shareprints.cruncher.el.progressBar.children("#perc"),count=shareprints.cruncher.val.progress,total=shareprints.cruncher.val.total,figure=Math.round(count/total*1e3)/10+"%";if(t){perc.text(shareprints.l10n.processing_images+" "+figure);n.css({width:figure});shareprints.cruncher.val.progress+=1}else if(shareprints.cruncher.val.failures>0){var r=shareprints.cruncher.val.failures>1?shareprints.l10n.images_na:shareprints.l10n.image_na;perc.text(shareprints.cruncher.val.failures+" "+r);n.css({width:"100%",background:"red"});shareprints.cruncher.el.gallery.find(".shareprints-retry-box").fadeIn(250)}else{shareprints.cruncher.el.progressBar.remove();shareprints.cruncher.el.progressBar=!1}},flagLoading:function(e){var t=shareprints.cruncher.el.gallery.find('.thumbnail[data-id="'+e+'"]');t.toggleClass("sp_loading");return},flagFailure:function(t,n){var r=shareprints.cruncher.el.gallery.find('.thumbnail[data-id="'+t+'"]');r.removeClass("sp_loading").addClass("failure");shareprints.cruncher.val.failures+=1;var i=e('<div class="shareprints-retry-box"><p>'+n+"</p></div>"),s=e('<div class="shareprints-retry-options"><span>'+shareprints.l10n.retry+'</span><a data-retry="yes" class="shareprints-retry-button shareprints-retry-yes">'+shareprints.l10n.yes+'</a> | <a data-retry="no" class="shareprints-retry-button shareprints-retry-no">'+shareprints.l10n.no+"</a></div>");i.hide().append(s);r.append(i);shareprints.cruncher.retryCrunch(r,t,s);return},retryCrunch:function(t,n,r){r.find("a").click(function(){var r=e(this).data("retry");if(r==="yes"){t.find(".shareprints-retry-box").remove();t.removeClass("failure");shareprints.cruncher.val.failures+=-1;shareprints.cruncher.checkThumbs(n)}else{shareprints.cruncher.val.failures+=-1;shareprints.cruncher.progressBar(!1);e("#post").siblings("#message.error.sp_val_error").remove();t.children(".hover").find(".shareprints-button-delete").trigger("click");delete shareprints.cruncher.val.allImages[n]}})},disableButton:function(){var t;if(e("body").hasClass("post-type-shareprints"))t=e("#publish");else if(e("#sp_update_gallery").is(":visible"))t=e("#sp_update_gallery");else{if(!e("#sp_publish_gallery").is(":visible"))return;t=e("#sp_publish_gallery")}if(!t.data("disabled")){t.data("disabled",!0);t.click(function(n){if(shareprints.cruncher.val.checking){n.preventDefault();e("#post").siblings("#message").remove().end().before('<div id="message" class="error"><p>'+shareprints.l10n.please_wait+"</p></div>");return}if(shareprints.cruncher.val.failures>0){n.preventDefault();e("#post").siblings("#message").remove().end().before('<div id="message" class="error sp_val_error"><p>'+shareprints.cruncher.el.progressBar.children("#perc").text()+"</p></div>");return}t.data("disabled",!1)})}}};e(window).load(function(){shareprints.media.init();setTimeout(function(){e(document).trigger("shareprints/setup_images",[e("#poststuff")])},10)});e(document).on("click",".shareprints-images .shareprints-button-edit",function(t){t.preventDefault();var n=e(this).closest(".thumbnail").attr("data-id");shareprints.shareprints_images.set({$el:e(this).closest(".shareprints-images")}).edit(n);e(this).blur()});e(document).on("click",".shareprints-images .shareprints-button-delete",function(t){t.preventDefault();var n=e(this).closest(".thumbnail").attr("data-id");shareprints.shareprints_images.set({$el:e(this).closest(".shareprints-images")}).remove(n);e(this).blur()});e(document).on("click",".shareprints-images .add-image",function(t){t.preventDefault();shareprints.shareprints_images.set({$el:e(this).closest(".shareprints-images")}).popup();e(this).blur()});e(document).on("click",".shareprints-images .view-grid",function(t){t.preventDefault();shareprints.shareprints_images.set({$el:e(this).closest(".shareprints-images")}).view("grid");e(this).blur()});e(document).on("click",".shareprints-images .view-smaller",function(t){t.preventDefault();shareprints.shareprints_images.set({$el:e(this).closest(".shareprints-images")}).view("smaller");e(this).blur()});e(document).on("click",".shareprints-images .view-list",function(t){t.preventDefault();shareprints.shareprints_images.set({$el:e(this).closest(".shareprints-images")}).view("list");e(this).blur()});e(document).on("click",".shareprints-images a.tab",function(t){t.preventDefault();var n=e(this).data("target");e(this).parents(".tabs").find(".active").removeClass("active");e(this).addClass("active");e(this).parents(".list-data").find(".tab-panel.active").removeClass("active");e(this).parents(".list-data").find("#"+n).addClass("active")});e(document).on("shareprints/setup_images",function(t,n){e(n).find(".shareprints-images").each(function(){shareprints.shareprints_images.set({$el:e(this)}).init()})})})(jQuery);