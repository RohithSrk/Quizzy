<?php
/**
 * Quzzy Online Interactive Quiz Application
 * Quizzy Login page
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

//Start or resume Session
session_start();

//Set Page Title
$page_title = 'Quizzy Login';

//Include Header
include( INCLUDES_PATH . "/header.php");


//if user already logged in, redirect to home
if( isset($_SESSION[ 'user_id' ]) ){
    header('location: /');
    die();
}

$error = false;

if(isset($_POST['submit'])){

    //if username or password files are empty show error username or password can't be empty
    if( !empty( $_POST[ 'username' ] ) and !empty( $_POST[ 'password' ] ) ) {

        $quizzy = new Quizzy();
        $user_name = $_POST[ 'username' ];
        $password = $_POST[ 'password' ];

        //validate unsername and password else show error Invalid unsername or password
        if( $user_details = $quizzy->authenticate_user( $user_name, $password ) ){

            //create session and redirect to home
            $_SESSION[ 'user_id' ] = $user_details['user_id'];
            $_SESSION[ 'username' ] = $user_details['username'];
            $_SESSION[ 'first_name' ] = $user_details['first_name'];
            $_SESSION[ 'last_name' ] = $user_details['last_name'];
            $_SESSION[ 'add_content' ] = $user_details['add_content'];
            $_SESSION[ 'modify_content' ] = $user_details['modify_content'];
            $_SESSION[ 'manage_users' ] = $user_details['manage_users'];

            header('location: /');
            die();
        } else {
            $error = 'Invalid unsername or password';
        }
    } else {
        $error = 'Username or password can\'t be empty!';
    }

}

//session_start();
//$_SESSION['userid'] = 1;
//PHP_SESSION_ACTIVE
?>
    <!-- Navigation Panel -->
    <nav class="main-nav logo-cen">
        <div class="full-wrapper relative clearfix">

            <!-- Logo -->
            <div class="nav-logo">
                <a href="/" class="logo">
                    <img src="images/logo-white-retina.png" width="135px" alt="quizzy logo">
                </a>
            </div><!-- End Logo -->

        </div>
    </nav><!-- End Navigation Panel -->

    <!-- Login Section -->
    <div class="page-section">

        <!-- Container -->
        <div class="container relative">

            <!-- Row -->
            <div class="row bg-panel-row">
                <div class="col-md-4 col-md-push-4">

                    <!-- Bg Panel -->
                    <div class="bg-panel">
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" class="form login-form" method="post">
                            <div class="form-label">
                                <h3 class="form-title">Quizzy Login</h3>
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" value="<?= isset($_POST['username'])? $_POST['username'] : ''; ?>" required placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" required placeholder="Password">
                            </div>
                            <?php if($error): ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Error:</strong>
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            <div class="clearfix">
                                <div class="form-left-col form-tip pt-5">
                                    <a href="#">Forgot Password?</a>
                                </div>
                                <div class="form-right-col align-right">
                                    <input type="submit" name="submit" class="btn btn-md btn-green" value="login">
                                </div>
                            </div>
                        </form>
                    </div><!-- End Panel -->

                </div>
            </div><!-- End row -->

        </div><!-- End Container -->

    </div><!-- End Login section -->
<?php
include( INCLUDES_PATH . "/footer.php");
