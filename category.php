<?php
$sql = "SELECT DISTINCT product_cat FROM products ORDER BY product_cat";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="panel-group category-products" id="accordian"><!--category-productsr-->';
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<div class="panel panel-default">
                    <div class="panel-heading">';
        echo '<h4 class="panel-title"><a href="shop.php?category='.$row["product_cat"].'">'.$row["product_cat"].'</a></h4>';
        echo '</div></div>';

    }
    echo '</div><!--/category-productsr-->';
} else {
    echo "0 results";
}
?>
