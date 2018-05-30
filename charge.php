<?php
ob_start();
//For register
include_once("lib/config.php");
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
                <?php
                try {

                    require_once('Stripe/init.php');
                \Stripe\Stripe::setApiKey("sk_test_CRfnHrlBeZxCjk1eV5PgWSrj"); //Replace with your Secret Key

                $charge =  \Stripe\Charge::create(array(
                    "amount" => 1500,
                    "currency" => "usd",
                    "card" => $_POST['stripeToken'],
                    "description" => "Charge for Facebook Login code."
                ));
                //send the file, this line will be reached if no error was thrown above
                echo "
                <div class=\"alert alert-success\">
                  <strong>Thank you!</strong> Payment received successfully.
                </div>
                ";


                //you can send the file to this email:
                var_dump($_POST);
                }
                //catch the errors in any way you like

                catch(Stripe_CardError $e) {

                }


                catch (Stripe_InvalidRequestError $e) {
                    // Invalid parameters were supplied to Stripe's API

                } catch (Stripe_AuthenticationError $e) {
                    // Authentication with Stripe's API failed
                    // (maybe you changed API keys recently)

                } catch (Stripe_ApiConnectionError $e) {
                    // Network communication with Stripe failed
                } catch (Stripe_Error $e) {

                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                } catch (Exception $e) {

                    // Something else happened, completely unrelated to Stripe
                }

                ?>

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