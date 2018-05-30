<?php
//current URL of the Page. cart_update.php redirects back to this URL
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
session_start(); //start session

include_once("lib/config.php");
require_once("userCake/models/config.php");

//session_start();

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
	</header>

	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<?php
						include_once ('category.php');
						?>
                        <h2>Origin</h2>
                        <?php
                        require_once 'origin.php';
                        ?>

                        <!--<div class="brands_products">
                            <h2>Brands</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href=""> <span class="pull-right">(50)</span>Acne</a></li>
                                    <li><a href=""> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                                    <li><a href=""> <span class="pull-right">(27)</span>Albiro</a></li>
                                    <li><a href=""> <span class="pull-right">(32)</span>Ronhill</a></li>
                                    <li><a href=""> <span class="pull-right">(5)</span>Oddmolly</a></li>
                                    <li><a href=""> <span class="pull-right">(9)</span>Boudestijn</a></li>
                                    <li><a href=""> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
                                </ul>
                            </div>
                        </div><!--/brands_products-->
						
						<!--<div class="price-range">
							<h2>Price Range</h2>
							<div class="well">
								 <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
								 <b>$ 0</b> <b class="pull-right">$ 600</b>
							</div>
						</div><!--/price-range-->
						
						<div class="shipping text-center"><!--shipping-->
							<img src="images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
						
					</div>
				</div>
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>

							<?php


							//current URL of the Page. cart_update.php redirects back to this URL
							$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
							?>


							<!-- Products List Start -->
							<?php
							if ($_GET['category']){
								$category = $_GET['category'];
								$results = $mysqli->query("SELECT product_code, product_name, product_desc_en, product_img_name, price FROM products WHERE product_cat= '$category' ORDER BY id ASC");
							}elseif ($_GET['origin']){
                                $origin = $_GET['origin'];
                                $results = $mysqli->query("SELECT product_code, product_name, product_desc_en, product_img_name, price FROM products WHERE product_origin= '$origin' ORDER BY id ASC");
                            }else{
                                $results = $mysqli->query("SELECT product_code, product_name, product_desc_en, product_img_name, price FROM products ORDER BY id ASC");
                            }

							if($results){

								$products_item = '<ul class="products">	<div id="easyPaginate">';
//fetch results set as object and output HTML
								while($obj = $results->fetch_object())
								{
									$products_item .= <<<EOT
										<form method="POST" class="form-item">
										<div class="col-sm-4">
											<div class="product-image-wrapper">
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="product-details.php?code={$obj->product_code}"><img src="images/home/products//{$obj->product_img_name}" alt="" width="270px" height="230px" /></a>
														<h2>{$currency}{$obj->price}</h2>
														<p>{$obj->product_name}</p>
														<div align="center">
															<input type="hidden" size="2" maxlength="2" name="product_qty" value="1" />
															<a class="btn btn-default add-to-cart" class="add_to_cart" onclick="btn_click('product_qty=1&product_code={$obj->product_code}')"><i class="fa fa-shopping-cart"></i>Add to cart</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<input type="hidden" name="product_code" value="{$obj->product_code}" />
										</form>
EOT;
								}
								$products_item .= '</ul></div>';
								echo $products_item;
							}
							?>
							<!-- Products List End -->
</div>



					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
	<?php
	include_once ('footer.php');
	?>
	<script src="js/jquery.js"></script>

	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
<!-- for the tabbing of articles -->
	<script src="js/jquery.snippet.min.js"></script>
	<script src="js/jquery.easyPaginate.js"></script>
	<script src="js/scripts.js"></script>


</body>
</html>