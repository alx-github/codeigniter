$(document).ready(function(){
	var isGettingPassword = false;
	$('.js-generate-password').click(function(e){
		e.preventDefault();		
		if(!isGettingPassword){
			isGettingPassword = true;
			$.getJSON($(this).data('url'), function(response){
				$('#password').val(response.password);
				isGettingPassword = false;
			});		
		}
	});

	$('input[type=radio]').click(function(e){
		change_brands_status();
	});

	var x = change_brands_status();
	function change_brands_status(){
		var type = $('input[name="type"]:checked').val();
		if(type == 1)
		{
			$('#list_brands').hide();
		} 
		else 
		{
			$('#list_brands').show();
		}
	}

	
});
