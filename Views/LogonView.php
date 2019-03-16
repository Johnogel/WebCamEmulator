<style>
    .login {
        display: block;
        padding-top:50px;
        margin: 0 auto;
        text-align: center;
        
    }
    
    .login table{
        margin: 0 auto;
    }
    
    .login button{
        width: 150px;
        height: 30px;
    }
</style>
<script>
    function login(){
        var postData = {
            username: $('#txtUsername').val(),
            password: $('#txtPassword').val()
        };
        
        $.ajax({
           type:'POST',
           url: '<?php resolveUrl('Login') ?>',
           dataType:'json',
           data: JSON.stringify(postData),
           success: function(e){
               location.reload();
           },
           error: function(e){
               console.error(e);
           }
        });
    }
    
    $(document).ready(function(){
        $('#btnEnter').on('keyup', function(e){
            if (e.keyCode === 13) {
                // Cancel the default action, if needed
                e.preventDefault();
                // Trigger the button element with a click
                $(this).click();
            }
        });
    });
</script>
<div class="login">
    
    <table cellspacing="5" cellpadding="10">
        <tr>
            <td>Username</td>
            <td><input id="txtUsername" type="text" /></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input id="txtPassword" type="password" /></td>
        </tr>
        <tr>
            <td colspan="2"><button id="btnEnter" onclick="login()">Log In</button></td>
        </tr>
        
    </table>
    
</div>