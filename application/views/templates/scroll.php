<script>

jQuery(document).ready(function($) {
	var fixedHeaderHeight = 100;

	$('.card-header').click(function(event){
		$('.scroll').off('shown.bs.collapse')
			.on('shown.bs.collapse', function () {
				$('.scroll').off('shown.bs.collapse');

				setTimeout(function() {
					var top = $(event.delegateTarget).offset().top;
					var scroll_top = top - fixedHeaderHeight;
					$('html, body').animate({scrollTop: scroll_top}, 500);
				}, 0);
		});
	});
});

</script>
