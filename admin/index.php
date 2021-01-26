<?php 
    session_start();
    $pageTitle = 'Home Page'; // This Varible we used to Get PageTitle
    $noNavbar = ''; // This Varible we used to Hide Navbar
    // Redirect To Dashboard if have $_SESSION['username']
    if(isset($_SESSION['Username'])) { header("Location: dashboard.php") ;  exit(); }
    include "init.php";
    
    // Check if user come from POST Request
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);

        //check if user Exists in DB
        $stmt = $con->prepare("SELECT `UserID`,`Username`,`Password` FROM `users` WHERE `Username`= ? AND `Password`= ? AND `GroupID` = 1 LIMIT 1 ");
        $stmt->execute(array($username,$hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount(); 
       //echo $count; // if count have number this mean The DB Contain Record About this username
       if($count > 0)
       {
           $_SESSION['Username'] = $username; 
           $_SESSION['id'] = $row['UserID']; //Get UserID from DB and save inside $_SESSION['id']
           header("Location: dashboard.php") ; // Will Redirect To Dashboard if have $_SESSION['username']
           exit();
       }



    }




?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post' class='login'>
    <h4 class="text-center h1">Admin Login</h4>
    <input type="text" class='form-control' name='user' placeholder="Username" autocomplete="off" > 
    <input type="password" class='form-control' name='pass' placeholder="Password" autocomplete="new-password"> 
    <input type="submit" class='btn btn-primary btn-block' name='submit' value="Login">
    <span>&copy; Apple- All rights Reversed</span>
</form>









<?php include $tpl."footer.php"; ?>

