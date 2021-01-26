<?php 
    session_start();
    $pageTitle = 'Home Page'; // This Varible we used to Get PageTitle
    include "init.php";
    
    
?>

<div class="container">
    <h1 class="text-center">Category</h1>
    <div class="row">

        <?php
        $allitems =getAllDate('*','items','WHERE Approve = 1','','Item_ID');//will get active items only
        foreach($allitems as $item){
            echo '<div class="col-md-3 col-sm-6">';
                echo '<div class="thumbnail item-box">';
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
        ?>

    </div>
    
</div>




<?php include $tpl."footer.php"; ?>

