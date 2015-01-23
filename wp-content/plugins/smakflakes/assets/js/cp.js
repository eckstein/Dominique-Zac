jQuery(document).ready(function($){
    $('#flakecolor.color-field').wpColorPicker({
		change: function(event, ui) {
			$('#flakecolor_rgb').val('{r:'+ui.color.toRgb().r+',g:'+ui.color.toRgb().g+',b:'+ui.color.toRgb().b+'}');
			console.log('{r:'+ui.color.toRgb().r+',g:'+ui.color.toRgb().g+',b:'+ui.color.toRgb().b+'}');
			}
    });
	
	$('#flakeshadow_color.color-field').wpColorPicker({
		change: function(event, ui) {
			$('#flakeshadow_color_rgb').val('{r:'+ui.color.toRgb().r+',g:'+ui.color.toRgb().g+',b:'+ui.color.toRgb().b+'}');
			}
    });
	
	$('#flaketype').on('change', function() {
		set_flaketype($(this).val());
		});
	function set_flaketype(val) {
		switch (val) {
			case 'colored': 
				$('#flakecolors').show();			
				break;
			default:
				$('#flakecolors').hide();
				break;
			}
		}
	set_flaketype($('#flaketype').val());
	
	
	
});