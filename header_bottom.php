<div class="header-bottom"><!--header-bottom-->
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="mainmenu pull-left">
                    <?php
                    if(isUserLoggedIn())
                        if ($loggedInUser->checkPermission(array(2))) {
                            echo '<ul class="nav navbar-nav collapse navbar-collapse">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="dropdown"><a href="#">Manage<i class="fa fa-angle-down"></i></a>
                                        <ul role="menu" class="sub-menu">
                                            <li><a href="products_list.php">Products list</a></li>
                                            <hr>
                                            <li><a href="add_product.php">Add new product</a></li>
                                            <li><a href="edit_product.php">Edit product</a></li>
                                            <li><a href="delete_product.php">Delete product</a></li>
                                            <hr>
                                            <li><a href="add_category.php">Add new category</a></li>
                                            <hr>
                                            <li><a href="bills.php">Bills</a></li>
                                        </ul>
                                    </li>
                                </ul>';
                        }else{
                            echo '<ul class="nav navbar-nav collapse navbar-collapse">
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="bills.html">My bills</a></li>
                                </ul>';
                        }
                    ?>


                </div>
            </div>

        </div>
    </div>
</div><!--/header-bottom-->