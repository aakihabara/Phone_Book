<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
    <script type="text/javascript" src="js/lightbox.js"></script>
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
        }
		.a {
			width: 20px;
		}
    </style>
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
  
    echo "<table border='1' style='margin: auto; text-align: center; font-size: 1vw; width: 90vw;'><tr><th style='width: 3vw;'>Id</th>
    <th style='width: 10vw;'>Name</th><th style='width: 77vw;'>FileImage</th></tr>";
  
    while (($row = $res -> fetch(PDO::FETCH_ASSOC)) !== false) {
        echo "<tr>";
        echo "<td style='max-width: 3vw;'>" . $row["id"] . "</td>";
        echo "<td style='max-width: 10vw; word-wrap: break-word;'>" . $row["name"] . "</td>";

        $path = $row['fl'];
        $arr = explode(".", $path);

        if(count($arr) > 1){
            $ext = $arr[count($arr) - 1];

            if($ext == "txt"){
                echo "<td style='max-width: 77vw; word-wrap: break-word;'><a href=\"" . $path . "\" target=\"_blank\" class=\"btn btn-primary btn-lg active\" role=\"button\">TXT</td>";
            } else {
                echo "<td style='max-width: 77vw; word-wrap: break-word;'><a href=\"" . $path . "\" rel=\"lightbox\"><img src=\"" . $path . "\" width=\"160\" height=\"120\"></a></td>";
            }

        } else {
            echo "<td style='max-width: 77vw; word-wrap: break-word;'>Отсутствует</td>";
        }

        echo "</tr>";
    }
  
    echo "</table>";

    echo "<br><table border='1' align='center' style='width: 30vw;text-align: center;'>";

    echo "<tr>";

    if ($page - 1 >= 1) {
        echo "<td class='yes'><a href=".$_SERVER['PHP_SELF']."?page=".($page - 1).">Предыдущая</a></td>";
    }

    if ($page + 1 <= $pages) {
        echo "<td class='yes'><a href=".$_SERVER['PHP_SELF']."?page=".($page + 1).">Следующая</a></td>";
    }

    echo "</tr>";

    echo "</table>";

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    ?>
<br>
<form action="index.php" method="get" >
<input class="inp" type="submit" name="back" value="Назад">
</form>
</body>
</html>