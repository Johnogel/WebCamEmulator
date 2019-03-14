<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Monitor My Stuff</title>
  <meta name="description" content="Test">
  <meta name="author" content="jbelaire">
  <script src="<?php echo $rootPath?>/Scripts/jquery-3.1.1.min.js"></script>

</head>

<body>
    <style>
        div{
            display: inline-block;
        }
        
        body{
            background-color: #46494f;
            color: white;
            margin:0px;
            padding:0px;
            
        }
        
        .main {
            width: 100vw;
        }
        
        .main .header{
            background-color: #36383d;
            box-shadow: 0px 3px 10px 3px #202123;
            width: 100%;
            height: 70px;
            
        }
        
        .header .flexWrapper{
            text-align: center;
            margin: 0 auto;
            width: 90%;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .body{
            width:100%;
        }
    </style>
    <script src="<?php echo $rootPath?>/Scripts/main.js"></script>
    <div class="main">
        <div class="header">
            <div class="flexWrapper">
                
                <div></div>
                <div><h3>LOGO PLACEHOLDER</h3></div>
                <div style="padding-right"><a>log out</a></div>
        
            </div>
        </div>
            <div class="body">

            <?php
              require_once '.config.php';

              if(isset($_SESSION['pass-hash']) && $_SESSION['pass-hash'] == $passwordHash){
                  require_once 'Views/CamView.php';
              }
              else{
                  require_once 'Views/LogonView.php';
              }
            ?>
        </div>
    </div>

  <script> 
    $(document).ready(function(){
        $.ajax({
            type:'POST',
            url: '<?php echo $rootPath?>/Login',
            contentType: 'application/json',
            content: {'test': 'test'},
            success: function(e){
                console.log(e);
                alert(e);
            },
            error: function(err){
                console.error(err);
    
            }
            
        });
    });

      
      
  </script>
</body>
</html>
