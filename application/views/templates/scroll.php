<script>

jQuery(document).ready(function($) {
	$('.scroll').click(function(){

       console.log(event.srcElement.id);
        var currentId = event.srcElement.id;
        console.log(event.srcElement.className)

       
        
        //es gibt error wenn class nicht existiert
        $('.scroll').on('shown.bs.collapse', function () {

            currentId2 = "#heading" + currentId;
		setTimeout(function() { //<-- delayed animation  
			$('html, body').animate({
				scrollTop: $(currentId2).offset().top - 100 //<-- This beacuse I have a fixed header
			}, 500);
		}, 200);
})
		
         
});
});

</script>


