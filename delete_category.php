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
        <div class="container">
            <?php
            if ($_POST){
                $category = $_POST['category'];
                if (deleteCategory($category) > 0){
                    $successes[] = lang("CAT_DELETIONS_SUCCESSFUL");
                    echo '<div class="alert alert-success">';
                    echo  $successes[0];
                    echo '</div>';
                }
                else {
                    $errors[] = lang("SQL_ERROR");
                    echo '<div class="alert alert-danger">';
                    echo $errors[0];
                    echo '</div>';

                  ;
                }

                /*$sql = "INSERT INTO category VALUES ('','$category_name')";

                if ($mysqli->query($sql) === TRUE) {
                    echo '<div class="alert alert-success">';
                    echo "New category created successfully</br>";
                    echo '</div>';

                } else {
                    echo '<div class="alert alert-danger">';
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                    echo '</div>';
                }*/
            }
            ?>
            <div class="alert alert-warning">
                <strong>Warning!</strong> Deleting a categoy will delete all its products.
            </div>

            <div class="col-xs-6 col-md-4">

                <div class="form-two login-form">
                    <form method="POST">
                        <h2>Categories list</h2>
                        <?php
                        $sql = "SELECT * FROM category ORDER BY category_name";
                        $result = $mysqli->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<select name='category'>";
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["id"]."'>" . $row["category_name"]."</option>";
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