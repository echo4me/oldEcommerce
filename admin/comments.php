<?php
/*
======================================================
= You Can Do [Edit - Add - Delete] Comments From here =
======================================================
*/
session_start();
$pageTitle = 'Comments';
// Make Sure none access this page only who have Authoristy
if(isset($_SESSION['Username']))
{
    include "init.php";
    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage' ;

    if($do =='manage'){ 
        //Manage Member Page Start      
        // Connect DB and Get All info to use inside Manage page-
        $stmt = $con->prepare("SELECT comments.* , items.Name , users.Username FROM `comments` 
        INNER JOIN items ON items.Item_ID = comments.item_id
        INNER JOIN users ON users.UserID = comments.user_id
          ");
        $stmt->execute();
        $rows = $stmt->fetchAll(); ?>
    
        <h1 class="text-center"><?= lang("COMMENTMANAGE")?></h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered text-center">
                    <tr>
                        <td>#ID</td>
                        <td width='45%'>Comment</td>
                        <td>Item Name</td>
                        <td>Comment User</td>
                        <td>Added Date</td>
                        <td>Control</td>
                    </tr>
                    <?php foreach($rows as $row):?>
                    <tr>
                        <td><?= $row['c_id']; ?></td>
                        <td><?= $row['comment']; ?></td>
                        <td><?= $row['Name']; ?></td>
                        <td><?= $row['Username']; ?></td>
                        <td><?= $row['comment_date']; ?></td>
                        <td>
                            <a href="?do=edit&comid=<?= $row['c_id'] ;?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                            <a href="?do=delete&comid=<?= $row['c_id'] ;?>" class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete</a>
                            <?php
                                // show Activate btn for Pending Customers
                                if($row['status']  == 0)
                                {
                                    echo "<a href='?do=approve&comid=".$row['c_id']. "' class='btn btn-info'><i class='fa fa-check'></i> Approve</a>"; 
                                }
                            
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    <?php 
    }elseif($do == 'edit')//Edit Page Start  
    {
        // Get integer ID from url that referer to $_SESSION['id'] For DB that mean UserID
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        
        $stmt = $con->prepare("SELECT * FROM `comments` WHERE `c_id`= ? ");
        $stmt->execute(array($comid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
       // var_dump($row);die;
        if($count > 0){?> <!-- End Php tag -->
        <!-- if the rowCount have value ,will submit the form -->
            <h1 class="text-center">Edit Comments</h1>
            <div class="container">
                <form action="?do=update" method="POST" class="form-horizontal">
                    <!-- put userid as hidden input to save his value to show in second page -->
                    <input type="hidden" name="comid" value="<?= $comid; ?>">
                    <!-- Comment Field -->
                    <div class="form-group">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Comment</label>
                        <div class="col-md-6 col-sm-10">
                        <textarea name="comment" class="form-control"><?= $row['comment'];?></textarea>
                        </div>
                    </div>
                    <!-- Button Field -->
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <input type="submit" name="submit" value='Update' class='btn btn-primary '>
                        </div>
                    </div>

                </form>
            </div>
        <?php 
        }else{ 
            echo "<div class='container'> ";
            $theMsg = "<div class='alert alert-danger'>There no Such ID </div>"; 
            redirectHome($theMsg);
            echo "</div>";
        }

        ?>
        
    <?php
    }elseif($do == 'update')//Update Page Start
    {
        echo '<h1 class="text-center">Update Comment</h1>';
        echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            //Get Variable From Form
            $comid   = $_POST['comid'];
            $comment = $_POST['comment'];

            // if no Error will update the DB
            if(!empty($comment))
            {
                
                //Update The Database
                $stmt = $con->prepare("UPDATE `comments` SET `comment`= ? WHERE `c_id` = ? ");
                $stmt->execute(array($comment,$comid));
                $count = $stmt->rowCount();
                $theMsg = '<div class="text-center alert alert-success"><strong>'.$count.'</strong> Recored Updated</div>';
                redirectHome($theMsg,'back');
            }else{
                echo "<div class='container'> ";
                $theMsg = "<div class='text-center alert alert-danger'>Sorry This Field is empty</div>"; 
                redirectHome($theMsg,'back');
                echo "</div>";
            }


        }else{
            echo "<div class='container'> ";
            $theMsg = "<div class='text-center alert alert-danger'>Sorry You can't Browse This Page</div>"; 
            redirectHome($theMsg);
            echo "</div>";
        }
        echo "</div>";

    }elseif($do == 'delete')
    { // Delete Member Page
        echo '<h1 class="text-center">Deleted Members</h1>';
        echo "<div class='container'>";
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        $stmt = $con->prepare("DELETE FROM `comments` WHERE `c_id`= ?");
        $stmt->execute(array($comid));
        $count = $stmt->rowCount();
        
        echo "<div class='container'> ";
            $theMsg = '<div class="alert alert-success"><strong>'.$count.'</strong> Recored Deleted</div></div>'; 
            redirectHome($theMsg,'back');
            echo "</div>"; 
    }elseif($do == 'approve')
    {// Activate Comment Page
        echo '<h1 class="text-center">Approve Comment</h1>';
        echo "<div class='container'>";
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        $stmt = $con->prepare("UPDATE `comments` SET `status` = 1 WHERE `c_id`= ? ");
        $stmt->execute(array($comid));
        $count = $stmt->rowCount();
        if($count > 0)
        {
            echo "<div class='container'> ";
            $theMsg = '<div class="alert alert-success"><strong>'.$count.'</strong> Recored Deleted</div></div>'; 
            redirectHome($theMsg,'back');
            echo "</div>";
        }else{
            $theMsg = '<div class="alert alert-danger"><strong>'.$count.'</strong> Recored Deleted</div>'; 
            redirectHome($theMsg,'back');
        }
    }
  
    include $tpl."footer.php";//include it for bootsrap js

}else
{
    header("Location: index.php");
}