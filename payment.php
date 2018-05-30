<?php
ob_start();
//For register
include_once("lib/config.php");
require_once('Stripe/lib/Stripe.php');
require_once("userCake/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }
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
	
	<section id="form"><!--form-->

	<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Credit and debit card payment</h2>
							<img src="images/home/creditcard.png" style="height: 10em; width: auto;">
							<form action="charge.php" method="POST">
								<script
									src="https://checkout.stripe.com/checkout.js" class="stripe-button"
									data-key="pk_test_wQe28gZMnrN7yMd9W8mUqNms" // your publishable keys
									data-image="images/home/cart.png" // your company Logo
									data-name="Losibericos"
									data-description="Download Script ($15.00)"
									data-amount="1500">
								</script>
							</form>

						</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Paypal payment</h2>
						<img src="images/home/paypal.png" style="height: 5em; width: auto;">
						<form name='newUser' action='<?php echo ($_SERVER['PHP_SELF']); ?>' method='post'>

						</form>
					</div><!--/sign up form-->
				</div>
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