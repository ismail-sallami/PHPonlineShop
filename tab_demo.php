<?php
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

				<table id='example' class='table table-striped table-bordered dt-responsive nowrap'>
				<thead>
				<tr>
				<th>Delete</th><th>Username</th>
				</tr>
				 </thead>
                        <tbody>
						<tr>
							<td>1</td>
							<td>2</td>
						</tr>
						<tr>
							<td>22</td>
							<td>22</td>
						</tr>
						<tr>
							<td>33</td>
							<td>33</td>
						</tr>
						<tr>
							<td>44</td>
							<td>1</td>
						</tr>
						<tr>
							<td>55</td>
							<td>1</td>
						</tr>
						<tr>
							<td>66</td>
							<td>1</td>
						</tr>
						</tbody>
 				</table>

	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>