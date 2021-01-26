<?php 
    ob_start();
    session_start();
    $pageTitle = 'Login';
    // Redirect To Dashboard if have $_SESSION['username']
    if(isset($_SESSION['user'])) { header("Location: profile.php") ;  exit(); }
    include "init.php";

    // Check if user come from POST Request
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        // Post From Login Page user and pass only
        if(isset($_POST['login']))
        {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $hashedPass = sha1($pass);
            
            //check if user Exists in DB
            $stmt = $con->prepare("SELECT `UserID` ,`Username`,`Password` FROM `users` WHERE `Username`= ? AND `Password`= ? ");
            $stmt->execute(array($user,$hashedPass));
            $result = $stmt->fetch();
            $count = $stmt->rowCount(); 
            
            //echo $count; // if count have number this mean The DB Contain Record About this username
            if($count > 0)
            {
                $_SESSION['user'] = $user; 
                $_SESSION['uid'] = $result["UserID"]; 
                header("Location: profile.php") ; // Will Redirect To Dashboard if have $_SESSION['username']
                exit();
            }
        }else{
            // Post From Signup Page
            $username  = $_POST['username'];
            $password  = $_POST['password'];
            $password2 = $_POST['password-again'];
            $email     = $_POST['email'];
            $fullname  = $_POST['fname'];
            
            $formErrors = [];
            if(isset($username))
            {
                $username = filter_var($username,FILTER_SANITIZE_STRING);
                if(empty($username)){
                    $formErrors[] ="Username is Required";
                }
                
            }

            //Password Check
            if(isset($password) && isset($password2))
            {
                if(empty($password)){ $formErrors[] ='Password is Required'; }

                if(sha1($password) !== sha1($password2)){
                    $formErrors[] = 'Sorry Password is Not Match';
                }
                
                
            }
            // Email check
            if(isset($email))
            {
                $email= filter_var($email,FILTER_SANITIZE_EMAIL);
                if(filter_var($email,FILTER_VALIDATE_EMAIL) !=true){
                    $formErrors[] = 'This Email is not Valid';
                }

            }
            // Fullname check
            if(isset($fullname)){
                $fullname = filter_var($fullname,FILTER_SANITIZE_STRING);
                if(empty($fullname)){
                    $formErrors[] = 'Fullname is Required';
                }
            }
            
            if(empty($formErrors))
            {             
                //Check if user Exist in DB (unique or no)
                $check = checkItem("Username",'users',$username);
                
                if($check == 1)
                {
                    $formErrors[] = 'Sorry This User is Exists';
                }else{
                    //Insert in The Database
                    $stmt = $con->prepare("INSERT INTO `users` (`Username`,`Password`,`Email`,`FullName`,`RegStatus`,`Date`) 
                    VALUES (:zusername ,:zpassword ,:zemail ,:zname , 0 ,now() ) ");
                    $stmt->execute(array(
                        'zusername'  => $username,
                        'zpassword'  => sha1($password),
                        'zemail'     => $email,
                        'zname'      => $fullname
                    ));
                    $count = $stmt->rowCount();
                    $successMsg = 'Successfuly You Regestier a New User';
                }
                
            }


        }//end post signup page
        


    }//end requestmethod=post page
?>


<div class="container parent-head">
    <h1 class="text-center">
        <span id='login' class="selected">Login</span> |
        <span id='signup' >SignUp</span>
    </h1>
    <!-- Login Form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-login mylogin">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Username" pattern=".{4,}" title="Username must be 4 Charcters">
        <input class="form-control" type="password" name="password" autocomplete="off" placeholder="Type Password" >
        <input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
    </form>

    <!-- Signup Form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-login mysignup ">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Your Username" pattern=".{4,}" title="Username must be 4 Charcters">
        <input class="form-control" type="password" name="password" autocomplete="off" placeholder="Type Complex Password" minlength="6" pattern=".{6,}" title="Username more than 6 Charcters">
        <input class="form-control" type="password" name="password-again" autocomplete="off" placeholder="Confirm Your Password">
        <input class="form-control" type="email" name="email" autocomplete="off" placeholder="Type Email Address">
        <input class="form-control" type="text" name="fname" autocomplete="off" placeholder="Type Full Name">
        <input class="btn btn-success btn-block" type="submit" name="signup" value="Signup">
    </form>
    <!-- Success/Error Message -->
    <div class="the-errors text-center">
        <?php
            if(!empty($formErrors)){
                foreach($formErrors as $err){
                    echo "<p class='msg error'>".$err .'</p>';
                }
            }
            if(isset($successMsg))
            {
                echo "<div class='msg success'>".$successMsg."</div>";
            }
        
        ?>
    </div>
</div>





<?php 
include $tpl."footer.php"; 
ob_end_flush();
?>

