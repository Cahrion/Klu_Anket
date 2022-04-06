$(document).ready(function(){
    $(".girisYap").click(function(){
        var gelenEmail = $("#email").val();
        var gelenPass = $("#password").val();
        var gelenAction =  $("form").attr("action");
        $.post(gelenAction, { gelenEmail: gelenEmail,gelenPass: gelenPass}, function (data) {
            if (data.length > 0) {
                if (data == 1) {
                    history.back();
                }
            }
        });
    });
});