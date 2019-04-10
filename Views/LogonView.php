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
    
    .errorSummary{
        width: 100%;
        text-align: center;
        color: red;
        padding-top: 20px;
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
           },
           error: function(e){
               console.error(e);
           },
            complete: function(){
                location.reload();

            }
        });
    }
    
    
    
    $(document).ready(function(){
        $('#btnEnter').on('keyup', function(e){
            if (e.keyCode === 13) {
                e.preventDefault();
                $(this).click();
            }
        });
        
        $('#txtUsername').focus();
        
        $('input').keyup(function(e){
            if(e.key === "Enter"){
                $('#btnEnter').click();
            }
        
        });
    });
</script>
<div class="login">
    <?php 
        $loginAttemps = getLoginAttempts();
        if(!hasExceededLoginMax()){
    ?>
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
    <?php
        }  
        else {
           
    ?>
        <img src="<?php resolveUrl("Images/UI/lock.png"); ?>" width="200"/>
        <br/>
        <p style="color:red">Max attempts exceeded. You will be locked out for <?php echo ConfigManager::Value('LockoutExpirationTimeSeconds') / 60 ?> minutes.</p>
        
    <?php
        }
    ?>
    
</div>
<div class="errorSummary">
    <?php
        $attemptsLeft = getMaxLoginAttempts() - getLoginAttempts();
        if($attemptsLeft > 0 && $attemptsLeft != getMaxLoginAttempts()){
            
            echo "<span>WARNING: $attemptsLeft attempts remaining.</span>";
        }
    ?>
    
</div>