<?php

// Function to Check item in DB
function checkItem($select,$table,$value)
{
    global $con;
    $statment = $con->prepare("SELECT `$select` FROM `$table` WHERE `$select` = ? ");
    $statment->execute([$value]);
    $count = $statment->rowCount();
    return $count;
}

// Function to Check user RegStatus : is user active or no
function checkUserStatus($user){
    global $con;
    $stmt = $con->prepare("SELECT `Username`,`RegStatus` FROM `users` WHERE `Username`= ? AND `RegStatus`= 0 ");
    $stmt->execute(array($user));
    $status = $stmt->rowCount(); // will return one if find username not active
    return $status;
}

// Get All Data From DB(Ultimate Get All Function)
function getAllDate($field, $table ,$where=NULL ,$and=NULL ,$orderfield ,$ordering='DESC')
{
    global $con;
  //  $sql =  ($where == NULL)  ? '' : $where ;
    $stmt = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering ");
    $stmt->execute();
    $all = $stmt->fetchAll();
    return $all;
}




// if page have Variable $pageTitle will Echo it
function getPageTitle(){
    global $pageTitle;

    if(isset($pageTitle))
    {
        echo $pageTitle;

    }else{
        echo "Default";
    }
}

// function to Redirect and Print Error Msg
function redirectHome($theMsg,$url=null,$seconds=3)
{
    if($url === null){
        $url = "index.php";
    }else{
        $url = isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "index.php" ;
    }
    echo $theMsg ;
    echo "<div class='alert alert-info text-center'> You will be redirected to Previous Page after $seconds Seconds. </div>";
    header("refresh:$seconds;url=$url");
    exit();

}

