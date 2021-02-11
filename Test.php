<?php 
    session_start();
    include_once 'includes/dbh.php';
    date_default_timezone_set('Europe/Sofia');
    $testId = $_GET['testId'];
    $sqlTest = "SELECT * FROM tests WHERE id='$testId'";
    $resultTest = mysqli_query($conn,$sqlTest);
    $rowTest = mysqli_fetch_array($resultTest);
    $testTag = $rowTest['test_tag'];
    $numQ = $rowTest['number_of_questions'];
    $userId = $_SESSION['userId'];
    /* if(!isset($_GET['id']))
    {
        
        echo 
        "<script>
             alert('Изтекла сесия');
             window.location.href = 'http://localhost/Informatics%20Test/Login.php?error=1';
        </script>";

    } */
       
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $rowTest['title'];?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" type='image/x-icon' href='./includes/icon.ico'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        p{
            text-indent:10px;
        }
        .questions {
            background-color:white;
            padding: 10px;
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            margin:20px;
            margin-bottom:40px;
            margin-top:40px;
            

        }
        h2{
            font-size: 32px;
        }
        img {
            width:50%;
        }
        #contents {
            padding:30px;
            background-color:white;
        }
        body {
            background-image: url("https://images.wallpaperscraft.com/image/leaves_green_dark_145996_1920x1080.jpg");
            background-size: contain;
        }
        hr.solid {
            border-top: 3px solid #bbb;
            margin:auto;
            width:100%;
            display: block;
        }
        button {
            width:100%;
        }
        #buttonContainer {
            width:50%;
            margin:auto;
            display: block;
        }
        

        .sticky {
            position: fixed;
            top: 0;
            right:0;
            padding:0;
            margin-right:10px;
            z-index: 999;
        }
        #timerContainer {
            right:0;
            position:absolute;
            top:0;
            margin-right:10px;
            color:white;
            
        }
        .titles {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div id ='timerContainer'>
        <h1 class='text-center display-5' id ='timer'></h1>
    </div>
    <div id = 'contents' class='container-xl pt-3 my-5'>
        <h1 class='display-2 text-center'><?php echo $rowTest['title'];?></h1>
        
    
    
    <form method="POST" id='test'>
    <div id = 'wholeForm'>
    <?php

        $sql = "SELECT q.id, a.value as 'answerValue', q.title, a.isCorrect, q.fileName,q.tag,q.isActive
                FROM questions as q 
                INNER JOIN questions_answers_rel as qar 
                ON q.id = qar.question_id 
                INNER JOIN answers AS a 
                ON a.id = qar.answer_id
                ORDER BY q.id ASC;";

        $result = mysqli_query($conn,$sql);
        

        $sqlTest = "SELECT * FROM tests WHERE isActive='1'";
        $resultTest = mysqli_query($conn,$sqlTest);
        $rowTest = mysqli_fetch_array($resultTest);
        
        $pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) &&
                              ($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0'||
                            $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache')&&!isset($_POST['submitAnswers']); 
        if($pageRefreshed == 1){
            echo "<script type = 'text/javascript'>confirm('Are you sure you want to refresh the page?');</script>";
        }
          
        $sqlTime = "SELECT * FROM users WHERE id = '$userId';";
        $resultTime = mysqli_query($conn, $sqlTime);
        $rowTime = mysqli_fetch_array($resultTime);
        $userTimeStart = date_create($rowTime['dateStarted']);
        $userTimeEnd = date_add($userTimeStart,date_interval_create_from_date_string($rowTest['time_for_test']." minutes"));
        
        $printed_questions = array();
        $counter = 1;
        $correct_answers = 0;
        while($row = mysqli_fetch_array($result))
        {
            
            if($testTag==$row['tag']&&$row['isActive'])
            {
            if(!in_array($row['id'],$printed_questions))
            {
                if($counter!=1)
                echo "
                      </div>
                      <hr class='solid'>";
                echo "<div id = 'question".$counter."' class = 'questions'>";
                
                echo "<p class='titles'>".$counter.". ".$row['title']."</p>";
                if($row['fileName'])
                    echo "<img src='http://localhost/Informatics%20Test/admin_panel/uploads/".$row['fileName']."' alt ='image".$row['id']."'/> <br>";

                array_push($printed_questions,$row['id']);
                $counter++;
            }
            echo "
                  <div class ='form-check'>
                    <label class='form-check-label'for = 'answersQ".$counter."'>
                        <input class='form-check-input' type='radio' name = 'answersQ".$counter."'value = '".$row['isCorrect']."'/>".$row['answerValue']."
                    </label>
                  </div>";
            if($counter == $numQ)
            break;
        }
        else 
        continue;
        }
        echo "</div>";


        $gradeString = "";
        function calculate_grade ($correct_answers, $counter) {
         
         if($correct_answers<$counter/2)
             $gradeString ="Слаб 2";
         if($correct_answers*100/$counter>=50 && $correct_answers*100/$counter<=60 )
             $gradeString = "Среден 3";
         if( $correct_answers*100/$counter>60 && $correct_answers*100/$counter<=70 )
             $gradeString = "Добър 4";
         if( $correct_answers*100/$counter>70 && $correct_answers*100/$counter<=90 )
             $gradeString =  "Мн.Добър 5";
         if( $correct_answers*100/$counter>90 && $correct_answers*100/$counter<=100 )
             $gradeString  = "Отличен 6";
             
             
             $_SESSION['grade'] = $gradeString;
             
             $_SESSION['points'] = $correct_answers;
             $_SESSION['questionsNum'] = $counter;
             
             
     }  
     
     if(isset($_POST['submitAnswers']))
     {
         $counter1 = 2;
         
         
         while($counter1<=$counter)
         {
             if($_POST['answersQ'.$counter1]=="1" && isset($_POST['answersQ'.$counter1]))
             $correct_answers++;
             $counter1++;
         }
         
         calculate_grade($correct_answers, $counter);
         echo "
            <script>
                window.location.href = 'http://localhost/Informatics%20Test/Result.php?id=".$userId."&dateEnded=". strtotime(date('Y-m-d H:i:s'))."';
            </script>";
         
         
                    
     }
        
        
    ?>
        <input name = 'submitAnswers' type = 'hidden'  checked/>
        <div id='buttonContainer'>
            <button type = "submit" name = "btnSubmit" class='btn btn-success' >Предай</button>
        </div>
    </div>
    </form>
    <script type='text/javascript'>
            
            var seconds = <?php echo date_diff(date_create(date('Y-m-d H:i:s')),$userTimeEnd)->format('%s');?>;
            var minutes = <?php echo date_diff(date_create(date('Y-m-d H:i:s')),$userTimeEnd)->format('%i');?>;
            
            function GetTime(){
            
                    seconds--;
                    if(seconds<=0)
                    {
                        seconds=59;
                        minutes--;
                    }
                    if(minutes<0)
                    {   
                        document.getElementById('test').submit();
                    }
                    
                    seconds = update(seconds);
                    timer = document.getElementById("timer").innerText =""+ minutes + " : "+ seconds;
                    time = setTimeout(function(){GetTime()},1000);
            
                }
                function update(a){
                    if(a<10){
                        return "0"+a;
                    }
                    else{
                        return a;
                    }
                    
                }
            GetTime();
            window.onscroll = function() {myFunction()};
            var timer = document.getElementById("timer");
            
            var sticky = timer.offsetTop;
            
            function myFunction() {
                if (window.pageYOffset >= sticky) {
                    timer.classList.add("sticky");
                }
                else {
                    timer.classList.remove("sticky");
                }
            }
    </script>
    </div>
</body>
</html>