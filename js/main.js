function login_now(){
    var email = $("#email").val();
    var password = $("#password").val();

    $.ajax({
        url:'login_verify.php',
        type:'post',
        data : {email:email,password:password},
        success : function(result){
            if(result=="done"){
                window.location.href= 'dashboard.php';
            }
            $("#msg").html(result);
        }
    });
}