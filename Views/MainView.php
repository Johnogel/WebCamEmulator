<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Security Camera</title>
  <meta name="description" content="Security PTZ Camera">
  <meta name="author" content="jbelaire">
  <script src="<?php resolveUrl('Scripts/jquery-3.1.1.min.js')?>"></script>
  <script src="<?php resolveUrl('Scripts/knockout-3.5.0.js')?>"></script>


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
            box-shadow: 0px 1px 4px 1px #202123;
            width: 100%;
            height: 130px;
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
        
        .header .outer{
            width: 70px;
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
                
                <div class="outer" ></div>
                <div><img src="<?php resolveUrl('Images/logo.jpg')?>" /></div>
                <div class="outer">
                    <?php if(authenticated()) { ?>
                        <button onclick="logout()">Log Out</button>
                    <?php } ?>
                </div>
        
            </div>
        </div>
            <div class="body">

            <?php

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
