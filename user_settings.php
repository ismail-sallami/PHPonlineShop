<?php
require_once("lib/config.php");
require_once("userCake/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if(!empty($_POST))
{
    $errors = array();
    $successes = array();
    $password = $_POST["password"];
    $password_new = $_POST["passwordc"];
    $password_confirm = $_POST["passwordcheck"];

    $errors = array();
    $email = $_POST["email"];

    //Perform some validation
    //Feel free to edit / change as required

    //Confirm the hashes match before updating a users password
    $entered_pass = generateHash($password,$loggedInUser->hash_pw);

    if (trim($password) == ""){
        $errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
    }
    else if($entered_pass != $loggedInUser->hash_pw)
    {
        //No match
        $errors[] = lang("ACCOUNT_PASSWORD_INVALID");
    }
    if($email != $loggedInUser->email)
    {
        if(trim($email) == "")
        {
            $errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
        }
        else if(!isValidEmail($email))
        {
            $errors[] = lang("ACCOUNT_INVALID_EMAIL");
        }
        else if(emailExists($email))
        {
            $errors[] = lang("ACCOUNT_EMAIL_IN_USE", array($email));
        }

        //End data validation
        if(count($errors) == 0)
        {
            $loggedInUser->updateEmail($email);
            $successes[] = lang("ACCOUNT_EMAIL_UPDATED");
        }
    }

    if ($password_new != "" OR $password_confirm != "")
    {
        if(trim($password_new) == "")
        {
            $errors[] = lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
        }
        else if(trim($password_confirm) == "")
        {
            $errors[] = lang("ACCOUNT_SPECIFY_CONFIRM_PASSWORD");
        }
        else if(minMaxRange(8,50,$password_new))
        {
            $errors[] = lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
        }
        else if($password_new != $password_confirm)
        {
            $errors[] = lang("ACCOUNT_PASS_MISMATCH");
        }

        //End data validation
        if(count($errors) == 0)
        {
            //Also prevent updating if someone attempts to update with the same password
            $entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);

            if($entered_pass_new == $loggedInUser->hash_pw)
            {
                //Don't update, this fool is trying to update with the same password Â¬Â¬
                $errors[] = lang("ACCOUNT_PASSWORD_NOTHING_TO_UPDATE");
            }
            else
            {
                //This function will create the new hash and update the hash_pw property.
                $loggedInUser->updatePassword($password_new);
                $successes[] = lang("ACCOUNT_PASSWORD_UPDATED");
            }
        }
    }
    if(count($errors) == 0 AND count($successes) == 0){
        $errors[] = lang("NOTHING_TO_UPDATE");
    }
}

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
            echo resultBlock($errors,$successes);

            echo "<div class='login-form col-md-4'>
                <form name='updateAccount' action='".$_SERVER['PHP_SELF']."' method='post'>
                <p>
                <label>Password:</label>
                <input type='password' name='password' />
                </p>
                <p>
                <label>Email:</label>
                <input type='text' name='email' value='".$loggedInUser->email."' />
                </p>
                <p>
                <label>New Pass:</label>
                <input type='password' name='passwordc' />
                </p>
                <p>
                <label>Confirm Pass:</label>
                <input type='password' name='passwordcheck' />
                </p>
                <p>
                <button class='btn btn-default' type='submit'>Update</button>

                </p>
                </form>
                </div>
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