<!DOCTYPE html>
<?php
include_once '../includes/dbh.php';
 session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" type='image/x-icon' href='../includes/icon.ico'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>File Manager</title>
    <style>
       
        #contents {
            background-color: white;
            padding-bottom:20px;
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
        #contents {
            background-color: white;

        }
        body {
            background-color: #CD5C5C;
        }
        hr.solid {
            border-top: 3px solid #bbb;
            border-radius: 1em;
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
         .cnt .btns {
            position: absolute;
            top:10%;
            right:0;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            color: white;
            font-size: 16px;
            
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        
        .cnt img {
            width: 100%;
            height: 100%;
        }
        
        
    </style>
</head>
<body>
<div id = "contents" class='container-xl pt-3 my-3'>
    <h1 class="display-1 text-center">Admin Panel</h1>
    <nav class="navbar navbar-expand-sm col-md-12 text-center" id ='navbar' >
        <ul class="navbar-nav" >
            <li class="nav-item"> <a href='question_handler.php'class="nav-link">Questions</a></li>
            <li class="nav-item"><a href='answer_handler.php' class="nav-link">Answers</a> </li>
            <li class="nav-item"> <a href='question_answer_relations.php'class="nav-link">Relations</a></li>
            <li class="nav-item"> <a href='file_manager.php'class="nav-link">File Manager</a></li>
            <li class="nav-item"> <a class="nav-link" href='test_panel.php'>Test Panel</a></li>
        </ul>
    </nav>
    <h1 class='display-4 text-center'>File Manager</h1>
    <br>
    <div class = 'row'>
        <div class='col-md-4'>
            <form method = 'POST' enctype='multipart/form-data'  class='shadow p-3 mb-5 bg-white rounded'>
                <label for='file'>Image to upload to the server: </label>
                <div class='custom-file my-3'>
                    <label class="custom-file-label" for="file">Choose file:</label>
                    <input type = 'file' name = 'file' id='file' class='custom-file-input'/>
                </div>
                <div class='form-group'>
                    <label for='questionId' >Question Id:</label>
                    <select name ='questionId' class='form-control'>
                        <?php
                            $sql = 'SELECT * FROM questions';
                            $result = mysqli_query($conn, $sql);
                            while($row=mysqli_fetch_array($result))
                            {
                                echo "<option value='".$row['id']."'>".substr($row['title'], 0, 60) . '...'."</option>";
                            }
                        ?>
                    </select>
                </div>
                <button type = 'submit' name = 'submit' class='btn btn-danger'>Submit Image</button>
            </form>
        </div>
    
    </div>
    <hr class='solid'>
    <?php 
        $directory = 'D:\xampp\XAMPP\htdocs\Informatics Test\admin_panel\uploads';

        if (!is_dir($directory)) {
            exit('Invalid diretory path');
        }
        
        $count = 0;
        echo "<div class='row'>";
        echo "<form method='GET'action='file_manager.php'>";
        
        foreach (scandir($directory) as $file) {
            $imageToQuestion = strpos($file,'image_question');
            if ($file !== '.' && $file !== '..' && $imageToQuestion !==false) {
                if($count%2==0)
                 echo "</div>
                        <div class='row'>" ; 
                 echo " <div class='col-md-6 cnt'>
                            <img class='img-fluid img-thumbnail' src='uploads/".$file."'/>
                            <button class='btn btn-danger btns' name='fileBtn' type='submit' value='".$file."'>x</button>
                        </div>";
                        $count++;
            }
        }
        if($_GET['file'] && $_POST['fileBtn'])
    {
        unlink($directory.'/'.$_GET['file']);
        return;
    }
        
    if(isset($_POST['submit']))
        {
            $_SESSION['fileSubmit'] = true;
            $questionId =$_POST['questionId'];
            var_dump($_FILES["file"]["name"]);
            $fileName = $_FILES["file"]["name"];
            $sqlQ = "UPDATE questions SET fileName='$fileName' WHERE id ='$questionId'";
            $result = mysqli_query($conn,$sqlQ);

        }
        
    if($_SESSION['fileSubmit']==true)
    {
        require_once "./file_upload.php";
        $_SESSION['fileSubmit']=false;
        return;
    }
    
    ?>
    <script>
    
        $(".custom-file-input").on("change",
        function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        window.onscroll = function() {stickyNavFunc()};
        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;
        function stickyNavFunc() {
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