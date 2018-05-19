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
    $('#btn-add-mhs').prop('disabled', true);

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



// CHECK NPM AVAILABLE OR NOT
function check_npm()
{
    var npm = $('#npm-prodi').val();

    $.ajax({
        method: "post",
        url: baseurl+"ajax/npmAvailability",
        data: {npm: npm},
        success: function(res){
            if (res == 1) {
                $('#status-npm').html("<p class='text-danger'><i class='fa fa-remove'></i> NPM sudah digunakan!!!</p>");
                $('#btn-add-mhs').prop('disabled', true);
                $('#npm-prodi-group').removeClass('has-success');
                $('#npm-prodi-group').addClass('has-error');
            } else {
                $('#status-npm').html("<p class='text-success'><i class='fa fa-check'></i> NPM tersedia!!!</p>");
                $('#btn-add-mhs').prop('disabled', false);
                $('#npm-prodi-group').removeClass('has-error');
                $('#npm-prodi-group').addClass('has-success');
            }
        }
    })
}




