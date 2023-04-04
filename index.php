<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
    <script type="text/javascript" src="js/lightbox.js"></script>
    <title>Document</title>
    <style>
        form {
            text-align:center;
            margin:auto;
        }
        input {
            height:2vw;
        }
        input {
            font-size:1vw;
            width: 15vw;
            border-radius:5px;
        }
        
        body {
            background-image: url('grnd.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            color: ghostwhite;
        }
        a {
            text-decoration: none;
		}
        .box{
            margin-left: auto;
            margin-right: auto;
            width: 20vw;
            background-color: white;
            border: 3px solid #615285;
            border-radius: 1vw;
            text-align: center;
        }
        .el{
            margin-left: auto;
            margin-right: auto;
            font-size: 2vw;
            line-height: 5vw;
            border: 1px solid #615285;
            border-radius: 1vw;
            width: 18vw;
            align-self: center;
        }
    </style>
</head>

<div class="box">
        <p class="el"><a href="AddToTab.php">Добавить</a></p>
        <p class="el"><a href="ShowTab.php">Посмотреть</a></p>
</div>
</body>
</html>