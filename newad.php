<?php 
session_start();
$pageTitle = 'Create New item Adds'; // This Varible we used to Get PageTitle
include "init.php";
$msg = '';
if(isset($_SESSION['user']))
{
  
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $formErrors = [];
        $name       = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $desc       = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $country    = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
        $status     = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $cate       = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
        $tags       = filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
        $member     = $_SESSION['uid'];
        
        if(strlen($name) < 4){
            $formErrors[] ='item name Must Be More Than 4 Charcter';
        }
        if(strlen($desc) < 15){
            $formErrors[] ='item Description Must Be More Than 15 Charcter';
        }
        if(strlen($country) < 2){
            $formErrors[] ='Cotunry Must Be More Than 15 Charcter';
        }
        if(empty($price)){
            $formErrors[] ='Price is Required';
        }
        if(empty($status)){
            $formErrors[] ='status is Required';
        }
        if(empty($cate)){
            $formErrors[] ='category is Required';
        }

        if(empty($formErrors))
            {   
                    //Insert in The Database
                    $stmt = $con->prepare("INSERT INTO `items` (`Name`,`Description`,`Price`,`Country_Made`,`Status`,`Cate_ID`,`Member_ID`,`tags`,`Add_Date`) 
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
                    if($stmt){
                        $msg = "Item Added";
                    }else{
                        $msg = "There Somthing Wrong";
                    }
                    
                                      
            }
    }//end post request

    
?>
    <h1 class='text-center'>New Add</h1>
    <div class="create-ad">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Create New Adds
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                        <!-- Form Adds -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">    
                            <!-- Item Name Field -->
                            <div class="form-group">
                                <label for="" class='col-md-4 col-sm-2 control-label'>Name </label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" name="name" class='form-control live-name' required="required" placeholder="Put Name of Item">
                                </div>
                            </div>
                            <!-- Item Description Field -->
                            <div class="form-group">
                                <label for="" class='col-md-4 col-sm-2 control-label'>Description</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" name="description" class='form-control live-desc' required="required" placeholder="Put Description of Item">
                                </div>
                            </div>
                            <!-- Item Price Field -->
                            <div class="form-group">
                                <label for="" class='col-md-4 col-sm-2 control-label'>Price</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" name="price" class='form-control live-price' required="required" placeholder="Put Price of Item">
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
                           
                            <!-- Category Field -->
                            <div class="form-group">
                                    <label for="" class='col-md-4 col-sm-2 control-label'>Category</label>
                                    <div class="col-md-6 col-sm-10">
                                        <select name="category" >
                                            <option value="0">...</option>
                                            <?php 
                                            $cates = getAllDate('*','categories','','','ID');
                                            foreach($cates as $cate){
                                                echo "<option value=".$cate['ID'].">".$cate['Name']."</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                            </div>
                            <!-- Tags Made Field -->
                            <div class="form-group">
                                <label for="" class='col-md-4 col-sm-2 control-label'>Tags</label>
                                <div class="col-md-6 col-sm-10">
                                    <input type="text" name="tags" class='form-control' placeholder="Seprate Tags with Comma (,)">
                                </div>
                            </div>

                                <!-- Button Field -->
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <input type="submit" name="submit" value='Create' class='btn btn-primary '>
                                    </div>
                                </div>
                                <?php if(!empty($msg)){echo "<div class='alert alert-info'>$msg </div>"; }?>
                        </form>
                        </div>
                        <!-- Show Adds Looklike -->
                        <div class="col-md-4">
                            <div class="thumbnail item-box live-preview">
                                <span class="price-tag">price</span>
                                <img class="img-responsive" src="img.png">
                                <div class="caption">
                                    <h3>Item Name</h3>
                                    <p>Item Descrption</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Loop For Errors -->
                     <?php
                        if(!empty($formErrors)){
                            foreach ($formErrors as $error){
                                echo '<div class="alert alert-danger">' .$error.'</div>';
                            }
                        }
                     ?>                       
                    <!-- End -->
                </div>
            </div>
        </div>
    </div>
                                   

<?php 
}else{
    header("Location: login.php"); 
    exit();
}
include $tpl."footer.php"; 
?>

