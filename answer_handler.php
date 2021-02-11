<?php
    include_once "../includes/dbh.php"
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type='image/x-icon' href='../includes/icon.ico'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Answer Handler</title>
    <style>
        #contents {
            background-color: white;
        }
        a {
            text-decoration: none;
            color:black;
        }
        a:active {
            text-decoration: none;
        }
        a:hover {
            text-decoration: none;
            color:black;
        }
        table {
            width:100%;
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
        }
        
        body {
            background-color: #CD5C5C;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        button {
            width: 100%;
        }
        th {
                text-align: center;
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
    </style>

</head>
<body>
    <div id = 'contents' class='container-xl pt-3 my-3'>
        <h1 class='display-1 text-center'>Admin Panel</h1>
            <nav class="navbar navbar-expand-sm col-md-12" id ='navbar'>
                <ul class="navbar-nav text-center">
                    <li class="nav-item"> <a class="nav-link" href='question_handler.php'>Questions</a></li>
                    <li class="nav-item"> <a class="nav-link" href='answer_handler.php'>Answers</a> </li>
                    <li class="nav-item"> <a class="nav-link" href='question_answer_relations.php'>Relations</a></li>
                    <li class="nav-item"> <a class="nav-link" href='file_manager.php'>File Manager</a></li>
                    <li class="nav-item"> <a class="nav-link" href='test_panel.php'>Test Panel</a></li>
                </ul>
            </nav>
        <h1 class='display-4 text-center'>Answers</h1>
        <div class='row'>          
            <div class = 'col-md-6'>
                <form method = "POST" class='shadow p-3 mb-5 bg-white rounded'>
                <div class= 'form-group'>
                    <label for = 'answer' >Answer: </label>
                    <br>
                    <input type = "text" name = "answer" class='form-control'/>
                </div>
                <div class= 'form-group'>
                    <label for = 'isCorrect'>Correct? </label>
                    <br>
                    <select name = "isCorrect" class='form-control'>
                        <option>Correct</option>
                        <option>Incorrect</option>
                    </select>
                </div>
                    <button type = 'submit' name = "submit" class ="btn btn-danger">Add Answer</button>
                </form>
            </div>
    </div>
        <?php
        
            if(isset($_POST['submit'])) {
                $answer = $_POST['answer'];
                if(isset($_POST['isCorrect']))
                {
                    $radioButton = $_POST['isCorrect'];
                    switch ($radioButton) {
                        case "Correct":
                            $radioButton = true;
                            break;
                        case "Incorrect":
                            $radioButton = false;
                            break;
                        default:

                    }
                }
                $sql = "INSERT into answers (value, isCorrect) VALUES ('$answer','$radioButton') ;";
                $result = mysqli_query($conn, $sql);
            }
            $sql_table_questions = "SELECT * FROM answers;";
            $result = mysqli_query($conn,$sql_table_questions);
            echo "<br> <br> 
                <table border='2px solid black' class='table'>
                 <thead>
                  <th>ID:</th>
                  <th> ANSWER</th>
                  <th> Correct?</th>
                  </thead>";
            $counter = 0;
            while($row = mysqli_fetch_array($result))
            {
                echo "<tr>";
                echo "<td name = 'id".$row['id']."'> <a href='answer_editor.php?id=" . $row['id'] . "'>" . $row['id']."</a></td>";
                echo "<td name = 'answer" .$row['id']."'> <a href='answer_editor.php?id=" . $row['id']."'>" . $row['value'] . " </a></td>";
                if($row['isCorrect'])
                echo "<td> Yes</td>";
                else
                echo "<td> No</td>";
                echo "</tr>";
                $counter++;
                
            }
            echo "</table>";
        ?>
    </div>
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