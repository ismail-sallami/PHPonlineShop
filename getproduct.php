<?php
require_once("lib/config.php");

$q = $_GET['q'];
mysqli_select_db($mysqli,"ajax_demo");
$sql="SELECT * FROM products WHERE product_name = '".$q."' LIMIT 1 ";
$result = mysqli_query($mysqli,$sql);


while($row = mysqli_fetch_array($result)) {
    $sql = "SELECT category_name FROM category ORDER BY category_name";
    $categories = $mysqli->query($sql);

    if ($categories->num_rows > 0) {
        echo "<label>Product category</label><select name='product_cat' id='product_cat'>";
        // output data of each row
        while($cat = $categories->fetch_assoc()) {
            if ($cat["category_name"] == $row['product_cat']){
                $selected = ' selected';
            }else{
                $selected = '';
            }
            echo "<option" . $selected . ">" . $cat["category_name"]."</option>";
        }
        echo "</select>";
    } else {
        echo "0 results";
    }
    echo '<label>Product image</label><input type="file" name="fileToUpload" accept="image/*">';
    echo '<label>Product code</label><input type="text" name="product_code" value="' .$row['product_code'] .'" />' ;
    echo '<label>Product price</label><input type="text" name="product_price"  value="' .$row['price'] .'"  />';
    echo '<label>German description</label><textarea rows="4" name="product_desc_de" placeholder="Deutsch description" >'.$row['product_desc_de'].'</textarea>';
    echo '<label>English description</label><textarea rows="4" name="product_desc_en" placeholder="English description" >'.$row['product_desc_en'].'</textarea>';
    echo '<label>Spanish description</label><textarea rows="4" name="product_desc_es" placeholder="Spanish description" >'.$row['product_desc_es'].'</textarea>';
    echo '<button type="submit" class="btn btn-default">Submit</button>';


}
mysqli_close($mysqli);

