<?php
require_once("userCake/models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("userCake/models/header.php");
?>
<div class="header-middle"><!--header-middle-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="logo pull-left">
                    <a href="index.php"><img src="images/home/logo.png" alt="" /></a>
                </div>
                <div class="btn-group pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                            DE
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="">DE</a></li>
                            <li><a href="">EN</a></li>
                            <li><a href="">ES</a></li>
                        </ul>
                    </div>


                </div>
            </div>
            <div class="col-sm-8">



                <div class="shop-menu pull-right">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#" class="cart-box" id="cart-info" title="View Cart">
                                <?php
                                if(isset($_SESSION["products"])){
                                    echo count($_SESSION["products"]);
                                }else{
                                    echo 0;
                                }
                                ?>
                                <i class="fa fa-shopping-cart"></i></a></li>
                        <div class="shopping-cart-box">
                            <a href="#" class="close-shopping-cart-box" >Close</a>
                            <h3>Your Shopping Cart</h3>
                            <div id="shopping-cart-results">
                            </div>
                        </div>

                        <?php
                        if (!securePage($_SERVER['PHP_SELF'])){die();}

                        if(isUserLoggedIn()) {
                            echo '<li><a href=""><i class="fa fa-user"></i> Weclome '. $loggedInUser->displayname.'</a></li>';

                        if ($loggedInUser->checkPermission(array(2))) {
                            echo "
                                    <li><a href='admin_configuration.php'><i class=\"fa fa-cogs\"></i>Configuration</a></li>
                                    <li><a href=\"user_settings.php\"><i class=\"fa fa-cog\"></i> Settings</a></li>
                                    <li><a href='admin_users.php'><i class='fa fa-users'></i>Users</a></li>
                                ";
                        }else{
                            echo '
                                <li><a href="checkout.php"><i class="fa fa-shopping-cart"></i> Checkout</a></li>
                                <li><a href="user_settings.php"><i class="fa fa-cogs"></i> Settings</a></li>
                                ';
                        }
                            echo '<li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>';


                        }else{
                                echo '
                                <li><a href=""><i class="fa fa-user"></i> Account</a></li>
                                <li><a href="cart.php"><i class="fa fa-shopping-cart"></i> Checkout</a></li>

                                <li><a href="login.php" class="active"><i class="fa fa-lock"></i> Login</a></li>
                                ';
                            }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div><!--/header-middle-->
