<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php getPageTitle()  ; ?></title>
    <link rel="stylesheet" href="<?= $css ;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?= $css ;?>font-awesome.min.css">
    <link rel="stylesheet" href="<?= $css ;?>jquery-ui.css">
    <link rel="stylesheet" href="<?= $css ;?>jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?= $css ;?>front.css">
</head>
<body>
<div class="upper-bar">
  <div class="container">
    <?php
    if(isset($_SESSION['user']))
    {?>

      <img src="img.png" alt="" class='img-circle img-thumbnail' height="35px" width="35px">
      <div class="btn-group my-info">
        <span class="btn dropdown-toggle" data-toggle="dropdown">
          <?= $sessionUser;?>
        <span class="caret"></span>
        </span>
        <!-- DropDown Menu bootstrap -->
        <ul class="dropdown-menu">
          <li><a href="profile.php">My Profile</a></li>
          <li><a href="newad.php">New Items</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>

      <?php
      $userStatus = checkUserStatus($sessionUser);// 1 from rowCount he fetch 
      if($userStatus == 1){echo " <i><small>Your Membership Need To Active by Admin</small></i>";}

    }else{

    ?>
    <span>
      <?= "Today is " .date("l").' '.date("d.m.Y");?>
    </span>
    <a href="login.php">
      <span class="pull-right">Login | Signup</span>
    </a>
    <?php  } ;?>
  </div>
</div>
<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">HOME PAGE</a>
    </div>

    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php 
          foreach(getAllDate('*','categories','WHERE parent =0','','ID','ASC') as $cate){
           
            echo '<li><a href="categories.php?pageid=' . $cate['ID'] . '">' . $cate['Name'] . '</a></li>';
          }
        ?>
      </ul>

  
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
