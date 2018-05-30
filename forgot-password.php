<?php
require_once("lib/config.php");
require_once("userCake/models/config.php");

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
	
	<section id="form"><!--form-->


		<div class="container">

            <?php
            //User has confirmed they want their password changed
            if(!empty($_GET["confirm"]))
            {
                $token = trim($_GET["confirm"]);

                if($token == "" || !validateActivationToken($token,TRUE))
                {
                    $errors[] = lang("FORGOTPASS_INVALID_TOKEN");
                }
                else
                {
                    $rand_pass = getUniqueCode(15); //Get unique code
                    $secure_pass = generateHash($rand_pass); //Generate random hash
                    $userdetails = fetchUserDetails(NULL,NULL,$token); //Fetchs user details
                    $mail = new userCakeMail();

                    //Setup our custom hooks
                    $hooks = array(
                        "searchStrs" => array("#GENERATED-PASS#","#USERNAME#"),
                        "subjectStrs" => array($rand_pass,$userdetails["email"])
                    );

                    if(!$mail->newTemplateMsg("your-lost-password.txt",$hooks))
                    {
                        $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
                    }
                    else
                    {
                        if(!$mail->sendMail($userdetails["email"],"Your new password"))
                        {
                            $errors[] = lang("MAIL_ERROR");
                        }
                        else
                        {
                            if(!updatePasswordFromToken($secure_pass,$token))
                            {
                                $errors[] = lang("SQL_ERROR");
                            }
                            else
                            {
                                if(!flagLostPasswordRequest($userdetails["email"],0))
                                {
                                    $errors[] = lang("SQL_ERROR");
                                }
                                else {
                                    $successes[]  = lang("FORGOTPASS_NEW_PASS_EMAIL");
                                }
                            }
                        }
                    }
                }
            }

            //User has denied this request
            if(!empty($_GET["deny"]))
            {
                $token = trim($_GET["deny"]);

                if($token == "" || !validateActivationToken($token,TRUE))
                {
                    $errors[] = lang("FORGOTPASS_INVALID_TOKEN");
                }
                else
                {

                    $userdetails = fetchUserDetails(NULL,$token);

                    if(!flagLostPasswordRequest($userdetails["email"],0))
                    {
                        $errors[] = lang("SQL_ERROR");
                    }
                    else {
                        $successes[] = lang("FORGOTPASS_REQUEST_CANNED");
                    }
                }
            }

            //Forms posted
            if(!empty($_POST))
            {
                $email = $_POST["email"];

                //Perform some validation
                //Feel free to edit / change as required

                if(trim($email) == "")
                {
                    $errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
                }
                //Check to ensure email is in the correct format / in the db
                else if(!isValidEmail($email) || !emailExists($email))
                {
                    $errors[] = lang("ACCOUNT_INVALID_EMAIL");
                }

                if(count($errors) == 0)
                {

                //Check that the username / email are associated to the same account

                    //Check if the user has any outstanding lost password requests
                    $userdetails = fetchUserDetails($email);
                    if($userdetails["lost_password_request"] == 1)
                    {
                        $errors[] = lang("FORGOTPASS_REQUEST_EXISTS");
                    }
                    else
                    {
                        //Email the user asking to confirm this change password request
                        //We can use the template builder here

                        //We use the activation token again for the url key it gets regenerated everytime it's used.

                        $mail = new userCakeMail();
                        $confirm_url = lang("CONFIRM")."\n".$websiteUrl."forgot-password.php?confirm=".$userdetails["activation_token"];
                        $deny_url = lang("DENY")."\n".$websiteUrl."forgot-password.php?deny=".$userdetails["activation_token"];

                        //Setup our custom hooks
                        $hooks = array(
                            "searchStrs" => array("#CONFIRM-URL#","#DENY-URL#","#USERNAME#"),
                            "subjectStrs" => array($confirm_url,$deny_url,$userdetails["email"])
                        );

                        if(!$mail->newTemplateMsg("lost-password-request.txt",$hooks))
                        {
                            $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
                        }
                        else
                        {
                            if(!$mail->sendMail($userdetails["email"],"Lost password request"))
                            {
                                $errors[] = lang("MAIL_ERROR");
                            }
                            else
                            {
                                //Update the DB to show this account has an outstanding request
                                if(!flagLostPasswordRequest($userdetails["email"],1))
                                {
                                    $errors[] = lang("SQL_ERROR");
                                }
                                else {

                                    $successes[] = lang("FORGOTPASS_REQUEST_SUCCESS");
                                }
                            }
                        }
                    }

                }
            }

            require_once("userCake/models/header.php");
            echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
";

            echo resultBlock($errors,$successes);

            echo "
<div id='regbox' class='login-form col-sm-4 col-sm-offset-1'>
<h2>Forgot Password</h2>

<form name='newLostPass'  action='".$_SERVER['PHP_SELF']."' method='post'>
<p>
<p>
<label>Email:</label>
<input type='text' name='email' />
</p>
<p>
<label>&nbsp;</label>
<button type='submit' class='btn btn-default' value='Submit'/>Submit</button>
</p>
</form>
</div>
</div>
<div id='bottom'></div>
";

            ?>



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