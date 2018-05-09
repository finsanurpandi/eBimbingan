// ALERT AUTOCLOSED
window.setTimeout(function() {
    $(".alert.alert-success").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);

// function getNumComment(id_bimbingan_ta)
// {
//     console.log(id_bimbingan_ta);
//     $.ajax({
//         method: "post",
//         url: baseurl+"ajax/getNumComment",
//         data: {id_bimbingan_ta:id_bimbingan_ta},
//         success: function(res){
//             $('#numComment').text(res);
//             console.log(res);
//         }
//     });
// }



