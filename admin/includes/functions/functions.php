<?php

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


// Function to Check item in DB
function checkItem($select,$table,$value)
{
    global $con;
    $statment = $con->prepare("SELECT `$select` FROM `$table` WHERE `$select` = ? ");
    $statment->execute([$value]);
    $count = $statment->rowCount();
    return $count;
}

/*
** Count Number Of Items Function v1.0
** Function To Count Number Of Items Rows
** $item = The Item To Count
** $table = The Table To Choose From
*/
function countItems($item,$table)
{
    global $con;
    $statment = $con->prepare("SELECT COUNT($item) FROM `$table` ");
    $statment->execute();
    return $statment->fetchColumn();

}

/*
** Get Latest Records Function v1.0
** Function To Get Latest Items From Database [ Users, Items, Comments ]
** $select = Field To Select
** $table = The Table To Choose From
** $order = The Desc Ordering
** $limit = Number Of Records To Get
*/

	function getLatest($select, $table, $order, $limit = 5) {

		global $con;

		$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

		$getStmt->execute();

		$rows = $getStmt->fetchAll();

		return $rows;

	}





