<?php 
include_once ("includes/dbh.php");
date_default_timezone_set('Europe/Sofia');
session_start();
$userId = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Резултат <?PHP echo $_SESSION['grade'] ;?></title>
    <link rel="shortcut icon" type='image/x-icon' href='./includes/icon.ico'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url('https://images.wallpaperscraft.com/image/leaves_green_dark_145996_1920x1080.jpg');
            background-size:cover;
            /* font-family: Gill Sans Extrabold, sans-serif; */
        }
        #contents {
            background-color: white;
            padding:20px;
            height:100%;
            padding-bottom:40px;

        }
        #cont {
            width:60%;
            display: block;
            margin:auto;
        }
        
    </style>
</head>
<body>
        <div id ='contents' class='container-xl shadow pt-3 my-5 bg-white rounded  '>
            <h1 class='display-3 text-center'>Резултат</h1>
            <?PHP 

                
                
                $points = $_SESSION['points'];
                $sqlNew = "SELECT * FROM users where id = '$userId'";
                $resultNew = mysqli_query($conn, $sqlNew);
                $row = mysqli_fetch_array($resultNew);

                $timeEnded = date_create(date('Y-m-d H:i:s',$_GET['dateEnded']));
                $timeStarted = date_create($row['dateStarted']);

                echo "<div  class='text-justify' id='cont'>";
                echo "<h1 class='display-2'> Име:<b>". $row['name']. "</b></h1>";
                echo "<h3>Оценка: ".$_SESSION["grade"]."</h3> ";
                echo "<h3>Точки: ".$_SESSION["points"]." / " . $_SESSION['questionsNum']."</h3>";
                $sql = "UPDATE users SET points = '$points', dateEnded = NOW() WHERE id = '$userId';";
                $result = mysqli_query($conn, $sql);
                $timeForTest = date_diff($timeStarted,$timeEnded)->format('%i'). " минути";

                if($timeForTest<=0)
                {
                    $timeForTest = date_diff($timeStarted,$timeEnded)->format('%s')." секунди";
                }
                echo "<h2> Ти направи теста за: ". $timeForTest ." </h2>";
                
            ?>
        <?php 
            switch ($_SESSION['grade'])
            {
                case "Слаб 2":
                    echo "<h2 class='fs-4 '> Не се отказвай! Постарай се повече!</h2>";
                break;
                case "Среден 3":
                    echo "<h2 class='fs-4 text-center'> Имаш значителни пропуски! Не се отказвай!</h2>";
                break;
                case "Добър 4":
                    echo "<h2 class='fs-4 text-center> Добре! Справи се значително добре!</h2>";
                break;
                case "Мн.Добър 5":
                    echo "<h2 class='fs-4 text-center> Почти си на върха! Браво! Не спирай да учиш! </h2>";
                break;
                case "Отличен 6":
                    echo "<h2 class='fs-4 text-center> Супер си! Не се очаква по-зле от теб! </h2>";
                break;
            }
        ?>
                
            </div>
        </div>
    
</body>
</html>