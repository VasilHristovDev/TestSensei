<!DOCTYPE html>
<?php
include_once "../includes/dbh.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Panel</title>
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
        <?php
        $testId ="";
            if(isset($_POST['testId']) && $_POST['testId']!="new"&&$_POST['testId']!="")
               { 
                    $testId = $_POST['testId'];
                    $title="";
                    $num_of_questions = "";
                    $time_for_test ="";
                    $tag="";
                    $isActive="";
                    $sqlFill = "SELECT * FROM tests WHERE id = '$testId'";
                    $result = mysqli_query($conn, $sqlFill);
                    $row = mysqli_fetch_array($result);
                    $title=$row['title'];
                    $num_of_questions = $row['number_of_questions'];
                    $time_for_test =$row['time_for_test'];
                    $tag=$row['test_tag'];
                    $isActive=$row['isActive'];
               }

         ?>
        <h1 class='display-4 text-center'>Test Options:</h1>
        <div class='row'>          
            <div class = 'col-md-6'>
                <form method="POST" class='shadow p-3 mb-5 bg-white rounded' id='panelControl'>
                    <div class= 'form-group'>
                        <label for='testId'>Test: </label>
                        <select name ='testId' id ="testId" class='form-control' onchange="fillForm()">
                            <?php
                                $sql = 'SELECT * FROM tests';
                                $result = mysqli_query($conn, $sql);
                                while($row=mysqli_fetch_array($result))
                                {
                                    if($row['id']===$testId)
                                        echo "<option selected value='".$row['id']."'>".$row['title']."</option>";
                                    else 
                                        echo "<option value='".$row['id']."'>".$row['title']."</option>";
                                }
                            ?>
                            <option value="new">New Test...</option>
                        </select>
                    </div>
                    <div class= 'form-group'>
                        <label for = 'title'>Test Title: </label>
                        <br>
                        <input name = "title" type ="text" class='form-control' value ="<?php if(isset($_POST['title'])) echo $title;?>"/>
                    </div>
                    <div class= 'form-group'>
                        <label for = 'num_of_questions'>Number of questions: </label>
                        <br>
                        <input name = "num_of_questions" type ="text" class='form-control' value ="<?php if(isset($_POST['num_of_questions'])) echo $num_of_questions;?>"/>
                    </div>
                    <div class= 'form-group'>
                        <label for = 'time_for_test'>Time in minutes: </label>
                        <br>
                        <input name = "time_for_test" type ="text" class='form-control'value ="<?php if(isset($_POST['time_for_test'])) echo $time_for_test;?>"/>
                    </div>
                    <div class= 'form-group'>
                        <label for = 'tag'>Test Tag: </label>
                        <br>
                        <input name = "tag" type ="text" class='form-control' value ="<?php if(isset($_POST['tag'])) echo $tag;?>"/>
                    </div>
                    
                    <div class= 'form-group'>
                        <label for='isActive'>Is Active?: </label>
                        <select name ='isActive' class='form-control'>
                            <?php
                                if($isActive==true) 
                                {
                                    echo "<option selected>Yes</option>";
                                    echo "<option>No</option>";
                                }
                                else 
                                {
                                    echo "<option>Yes</option>";
                                    echo "<option selected>No</option>";
                                }
                                    

                            ?>
                            
                            
                        </select>
                    </div>
                    <button type = "submit" name = "submit" class='btn btn-danger'>Submit Test Options</button>
                </form>
            </div>
            
        </div>
        
        <script type ='text/javascript'>
            function fillForm() {
                var testid = document.getElementById('testId').value;
                if(testid!=='new')
                document.getElementById('panelControl').submit.click();
                if(testid==='new')
                {
                    var inputs = document.getElementsByTagName('input');
                    for(var i =0; i< inputs.length;i++)
                    {
                        inputs[i].value= "";
                        
                    }
                }

            }
        </script>

    <?php
    
        if(isset($_POST['submit'])) {
            
            $tag = $_POST['tag'];
            $time = $_POST['time_for_test'];
            $num = $_POST['num_of_questions'];
            $title = $_POST['title'];
            $testId = $_POST['testId'];
            $isActive = $_POST['isActive'];
            switch($isActive)
            {
                case "Yes":
                    $isActive=1;
                break;
                case "No":
                    $isActive=0;
                break;
                default:

            }
            
            if($_POST['testId']=='new')
            {
                
                $sqlTest1 = "INSERT INTO
                tests (title, number_of_questions, time_for_test, test_tag, isActive)
                VALUES('$title', '$num', '$time', '$tag', '$isActive')";
                 mysqli_query($conn,$sqlTest1);
                
            }
            else
            {
                
                $sqlTest = "UPDATE
                tests
              SET
                title = '$title',
                number_of_questions = '$num',
                time_for_test = '$time',
                test_tag = '$tag',
                isActive = '$isActive'
              WHERE
                id = '$testId'";
                mysqli_query($conn,$sqlTest);
            }
            
        }
        
    ?>
    
    
</body>
</html>