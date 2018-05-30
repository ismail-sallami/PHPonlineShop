<?php
require_once("lib/config.php");
require_once("userCake/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("userCake/models/header.php");

if ($_POST){
	if (!is_null($_POST['delete'])){
		foreach ($_SESSION["products"] as $key => $val)
		{
			if ($val["product_code"] == $_POST['code']) {
				unset($_SESSION["products"][$key]);
			}
		}
	}
	if (!is_null($_POST['qty_up'])){
		foreach ($_SESSION["products"] as $key => &$val)
		{
			if ($val["product_code"] == $_POST['code']) {
				$val["product_qty"] += 1;
			}
		}
	}
	if (!is_null($_POST['qty_down'])){
		foreach ($_SESSION["products"] as $key => &$val)
		{
			if ($val["product_code"] == $_POST['code']) {
				if ($val["product_qty"]>1){
					$val["product_qty"] -= 1;
				}else{
					unset($_SESSION["products"][$key]);
				}
			}
		}
	}



}

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
			<?php
			if (!$_SESSION["products"] ){
				echo '<a href="shop.php"><i class="fa fa-shopping-cart"></i> Go Shopping</a>';
				echo '<img src="images/home/emptycart.jpg" style=" display: block;margin-left: auto;margin-right: auto;">';
			}
			else
			{
			?>


			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php

					if(isset($_SESSION["products"])) //check session var
					{
						$total = 0; //set initial total value
						foreach ($_SESSION["products"] as $cart_itm)
						{
							echo '
							<tr>
								<form method="post" id="bill_line">

									<td class="cart_product">
										<img src="images/home/products/'.$cart_itm["product_img_name"].'" alt="" height="70px" width="70px">
									</td>

									<td class="cart_description">
										<h4><a href="">'.$cart_itm["product_name"].'</a></h4>
										<p>Code:'.$cart_itm["product_code"].'</p>
									</td>

									<td class="cart_price">
										<p>'.$cart_itm["product_price"].'</p>
									</td>

									<td class="cart_quantity">
										<div class="cart_quantity_button">
											<button name="qty_up" class="cart_quantity_up" > + </button>

											<input class="cart_quantity_input" type="text" name="quantity" value="'.$cart_itm["product_qty"].'" autocomplete="off" size="2">
											<button name="qty_down" class="cart_quantity_down" > - </button>

										</div>
									</td>

									<td class="cart_total">
										<p class="cart_total_price">'.$cart_itm["product_price"] * $cart_itm["product_qty"].'</p>
									</td>

									<td class="cart_delete">

										<button class="cart_quantity_delete" href="" name="delete"><i class="fa fa-times"></i></button>
										<input type="hidden" name="code" value="'. $cart_itm["product_code"] .'">
									</td>
								</form>
							</tr>';
							$total+=($cart_itm["product_price"] * $cart_itm["product_qty"]);
                            if ($total>49)
                                $shipping_cost = 0;
                            else
                                $shipping_cost = 4.9;

                        }
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
							<li>Shipping Cost <span><?= $shipping_cost  ?></span></li>
							<li>Total <span><?= $total+$shipping_cost?></span></li>
						</ul>
							<a class="btn btn-default update" href="shop.php"><< Back to shop</a>
							<a class="btn btn-default check_out" href="checkout.php">Pay Out >></a>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>
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