<?php
require_once("lib/config.php");
require_once("userCake/models/config.php");
//Allow only admin to display add_product page, other user are redirected to index.php
if( !(isUserLoggedIn()) || !$loggedInUser->checkPermission(array(2))){
    header('Location: index.php');
}

if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("userCake/models/header.php");

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <?php
    require_once "head.html";
    ?>
    <script>
        function showProduct(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET","getproduct.php?q="+str,true);
                xmlhttp.send();
            }
        }
    </script>
</head><!--/head-->

<body>
	<header id="header"><!--header-->

		<?php
		include_once ('header_top.php');
		include_once ('header_middle.php');
		include_once ('header_bottom.php');
		?>

	</header><!--/header-->
	
	<section id="form"><!--form-->
        <div class="container"><?php
            if ($_POST){
                $product_code = $_POST['product_code'];
                $product_cat = $_POST['product_cat'];
                $product_name = $_POST['product_name'];
                $product_price = $_POST['product_price'];
                $product_desc_de = $_POST['product_desc_de'];
                $product_desc_es = $_POST['product_desc_es'];
                $product_desc_en = $_POST['product_desc_en'];
                $product_pic = basename( $_FILES["fileToUpload"]["name"]);

                //$sql = "INSERT INTO products VALUES ('','$product_cat','$product_code', '$product_name', '$product_desc_en' ,'$product_desc_de' ,'$product_desc_es', '$product_pic', '$product_price')";
                $sql = "UPDATE products SET product_cat = '$product_cat',product_code = '$product_code', product_name = '$product_name', product_desc_en = '$product_desc_en' ,product_desc_de = '$product_desc_de' ,product_desc_es = '$product_desc_es', product_img_name = '$product_pic', price = '$product_price'
                        WHERE product_name = '$product_name'";


                if ($mysqli->query($sql) === TRUE) {
                    echo '<div class="alert alert-success">';
                    echo "Product updated successfully</br>";
                    require_once("lib/upload.php");
                    echo '</div>';

                } else {
                    echo '<div class="alert alert-danger">';
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                    echo '</div>';

                }

            }
            ?>
            <div class="col-sm-4 col-sm-offset-1">

                <div class="login-form"><!--login form-->

                    <h2>Edit product</h2>
                    <form name='login' action='<?php echo ($_SERVER['PHP_SELF']); ?>' method='post' enctype="multipart/form-data">
                        <label>Product name</label>

                        <?php
                        $sql = "SELECT product_name FROM products ORDER BY product_name";
                        $result = $mysqli->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<select name='product_name' onclick='showProduct(this.value)'>";
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["product_name"] . "'>" . $row["product_name"]."</option>";
                            }
                            echo "</select>";
                        } else {
                            echo "0 results";
                        }
                        $mysqli->close();
                        ?>
                        <div id="txtHint"> </div>
                    </form>
                </div><!--/login form-->
            </div>
        </div>
    </section><!--/form-->


	<?php
	include_once ('footer.php');
	?>


  
    <script src="js/jquery.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>