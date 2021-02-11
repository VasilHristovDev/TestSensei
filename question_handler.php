<?php
    include_once '../includes/dbh.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Handler</title>
    <link rel="shortcut icon" type='image/x-icon' href='../includes/icon.ico'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        a {
            text-decoration: none;
            
        }
        #contents {
            background-color: white;
        }
        body {
            background-color: #CD5C5C;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        
        }
        ul {
            display:block;
            width:100%;
            text-decoration: none;
            background-color: #d52b2b;
        }
        li {
            display: inline-block;
            padding:10px;
            margin:0;
            width:25%;
            color:white;
        }
        li a:hover {
            
            color:white;
        }
        li:hover {
            background-color: #ff0101;
            color:white;
        }
        li a {
            color:white;
        }
        table a {
            color:black;
        }
        thead {
            background-color: #d52b2b;
            color:white;
        }
        #navbar {
                overflow: hidden;
            }

        .sticky {
            position: fixed;
            top: 0;
            width:75%;
            padding:0;
            z-index: 999;
        }
        img {
            
            height:270px;
        }
        button {
            width:100%;
        }
        a:hover {
            color:black;
            text-decoration: none;
        }
        
    </style>
</head>
<body>
    <div id = "contents" class='container-xl pt-3 my-3'>
        <h1 class='display-1 text-center'>Admin Panel</h1>
        <nav  class="navbar navbar-expand-sm col-md-12" id ='navbar'>
            <ul class="navbar-nav text-center">
                <li class="nav-item"> <a class="nav-link" href='question_handler.php'>Questions</a></li>
                <li class="nav-item"> <a class="nav-link" href='answer_handler.php'>Answers</a> </li>
                <li class="nav-item"> <a class="nav-link" href='question_answer_relations.php'>Relations</a></li>
                <li class="nav-item"> <a class="nav-link" href='file_manager.php'>File Manager</a></li>
                <li class="nav-item"> <a class="nav-link" href='test_panel.php'>Test Panel</a></li>
            </ul>
        </nav>
        <h1 class='display-4 text-center'>Questions</h1>
        <div class='row'>          
            <div class = 'col-md-6'>
                <form method="POST" class='shadow p-3 mb-5 bg-white rounded'>
                    <div class= 'form-group'>
                        <label for = 'question'>Title: </label>
                        <br>
                        <input name = "question" type ="text" class='form-control'/>
                    </div>
                    <div class= 'form-group'>
                        <label for = 'tag'>Tag: </label>
                        <br>
                        <input name = "tag" type ="text" class='form-control'/>
                    </div>
                    <div class= 'form-group'>
                        <label for = 'isActive'>Is Active?: </label>
                        <select name ='isActive' class='form-control'>
                            <option>Yes</option>
                            <option>No</option>
                        </select>
                    </div>
                    <button type = "submit" name = "submit" class='btn btn-danger'>Submit Question</button>
                </form>
            </div>
            
        </div>

    <?php
    
        if(isset($_POST['submit'])) {
            $question = $_POST['question'];
            switch($_POST['isActive'])
            {
                case "Yes":
                    $isActive=1;
                break;
                case "No":
                    $isActive=0;
                break;
                default:
                
            }
            $tag = $_POST['tag'];
            
            $sql = "INSERT INTO questions (title,tag,isActive) VALUES ('$question','$tag','$isActive')";
            mysqli_query($conn,$sql);
        }
        $sql_table_request = "SELECT * FROM questions";
        $result_new_request = mysqli_query($conn,$sql_table_request);
        echo " <table border = '1px solid black' class='table'>
                 <thead class='text-center'>
                  <th> ID: </th>
                  <th> Title: </th>
                  <th> Image? </th>
                 </thead>";
        while ($row = mysqli_fetch_array($result_new_request)) {
            echo "<tr>";
            echo "<td name = 'id".$row['id']."'><a href='question_editor.php?id=".$row['id']."'>".$row['id']."</a></td>";
            echo "<td name = 'question".$row['title']."'><a href='question_editor.php?id=". $row['id']. "'>".$row['title']."</a></td>";
            echo "<td>".$row['fileName']." </td>";
            
        }
        echo "</div>";
    ?>
    <script type ='text/javascript'>
        window.onscroll = function() {myFunction()};
        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;
        function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
        }
    </script>
</body>
</html>