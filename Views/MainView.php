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
        
        input{
            caret-color: white;
        }
        
        /* Change the white to any color ;) */
        input[type="text"]:-webkit-autofill,
        input[type="text"]:-webkit-autofill:hover, 
        input[type="text"]:-webkit-autofill:focus, 
        input[type="text"]:-webkit-autofill:active,
        input[type="password"]:-webkit-autofill,
        input[type="password"]:-webkit-autofill:hover, 
        input[type="password"]:-webkit-autofill:focus, 
        input[type="password"]:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #36383d inset !important;
            min-height: 30px;
            caret-color: white;
            color: white;
            text-shadow: 0px 0px 0px #000;
            -webkit-text-fill-color: transparent;
        }

        input[type="text"]:-webkit-autofill,
        input[type="password"]:-webkit-autofill,
        input[type="text"], textarea,
        input[type="password"], textarea{
            -webkit-text-fill-color: white !important;
            padding-left:5px;
            background-color: #36383d;
        }

        input{
            min-width: 75px;
            min-height: 25px;
            background-color: Transparent;
            background-repeat:no-repeat;
        }

        button, input[type="button"]{

            border: lightgrey 1px solid;
            color: white;
            background-color: #36383d;
            cursor:pointer;
            overflow: hidden; 
            box-shadow: 0px 0px 1px 1px gray;
            min-width: 75px;
            min-height: 25px;

        }



        button:hover, 
        input[type="button"]:hover{
            border: darkslateblue 1px solid;
            color: gray;
            cursor:pointer;
            box-shadow: 0px 0px 1px 1px darkgray;
        }

        button:active, 
        input[type="button"]:active{
            border: blue 1px solid;
            color: black;
            min-width: 75px;
            min-height: 25px;
            cursor:pointer;
            box-shadow: 0px 0px 1px 3px black;
        }

        
        
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
        
        document.addEventListener('contextmenu', event => event.preventDefault());
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
