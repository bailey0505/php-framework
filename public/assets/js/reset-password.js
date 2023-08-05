$(document).ready(function(){

    $('#reset-password-request-form').on('submit', function(e){
        e.preventDefault();

        $('#reset-password-request-button').prop('disabled', true);

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

            $('#reset-password-request-button').prop('disabled', false);
        });
    });


    $('#reset-password-form').on('submit', function(e){
        e.preventDefault();

        $('#reset-password-button').prop('disabled', true);

        var data = {};
        data['password'] = $('[name="password"]').val();

        var passwordRetype = $('[name="passwordRetype"]').val();

        if(data['password'] !== passwordRetype){
            ShowAlert("Password does not match", "error");
            return false;
        }

        data['Id_admin_users'] = $('[name="Id_admin_users"]').val();
        data['reset_token'] = $('[name="reset_token"]').val();
        data['action'] = 'reset-password';

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
                document.location.href = "/";
            }else{
                $('#reset-password-button').prop('disabled', false);
                ShowAlert(result['message'], "error");
            }
        });

    });
});