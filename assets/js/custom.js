// ALERT AUTOCLOSED
window.setTimeout(function() {
    $(".alert.alert-success").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
    $(".alert.alert-danger").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);

$(document).ready(function(){
    $('#formDecline').hide();

    $('#btn-decline-post').prop('disabled', true);

    $('#declineComment').keyup(function(e){
        if (this.value.split(' ').length > 5) {
            $('#btn-decline-post').prop('disabled', false);
            $('#commentValue').val(this.value);
        } else {
            $('#btn-decline-post').prop('disabled', true);
        }
    });
    
});

$('#btn-decline').click(function(){
    $('#formDecline').slideToggle();
});




