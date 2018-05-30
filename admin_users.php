<?php
	require_once("lib/config.php");
	require_once("userCake/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login | E-Shopper</title>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
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
			/*
            UserCake Version: 2.0.2
            http://usercake.com
            */



			//Forms posted
			if(!empty($_POST))
			{
				$deletions = $_POST['delete'];
				if ($deletion_count = deleteUsers($deletions)){
					$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}

			$userData = fetchAllUsers(); //Fetch information for all users

			echo "
<div id='main'>";

			echo resultBlock($errors,$successes);

			echo "
				<div class='login-form'>
				<form name='adminUsers' class='signup-form' action='".$_SERVER['PHP_SELF']."' method='post'>

				<table id='example' class='table table-striped table-bordered dt-responsive nowrap'>
				<thead>
				<tr>
				<th>Delete</th><th>Username</th><th>Display Name</th><th>Title</th><th>Last Sign In</th>
				</tr>
				 </thead>
                        <tbody>";

			//Cycle through users
			foreach ($userData as $v1) {
				echo "
					<tr>
					<td><span><input type='checkbox' name='delete[".$v1['id']."]' id='delete[".$v1['id']."]' value='".$v1['id']."'></span></td>
					<td><a href='admin_user.php?id=".$v1['id']."'>".$v1['user_name']."</a></td>
					<td>".$v1['display_name']."</td>
					<td>".$v1['title']."</td>
					<td>
					";

								//Interprety last login
								if ($v1['last_sign_in_stamp'] == '0'){
									echo "Never";
								}
								else {
									echo date("j M, Y", $v1['last_sign_in_stamp']);
								}
								echo "
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