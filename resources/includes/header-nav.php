<!-- Navigation Panel -->
<nav class="main-nav mobile">
    <div class="full-wrapper relative clearfix">

        <!-- Logo -->
        <div class="nav-logo">
            <a href="/" class="logo">
                <img src="images/logo-white-retina.png" width="135px" alt="quizzy logo">
            </a>
        </div><!-- End Logo -->

        <!-- Mobine Nav Btn -->
        <div class="mobile-nav">
            <i class="fa fa-bars"></i>
        </div><!-- End Mobine Nav Btn -->

        <!-- Inner Navigation -->
        <div class="inner-nav">
            <ul class="clearlist">
                <?php if(PHP_SESSION_ACTIVE and isset($_SESSION['user_id'])): ?>
                <li><a href="#"><?php echo $_SESSION['first_name'], ' ' ,$_SESSION['last_name']; ?></a></li>
                <?php endif; ?>
                <li><a href="/">Home</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Contact</a></li>
                <?php if(PHP_SESSION_ACTIVE and isset($_SESSION['user_id'])): ?>
                    <li><a href="/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div><!-- End Inner Navigation -->
    </div>
</nav><!-- End Navigation Panel -->
