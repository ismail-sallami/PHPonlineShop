<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
<h1>UserCake</h1>
<h2>User Settings</h2>
<div id='left-nav'>";
include("left-nav.php");

echo "
</div>
<div id='main'>";

echo resultBlock($errors,$successes);

echo "
<div id='regbox'>
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
<label>&nbsp;</label>
<input type='submit' value='Update' class='submit' />
</p>
</form>
</div>
</div>
<div id='bottom'></div>
</div>
</body>
</html>";

?>
