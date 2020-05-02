<script>
$(document).ready(function(){

// URL to simulate success
const success =
  "https://dguv3.d-systems.us/Dguv3/get_toast";


//start hier
//$( document ).ready( start );


function start() {

	let url;

url = success;

$.get(url, function (html) {

  toastr.remove();
  showToastr("success", "Success!", html);

});
	//showToastr("info", "Please Wait", "I'm fetching some data.");
 // setTimeout(loadResponse, 0); // Setting arbitrary timeout here so we can see the 'loading' state.
}

function loadResponse() {
  let url;

    url = success;

  $.get(url, function (html) {

      toastr.remove();
      showToastr("success", "Success!", html);

  });
}

function showToastr(type, title, message) {
  let body;
  toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
	progressBar: true,
    positionClass: "toast-bottom-right",
    preventDuplicates: true,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: 0,
    onclick: null,
    onCloseClick: null,
    extendedTimeOut: 0,
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
    tapToDismiss: true
  };
  switch (type) {
    case "info":
      body = "<span> <i class='fa fa-spinner fa-pulse'></i></span>";
      break;
    default:
      body = "";
  }
  const content = message + body;
  toastr[type](content, title);
}


});
</script>


