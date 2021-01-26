<?php
/*
======================================================
= You Can Do [Edit - Add - Delete] Members From here =
======================================================
*/
session_start();
$pageTitle = 'Members';
// Make Sure none access this page only who have Authoristy
if(isset($_SESSION['Username']))
{
    include "init.php";
    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage' ;

    if($do =='manage'){ //Manage Member Page Start 
        // check if there Get request ?page=pending will show pending user by add to $query RegStatus=0
        $query = '';
        if(isset($_GET['page']) && $_GET['page']=='pending'){
            $query = 'AND `RegStatus` = 0 ';
        }
        
        // Connect DB and Get All info to use inside Manage page-
        //select all normal users not admin 
        $stmt = $con->prepare("SELECT * FROM `users` WHERE `GroupID` != 1 $query ");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        

    ?>

        <h1 class="text-center"><?= lang("MANAGEMEMBERS")?></h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered text-center manage-members">
                    <tr>
                        <td>#ID</td>
                        <td>Avatar</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Fullname</td>
                        <td>Date</td>
                        <td>Control</td>
                    </tr>
                    <?php foreach($rows as $row):?>
                    <tr>
                        <td><?= $row['UserID']; ?></td>
                            <?php
                           
                            echo "<td>";
                            if (empty($row['avatar'])) { echo 'No Image'; } else { echo "<img src='uploads/avatars/" . $row['avatar'] . "'  />"; }
                            echo "</td>";
                            ?>
                            
                        <td><?= $row['Username']; ?></td>
                        <td><?= $row['Email']; ?></td>
                        <td><?= $row['FullName']; ?></td>
                        <td><?= $row['Date']; ?></td>
                        <td>
                            <a href="?do=edit&userid=<?= $row['UserID'] ;?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                            <a href="?do=delete&userid=<?= $row['UserID'] ;?>" class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete</a>
                            <?php
                                // show Activate btn for Pending Customers
                                if($row['RegStatus']  == 0)
                                {
                                    echo "<a href='?do=activate&userid=".$row['UserID']. "' class='btn btn-info'><i class='fa fa-check'></i> Activate</a>"; 
                                }
                            
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <a href='members.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i> <?= lang("ADDNEWMEMBER");?></a>
        </div>
         
        
    <?php 
    }elseif($do == 'add')
    { // Add Page Start ?>
        <h1 class="text-center">Add New Members</h1>
        <div class="container">
            <form action="?do=insert" method="POST" class="form-horizontal" enctype="multipart/form-data">    
                <!-- username Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Username</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="username" class='form-control' autocomplete="off" required="required" placeholder="Put your Username">
                    </div>
                </div>
                <!-- Password Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Password</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="password" name="password" class='password form-control'  autocomplete="new-password" autocomplete="off" required="required" placeholder="Password must be Complex">
                        <i class="show-pass fa fa-eye fa-lg"></i>
                    </div>
                </div>
                <!-- Email Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Email</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="email" name="email" class='form-control' autocomplete="off" required="required" placeholder="Email Address Must be Valid">
                    </div>
                </div>
                <!-- Fullname Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Full Name</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="fullname" class='form-control' autocomplete="off" required="required" placeholder="Fullname Appear in Your Profile">
                    </div>
                </div>
                <!-- Avatar Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>User Avatar</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="file" name="avatar" class='form-control' required="required" id="inputGroupFile01">
                    </div>
                </div>

                <!-- Button Field -->
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <input type="submit" name="submit" value='Add' class='btn btn-primary '>
                    </div>
                </div>
            </form>
        </div>   

    <?php
    }elseif($do == 'insert')//Edit Page Start 
    {
        if($_SERVER['REQUEST_METHOD']=="POST"){

            echo '<h1 class="text-center">Insert Members</h1>';
            echo "<div class='container'>";
            
            //Get Variable From Form
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email    = $_POST['email'];
            $fullname = $_POST['fullname'];
            //Img Info
            $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");
            $avatarName      = $_FILES['avatar']['name'];
            $avatarSize      = $_FILES['avatar']['size'];
            $avatarTmp       = $_FILES['avatar']['tmp_name'];
            $avatarType      = $_FILES['avatar']['type'];
            $tmp = explode('.', $avatarName);
            $avatarExtension = end($tmp);

            $hashedPass = sha1($password);
             //Valdate my Form
            $formErrors = array();
            if(strlen($username) < 4){
                $formErrors[] = "Username Can't be Less than <strong>4</strong> Charcter";
            }
            if(empty($username)){
                $formErrors[] = "Username is Required";
            }
            if(empty($password)){
                $formErrors[] = "Username is Required";
            }
            if(empty($email)){
                $formErrors[] = "Email is Required";
            }
            if(empty($fullname)){
                $formErrors[] = "Fullname is Required";
            }
            if(empty($avatarName)){
                $formErrors[] = "Please Select Photo";
            }
            if(!empty($avatarName) && ! in_array($avatarExtension,$avatarAllowedExtension)){
                $formErrors[] = "sorry this File Extention Not Allowed";
            }
            if($avatarSize > 4194304 ){
                $formErrors[] = "Avatar Cant Be Big Than 4 MB ";
            }
            //loop in array and show error if it exists
            foreach ($formErrors as $error) { echo "<div class='alert alert-danger'>".$error."</div>";}
            // if no Error will update the DB
            
            if(empty($formErrors))
            {             
                $avatar = rand(100,10000).'_'.$avatarName; //random name image
                move_uploaded_file($avatarTmp,"uploads\avatars\\".$avatar ); //function to move img from tmp to new folder
                
                //Check if user Exist in DB (unique or no)
                $check = checkItem("Username",'users',$username);
                if($check == 1)
                {
                    $theMsg = "<div class='alert alert-danger'>Sorry This User is Exists</div>";
                    redirectHome($theMsg,'back');
                }else{
                    //Insert in The Database
                    $stmt = $con->prepare("INSERT INTO `users` (`Username`,`Password`,`Email`,`FullName`,`RegStatus`,`Date`,`avatar`) 
                    VALUES (:zusername ,:zpassword ,:zemail ,:zfullname, 1 ,now() ,:zavatar ) ");
                    $stmt->execute(array(
                        'zusername'  => $username,
                        'zpassword'  => $hashedPass,
                        'zemail'     => $email,
                        'zfullname'  => $fullname,
                        'zavatar'    => $avatar
                    ));
                    $count = $stmt->rowCount();
                    echo "<div class='container'>";
                    $theMsg = '<div class="alert alert-success"><strong>'.$count.'</strong> Recored Added</div>';
                    redirectHome($theMsg,'back');
                    echo "</div>";
                }
                
            }


        }else{
            $theMsg = "<div class='alert alert-danger' >Sorry You can't Browse This Page</div>";
            redirectHome($theMsg,'back') ;
        }
        echo "</div>";
    }elseif($do == 'edit')//Edit Page Start  
    {
        // Get integer ID from url that referer to $_SESSION['id'] For DB that mean UserID
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        
        $stmt = $con->prepare("SELECT * FROM `users` WHERE `UserID`= ? LIMIT 1 ");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){?> <!-- End Php tag -->
        <!-- if the rowCount have value ,will submit the form -->
            <h1 class="text-center">Edit Members</h1>
            <div class="container">
                <form action="?do=update" method="POST" class="form-horizontal">
                    <!-- put userid as hidden input to save his value to show in second page -->
                    <input type="hidden" name="userid" value="<?= $userid; ?>">
                    <!-- username Field -->
                    <div class="form-group">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Username</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" name="username" class='form-control' value="<?= $row['Username']; ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Password</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="hidden" name="oldpassword" value="<?= $row['Password'] ;?>">
                            <input type="password" name="newpassword" class='form-control'  autocomplete="new-password" placeholder="Leave it blank If you not Write">
                        </div>
                    </div>
                    <!-- Email Field -->
                    <div class="form-group ">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Email</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="email" name="email" class='form-control'value="<?= $row['Email']; ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- Fullname Field -->
                    <div class="form-group ">
                        <label for="" class='col-md-4 col-sm-2 control-label'>Full Name</label>
                        <div class="col-md-6 col-sm-10">
                            <input type="text" name="fullname" class='form-control' value="<?= $row['FullName']; ?>" autocomplete="off" required="required">
                        </div>
                    </div>
                    <!-- Button Field -->
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <input type="submit" name="submit" value='Save' class='btn btn-primary '>
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
        echo '<h1 class="text-center">Update Members</h1>';
        echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            //Get Variable From Form
            $userid   = $_POST['userid'];
            $username = $_POST['username'];
            $email    = $_POST['email'];
            $fullname = $_POST['fullname'];
            //password Trick oldpassword and newpassword
            $newpass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;
            //Valdate my Form
            $formErrors = array();
            if(strlen($username) < 4){
                $formErrors[] = "Username Can't be Less than <strong>4</strong> Charcter";
            }
            if(empty($username)){
                $formErrors[] = "Username is Required";
            }
            if(empty($email)){
                $formErrors[] = "Email is Required";
            }
            if(empty($fullname)){
                $formErrors[] = "Fullname is Required";
            }
            //loop in array and show error if it exists
            foreach ($formErrors as $error) { echo "<div class='alert alert-danger'>".$error."</div>";}
            
            // if no Error will update the DB
            if(empty($formErrors))
            {
                // Make this query to check if edit or update username with same name will there or no
                $stmt2 = $con->prepare("SELECT * FROM `users` WHERE `Username`=? AND `UserID` != ? ");
                $stmt2->execute([$username,$userid]);
                $count2 = $stmt2->rowCount();
                if($count2 == 1){
                    echo "Sorry this username is Exists";
                }else{
                //Update The Database
                $stmt = $con->prepare("UPDATE `users` SET `Username`= ?, `Password`=?,`Email`= ?,`FullName`= ? WHERE `UserID` = ? ");
                $stmt->execute(array($username,$newpass,$email,$fullname,$userid));
                $count = $stmt->rowCount();
                $theMsg = '<div class="text-center alert alert-success"><strong>'.$count.'</strong> Recored Updated</div>';
                redirectHome($theMsg,'back');
                }
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
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $stmt = $con->prepare("DELETE FROM `users` WHERE `UserID`= ? LIMIT 1 ");
        $stmt->execute(array($userid));
        $count = $stmt->rowCount();
        
        echo "<div class='container'> ";
            $theMsg = '<div class="alert alert-danger"><strong>'.$count.'</strong> Recored Deleted</div></div>'; 
            redirectHome($theMsg,'back');
            echo "</div>"; 
    }elseif($do == 'activate')
    {// Activate Member Page
        echo '<h1 class="text-center">Activate Members</h1>';
        echo "<div class='container'>";
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $stmt = $con->prepare("UPDATE `users` SET `RegStatus` = 1 WHERE `UserID`= ? ");
        $stmt->execute(array($userid));
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