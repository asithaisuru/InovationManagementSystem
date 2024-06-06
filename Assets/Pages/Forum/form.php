<?php
session_start();
if (isset($_SESSION['username']) || isset($_SESSION['role'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
    if ($role != 'Innovator') {
        echo "<script>window.location.href='../../../index.php';</script>";
        exit();
    }
} else {
    // header("Location: ../../../index.php");
    echo "<script>window.location.href='../../../index.php';</script>";
    exit();
}


include '../dbconnection.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html 
        {font-size: 14px;
        font-family: 'Titilium Web',sans-serif;
        background-color:black;
        color:white;
        }


        
      </style>
</head>
<!-- <?php include 'innovator-nav.php'; ?> -->

<body class="bg-dark text-white">


    <div class="container">
          <div class="subforum">
             <div class="subforum-title">
               <h1> General Information</h1>
             </div>
             <div class="subforum-row">
                    <div class="subforum-icon">
                        <i class="fa fa-car"></i>

                    </div>
                    <div class="subforum-description">
                       <h1><a href="">=Description Title:</a></h1>
                        <p>Description content</p>
                    </div>
                    <div class="subforum-stats">
                     <span>24 posts | 15 Topics</span>
                
                    </div>
                    <div class="subform-info">
                        <b><a href="">Last post</a></b> <a href="">JustUser</a>
                        <br>
                        on <small>22 Aug 2024</small>
                         
                    </div>
                     
                    



             </div>
            
            
            
            
            
            
            </div>
        
        
        
        
        
        
        
        
        </div>







</div>
   
    
</body>
</html