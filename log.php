<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Holland Decoded</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

 
 
    <!-- Read More scroll-->
     <link href="css/readmore.css" rel="stylesheet">
     <!-- Login-->
     <link href="css/login.css" rel="stylesheet">

</head>

<body id="page-top">
   <nav>
         
       
               
         <a class="navbar-brand page-scroll" href="index.html">
                    <img src="img/logo.png">
                <p>
                     <b >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Holland&nbsp;</b>
                     <b style="letter-spacing:4px">Decoded</b>
                      <!-- for decoded we add spaces -->
                </p>                     
                                     
                                    
          </a>
   
  
    </nav>
<header>
 
<video autoplay loop muted poster="" id="backgroundVideo">
         <source src="video/video.mp4" type="video/mp4">
</video>
 
 
    <div  class="login col-lg-12">
    <div class="col-lg-6">
    	<h2>Login</h2>
        <?php 
    if(isset($_POST['login'])){

    //get the value from form login 
    $username=$_POST['username1'];
    $password=$_POST['password1'];

    //Connect to the database
    $connection = mysqli_connect('localhost' , 'root' , 'root' , 'holland');
    if(!$connection){
       die ("database connection has failed");
    }

    //to prevent mysql injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    //if the username or the password is empty
    if (empty($username)) {
        $lerror ='Invalid username or password';
    }
    elseif (empty($password)) {
        $lerror ='Invalid username or password';
    }

    //query the database for users
    else{
    $query = "select * from users where username='$username' and password='$password'";
           $result=mysqli_query($connection , $query)
           or die("failed to query databases".mysql_error());
            
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if($row['username']==$username && $row['password']==$password){

    //to print the name in next page 
    $_SESSION['username'] = $row['username'];
    $_SESSION['id']= $row['id'];
    header('location: index.php');

    //if the user is not exsist in database
    }else{
       $lerror ='Invalid username or password';
    }
    }
    }
    ?>
        <form action=" " method="post">
        <div>
        	<input type="text" name="username1" placeholder="username" >
            <input type="password" name="password1" placeholder="password" >
            <span class="isa_error"><?php if(isset($lerror)){ echo $lerror; }?></span>
            <button type="submit" name="login" class="btn btn-primary btn-block btn-large">login</button>
        </div>
        </form>
    	 </div>
            <div class="col-lg-6">
    	<h2>Register now !</h2>
        <?php

    //get the value from form login 
    if(isset($_POST['submit'])){
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $confirm_password=$_POST['confirm_password'];

    //Connect to the database
    $connection = mysqli_connect('localhost' , 'root' , 'root' , 'holland');
    if(!$connection){
        die ("database connection is faild");
    }
    else{
        
    }

    //if the form without value
    if ($email && $password && $username){

    }
    else {
        $rerror='this field cannot be blank';
    }

    //check valid email
    if($email){
        if(!strpos($email,'@')){
            $eerror='invalid email';
        }
        else{ 

            //if the email exists 
            $check = "select * from users where email='$email' ";
            $result0=mysqli_query($connection , $check)or die("failed to query databases".mysql_error());
            $row = mysqli_fetch_array($result0, MYSQLI_ASSOC);
            if($row['email']== $email)
                        {
                            $Eerror='the email you inserted it does exist';
                        }

            //start inserting data if password biger than 6 and password = confirm password and name doesn't contant namber
            elseif(strlen($password) <6){
             $perror='your password is too short';
            }
            elseif ($password != $confirm_password){
             $Perror='your password is wrong';
            }
            
            elseif(strpos($username, '1')) {
                $Nerror='your username contain numbers';
            }
            elseif(strpos($username, '2')) {
                $Nerror='your username contain numbers';
            }
            elseif(strpos($username, '3')) {
                $Nerror='your username contain numbers';
            }
            elseif(strpos($username, '4')) {
                $Nerror='your username contain numbers';
            }
            elseif(strpos($username, '5')) {
                $Nerror='your username contain numbers';
            }
            elseif(strpos($username, '6')) {
                $Nerror='your username contain numbers';
            }
            elseif(strpos($username, '7')) {
                $Nerror='your username contain numbers';
            }
            elseif(strpos($username, '8')) {
                $Nerror='your username contain numbers';
            }
            elseif(strpos($username, '9')) {
                $Nerror='your username contain numbers';
            }
            elseif(strpos($username, '0')) {
                $Nerror='your username contain numbers';
            }
            else {

            //start inserting data
            $connection = mysqli_connect('localhost' , 'root' , 'root' , 'holland');
            $query = "insert into users (username,email,password) values ('$username' ,'$email' ,'$password')";
            $result=mysqli_query($connection , $query);
                if(!$result){
                    die ("query failded" . mysqli_errno());
                }else{
                    $_SESSION['username'] = $_POST['username'];
                    //echo "welcome " . $_POST['username'];
                    header('location: index.php');
                }
        }
    }
    }

    // pick up the id for next page 
    $query = "select * from users where email='$email' and password='$password'";
           $result=mysqli_query($connection , $query)
           or die("failed to query databases".mysql_error());
            
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['id']=$row['id'];
    }
    ?>


    	<form action=" " method="post">
        <div >
        	<input type="text" name="username" placeholder="firstname" >
            <span class="isa_error"><?php if (isset($Nerror)){echo $Nerror;} ?></span>
        </div>
        <div > 
            <input type="text" name="lastname" placeholder="last name">
            <span class="isa_error"><?php if (isset($Nerror)){echo $Nerror;} ?></span>
        </div>

        <div>
            <input type="text" name="email" placeholder="email" >
            <span class="isa_error"><?php if (isset($eerror)){echo $eerror;} ?></span>
            <span class="isa_error"><?php if (isset($Eerror)){echo $Eerror;} ?></span>
        </div>
        <div>
            <input type="password" name="password" placeholder="password" >
            <span class="isa_error"><?php if (isset($perror)){echo $perror;} ?></span>
        </div>
        <div>
            <input type="password" name="confirm_password" placeholder="confirm Password" >
            <span class="isa_error"><?php if(isset($rerror)){echo $rerror;} ?></span>
            <span class="isa_error"><?php if(isset($Perror)){echo $Perror;} ?></span>
        </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block btn-large">register</button>
        </form>
        </div>
 
    </div> 
 
</header>


 
</body>   

</html>


