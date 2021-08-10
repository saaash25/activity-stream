<?php
error_reporting(0);
include('_conf.php');
if(isset($_COOKIE['usid']) && $_COOKIE['usid']!="") {
    header('location:'.SITEPATH.'menuListing.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Activity Stream</title>
        <!--<link rel="shortcut icon" href="<?= SITEPATH ?>assets/images/favicon.ico">-->
        <link rel="stylesheet" href="<?= SITEPATH ?>assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?= SITEPATH ?>style/style.css" />
    </head>
    <body>
        <?php
        include(BASEPATH . 'includes/header.php')
        ?>
        <main>
            <div class="container">
                <section class="form-section">
                    <div class="col-4 sign-in-form-div">
                        <form id="sign-in" action="#" method='POST' autocomplete="off">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input  type="text" name="username" class="form-control username" id="username"  placeholder="username"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input  type="password" name="password" class="form-control password" id="password"  placeholder="password"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <button  type="submit" name="login-submit" class="btn btn-sm btn-success login-submit" id="login-submit" >Login</button>
                                    <button  type="button" name="login-cancel" class="btn btn-sm btn-secondary login-cancel" >Cancel</button>
                                    <button type='button' name='go-registration' class='btn btn-link go-registration'>Sign Up</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div  class="col-4 sign-up-form-div" style='display:none'>
                        <form id="sign-up" action="#" method='POST'  autocomplete="off">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input  type="text" name="name" class="form-control name" id="name"  placeholder="name"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="reg-username">Username</label>
                                    <input  type="text" name="reg-username" class="form-control reg-username" id="reg-username"  placeholder="username"/>
                                </div>
                            </div>

                            
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input  type="password" name="reg-password" class="form-control reg-password" id="reg-password"  placeholder="password"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm</label>
                                    <input  type="password" name="confirmpassword" class="form-control confirmpassword" id="confirmpassword"  placeholder="reenter password"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <button  type="submit" name="reg-submit" class="btn btn-sm btn-success reg-submit" >Login</button>
                                    <button  type="button" name="reg-cancel" class="btn btn-sm btn-secondary reg-cancel" >Cancel</button>
                                    <button type='button' name='go-signin' class='btn btn-link go-signin'>Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
            <script src="<?= SITEPATH ?>assets/jquery/jquery.min.js"></script>
            <script src="<?= SITEPATH ?>assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="<?= SITEPATH ?>script/ActivityStream.js"></script>
            <script>
                var BASEPATH = '<?php echo BASEPATH ?>';
                var SITEPATH= '<?php echo SITEPATH ?>';
                $(document).ready(function () {
                    ActivityStream.LoadAllFunctions();
                })
            </script>
    </body>
</html>
