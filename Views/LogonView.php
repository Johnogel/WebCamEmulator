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
        $.ajax({
           type:'POST',
           url: '',
           success: function(e){
               
           },
           error: function(e){
               
           }
        });
    }
</script>
<div class="login">
    
    <table cellspacing="5" cellpadding="10">
        <tr>
            <td>Username</td>
            <td><input type="text" /></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" /></td>
        </tr>
        <tr>
            <td colspan="2"><button>Log In</button></td>
        </tr>
        
    </table>
    
</div>