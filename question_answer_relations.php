<?php
include_once "../includes/dbh.php"
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Relations Handler</title>
        <link rel="shortcut icon" type='image/x-icon' href='../includes/icon.ico'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            #contents {
                
                background-color:white;
               
            }
            body {
                background-color: #CD5C5C;
                font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            a {
                text-decoration: none;  
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
                text-align: center;
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
            
            th {
                text-align: center;
                color:white;
            }
            form {
                padding:10px;
                
                /* margin:auto;
                display:block; */
                margin-left:20px;
            }
            button{
                width:100%;
                background-color: #b54b4b;
            }
            thead {
                background-color: #d52b2b;
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
        <div id = "contents" class='container-xl pt-3 my-3'>
            <h1 class="display-1 text-center">Admin Panel</h1>
                <nav class="navbar navbar-expand-sm col-md-12" id ='navbar' >
                    <ul class="navbar-nav " >
                        <li class="nav-item"> <a href='question_handler.php'class="nav-link">Questions</a></li>
                        <li class="nav-item"><a href='answer_handler.php' class="nav-link">Answers</a> </li>
                        <li class="nav-item"> <a href='question_answer_relations.php'class="nav-link">Relations</a></li>
                        <li class="nav-item"> <a href='file_manager.php'class="nav-link">File Manager</a></li>
                        <li class="nav-item"> <a class="nav-link" href='test_panel.php'>Test Panel</a></li>
                        
                    </ul>
                </nav>
                <h1 class='display-4 text-center'>Relations</h1>
                <br>
                
                <div class='row'>
                    
                    <div class = 'col-md-6'>
                        <form method = "POST" class='shadow p-3 mb-5 bg-white rounded'>
                            <div class= 'form-group'>
                                <label for = 'questionId'>Question Id: </label>
                                <br>
                                <input type = "text" name = 'questionId'class='form-control'/>
                            </div>
                            <div class= 'form-group'>
                                <label for = 'answerId'>Answer Id: </label>
                                <br>
                                <input type = 'text'name = "answerId" class='form-control'/> 
                            </div>
                            <button type = 'submit' name = "submit" class="btn btn-danger">Submit </button>
                        </form>
                    </div>
                    <div class = 'col-md-6'>
                        <img src = 'uploads/many-to-many.png'/>
                    </div>
                </div>
                <div class='content'>
                <?php
                    if(isset($_POST['submit'])) {
                        $questionId = $_POST['questionId'];
                        $answerId = $_POST['answerId'];
                        $sql = "INSERT into questions_answers_rel (question_id, answer_id) VALUES ('$questionId','$answerId') ;";
                        $result = mysqli_query($conn, $sql);
                    }
                    $sqlReqCount = "SELECT COUNT(a.id) as id
                                    FROM questions as q 
                                    INNER JOIN questions_answers_rel as qar 
                                    ON q.id = qar.question_id 
                                    INNER JOIN answers AS a 
                                    ON a.id = qar.answer_id
                                    GROUP BY q.id
                                    ORDER BY q.id ASC";
                    
                    $resultReqCount = mysqli_query($conn,$sqlReqCount);
                    $arrayCount = mysqli_fetch_all($resultReqCount);

                    $sqlReq =  "SELECT q.id as 'questionId',  q.title,a.id as 'answerId',a.value as 'answerValue',a.isCorrect
                                FROM questions as q 
                                INNER JOIN questions_answers_rel as qar 
                                ON q.id = qar.question_id 
                                INNER JOIN answers AS a 
                                ON a.id = qar.answer_id
                                ORDER BY q.id ASC";

                    $resultReq = mysqli_query($conn,$sqlReq);


                    echo "
                            <table border = '1px solid black' class='table'>
                             <thead> 
                             <tr>
                                <th> Question ID:</th> 
                                <th> Question: </th>
                                <th> Answer ID: </th> 
                                <th> Answer</th>
                                <th>Correct?</th>
                              </tr>
                            </thead>";


                    $counterOfAnswers = 0;
                    $printed_questions = array();
                    $isCorrectHelper = "";
                    while ($row = mysqli_fetch_array($resultReq)) {
                        switch($row['isCorrect'])
                            {
                                case 1: 
                                    $isCorrectHelper = "Yes";
                                break;
                                case 0:
                                    $isCorrectHelper = "No";
                                break;
                                default:
                            }
                        if(!in_array($row['questionId'],$printed_questions))
                        {
                            
                            echo 
                            "<tr>
                                <td rowspan='".($arrayCount[$counterOfAnswers][0]+1)."'>".$row['questionId']."</td>
                                <td rowspan='".($arrayCount[$counterOfAnswers][0]+1)."'>".$row['title']."</td>
                            </tr>";
                            
            
                            array_push($printed_questions,$row['questionId']);
                            $counterOfAnswers++;
                            
                        }
                        
                        
                            echo "<tr>
                                    <td>".$row['answerId']."</td>
                                    <td>".$row['answerValue']."</td>
                                    <td>".$isCorrectHelper."</td>
                                </tr>";
                        
                    }
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
        </div>
    </body>
</html>