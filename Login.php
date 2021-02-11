<!DOCTYPE html>
<?php 
    include_once "./includes/dbh.php";
    date_default_timezone_set('Europe/Sofia');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" type='image/x-icon' href='./includes/icon.ico'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        button {
            width: 100%;
            
        }
        body {
            font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-image: url("https://images.wallpaperscraft.com/image/leaves_green_dark_145996_1920x1080.jpg");
            background-size: cover;
        }
        
        #form-login {
           
            display: block;
            width:50%;
            margin:auto;
        
        }
        form {
            width:70%;
            display: block;
            margin:auto;
        }

    </style>
</head>
<body>
    <div id ='contents' class='container-xl pt-3 my-5'>
        
        <div class=' shadow p-5 my-5 bg-white rounded' id='form-login'>
            <h1 class='display-3 text-center'>Login</h1>
                <form method = "POST" class='my-4'>
                    <div class='form-group'>
                        <label for = 'name'>Your Name: </label>
                        <input name = 'name' class='form-control'/>
                    </div>
                    <button type = 'submit' name = 'submit' class='btn btn-success'>START</button>
                </form>
            
        </div>
    </div>
    <?php 
    if(isset($_POST['submit']))
    {
        $name = $_POST['name'];
        $check = "SELECT COUNT(*) as userExists FROM  users WHERE name = '$name' LIMIT 1";
        
        $resultCheck = mysqli_query($conn, $check);
        $rowCheck = mysqli_fetch_array($resultCheck);
        
        if ( (int)$rowCheck['userExists'] == 1 )
            echo "<script> alert('Този човек вече е правил  този тест!');</script>";
        else if($name == "")
        {
            echo "<script> alert ('Моля попълнете полето за име');</script>";
        }
        else {
            $sql = "INSERT into users(name,dateStarted) VALUES ('$name',NOW());";
            
            $result = mysqli_query($conn, $sql);
            
            $sqlNew = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
            $result1 = mysqli_query($conn,$sqlNew);
            $row = mysqli_fetch_array($result1);
            echo "<script>
                        window.location.href = 'http://localhost/Informatics%20Test/TestChoice.php?id=".$row['id']."';
                 </script>";
        }
    }
    ?>
</body>
</html>