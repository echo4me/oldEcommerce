<?php
ob_start();
session_start();
// Make Sure none access this page only who have Authoristy
if(isset($_SESSION['Username']))
    {
        $pageTitle = 'Dashboard'; // This Varible we used to Get PageTitle
        include "init.php";
        $theLatestUsers = getLatest("*","users","UserID",5);
        $theLatestItems = getLatest("*","items","Item_ID",3);
        ?>
        <!-- Start Dashboard Page Design -->
        <section class="home-stats">
            <div class="container">
                <h1 class="text-center"><?= lang('DASHBOARD') ;?></h1>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat st-members">
                        <i class="fa fa-users"></i>
                            <div class="info"> 
                                <?= lang('TOTALMEMBERS') ;?> <span><a href="members.php"><?= countItems('UserID','users'); ?></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-pending">
                        <i class="fa fa-user"></i>
                            <div class="info">
                            <?= lang('PENDINGMEMBERS') ;?> <span><a href="members.php?do=manage&page=pending"><?= checkItem('RegStatus','users',0) ;?></a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-items">
                            <i class="fa fa-check"></i>
                            <div class="info"><?= lang('TOTALITEMS') ;?> <span><a href="items.php?do=manage">
                                <?= countItems('Item_ID','items') ;?></a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-comments">
                            <i class="fa fa-comments"></i>
                                <div class="info"> <?= lang('TOTALCOMMENTS') ;?> <span><a href="comments.php"><?= countItems('c_id','comments'); ?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="latest">
            <div class="container latest">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-users"></i> <?= lang('LATESTUSERS') ;?>
                                <span class="toggle-info pull-right"> 
                                    <i class="fa fa-plus fa-lg"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                <?php
                                    if(!empty($theLatestUsers))
                                    {
                                        foreach($theLatestUsers as $user ){
                                            echo '<li>'.$user['FullName'].
                                            '<a href="members.php?do=edit&userid='.$user['UserID'].'">
                                            <span class="btn btn-success pull-right"><i class="fa fa-edit"></i> Edit </span></a></li>'; 
                                        }
                                    }else{
                                        echo "There is no Recored To show";
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-tag"></i> <?= lang('LATESTITEMS') ;?>
                                <span class="toggle-info pull-right"> 
                                    <i class="fa fa-plus fa-lg"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                <?php
                                    foreach($theLatestItems as $item ){
                                        echo '<li>'.$item['Name'].
                                        '<a href="items.php?do=edit&itemid='.$item['Item_ID'].'">
                                        <span class="btn btn-success pull-right"><i class="fa fa-edit"></i> Edit 
                                        
                                      </span></a></li>'; 
                                        
                                     }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start Comments Table -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-comment"></i> Latest Comments
                                <span class="toggle-info pull-right"> 
                                    <i class="fa fa-plus fa-lg"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                
                                <?php
                                $stmt = $con->prepare("SELECT comments.* , users.Username  FROM `comments` 
                                INNER JOIN users ON users.UserID = comments.user_id ORDER BY c_id DESC LIMIT 5");
                                $stmt->execute();
                                $comments = $stmt->fetchAll();   
                                foreach( $comments as $comment){
                                    echo "<div class='comment-box' >";
                                    echo "<a href='members.php?do=edit&userid=".$comment['user_id']."'>
                                    <span class='membersu'>".$comment['Username']."</span></a>";
                                    echo "<p class='commentu'>".$comment['comment'] ."</p>";
                                    echo "</div>";
                                }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    <?php    include $tpl."footer.php";

    }else
    {
        header("Location: index.php");
        exit();
    }
    ob_end_flush();
?>