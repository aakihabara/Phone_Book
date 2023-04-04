<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
	$secret = '6LcO8UwjAAAAAHaDkjmyyWfsjuHifM51cCARAC4B';
	$ip = $_SERVER['REMOTE_ADDR'];
	$response = $_POST['g-recaptcha-response'];
	$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
	$arr = json_decode($rsp, TRUE);
	if ($arr['success']) {
        $db = "lab91011"; 
        $host = "localhost"; 
        $user = "root"; 
        $pass = ""; 
        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
	        die("Ошибка в подключении: " . $conn->connect_error);
        }

        $userFile = null;

        function getExtension($x) {
            $res = explode(".", $x);
            return $res[count($res) - 1];
        }


        $extArray = array("txt", "png", "jpeg", "gif");

        $extension = getExtension(basename($_FILES['fl']['name']));
        

        if(!in_array($extension, $extArray)){

        } else {
            if ($extension == "txt") {
                if (filesize($_FILES['fl']['tmp_name']) <= 102400) {
                    $index = rand(1, 100);
                    $uploaddir = 'files/';
                    $fileName = basename($_FILES['fl']['name']);
                    if($fileName != ""){
                        $userFile = $uploaddir . $index . "-" . basename($_FILES['fl']['name']);
                        move_uploaded_file($_FILES['fl']['tmp_name'], $userFile);
                    }
                }
            } else {
                $index = rand(1, 100);
                $uploaddir = 'files/';
                $fileName = basename($_FILES['fl']['name']);
                
                if($fileName != ""){
                    $userFile = $uploaddir . $index . "-" . basename($_FILES['fl']['name']);
                    move_uploaded_file($_FILES['fl']['tmp_name'], $userFile);
                }
            }
        }

        $userName = $_POST['name'];
        $userURL = $_POST['homepage'];
        $userText = $_POST['text'];
        $userEmail = $_POST['email'];
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        $userIp = $_SERVER['REMOTE_ADDR'];

        if(isset($userName) && isset($userText) && isset($userEmail) && !empty($userName) && !empty($userText) && !empty($userEmail)){
            $userName = htmlspecialchars(trim($userName));
            $userEmail = htmlspecialchars(trim($userEmail));
            $userText = htmlspecialchars(trim($userText));
            $userURL = htmlspecialchars(trim($userURL));

            $res = mysqli_query($conn, "INSERT INTO guests (name, email, homepage, text, browser, ip, fl) VALUES 
            ('$userName', '$userEmail', '$userURL', '$userText', '$userBrowser', '$userIp', '$userFile')");
            
            if($res == true) { 
                echo "<meta http-equiv='Refresh' content='0; URL=index.php'>"; 
            } else { 
                echo "Ошибка";
            }
        } else {
            echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";
        }

        $conn->close();
    } else {
        echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";
        }
} else {
    echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";
    }
?>
