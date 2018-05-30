<?php
$sql = "SELECT DISTINCT product_origin FROM products ORDER BY product_origin";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="panel-group category-products" id="accordian"><!--category-productsr-->';
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<div class="panel panel-default">
                    <div class="panel-heading">';
        echo '<h4 class="panel-title"><a href="shop.php?origin='.$row["product_origin"].'">'.$row["product_origin"].'</a></h4>';
        echo '</div></div>';

    }
    echo '</div><!--/category-productsr-->';
}