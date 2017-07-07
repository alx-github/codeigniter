var $j = jQuery.noConflict();

$j(document).ready(function(){
	var isGettingPassword = false;
	$j('.js-generate-password').click(function(e){
		e.preventDefault();

		if(!isGettingPassword){
			isGettingPassword = true;
			$j.getJSON($j(this).data('url'), function(response){
				$j('#password').val(response.password);
				isGettingPassword = false;
			});
		}
	});
});