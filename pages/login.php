<?php
include("../initialize.php");
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php includeHead("PSRMS - Login"); ?>
    </head>

    <body class="main">

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default" id="panel-login">
                        <div class="panel-body" id="panel-body-login">
                            <h3 class="text-center">Account Login</h3>
                            <p class="text-center" style="margin-bottom: 40px;">Sign In to your account</p>
                            <hr>
                            <form action="/includes/actions/global.login.php" method="post">
                                <div class="form-group">
                                    <input type="email" class="form-login form-control" id="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-login form-control" id="pwd" name="pwd" placeholder="Password">
                                </div>
                                <?php
                                if(isset($_GET['err']) && $_GET['err'] == '3')
                                {
                                ?>
                                <div class="alert alert-danger">
                                    Multiple sign-ins detected! Please sign in again.
                                </div>
                                <?php
                                } else if(isset($_GET['err']) && $_GET['err'] == '2')
                                {
                                ?>
                                <div class="alert alert-danger">
                                    Invalid credentials!
                                </div>
                                <?php
                                }
                                ?>
                                <input type="submit" class="btn btn-lg btn-primary btn-block" id="login-btn" value="Sign in">
                                <!--<a href="https://docs.google.com/spreadsheets/d/1eR6-KJx_tf3MGM8Y6evQ7DtDF8g1nDEi6KsO_qayigA/edit?usp=sharing" >Retrieve</a>-->
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>