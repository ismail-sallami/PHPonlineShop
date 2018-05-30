<div class="header_top"><!--header_top-->
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="contactinfo">
                    <ul class="nav nav-pills">
                        <li><a href=""><i class="fa fa-phone"></i> +49(0)17678494604
                            </a></li>
                        <li><a href="mailto:info@losibericos.de"><i class="fa fa-envelope"></i> info@losibericos.de</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="social-icons pull-right">
                    <ul class="nav navbar-nav">
                        <li><a href=""><i class="fa fa-facebook"></i></a></li>
                        <li><a href=""><i class="fa fa-twitter"></i></a></li>
                        <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                        <li><a href=""><i class="fa fa-dribbble"></i></a></li>
                        <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div><!--/header_top-->
<?php
if (isset($_POST['newsletter_email'])){
    $name       = 'Newsletter subscriber';
    $email      = trim(stripslashes($_POST['newsletter_email']));
    $subject    = 'Newsletter subscription';
    $message    = 'The following email wants to subscribe in the newsletter :'. $email;

    $msg = 'Name: ' . $name . "\n\n" . 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;
    // send email
    mail("sallami.ismail@gmail.com",$subject,$msg);


    echo'
     <div id="success-alert" class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Thank you for your subscription!</strong> You will get updated with our last news and promotions.
  </div>
    ';

    echo '<script>
            $("#success-alert").fadeTo(5000, 500).fadeOut(500, function(){
            $("#success-alert").alert("close");
            });
        </script>
    ';
}
?>