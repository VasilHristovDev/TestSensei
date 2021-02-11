<?php
    include_once '../includes/dbh.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Editor</title>
    <link rel="shortcut icon" type='image/x-icon' href='../includes/icon.ico'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        #contents {
            background-color: #ffffff;
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
            text-decoration: none;
        }
        table a {
            color:black;
        }
        a {
            text-decoration:none;
        }
        body {
            background-color: #CD5C5C;
        }
        form {
            margin:10px;
            padding:10px;
        }
        
    </style>
</head>
<body>
    <div id= 'contents' class='container-xl pt-3 my-3'>
    <h1 class='display-1 text-center'>Admin Panel</h1>
        <nav class='navbar navbar-expand-sm col-md-12'>
            <ul class='navbar-nav text-center'>
                <li class="nav-item"> <a class="nav-link" href='question_handler.php'>Questions</a></li>
                <li class="nav-item"> <a class="nav-link" href='answer_handler.php'>Answers</a> </li>
                <li class="nav-item"> <a class="nav-link" href='question_answer_relations.php'>Relations</a></li>
                <li class="nav-item"> <a class="nav-link" href='file_manager.php'>File Manager</a></li>
                <li class="nav-item"> <a class="nav-link" href='test_panel.php'>Test Panel</a></li>
            </ul>
        </nav>

    <?php
        $result = "";
        $answer = "";
        $isCorrect ="";
        if(isset($_POST['edit'])) {
            $id1 = $_POST['id'];
            $answer = $_POST['answer'];
            $isCorrect = $_POST['isCorrect'];
            switch ( $isCorrect)
            {
                case "Correct":
                    $isCorrect = true;
                    break;
                case "Incorrect":
                    $isCorrect = false;
                    break;
                default:

            }
            $sql = "UPDATE answers SET value = '$answer', isCorrect = '$isCorrect' WHERE id = '$id1';";
            mysqli_query($conn,$sql);
        }
            
       
        $id = $_GET['id'];
        $sql = "SELECT * FROM answers WHERE id = $id ;";
        $result = mysqli_query($conn, $sql);
        while ( $row = mysqli_fetch_array($result)) {
            $answer = $row ['value'];
            $isCorrect = $row['isCorrect'];
               
            }           

        
        
        
    ?>
    <div class='row'>
        <div class='col-md-6'>
            <div class='container-xl'>
            <form method="POST" class='shadow p-3 mb-5 bg-white rounded'>
                <div class='form-group'>
                    <input name = "id" type ="hidden" value = '<?PHP echo $id ;?>'/>
                    <label for = 'answer'>Answer:</label>
                    <input name = "answer" type = "text" class='form-control' value = "<?PHP echo $answer; ?>"/>
                </div>
                <div class='form-group>'>
                <label for = 'isCorrect'>Correct</label>
                <select name = "isCorrect"  class='form-control'>
                    <?php
                    if($isCorrect)
                    echo "<option selected>Correct</option>
                          <option>Incorrect</option>";
                    else 
                    echo "<option>Correct</option>
                          <option selected>Incorrect</option>";
                    
                    ?>
                </select>
                </div>
                <br>
                <button type = "submit" class='btn btn-danger' name = "edit">Edit Answer </button>
            </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>