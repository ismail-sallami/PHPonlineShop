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
                $to_delete = $_POST['to_delete'];

                $sql = "DELETE FROM products WHERE product_name='$to_delete'";

                if ($mysqli->query($sql) === TRUE) {
                    echo '<div class="alert alert-success">';
                    echo "Product deleted successfully</br>";
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

                    <h2>Delete product</h2>
                    <form name='login' action='<?php echo ($_SERVER['PHP_SELF']); ?>' method='post'>
                        <?php
                            $sql = "SELECT product_name FROM products ORDER BY product_name";
                            $result = $mysqli->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<select name='to_delete'>";
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option>" . $row["product_name"]."</option>";
                                }
                                echo "</select>";
                            } else {
                                echo "0 results";
                            }
                            $mysqli->close();
                        ?>
                        <button type="submit" class="btn btn-default">Delete</button>
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