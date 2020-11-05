$(document).ready(function($){
    alert('jquery');
    $("textarea[name=memo]").focus();
});



$('.memo-delete').on('click', function() {
    var confirmed = confirm('Really?')
    if (confirmed) {
        $('#memo-delete').submit()
    }
});
