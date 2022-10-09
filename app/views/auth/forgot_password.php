
<!DOCTYPE html>
<html>
  <head>
    <title>Admin Login</title>
    <!-- Bootstrap -->
    <link href="<?= base_url('theme/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" media="screen">
    <link href="<?= base_url('theme/bootstrap/css/bootstrap-responsive.min.css')?>" rel="stylesheet" media="screen">
    <link href="<?= base_url('theme/assets/styles.css') ?>" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?= base_url('theme/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js') ?>"></script>
  </head>
  <body id="login">
    <div class="container">
 <form class="form-signin" method="post" action="<?= site_url('auth/forgot_password')?>">
      
        <h5 class="form-signin-heading"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></h5>
       
		<input id="identity" type="text" value="" name="email" type="text" class="input-block-level" placeholder="Email address" required autofocus>
        
        
        <button class="btn btn-lg btn-primary btn-block"" type="submit">Sign in</button>
        <a class="btn btn-lg btn-primary btn-block" href="<?= site_url('auth')?>">Cancel</a>
      </form>

    </div> <!-- /container -->
    <script src="<?= base_url('theme/vendors/jquery-1.9.1.min.js')?>"></script>
    <script src="<?= base_url('theme/bootstrap/js/bootstrap.min.js')?>"></script>
  </body>
</html>

