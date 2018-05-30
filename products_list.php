<?php
	require_once("lib/config.php");
	require_once("userCake/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	require_once 'head.html';
	?>
	<link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/table_jui.css" rel="stylesheet" type="text/css" />


	<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>



	<![endif]-->
	<script src="js/jquery.js"></script>
	<script src="js/jquery.dataTables.js"></script>


	<script type="text/javascript">
		$(document).ready(function () {
			$("#example").dataTable({
				"scrollY":"700px",
				"bScrollCollapse": true,
				"bPaginate": true,
				"sPaginationType": "full_numbers",
				"bJQueryUI": true,
				"aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
				"iDisplayLength": 10
			});
		});


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


		<div class="container">
			<?php


			//Forms posted
			if(!empty($_POST))
			{
				$deletions = $_POST['delete'];
				if ($deletion_product = deleteProducts($deletions)){
					$successes[] = lang("PRODUCTS_DELETIONS_SUCCESSFUL", array($deletion_product));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}

			$productsData = fetchAllProducts(); //Fetch information for all users

			echo "
<div id='main'>";

			echo resultBlock($errors,$successes);

			echo "
				<div class='login-form'>
				<form name='adminUsers' class='signup-form' action='".$_SERVER['PHP_SELF']."' method='post'>

				<table id='example' class='table table-striped table-bordered dt-responsive nowrap'>
				<thead>
				<tr>
				<th>Delete</th><th>Code</th><th>Product</th><th>Category</th><th>Price</th><th>Quantity</th>
				</tr>
				 </thead>
                        <tbody>";

			//Cycle through users
			foreach ($productsData as $v1) {
				echo "
					<tr>
					<td><span><input type='checkbox' name='delete[".$v1['product_code']."]' id='delete[".$v1['product_code']."]' value='".$v1['product_code']."'></span></td>
					<td>".$v1['product_code']."</td>
					<td>".$v1['product_name']."</td>
					<td>".$v1['product_cat']."</td>
					<td>".$v1['price']."</td>
					<td>".$v1['product_qty']."
					</td>
					</tr>";
			}

			echo " </tbody>
 				</table>
<button type='submit' class='btn btn-default'>Delete</button>



</form>
</div>
</div>
<div id='bottom'></div>
</div>
</body>
</html>";

			?>
		</div>
	</section><!--/form-->


	<?php
	include_once ('footer.php');
	?>

	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>