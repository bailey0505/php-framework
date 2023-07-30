$(document).ready(function(){
    console.log(window.notyf);
    
    $('#login-form').on('submit', function(e){
        e.preventDefault();

        var data = {};
        data['action'] = 'login';
        data['username'] = $('[name="username"]').val();
        data['password'] = $('[name="password"]').val();

        var request = $.ajax({
            url: "/app/Ajax/authentication.php",
            method: "POST",
            data: data,
            dataType: "json"
        });
        request.fail(function( jqXHR, textStatus ) {
            console.log("Request failed: " + textStatus);
        });
        request.done(function(result) { 
            if(result['result']){
                window.location = '/';
            }else{
                ShowAlert(result['message'], "error");
            }
        });

    });
});