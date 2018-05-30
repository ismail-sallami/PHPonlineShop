<?php
require_once("lib/config.php");
require_once("userCake/models/config.php");
//Allow only admin to display add_product page, other user are redirected to index.php
if( !(isUserLoggedIn()) || !$loggedInUser->checkPermission(array(2))){
	header('Location: index.php');
}



$bill_id = $_GET['id'];
			if (isset($_POST['action'])) {
				$action = $_POST['action'];
				switch ($action) {
					case "Process":
						$sql = $mysqli->prepare("UPDATE bills SET status='Process' WHERE id=$bill_id");
						$sql->execute();
						break;
					case "Delivered":
						$sql = $mysqli->prepare("UPDATE bills SET status='Delivered' WHERE id=$bill_id");
						$sql->execute();
						break;

					case "Delete":
						$sql = $mysqli->prepare("DELETE bills, bill_line FROM bills INNER JOIN bill_line WHERE bills.id=$bill_id AND bills.id = bill_line.bill_id");
						$sql->execute();
						header('Location: bills.php');
						break;
				}
			}
			$result = $mysqli->query("SELECT * FROM bills WHERE bills.id= '$bill_id'");
			$row = mysqli_fetch_assoc($result);



if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("userCake/models/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		require_once 'head.html';
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

	<section id="cart_items">
		<div class="container">



			<H4>Bill : <?=$_GET['id']?> </H4>
			<H4>Customer : <?=$row['fname']?> <?=$row['lname']?> </H4>
			<h4>Date : <?=$row['date']?> : <?=$row['time']?></h4>
			<h4>Status: <?=$row['status']?> </h4>
			<form method="post" action="bill_details.php?id=<?=$_GET['id']?>">
				<input  name="action" class="btn btn-info " type="submit" value="Process">
				<input  name="action"class="btn btn-success " type="submit" value="Delivered">
				<input  name="action" class="btn btn-danger " type="submit" value="Delete">
			</form>


			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Code</td>
							<td class="image">Product</td>
							<td class="description">Quantity</td>
							<td class="price">Price</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php
					$bill_id = $_GET['id'];
					$result = $mysqli->query("SELECT * FROM bills, bill_line WHERE bills.id= '$bill_id' AND bills.id = bill_line.bill_id");

					if($result->num_rows > 0) //check if bill is not empty
					{$total = 0;
						while ($bill_line = $result->fetch_assoc())
						{

							echo '
							<tr>
									<td class="cart_description">
										<p>'.$bill_line["product_code"].'</p>
									</td>

									<td class="cart_description">
										<p>'.$bill_line["product"].'</p>
									</td>
									<td class="cart_price">
										<p>'.$bill_line['quantity'].'</p>
									</td>

									<td class="cart_price">
										<p>'.$bill_line["price"].'</p>
									</td>

									<td class="cart_price">
										<p>'.$bill_line["total"].'</p>
									</td>
							</tr>';
							$total += (int)$bill_line["price"] * (int)$bill_line["quantity"];
						}


						$shipping_cost = ($shipping_cost)?'Shipping Cost : '.$currency. sprintf("%01.2f", $shipping_cost).'<br />':'';
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="row">
				<div class="col-sm-6" style="float: right">
					<div class="total_area">
						<ul>
							<li>Cart Sub Total <span><?= $total?></span></li>
							<li>Eco Tax <span>$2</span></li>
							<li>Shipping Cost <span>Free</span></li>
							<li>Total <span><?= $total?></span></li>
						</ul>
							<a class="btn btn-default update" href="bills.php"><< Back</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->

	<?php
	include_once ('footer.php');
	?>
	


    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>