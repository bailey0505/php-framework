$(document).ready(function(){

    $('#reset-password-request-form').on('submit', function(e){
        e.preventDefault();

        var data = {};
        data['action'] = 'request-reset-password';
        data['username'] = $('[name="username"]').val();

        var request = $.ajax({
            url: "/app/Ajax/reset-password.php",
            method: "POST",
            data: data,
            dataType: "json"
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log("Request failed: " + textStatus);
        });
        request.done(function(result) { 
            if(result['result']){
                ShowAlert(result['message'], "success");
            }else{
                ShowAlert(result['message'], "error");
            }
        });
    });
});