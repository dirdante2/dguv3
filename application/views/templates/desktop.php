<script>
$(document).ready( function () {
    $('#table').DataTable( {
		  "language": {
            "url": "<?php echo base_url(); ?>lib/datatables/German.json"
           } ,
      "paging": true,
      "bSmart": true,
      "bFilter": true,
      "bSort": true,
      "info": true,
      "iDisplayLength":25,
      "order": [[ 0, "desc" ]]
      
  
           
     } );
     $('#tabledesc').DataTable( {
		  "language": {
            "url": "<?php echo base_url(); ?>lib/datatables/German.json"
           } ,
      "paging": true,
      "bSmart": true,
      "bFilter": true,
      "bSort": true,
      "info": true,
      "iDisplayLength":25,
      "order": [[ 0, "desc" ]]
      
  
           
     } );
           
           
           
    $('#table_print').DataTable( {
        //"order": [[ 0, "desc" ]],
        "paging": false,
      	"bFilter": false,
      	"bSort": false,
        "info": false,
      	"columnDefs": [ {
			      "targets": 'no-sort',
			      "orderable": false
    			} ]
    			
    			
    } );

    
    
    
    
    $('#table_passiv').DataTable( {
          	 
      "paging": false,
      "bFilter": false,
      "bSort": false,
      "info": false
    } );
            
 var table = $('#table').DataTable();
 
// #column3_search is a <input type="text"> element
$('#suche_inaktiv').on( 'click', function () {
    table
        .columns( 1 )
        .search( "1")
        .draw();
} );
$('#suche_abgelaufen').on( 'click', function () {
    table
        .columns( 1 )
        .search( "2")
        .draw();
} );

$('#suche_baldabgelaufen').on( 'click', function () {
    table
        .columns( 1 )
        .search( "3")
        .draw();
} );
$('#suche_failed').on( 'click', function () {
    table
        .columns( 1 )
        .search( "4")
        .draw();
} );
$('#suche_alle').on( 'click', function () {
    table
        .columns( 1 )
        .search( "")
        .draw();
} );

  var table2 = $('#tabledesc').DataTable();
 
// #column3_search is a <input type="text"> element
$('#suche_inaktiv').on( 'click', function () {
    table2
        .columns( 1 )
        .search( "1")
        .draw();
} );
$('#suche_abgelaufen').on( 'click', function () {
    table2
        .columns( 1 )
        .search( "2")
        .draw();
} );

$('#suche_baldabgelaufen').on( 'click', function () {
    table2
        .columns( 1 )
        .search( "3")
        .draw();
} );
$('#suche_failed').on( 'click', function () {
    table2
        .columns( 1 )
        .search( "4")
        .draw();
} );
$('#suche_alle').on( 'click', function () {
    table2
        .columns( 1 )
        .search( "")
        .draw();
} );





   } );
   



 </script>


