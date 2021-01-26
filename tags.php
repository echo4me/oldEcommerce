<?php  include "init.php"; 



?>

<div class="container">
    
    <div class="row">

        <?php
        if(isset($_GET['name'])){
            $tagName =  $_GET['name'];
            echo '<h1 class="text-center">' .$tagName.'</h1>' ;
            $tagItems = getAllDate("*","items","where Tags LIKE '%$tagName%' "," AND Approve = 1","Item_ID");
            foreach($tagItems as $tag){
                echo '<div class="col-md-4 col-sm-6">';
                    echo '<div class="thumbnail item-box">';
                    echo '<span class="price-tag">$' .$tag['Price']. '</span>';
                        echo '<img class="img-responsive" src="img.png">';
                        echo '<div class="caption">';
                            echo '<h3><a href="items.php?itemid='.$tag['Item_ID'].'">'.$tag['Name'].'</a></h3>';
                            echo '<p>'.$tag['Description'].'</p>';
                            echo '<div class="date">'.$tag['Add_Date'].'</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
        }else{
            echo "404";
        }
        ?>

    </div>
    
</div>




<?php include $tpl."footer.php"; ?>

