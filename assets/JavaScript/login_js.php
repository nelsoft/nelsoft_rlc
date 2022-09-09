<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script>
$(function(){
    $(document).ready(function(){
        $("#login").click(function(){
            login();
        });
    });
    $("#pass").keypress(function(evt){
            if (evt.keyCode == 13) {
                login();
            }
    });
    function login()
    {
        var username_val = $('#username').val();
        var password_val = $('#pass').val();
        $.get("<?=base_url()?>login/check_username_control",
            {
            username: username_val , 
            password: password_val},
            
        function(data) {
            console.log(data.userid);
            if (data == "error")
                alert("Invalid username and password");
            if (data.id > 0)
                window.location.replace('controlpanel');
            else  if (data.id == 0)
                window.location.replace('personalinfo');
        },'JSON');
    }
});
</script>