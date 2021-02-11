<!DOCTYPE html>
    <?php
        include_once 'includes/dbh.php';
        session_start();
        $_SESSION['userId'] = $_GET['id'];
    ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" type='image/x-icon' href='./includes/icon.ico'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Test Select</title>
    <style>
        .test {
            margin:1px;
        }
        a {
            text-decoration: none;
            color:black;
        }
        a:hover {
            text-decoration: none;
            color:black;
        }
        body {
            font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-image: url("https://images.wallpaperscraft.com/image/leaves_green_dark_145996_1920x1080.jpg");
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class='container-xl pt-3 my-3'>
        
        <?php 
            
            $sqlRequest = "SELECT * FROM tests";
            $result = mysqli_query($conn,$sqlRequest);
            $counter = 0;
            while($row = mysqli_fetch_array($result))
            {
                if($row['isActive'])
                {
                    if($counter==0)
                    echo "<div class='row'>";

                    echo "
                            <div class='col-xl-6 test shadow p-5 my-5 bg-white rounded'>
                            <a href ='test.php?testId=".$row['id']."'>
                                    <h1>".$row['title']."</h1>
                                    <p>Брой въпроси: ".$row['number_of_questions']."</p>
                                    <p>Време: ".$row['time_for_test']." минути </p>
                                    </a>
                            </div>
                            
                        ";
                        
                        
                        $counter++;
                        if($counter%2==0)
                        {
                            echo "</div>
                                <div class='row'>";
                        }
                }
                else 
                continue;
            }
        ?>
    </div>
</body>
</html>