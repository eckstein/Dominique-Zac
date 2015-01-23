var dom = {
	init: function(){
		//searchform
		$('#searchform #s').blur(function(){
			dom.toggleSearch(0);
		});
		$(document).keyup(function(e) {
			if (e.keyCode == 27){
				dom.toggleSearch(0);
			}
		});
		//catgrid
		var s = 400;
		$('.catgrid .post').hover(function(){
			$(this).find('.ovl').stop().animate({
				height:"100%"
			}, s);
			$(this).find('.catTitle').stop().animate({
				height:"32px",
				opacity:1,
				marginBottom:"10px",
				paddingBottom:"10px"
			}, s, function(){
				$(this).animate({
					marginLeft:"30px",
					marginRight:"30px",
				}, s);
			});
			$(this).find('.btn').stop().animate({
				opacity:1
			}, s);
		}, function(){
			$(this).find('.ovl').stop().animate({
				height:"70px"
			}, s);
			$(this).find('.catTitle').stop().animate({
				height:0,
				opacity:0,
				marginBottom:0,
				paddingBottom:0,
				marginLeft:0,
				marginRight:0,
			}, s);
			$(this).find('.btn').stop().animate({
				opacity:0
			}, s);
		});
	},
	toggleSearch: function(s) {
        if ($(window).width() > 767) {
            if (s) {
                $('#navbar-collapse > .searchTrigger').hide();
                $('#menuItems').hide();
                $('#searchFormToggler').fadeIn(400);
                $('#searchform #s').focus();
            } else {
                $('#searchFormToggler').hide();
                $('#menuItems').fadeIn(400);
                $('#navbar-collapse > .searchTrigger').fadeIn(400);
                $('#searchform #s').val('');
            }
        }
    },
    toggleSignUp: function(s){
        if(s) {
            $('#mc_embed_signup').fadeOut(400);
        } else {
            $('#mc_embed_signup').fadeIn(400);
            $('#mc_embed_signup').focus();
        }
    }
}