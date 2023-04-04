<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .inp {
            font-size:2vw;
            width: 8vw;
        }
        .yes {
            font-size:2vw;
            max-width: 15px;
            text-align: center;
        }
		a {
            text-decoration: none;
		}
        body {
            background-image: url('grnd.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        td, th, tr, table{
            border-collapse: collapse;
            border: 4px solid #615285;
            color: #615285;
            border-radius: 5px;
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
            line-height: 3vw;
            border: 1px solid #615285;
            border-radius: 1vw;
            width: 18vw;
            align-self: center;
        }
    </style>
    <link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
    <script type="text/javascript" src="js/lightbox.js"></script>
</head>
<body>
<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=lab91011", "root", "");
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

    $page = 1;

    if (isset($_GET['page'])) {
        $page = filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT);
    }

    $personCount = 25;

    $sqlcount = "select count(*) as tR from guests";
    $res = $conn->prepare($sqlcount);
    $res->execute();
    $row = $res->fetch();
    $tR = $row['tR'];
    $pages = ceil($tR / $personCount);

    $offset = ($page-1) * $personCount;
  
    $sql = "select * from guests limit :offset, :personCount";
  
    $res = $conn->prepare($sql);
  
    $res -> execute(['offset'=>$offset, 'personCount'=>$personCount]);
  
    echo "<table border='3' style='background-color: white;margin: auto; text-align: center; font-size: 1vw; width: 95vw;'><tr><th style='width: 3vw;'>Id</th>
    <th style='width: 10vw;'>Name</th><th style='width: 12vw;'>Email</th><th style='width: 15vw;'>Homepage</th><th style='width: 20vw;'>Text</th>
    <th style='width: 10vw;'>Ip</th><th style='width: 15vw;'>Browser</th><th style='width: 10vw;'>FileImage</th></tr>";
  
    while (($row = $res -> fetch(PDO::FETCH_ASSOC)) !== false) {
        
        echo "<tr>";
        echo "<td style='max-width: 3vw;'>" . $row["id"] . "</td>";
        echo "<td style='max-width: 10vw; word-wrap: break-word;'>" . htmlspecialchars_decode($row["name"])  . "</td>";
        echo "<td style='max-width: 12vw; word-wrap: break-word;'>" . htmlspecialchars_decode($row["email"]) . "</td>";
        echo "<td style='max-width: 15vw; word-wrap: break-word;'>" . htmlspecialchars_decode($row["homepage"]) . "</td>";
        echo "<td style='max-width: 20vw; word-wrap: break-word;'>" . htmlspecialchars_decode($row["text"]) . "</td>";
        echo "<td style='max-width: 10vw; word-wrap: break-word;'>" . htmlspecialchars_decode($row["ip"]) . "</td>";
        echo "<td style='max-width: 15vw; word-wrap: break-word;'>" . htmlspecialchars_decode($row["browser"]) . "</td>";

        $path = $row['fl'];
        $arr = explode(".", $path);

        if(count($arr) > 1){
            $ext = $arr[count($arr) - 1];
            if($ext == "txt"){
                echo "<td style='max-width: 77vw; word-wrap: break-word;'><a href=\"" . $path . "\" target=\"_blank\" class=\"btn btn-primary btn-lg active\" role=\"button\">TXT</td>";
            } else {
                echo "<td style='max-width: 77vw; word-wrap: break-word;'><img src=\"" . $path . "\" width=\"160\" height=\"120\"></a></td>";
            }
        } else {
            echo "<td style='max-width: 77vw; word-wrap: break-word;'>Пусто</td>";
        }
        echo "</tr>";
    }
  
    echo "</table>";

    echo "<br><div class='box'>";


    if ($page - 1 >= 1) {
        echo "<p class='el'><a href=".$_SERVER['PHP_SELF']."?page=".($page - 1).">Предыдущая</a></p>";
    }

    if ($page + 1 <= $pages) {
        echo "<p class='el'><a href=".$_SERVER['PHP_SELF']."?page=".($page + 1).">Следующая</a></p>";
    }


    echo "<p class='el'><a href='index.php'>Назад</a></p>";

    echo "</div>";

} catch(PDOException $e) {
    echo $e->getMessage();
}
?>
</body>
</html>