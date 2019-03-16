<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Monitor My Stuff</title>
  <meta name="description" content="Test">
  <meta name="author" content="jbelaire">
  <script src="<?php resolveUrl('Scripts/jquery-3.1.1.min.js')?>"></script>

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
    <script src="<?php resolveUrl('Scripts/main.js')?>"></script>
    <script>
        function logout(){
            $.ajax({
                type:'POST',
                url: '<?php resolveUrl('Logout') ?>',
                dataType:'json',
                success: function(e){
                    location.reload();
                },
                error: function(e){
                    console.error(e);
                }
            });
        }
    </script>
    <div class="main">
        <div class="header">
            <div class="flexWrapper">
                
                <div></div>
                <div><h3>LOGO PLACEHOLDER</h3></div>
                <div style="padding-right">
                    <?php if(authenticated()) { ?>
                        <button onclick="logout()">Log Out</button>
                    <?php } ?>
                </div>
        
            </div>
        </div>
            <div class="body">

            <?php
            
              require_once '.config.php';

              if(authenticated()){
                  require_once 'Views/CamView.php';
              }
              else{
                  require_once 'Views/LogonView.php';
              }
            ?>
        </div>
    </div>


</body>
</html>
