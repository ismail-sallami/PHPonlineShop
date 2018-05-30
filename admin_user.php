<?php
require_once("lib/config.php");
require_once("userCake/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $_GET['id'];

//Check if selected user exists
if(!userIdExists($userId)){
    header("Location: admin_users.php"); die();
}

$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details

//Forms posted
if(!empty($_POST))
{
    //Delete selected account
    if(!empty($_POST['delete'])){
        $deletions = $_POST['delete'];
        if ($deletion_count = deleteUsers($deletions)) {
            $successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
        }
        else {
            $errors[] = lang("SQL_ERROR");
        }
    }
    else
    {
        //Update display name
        if ($userdetails['display_name'] != $_POST['display']){
            $displayname = trim($_POST['display']);

            //Validate display name
            if(displayNameExists($displayname))
            {
                $errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
            }
            elseif(minMaxRange(5,25,$displayname))
            {
                $errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
            }
            elseif(!ctype_alnum($displayname)){
                $errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
            }
            else {
                if (updateDisplayName($userId, $displayname)){
                    $successes[] = lang("ACCOUNT_DISPLAYNAME_UPDATED", array($displayname));
                }
                else {
                    $errors[] = lang("SQL_ERROR");
                }
            }

        }
        else {
            $displayname = $userdetails['display_name'];
        }

        //Activate account
        if(isset($_POST['activate']) && $_POST['activate'] == "activate"){
            if (setUserActive($userdetails['activation_token'])){
                $successes[] = lang("ACCOUNT_MANUALLY_ACTIVATED", array($displayname));
            }
            else {
                $errors[] = lang("SQL_ERROR");
            }
        }

        //Update email
        if ($userdetails['email'] != $_POST['email']){
            $email = trim($_POST["email"]);

            //Validate email
            if(!isValidEmail($email))
            {
                $errors[] = lang("ACCOUNT_INVALID_EMAIL");
            }
            elseif(emailExists($email))
            {
                $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
            }
            else {
                if (updateEmail($userId, $email)){
                    $successes[] = lang("ACCOUNT_EMAIL_UPDATED");
                }
                else {
                    $errors[] = lang("SQL_ERROR");
                }
            }
        }

        //Update title
        if ($userdetails['title'] != $_POST['title']){
            $title = trim($_POST['title']);

            //Validate title
            if(minMaxRange(1,50,$title))
            {
                $errors[] = lang("ACCOUNT_TITLE_CHAR_LIMIT",array(1,50));
            }
            else {
                if (updateTitle($userId, $title)){
                    $successes[] = lang("ACCOUNT_TITLE_UPDATED", array ($displayname, $title));
                }
                else {
                    $errors[] = lang("SQL_ERROR");
                }
            }
        }

        //Remove permission level
        if(!empty($_POST['removePermission'])){
            $remove = $_POST['removePermission'];
            if ($deletion_count = removePermission($remove, $userId)){
                $successes[] = lang("ACCOUNT_PERMISSION_REMOVED", array ($deletion_count));
            }
            else {
                $errors[] = lang("SQL_ERROR");
            }
        }

        if(!empty($_POST['addPermission'])){
            $add = $_POST['addPermission'];
            if ($addition_count = addPermission($add, $userId)){
                $successes[] = lang("ACCOUNT_PERMISSION_ADDED", array ($addition_count));
            }
            else {
                $errors[] = lang("SQL_ERROR");
            }
        }

        $userdetails = fetchUserDetails(NULL, NULL, $userId);
    }
}

$userPermission = fetchUserPermissions($userId);
$permissionData = fetchAllPermissions();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login | E-Shopper</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
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

echo "
<div class='login-form'>
<form name='adminUser' action='".$_SERVER['PHP_SELF']."?id=".$userId."' method='post'>
 <div class='row '>
        <div class='col-xs-6'>

<h2>User Information</h2>
<div id='regbox'>
<p>
<label>ID:</label>
".$userdetails['id']."
</p>
<p>
<label>Username:</label>
".$userdetails['user_name']."
</p>
<p>
<label>Display Name:</label>
<input type='text' name='display' value='".$userdetails['display_name']."' />
</p>
<p>
<label>Email:</label>
<input type='text' name='email' value='".$userdetails['email']."' />
</p>
<p>
<label>Active:</label>";

//Display activation link, if account inactive
if ($userdetails['active'] == '1'){
    echo "Yes";
}
else{
    echo "No
	</p>
	<p>
	<label>Activate:</label>
	<span><input type='checkbox' name='activate' id='activate' value='activate'></span>
	";
}

echo "
</p>
<p>
<label>Title:</label>
<input type='text' name='title' value='".$userdetails['title']."' />
</p>
<p>
<label>Sign Up:</label>
".date("j M, Y", $userdetails['sign_up_stamp'])."
</p>
<p>
<label>Last Sign In:</label>";

//Last sign in, interpretation
if ($userdetails['last_sign_in_stamp'] == '0'){
    echo "Never";
}
else {
    echo date("j M, Y", $userdetails['last_sign_in_stamp']);
}

echo "
</p>
<p>
<label>Delete:</label>
<span><input type='checkbox' name='delete[".$userdetails['id']."]' id='delete[".$userdetails['id']."]' value='".$userdetails['id']."'></span>
</p>
<p>
<button class='btn btn-default' type='submit'>Update</button>
</p>
</div>
</div>
</div><!--row-->
</form>
</div><!--login-form-->";

            ?>		</div>
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