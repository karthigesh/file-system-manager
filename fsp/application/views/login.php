<section id="login-page">
    <div class="login-container">
		<?php echo $this->session->flashdata('login'); ?>
        <form method="post" action="<?php echo BASE_URL;?>login/submitlogin" class="ng-pristine ng-valid">

            <a href="#"><img src="<?php echo BASE_URL;?>images/logo_dark.png" alt="logo" class="logo"></a>

            
            <div class="form-group">
                <input class="form-control" name="username" placeholder="Username" type="text" required>
            </div>
            <div class="form-group">
                <input class="form-control" name="password" type="password" placeholder="Password" required>
            </div>

            <section class="clearfix">
                <div class="pull-left" style="margin-top: 7px;">
                    <a href="#" style="font-size: 17px;">forget Password?</a>
                </div>
                <div class="pull-right ng-scope" ng-controller="SocialLoginController">
                    <input type="submit" class="btn btn-primary" value="Login" style="width:150px;">
                </div>
            </section>
            <!--<p>Don't have an account? <a href="<?php echo BASE_URL;?>register">Register here.</a> Or login with:</p>-->
        </form>
    </div>
</section>
