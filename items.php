<?php 
ob_start();
session_start();
$pageTitle = 'Show items'; // This Varible we used to Get PageTitle
include "init.php";

    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    $stmt = $con->prepare("SELECT items.*, categories.Name AS category_name, users.Username
    FROM `items` 
    INNER JOIN categories ON categories.ID = items.Cate_ID 
    INNER JOIN users ON users.UserID = items.Member_ID 
    WHERE `Item_ID`= ? AND `Approve` = 1 ");
    $stmt->execute(array($itemid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0)
    { 
        
?>
    <h1 class='text-center'><?= $row['Name']; ?></h1>
    <div class="container">
        <div class="row">
            <!-- photo -->
            <div class="col-md-3">
                <img src="img.png" alt="" class="img-responsive img-thumbnail center-block">
            </div>
            <!-- info -->
            <div class="col-md-9 item-info">
                <h2><?= $row['Name']; ?></h2>
                <p><?= $row['Description']; ?></p>
                <ul class="list-unstyled">
                    <li>
                        <i class="fa fa-calendar"></i>
                        <?= $row['Add_Date']; ?></li>
                    <li>
                    <i class="fa fa-money"></i>
                        <?= $row['Price']; ?>
                    </li>
                    <li>
                        <i class="fa fa-flag"></i>
                        <span> Made in: </span><?= $row['Country_Made']; ?>
                    </li>
                    <li>
                        <i class="fa fa-tags"></i>
                        <span>Category : </span><a href="categories.php?pageid=<?= $row['Cate_ID']; ?>"><?= $row['category_name']; ?></a>
                    </li>
                    <li>
                        <i class="fa fa-user"></i>
                        <span>Added By : </span><a href="#"><?= $row['Username']; ?></a>
                    </li>
                    <li class="tags-items">
                        <i class="fa fa-tags"></i>
                        <span>Tags : </span><?php 
                            $allTags = explode(',',$row['Tags']);
                            foreach($allTags as $oneTag){
                                $oneTag = str_replace(' ','',$oneTag);
                                $oneTag = strip_tags($oneTag);
                                if(!empty($oneTag))
                                {
                                echo "<a href='tags.php?name=".strtolower($oneTag)."'>" .$oneTag.'</a>';
                                }
                            }

                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <!-- Start Add Comment Section -->
        <?php 
        if (isset($_SESSION['user'])){

        ?>
        <div class="row">
            <div class="col-md-offset-3">
                <div class="add-comment">
                    <h3>Add your comment</h3>
                    <form action="<?= $_SERVER['PHP_SELF'] .'?itemid='.$row['Item_ID'];  ?>" method="POST" >
                        <textarea name="comment" id="" class="form-control" resize=none required></textarea>
                        <input type="submit" value="Add Comment" class="btn btn-primary">
                    </form>
                    <?php
                        if($_SERVER['REQUEST_METHOD'] == "POST")
                        {
                            $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING); 
                            $itemid  = $row['Item_ID'];
                            // we use uid so it will add comment with our id 
                            $userid  = $_SESSION['uid'];
                            if(!empty($comment)){
                                $stmt = $con->prepare("INSERT INTO 
                                comments(`comment`, `status`, `comment_date`,`item_id`,`user_id`) 
                                VALUES(:zcomment, 0, now(), :zitemid, :zuserid)
                                ");
                                $stmt->execute([
                                    ':zcomment' => $comment,
                                    ':zitemid' =>$itemid,
                                    ':zuserid' =>$userid
                                ]);
                                // check if stmt done and everything is fine
                                if($stmt)
                                { 
                                    echo "<div class='alert alert-success' >Comment Added</div>"; 
                                }
                            }else{
                                echo "<div class='alert alert-danger' >Comment is Required</div>"; 
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- End Add Comment Section -->
        <?php }else{
                 echo "<i>You need To <a href='login.php'>Login</a> To Add Comments</i>";// if someone not have session will not Add comments
        }     ?>

        <hr>
        <?php
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                // will filter comments and show for user only that login already-and only for activate comments by admin will show 1
                $stmt = $con->prepare("SELECT comments.* , users.Username
                FROM `comments` INNER JOIN users ON users.UserID = comments.user_id 
                WHERE `item_id` = ? AND status = 1
                ORDER BY `c_id` DESC ");
                $stmt->execute([$row['Item_ID']]);
                $comments = $stmt->fetchAll();
                $count = $stmt->rowCount();
            ?>
            <!-- Loop and Get Data -->
            <?php
            foreach($comments as $comment){ ?>
                <div class="comment-box">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img src="img.png"  class="img-responsive img-circle img-thumbnail center-block">
                            <?= $comment['Username']?>
                        </div>

                        <div class="col-md-10"> 
                            <p class='lead'><?= $comment['comment']?></p>
                        </div>
                    </div>
                </div>
                <hr>
           <?php } ?>
            
            
    </div>



<?php 
}else{
    $theMsg = "<div class='alert alert-danger text-center'> There is No Such ID Or This Item waiting Approval</div>";
    redirectHome($theMsg,'back');
}

include $tpl."footer.php"; 
ob_end_flush();
?>

