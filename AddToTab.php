<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form{
            width: 100%;
            height: 100%;
        }
        input, textarea{
            border: solid #615285;
            font-size:1vw;
            width: 15vw;
            border-radius:5px;
            color: #615285;
        }
        textarea{
            height: 3vw;
        }
        .parent {
            margin-left: auto;
            margin-right: auto;
            width: 30vw;
            height: 35vw;
            background-color: white;
            border: 3px solid #615285;
            border-radius: 1vw;
            text-align: center;
        }
        .child {
            margin-left: auto;
            margin-right: auto;
            font-size: 1vw;
            line-height: 1.5vw;
            border-radius: 1vw;
            width: 18vw;
        }
        body {
            background-image: url('grnd.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            color: #615285;
            font-size: 1vw;
            position: relative;
        }
        button {
            background-color: #615285;
            border: 1px solid white;
            border-radius: 5px;
            font-size: 1.25vw;
            color: ghostwhite;
        }
        #tooltip {
            z-index: 9999;
            position: absolute;
            display: none;
            top:0px;
            left:0px;
            width: 250px;
            background-color: #fff;
            padding: 5px 10px 5px 10px;
            color: #000;
            border-radius: 5px; 
            box-shadow: 0 1px 2px #555;
        }
    </style>
</head>
<body>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
$db = "lab91011"; 
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$conn = new mysqli($host, $user, $pass); 
if ($conn->connect_error) {
	die("Ошибка в подключении: " . $conn->connect_error);
}

?>
<form enctype="multipart/form-data" action="get.php" method="post">
<div class="parent">
    <div class="child">
        <label>Имя</label><br>
        <input type="text" name="name" size="45"><br>
        <label>Почта</label><br>
        <input id="emailinp" class="form-control" type="email" name="email" size="45"><br>
        <label>Сайт(Необязательно)</label><br>
        <input type="url" name="homepage" size="45"><br>
        <button type="button" onclick="link()">link</button>
        <button type="button" onclick="italic()">italic</button>
        <button type="button" onclick="strike()">strike</button>
        <button type="button" onclick="strong()">strong</button><br>
        <label>Текст</label><br>
        <textarea data-tooltip="Подсказка номер 1" id="textarea" name="text" class="form-control"></textarea><br>
        <div style="color:red;" id="valid"></div>
        <input type="file" name="fl" accept=".jpeg, .png, .gif, .txt"><br>
        <label>Допустимые форматы</label><br>
        <label>.jpeg, .png, .gif, .txt(Не более 100Кб)</label><br>
        <p><div class="g-recaptcha" data-sitekey="6LcO8UwjAAAAAGRaOkB5t2VulDxiFokCabyqF8YI"></div></p>
        <p><div class="text-danger" id="recaptchaError"></div></p>
        <input type="submit">

        

        <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script>

        function link(){
            document.getElementById('textarea').value +="<a href=”” title=””> </a>";
        }

        function italic(){
            document.getElementById('textarea').value +="<i> </i>";
        }

        function strike(){
            document.getElementById('textarea').value +="<strike> </strike>";
        }

        function strong(){
            document.getElementById('textarea').value +="<strong> </strong>";
        }

        $('#textarea').on('input', function() {
            if(ValidText()){
                $('#valid').empty();
            } else {
                document.getElementById('valid').innerHTML="Некоректно введенные данные";
            }
            
        });

        $('#emailinp').on('input', function() {
            if(ValidEmail()){
                emailinp.style.borderColor = 'green';
            }else{
                emailinp.style.borderColor = 'red';
            }
            
        });

        function ValidEmail() {
            let email = document.getElementById('emailinp').value;
            let res = /[a-z0-9_]+([a-z0-9_])*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
            return res.test(String(email).toLowerCase());
        }

        function ValidText() {
            let str = document.getElementById('textarea').value;
            str = str.replace(/\s/g, '');
            str = str.replace(/[a-zа-яё]/gi, '');
            let ch1 = 0;
            let ch2 = 0;
            for (let i = 0; i < str.length; i++) {
                if(str[i]=="<"){
                    ch1++;
                }
                
                if(str[i]==">"){
                    ch2++;
                }
            } 
            return ch1 % 2 == 0 && ch1==ch2;
        }
        
        $(function(){
            $("[data-tooltip]").mousemove(function (eventObject) {
                if(document.getElementById('textarea').value == ""){
                    return;
                }
                $data_tooltip = document.getElementById('textarea').value;
                $("#tooltip").html($data_tooltip)
                    .css({ 
                        "top" : eventObject.pageY + 5,
                        "left" : eventObject.pageX + 5
                    })
                    .show();
                }).mouseout(function () {
                    $("#tooltip").hide()
                        .html("")
                        .css({
                            "top" : 0,
                            "left" : 0
                });
            });
        });

    </script>
    </div>
</div>
</form>
<div id="tooltip"></div>
</body>
</html>