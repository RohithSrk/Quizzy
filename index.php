<?php
/**
 * Quzzy Online Interactive Quiz Application
 * Home Page and Category Almanac
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

//start session or resume
session_start();

//Set Page Title
$page_title = 'Quzzy Online Interactive Quiz Application';

//Include Header
include( INCLUDES_PATH . "/header.php");

//check sessions are active and user detailes are set
if( PHP_SESSION_ACTIVE and isset($_SESSION['user_id']) ){
//    var_dump( $_SESSION );
}
?>
    <!-- Sticky Header -->
    <div class="sticky-wrapper">
        <div class="stick-fixed js-stick">
            <?php include_once( INCLUDES_PATH . "/header-nav.php"); ?>
        </div>
    </div><!-- End Sticky Header -->

    <!-- Hero Section -->
    <section class="page-section bg-color-white" id="home">
        <div class="container relative align-left">
            <!-- Section Title -->
            <h3 class="section-title align-center"><span class="typedjs"></span></h3><!-- End Section Title -->
            <div class="row">
                <div class="col-md-6 col-md-push-3 text-style-1 align-center">
                    <p class="mb-0">Quizzy is a free and open quiz platform where students can enhance their knowledge by participating in quizzes created by community. Students can test their skills by competing with other students</p>
                </div>
            </div>
        </div>
    </section><!-- End Hero Section -->

    <!-- Divider -->
    <hr class="mt-0 mb-0 "/>
    <!-- End Divider -->

    <!-- Categories -->
    <section class="small-section" id="categories">
        <div class="container relative">
            <div class="row">

                <!-- Masonry Grid -->
                <div class="mason-grid">

                    <?php
                        $quizzy = new Quizzy();
                        $category_rows = $quizzy->get_categories();
                        foreach( $category_rows as $category_row ):
                    ?>
                    <!-- Category Box -->
                    <div class="mason-grid-item">
                        <div class="category-box" data-id="<?php echo $category_row['id']; ?>">
                            <h3 class="category-heading"><?php echo $category_row['category']; ?></h3>
                                <ul class="category-menu">
                                <?php
                                    $topic_rows = $quizzy->get_topics( $category_row['id'] );
                                    if( $topic_rows ) :
                                        foreach( $topic_rows as $topic_row ):
                                    ?><li class="topic">
                                        <?php printf('<a href="/topic.php?id=%d">', $topic_row[ 'topic_id' ] );
                                            echo $topic_row[ 'topic' ];
                                        ?><span class="label label-default"><?php echo $quizzy->get_quizzes($topic_row[ 'topic_id' ], true); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; endif; ?>
                            </ul>
                            <?php if($quizzy->is_user_loggedin()): ?>
                                <a href="javascript:void(0)" class="add-topic active">Add Topic</a>
                            <?php else: ?>
                                <a href="/login.php" class="add-topic">Add Topic</a>
                            <?php endif; ?>
                        </div>
                    </div><!-- End Category Box -->

                    <?php endforeach; $quizzy->close_db_conn(); ?>

                </div><!-- End Masonry Grid -->
            </div><!-- Add Category -->
            <div class="row">
                <div class="col-md-4 col-md-push-4 col-xs-6 col-xs-push-3 col-xxs-12 col-xxs-push-0">
                    <?php if($quizzy->is_user_loggedin()): ?>
                        <a id="add-category" href="javascript:void(0)" class="btn add-category active">Add Category</a>
                    <?php else: ?>
                        <a id="add-category" href="/login.php" class="btn add-category">Add Category</a>
                    <?php endif; ?>
                </div>
            </div><!-- End Add Category -->
        </div>
    </section><!-- End Categories -->

<?php
include( INCLUDES_PATH . "/footer.php");
