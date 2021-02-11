<?php
    include_once '../includes/dbh.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" type='image/x-icon' href='../includes/icon.ico'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Question Editor</title>
        <style>
            #contents {
                background-color: white;
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
            a {
                text-decoration:none;
            }
            h1 {
                text-align:center;
            }
            a:hover {
                text-decoration: none;
                color:black;
            }
            body {
                background-color: #CD5C5C;
            }
            img {
                width:auto;
                height:350px;
            }
        </style>
    </head>
    <body>
        <div id = "contents" class='container-xl pt-3 my-3'>
            <h1 class='text-center display-1'>Admin Panel</h1>
                <nav class='navbar navbar-expand-sm col-md-12'>
                    <ul class='navbar-nav text-center'>
                        <li class='nav-item'> <a class='nav-link' href='question_handler.php'>Questions</a></li>
                        <li class='nav-item'> <a class='nav-link' href='answer_handler.php'>Answers</a> </li>
                        <li class='nav-item'> <a class='nav-link' href='question_answer_relations.php'>Relations</a></li>
                        <li class='nav-item'> <a class='nav-link' href='file_manager.php'>File Manager</a></li>
                        <li class="nav-item"> <a class="nav-link" href='test_panel.php'>Test Panel</a></li>
                    </ul>
                </nav>
            

            <?php
                $result = "";
                $question = "";
                $fileName ="";
                $tag="";
                $isActive="";
            
                $id = $_GET['id'];
                $sql = "SELECT * FROM questions WHERE id = $id ;";
                $result = mysqli_query($conn, $sql);
                 $row = mysqli_fetch_array($result);
                 $question = $row ['title'];
                 if($row['fileName'])
                    $fileName = $row['fileName'];
                
                    if(isset($_POST['edit'])) {
                       
                        $question = $_POST['question'];
                        $fileName = $_POST['fileName'];
                        $tag = $_POST['tag'];
                        switch($_POST['isActive'])
                        {
                            case "Yes":
                                $isActive = 1;
                            break;
                            case "No":
                                $isActive=0;
                            break;
                            default:

                        }

                        $sql = "UPDATE
                                questions
                                SET
                                title = '$question',
                                fileName = '$fileName',
                                tag = '$tag',
                                isActive = '$isActive'
                                WHERE
                                id = '$id'";
                        mysqli_query($conn,$sql);
                    }
               
                    
                
            
            ?>
            <div class='row'>
                <div class='col-md-6'>
                    <form method="POST" class='shadow p-3 mb-5 bg-white rounded'>
                        <div class='form-group'>
                            <input name = "id" type ="hidden" value = "<?php if(isset($_SESSION['questionId'])) echo $_SESSION['questionId'];?>"/>
                            <label for = 'question'>Question:</label>
                            <input name = "question" class = 'form-control'type = "text" value = "<?PHP echo $question; ?>"/>
                        </div>
                        <div class='form-group'>
                            <label for = 'fileName'>Image Source: </label>
                            <input type = 'text' name ='fileName' value = "<?php echo $fileName ;?>" class='form-control'/>
                            </select>
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
                        <button type = "submit" class='btn btn-danger' name = "edit">Edit Question </button>
                    </form>
                </div>
                <div class='col-md-6'>
                    <?php echo "<img src='uploads/".$fileName."'/>";?>
                </div>
            </div>
        </div>
    </body>
</html>