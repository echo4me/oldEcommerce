<?php
/*
======================================================
= You Can Do [Edit - Add - Delete] Members From here =
======================================================
*/
ob_start();
session_start();
$pageTitle = 'Categories';
// Make Sure none access this page only who have Authoristy
if(isset($_SESSION['Username']))
{
    include "init.php";
    $do = isset($_GET['do']) ?  $_GET['do'] : 'manage' ;

    if($do == 'manage')
    {
        $sort = 'asc';
        $sort_array = ['asc','desc'];
        if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
            $sort = $_GET['sort'];
        }
        $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent=0 ORDER BY Ordering $sort ");
        $stmt2->execute();
        $cates = $stmt2->fetchAll(); ?>

    <!-- Start Manage Categories Page -->
    <h1 class="text-center ">Manage Categories</h1>
    <div class="container categories">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-users"></i> Manage Categories
                <div class="option pull-right">
                    <a href="?sort=asc" class="<?php if($sort =='asc'){echo 'active';} ;?>"><i class='fa fa-arrow-up'></i></a> |
                    <a href="?sort=desc" class="<?php if($sort =='desc'){echo 'active';} ;?>"><i class='fa fa-arrow-down'></i></a>
                     <span data-view='classic'>[ Classic</span> | <span class='active' data-view='full'>Full ]</span> 
                </div>
            </div>
            <div class="panel-body">
                <?php
                //Chek values and insert if it there
                    foreach($cates as $cate){
                        echo "<div class='cate'>";
                            echo "<div class='hidden-button'>";
                                echo "<a href='categories.php?do=edit&cateid=".$cate['ID']."' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i> Edit</a>";
                                echo "<a href='categories.php?do=delete&cateid=".$cate['ID']."' class='confirm btn btn-danger btn-xs'><i class='fa fa-close'></i> Delete</a>";
                            echo "</div>";
                            echo "<h3>".$cate['Name']."</h3>";
                            echo "<div class='full-view'>" ;
                                echo "<p>".$cate['Description']."</p>";
                                if($cate['Visibility'] == 1){echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>' ;} 
                                if($cate['Allow_Comment'] == 1){echo '<span class="comment"><i class="fa fa-close"></i> Comment Disbaled</span>' ;}
                                if($cate['Allow_Ads'] == 1){echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disbaled</span>' ;}
                                // Loop to get Sub Categories
                                $childCate = getAllDate('*','categories',"WHERE parent ={$cate['ID']}",'','ID');
                                if(!empty($childCate)){
                                    echo "<h4>Sub Category</h4>";
                                    echo "<ul class='list-unstyled child-cate'>";
                                foreach($childCate as $subCate){
                                    echo "<li> <a href='categories.php?do=edit&cateid=".$subCate['ID']."'>" . $subCate['Name'] . '</li>'; }
                                    echo "</ul>";
                                }
                                echo"</div> <hr>";
                            echo "</div>";


                    }

                ?>
            </div>
        </div>
        <a href="categories.php?do=add" class='btn btn-primary add-cate'><i class="fa fa-plus"></i> Add New Category</a>
    </div>
    <?php
    }elseif($do == 'add'){ ?>
    <!-- Start Add Category Page -->
    <h1 class="text-center">Add New Category</h1>
        <div class="container">
            <form action="?do=insert" method="POST" class="form-horizontal">    
                <!-- Name Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Name </label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="name" class='form-control' autocomplete="off" required="required" placeholder="Put Name of Category">
                    </div>
                </div>
                <!-- Description Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Description</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="description" class='form-control'  autocomplete="off" autocomplete="off" placeholder="Describtion About Your Category">
                    </div>
                </div>
                <!-- Ordering Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Ordering</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="ordering" class='form-control' autocomplete="off" placeholder="Number to Arrange the Category">
                    </div>
                </div>
                <!-- Category type Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Parent ?</label>
                    <div class="col-md-6 col-sm-10">
                        <select name="parent" >
                            <option value="0">None</option>
                            <?php 
                                $allcates = getAllDate('*','categories','WHERE parent=0','','ID');
                                foreach ($allcates as $c){
                                    echo '<option value="'.$c['ID'].'" >'.$c['Name']. '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Visibility Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Visible</label>
                    <div class="col-md-6 col-sm-10">
                        <div>
                            <input id='visible-yes' type="radio" name="visible" value="0" checked>
                            <label for="visible-yes">Yes</label>
                        </div>
                        <div>
                            <input id='visible-no' type="radio" name="visible" value="1" >
                            <label for="visible-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- Allow Comment Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Allow Comment</label>
                    <div class="col-md-6 col-sm-10">
                        <div>
                            <input id='comment-yes' type="radio" name="commenting" value="0" checked>
                            <label for="comment-yes">Yes</label>
                        </div>
                        <div>
                            <input id='comment-no' type="radio" name="commenting" value="1" >
                            <label for="comment-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- Ads Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Allow Ads</label>
                    <div class="col-md-6 col-sm-10">
                        <div>
                            <input id='ads-yes' type="radio" name="ads" value="0" checked>
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id='ads-no' type="radio" name="ads" value="1" >
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>


                <!-- Button Field -->
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <input type="submit" name="submit" value='Add Category' class='btn btn-primary '>
                    </div>
                </div>
            </form>
        </div>   
    
    <?php
    }elseif($do == 'insert'){
        //<!-- Start Insert Category Page -->
        if($_SERVER['REQUEST_METHOD']=="POST"){

            echo '<h1 class="text-center">Insert Category</h1>';
            echo "<div class='container'>";

            //Get Variable From Form
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $parent     = $_POST['parent'];
            $order      = $_POST['ordering'];
            $visible    = $_POST['visible'];
            $comment    = $_POST['commenting'];
            $ads        = $_POST['ads'];

            //Check if user Exist in DB (unique or no)
            $check = checkItem("Name",'categories',$name);
            if($check == 1)
            {
                $theMsg = "<div class='alert alert-danger'>Sorry This Category is Exists</div>";
                redirectHome($theMsg,'back');
            }else{
                //Insert in The Database
                $stmt = $con->prepare("INSERT INTO `categories` (`Name`,`Description`,`parent`,`Ordering`,`Visibility`,`Allow_Comment`,`Allow_Ads`) 
                VALUES (:zname ,:zdescription ,:zparent ,:zorder ,:zvisible, :zcomment , :zads ) ");
                $stmt->execute(array(
                    'zname'           => $name,
                    'zdescription'    => $desc,
                    'zparent'         => $parent,
                    'zorder'          => $order,
                    'zvisible'        => $visible,
                    'zcomment'        => $comment,
                    'zads'            => $ads
                ));
                $count = $stmt->rowCount();
                
                $theMsg = '<div class="container"><div class="alert alert-success"><strong>'.$count.'</strong> Recored Added</div></div>';
                redirectHome($theMsg,'back');
        
            }
                
           
        }else{
            $theMsg = "<div class='container'><div class='alert alert-danger' >Sorry You can't Browse This Page</div></div>";
            redirectHome($theMsg,'back') ;
        }
        echo "</div>";
  
        
    }elseif($do == 'edit'){
        // Get integer ID from url that referer to $_SESSION['id'] For DB that mean CateID
        $cateid = isset($_GET['cateid']) && is_numeric($_GET['cateid']) ? intval($_GET['cateid']) : 0;
        
        $stmt = $con->prepare("SELECT * FROM `categories` WHERE `ID`= ? ");
        $stmt->execute(array($cateid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        
        if($count > 0){?> <!-- End Php tag -->
        <!-- if the rowCount have value ,will submit the form -->
        <!-- Start Edit Category Page -->
    <h1 class="text-center">Edit The Category </h1>
        <div class="container">
            <form action="?do=update" method="POST" class="form-horizontal">
                <input type="hidden" name='cateid' value="<?= $row['ID']; ?>">    
                <!-- Name Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Name </label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="name" class='form-control' required="required" placeholder="Put Name of Category" value="<?= $row['Name']?>" >
                    </div>
                </div>
                <!-- Description Field -->
                <div class="form-group">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Description</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="description" class='form-control' placeholder="Describtion About Your Category" value="<?= $row['Description']?>" >  
                    </div>
                </div>
                <!-- Ordering Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Ordering</label>
                    <div class="col-md-6 col-sm-10">
                        <input type="text" name="ordering" class='form-control' placeholder="Number to Arrange the Category" value="<?= $row['Ordering']?>">
                    </div>
                </div>
                <!-- Category type Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Parent ?</label>
                    <div class="col-md-6 col-sm-10">
                        <select name="parent" >
                            <option value="0">None</option>
                            <?php 
                                $allcates = getAllDate('*','categories','WHERE parent=0','','ID');
                                foreach ($allcates as $c){
                                    echo '<option value="'.$c['ID'].'"' ;
                                    //very important
                                    if($row['parent'] == $c['ID']  ){
                                        echo "selected";// get parent category for subChild category
                                    }
                                    echo ">".$c['Name']. "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Visibility Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Visible</label>
                    <div class="col-md-6 col-sm-10">
                        <div>
                            <input id='visible-yes' type="radio" name="visible" value="0" <?php if($row['Visibility'] == 0){echo "checked"; } ;?> />
                            <label for="visible-yes">Yes</label>
                        </div>
                        <div>
                            <input id='visible-no' type="radio" name="visible" value="1" <?php if($row['Visibility'] == 1){echo "checked"; } ;?> />
                            <label for="visible-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- Allow Comment Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Allow Comment</label>
                    <div class="col-md-6 col-sm-10">
                        <div>
                            <input id='comment-yes' type="radio" name="commenting" value="0" <?php if($row['Allow_Comment'] == 0){echo "checked"; } ;?> />
                            <label for="comment-yes">Yes</label>
                        </div>
                        <div>
                            <input id='comment-no' type="radio" name="commenting" value="1" <?php if($row['Allow_Comment'] == 1){echo "checked"; } ;?> />
                            <label for="comment-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- Ads Field -->
                <div class="form-group ">
                    <label for="" class='col-md-4 col-sm-2 control-label'>Allow Ads</label>
                    <div class="col-md-6 col-sm-10">
                        <div>
                            <input id='ads-yes' type="radio" name="ads" value="0" <?php if($row['Allow_Ads'] == 0){echo "checked"; } ;?> />
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id='ads-no' type="radio" name="ads" value="1" <?php if($row['Allow_Ads'] == 1){echo "checked"; } ;?> />
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>


                <!-- Button Field -->
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <input type="submit" name="submit" value='Update Category' class='btn btn-primary '>
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
    }elseif($do == 'update'){
        echo '<h1 class="text-center">Update Members</h1>';
  
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $cateid   = $_POST['cateid'];
            $name     = $_POST['name'];
            $desc     = $_POST['description'];
            $parent   = $_POST['parent'];
            $visible  = $_POST['visible'];
            $order    = $_POST['ordering'];
            $comment  = $_POST['commenting'];
            $ads      = $_POST['ads'];

            $stmt = $con->prepare("UPDATE `categories` SET `Name`=? , `Description`=? ,`parent`=? ,`Ordering`=? ,`Visibility`=? , `Allow_Comment`=? , `Allow_Ads`=? WHERE `ID`='$cateid' ");
            $stmt->execute([$name,$desc,$parent,$order,$visible,$comment,$ads]);
            $count = $stmt->rowCount();
            $theMsg = '<div class="text-center alert alert-success"><strong>'.$count.'</strong> Recored Updated</div>';
            redirectHome($theMsg,'back');
        }else{
            echo "<div class='container'> ";
            $theMsg = "<div class='text-center alert alert-danger'>Sorry You can't Browse This Page</div>"; 
            redirectHome($theMsg);
           
        }
        echo "</div>";
    }elseif($do == 'delete'){
        // Delete Member Page
        echo '<h1 class="text-center">Deleted Members</h1>';
        echo "<div class='container'>";
        $cateid = isset($_GET['cateid']) && is_numeric($_GET['cateid']) ? intval($_GET['cateid']) : 0;
        $stmt = $con->prepare("DELETE FROM `categories` WHERE `ID`= ? ");
        $stmt->execute(array($cateid));
        $count = $stmt->rowCount();
        if($count > 0)
        {
            echo "<div class='container'> ";
            $theMsg = '<div class="alert alert-success"><strong>'.$count.'</strong> Recored Deleted</div></div>'; 
            redirectHome($theMsg,'back');
            echo "</div>"; 

        }else{
            echo "<div class='container'> ";
            $theMsg = '<div class="alert alert-danger">There is No Such ID</div></div>'; 
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