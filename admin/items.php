<?php
/*
======================================================
= You Can Do [Edit - Add - Delete] Members From here =
======================================================
*/
ob_start();
session_start();
$pageTitle = 'Items Page';
// Make Sure none access this page only who have Authoristy
if(isset($_SESSION['Username']))
{
    include "init.php";
    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage' ;
    if($do == 'manage')
    {
        //manage page start
        $query = '';
        if(isset($_GET['page']) && $_GET['page']=='pending'){
            $query = 'AND `Approve` = 0 ';
        }
        // Connect DB and Get All info to use inside Manage page-
        $stmt = $con->prepare("SELECT items.*, categories.Name AS category_name,users.Username FROM `items` 
        INNER JOIN categories ON categories.ID = items.Cate_ID
        INNER JOIN users ON users.UserID = items.Member_ID");
        $stmt->execute();
        $rows = $stmt->fetchAll();
       // var_dump($rows);die;

    ?>

        <h1 class="text-center"><?= lang("MANAGEMEMBERS")?></h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered text-center">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Add Date</td>
                        <td>Country Made</td>
                        <td>Category</td>
                        <td>Member</td>
                        <td width="25%">Control</td>
                    </tr>
                    <?php foreach($rows as $row):?>
                    <tr>
                        <td><?= $row['Item_ID']; ?></td>
                        <td><?= $row['Name']; ?></td>
                        <td><?= $row['Description']; ?></td>
                        <td><?= $row['Price']; ?></td>
                        <td><?= $row['Add_Date']; ?></td>
                        <td><?= $row['Country_Made']; ?></td>
                        <td><?= $row['category_name']; ?></td>
                        <td><?= $row['Username']; ?></td>
                        <td>
                            <a href="?do=edit&itemid=<?= $row['Item_ID'] ;?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                            <a href="?do=delete&itemid=<?= $row['Item_ID'] ;?>" class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete</a>
                        <?php
                            // show Activate btn for Pending Customers
                            if($row['Approve']  == 0)
                            {
                                echo "<a href='?do=approve&itemid=".$row['Item_ID']. "' class='btn btn-info'><i class='fa fa-check'></i> Aprrove</a>"; 
                            }
                        ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <a href='?do=add' class="btn btn-primary"><i class="fa fa-plus"></i> Add New Items</a>
        </div>
         
        
    <?php 

    }elseif($do == 'add'){?>
    <!-- Start Add Category Page -->
    <h1 class="text-center">Add New Item</h1>
        <div class="container">
            <form action="?do=insert" method="POST" class="form-horizontal">    
                <!-- Item Name Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Name </label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="name" class='form-control' required="required" placeholder="Put Name of Item">
                    </div>
                </div>
                <!-- Item Description Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Description</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="description" class='form-control' required="required" placeholder="Put Description of Item">
                    </div>
                </div>
                <!-- Item Price Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Price</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="price" class='form-control' required="required" placeholder="Put Price of Item">
                    </div>
                </div>
                 <!-- Item Country Made Field -->
                 <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Country Made</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="country" class='form-control' required="required" placeholder="Put Country of Made">
                    </div>
                </div>
                 <!-- Item Status Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Status</label>
                    <div class="col-md-6 col-sm-10">
                        <select name="status" >
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">Used</option>
                            <option value="3">Old</option>
                        </select>

                    </div>
                </div>
                <!-- Member Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Member</label>
                    <div class="col-md-6 col-sm-10">
                        <select name="member" >
                            <option value="0">...</option>
                            <?php 
                            $members = getAllDate('*','users','','','UserID');
                            foreach($members as $user){
                                echo "<option value=".$user['UserID'].">".$user['Username']."</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>
               <!-- Category Field -->
               <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Category</label>
                    <div class="col-md-6 col-sm-10">
                        <select name="category" >
                            <option value="0">...</option>
                            <?php 
                            $allCates = getAllDate('*','categories','WHERE parent=0','','ID');
                            foreach($allCates as $cate){
                                echo "<option value=".$cate['ID'].">".$cate['Name']."</option>";
                                $childCates = getAllDate('*','categories',"WHERE parent = {$cate['ID']}",'','ID');
                                foreach($childCates as $child){
                                    echo "<option value=".$child['ID'].">----".$child['Name']."</option>";
                                }
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <!-- Item tags Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Tags</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="tags" class='form-control' placeholder="Sperate tags with comma (,)">
                    </div>
                </div>
                <!-- Button Field -->
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <input type="submit" name="submit" value='Add Item' class='btn btn-primary '>
                    </div>
                </div>
            </form>
        </div>   
    <?php
    }elseif($do == 'insert'){
        if($_SERVER['REQUEST_METHOD']=="POST"){

            echo '<h1 class="text-center">Insert Items</h1>';
            echo "<div class='container'>";

            //Get Variable From Form
            $name     = $_POST['name'];
            $desc     = $_POST['description'];
            $price    = $_POST['price'];
            $country  = $_POST['country'];
            $status   = $_POST['status'];
            $cate     = $_POST['category'];
            $member   = $_POST['member'];
            $tags     = $_POST['tags'];
             //Valdate my Form
            $formErrors = array();
            
            if(empty($name)){
                $formErrors[] = "Item Name is Required";
            }
            if(empty($desc)){
                $formErrors[] = "Description is Required";
            }
            if(empty($price)){
                $formErrors[] = "Price is Required";
            }
            if(empty($country)){
                $formErrors[] = "Country is Required";
            }
            if($status == 0){
                $formErrors[] = "You must choose the Status";
            }
            if($cate == 0){
                $formErrors[] = "You must choose the Category";
            }
            if($member == 0){
                $formErrors[] = "You must choose the Member";
            }
            //loop in array and show error if it exists
            foreach ($formErrors as $error) { echo "<div class='alert alert-danger'>".$error."</div>";}
            // if no Error will update the DB
            
            if(empty($formErrors))
            {   
                    //Insert in The Database
                    $stmt = $con->prepare("INSERT INTO `items` (`Name`,`Description`,`Price`,`Country_Made`,`Status`,`Cate_ID`,`Member_ID`,`Tags`,`Add_Date`) 
                    VALUES (:zname ,:zdescription ,:zprice ,:zcountry, :zstatus ,:zcate ,:zmember ,:ztags ,now() ) ");
                    $stmt->execute(array(
                        'zname'         => $name,
                        'zdescription'  => $desc,
                        'zprice'        => $price,
                        'zcountry'      => $country,
                        'zstatus'       => $status,
                        'zcate'         => $cate,
                        'zmember'       => $member,
                        'ztags'         => $tags
                    ));
                    $count = $stmt->rowCount();
                    echo "<div class='container'>";
                    $theMsg = '<div class="alert alert-success"><strong>'.$count.'</strong> Recored Added</div>';
                    redirectHome($theMsg,'back');
                    echo "</div>";                    
            }

        }else{
            $theMsg = "<div class='alert alert-danger' >Sorry You can't Browse This Page</div>";
            redirectHome($theMsg,'back') ;
        }
        echo "</div>";
    }elseif($do == 'edit'){
        // Get integer ID from url that referer to $_SESSION['id'] For DB that mean itemid
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        
        $stmt = $con->prepare("SELECT * FROM `items` WHERE `Item_ID`= ? ");
        $stmt->execute(array($itemid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){?> <!-- End Php tag -->
        <!-- if the rowCount have value ,will submit the form -->
            <h1 class="text-center">Edit Items</h1>
            <div class="container">
                <form action="?do=update" method="POST" class="form-horizontal">
                    <!-- put itemid as hidden input to save his value to show in second page -->
                    <input type="hidden" name="itemid" value="<?= $itemid; ?>">
                    <!-- item Name Field -->
                    <div class="form-group">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Name</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" name="name" class='form-control' value="<?= $row['Name']; ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- Description Field -->
                    <div class="form-group">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Description</label>
                        <div class="col-md-6 col-sm-10">
                        <input type="text" name="desc" class='form-control' value="<?= $row['Description']; ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- Price Field -->
                    <div class="form-group ">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Price</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" name="price" class='form-control'value="<?= $row['Price']; ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- Country_Made Field -->
                    <div class="form-group ">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Country Made</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" name="country" class='form-control' value="<?= $row['Country_Made']; ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- Item Status Field -->
                    <div class="form-group">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Status</label>
                        <div class="col-md-6 col-sm-10">
                            <select name="status" >
                                <option value="0">...</option>
                                <option value="1" <?php if($row['Status'] == 1){echo "selected";} ;?> >New</option>
                                <option value="2" <?php if($row['Status'] == 2){echo "selected";} ;?> >Used</option>
                                <option value="3" <?php if($row['Status'] == 3){echo "selected";} ;?> >Old</option>
                            </select>

                        </div>
                    </div>
                    <!-- Member Field -->
                    <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Member</label>
                    <div class="col-md-6 col-sm-10">
                        <select name="member" >
                            <option value="0">...</option>
                            <?php 
                            $allUsers = getAllDate('*','users','','','UserID');
                            foreach($allUsers as $user){
                            //very important
                                echo "<option value='".$user['UserID']."'"; 
                                if($row['Member_ID'] == $user['UserID']){echo "selected";} 
                                echo " >".$user['Username']."</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>
               <!-- Category Field -->
               <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Category</label>
                    <div class="col-md-6 col-sm-10">
                        <select name="category" >
                            <option value="0">...</option>
                            <?php 
                            $allCate = getAllDate('*','categories','','','ID');
                            foreach($allCate as $cate){
                                echo "<option value='".$cate['ID']."'"; 
                                if($row['Cate_ID'] == $cate['ID']){echo "selected";} 
                                echo " >".$cate['Name']."</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <!-- Item tags Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Tags</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="tags" class='form-control' value="<?= $row['Tags']; ?>" placeholder="Sperate tags with comma (,)">
                    </div>
                </div>
                
                <!-- Button Field -->
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <input type="submit" name="submit" value='Save' class='btn btn-primary '>
                    </div>
                </div>
            </form>
        <!-- fetch comment start -->
            <?php
            $stmt = $con->prepare("SELECT comments.* , users.Username FROM `comments` 
            INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = '$itemid' ");
            $stmt->execute();
            $rows = $stmt->fetchAll(); 
            if( !empty($rows)) 
            {
            ?>
            <h1 class="text-center"><?= lang("COMMENTMANAGE")?></h1>
                <div class="table-responsive">
                    <table class="main-table table table-bordered text-center">
                        <tr>
                            <td>Comment</td>
                            <td>Comment User</td>
                            <td>Added Date</td>
                            <td>Control</td>
                        </tr>
                        <?php foreach($rows as $row):?>
                        <tr>
                            <td><?= $row['comment']; ?></td>
                            <td><?= $row['Username']; ?></td>
                            <td><?= $row['comment_date']; ?></td>
                            <td>
                                <a href="comments.php?do=edit&comid=<?= $row['c_id'] ;?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                <a href="comments.php?do=delete&comid=<?= $row['c_id'] ;?>" class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php  } ?>
    <!-- end Comment fetch -->
            </div>
        <?php 
        }else{ 
            echo "<div class='container'> ";
            $theMsg = "<div class='alert alert-danger'>There no Such ID </div>"; 
            redirectHome($theMsg);
            echo "</div>";
        }

   
   
    }elseif($do == 'update'){
        echo '<h1 class="text-center">Update Items</h1>';
        echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            //Get Variable From Form
            $id        = $_POST['itemid'];
            $name      = $_POST['name'];
            $desc      = $_POST['desc'];
            $price     = $_POST['price'];
            $country   = $_POST['country'];
            $status    = $_POST['status'];
            $cate      = $_POST['category'];
            $member    = $_POST['member'];
            $tags      = $_POST['tags'];

            //Valdate my Form
            $formErrors = array();
            if(empty($name)){
                $formErrors[] = "Item Name is Required";
            }
            if(empty($desc)){
                $formErrors[] = "Description is Required";
            }
            if(empty($price)){
                $formErrors[] = "Price is Required";
            }
            if(empty($country)){
                $formErrors[] = "Country is Required";
            }
            if($status == 0){
                $formErrors[] = "You must choose the Status";
            }
            if($cate == 0){
                $formErrors[] = "You must choose the Category";
            }
            if($member == 0){
                $formErrors[] = "You must choose the Member";
            }
            //loop in array and show error if it exists
            foreach ($formErrors as $error) { echo "<div class='alert alert-danger'>".$error."</div>";}
            
            // if no Error will update the DB
            if(empty($formErrors))
            {
                //Update The Database
                $stmt = $con->prepare("UPDATE `items` 
                SET
                 `Name`= ? , `Description`= ? , `Price`= ?, `Country_Made` = ?, `Status` = ?, `Cate_ID`= ?, `Member_ID`= ? , `Tags`= ? WHERE `Item_ID` = ? ");
                $stmt->execute(array($name,$desc,$price,$country,$status,$cate,$member,$tags,$id));
                $count = $stmt->rowCount();
                $theMsg = '<div class="text-center alert alert-success"><strong>'.$count.'</strong> Recored Updated</div>';
                redirectHome($theMsg,'back');
            }


        }else{
            echo "<div class='container'> ";
            $theMsg = "<div class='text-center alert alert-danger'>Sorry You can't Browse This Page</div>"; 
            redirectHome($theMsg);
            echo "</div>";
        }
        echo "</div>";

    }elseif($do == 'delete'){
        // Delete Member Page
        echo '<h1 class="text-center">Deleted Members</h1>';
        echo "<div class='container'>";
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        $stmt = $con->prepare("DELETE FROM `items` WHERE `Item_ID`= ? LIMIT 1 ");
        $stmt->execute(array($itemid));
        $count = $stmt->rowCount();
        
        echo "<div class='container'> ";
            $theMsg = '<div class="alert alert-danger"><strong>'.$count.'</strong> Recored Deleted</div></div>'; 
            redirectHome($theMsg,'back');
            echo "</div>"; 
    }elseif($do == 'approve'){
        // Activate Member Page
        echo '<h1 class="text-center">Approve Items</h1>';
        echo "<div class='container'>";
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        $stmt = $con->prepare("UPDATE `items` SET `Approve` = 1 WHERE `Item_ID`= ? ");
        $stmt->execute(array($itemid));
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
    


    include $tpl.'footer.php';
}else{
    header("Location: index.php");
    exit();
}


ob_end_flush();
?>