<?php 
session_start();
$pageTitle = 'Profile'; // This Varible we used to Get PageTitle
include "init.php";
if(isset($_SESSION['user']))
{
    $getUser = $con->prepare("SELECT * FROM `users` WHERE `Username`=? ");
    $getUser->execute([$sessionUser]); //is varibale come from init.php it same $_SESSION['user']
    $info=$getUser->fetch();
    $userid = $info['UserID'];
    
?>
    <h1 class='text-center'>My Profile</h1>
    <div class="information">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Main info
                </div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li> 
                            <i class="fa fa-unlock-alt"></i>
                            <span>User:</span>  <?= $info['Username'] ."<br>";  ?>
                        </li>
                        <li>
                        <i class="fa fa-envelope"></i>
                            <span>Email:</span>  <?= $info['Email'] ."<br>" ; ?>
                        </li>
                        <li>
                        <i class="fa fa-user"></i>
                            <span>Name :</span>  <?= $info['FullName']."<br>" ; ?>
                        </li>
                        <li>
                            <i class="fa fa-calendar"></i>
                            <span>Date :</span>  <?= $info['Date']."<br>" ; ?>
                        </li>
                        <li>
                            <i class="fa fa-tags"></i>
                            <span>Favourite :</span> Nothing
                        </li>
                    </ul>
                    <a  href='#' class="btn btn-default">Edit information</a>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Adds Section -->
    <div class="my-adds">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    My Items
                </div>
                <div class="panel-body">
                    <?php

                    $myItems = getAllDate("*","items","WHERE Member_ID = $userid","","Item_ID");
                    if(!empty($myItems))
                    {
                        echo "<div class='row'>";
                        // we use 1 here to show all items adds that approve and not approve
                        foreach($myItems as $item){
                            echo '<div class="col-md-3">';
                                echo '<div class="thumbnail item-box">';
                                if($item['Approve'] == 0){
                                    echo "<span class='approve-status'>Waiting Approval </span>";
                                }
                                echo '<span class="price-tag">$' .$item['Price']. '</span>';
                                    echo '<img class="img-responsive" src="img.png">';
                                    echo '<div class="caption">';
                                        echo '<h3><a href="items.php?itemid='.$item['Item_ID'].'">'.$item['Name'].'</a></h3>';
                                        echo '<p>'.$item['Description'].'</p>';
                                        echo '<div class="date">'.$item['Add_Date'].'</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }else{
                        echo "<i>There no Adds,You can </i> <a href='newad.php'>Create new Add</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- comments Section -->
    <div class="my-comments">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Latest Comment
                </div>
                <div class="panel-body">
                <?php
                    $myComments = getAllDate('comment','comments',"WHERE user_id = $userid",'','C_ID');
                    
                    if(!empty($myComments)){
                        foreach($myComments as $comment){
                            echo '<p>'.$comment['comment'].'</p>';
                        }
                        
                    }else{
                        echo "<i>There no Comments</i>";
                    }
                ?>
                </div>
            </div>
        </div>
    </div>

<?php 
}else{
    header("Location: index.php"); 
    exit();
}
include $tpl."footer.php"; 
?>

