<?php
/**
 * Quzzy Online Interactive Quiz Application
 * Category Topics page
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

//Start or resume Session
session_start();

//if Topic id not set, redirect to home
if( !isset( $_GET['id'] ) ){
    header('location: /');
    die();
}

//check sessions are active and user detailes are set
//if( PHP_SESSION_ACTIVE and isset($_SESSION['user_id']) ){
//    var_dump( $_SESSION );
//}

$topic_id = $_GET['id'];

//validate topic id
if( !preg_match( "/^\d+$/", $topic_id ) ){
    //redirect to home
    header('location: /');
    die();
}

$quizzy = new Quizzy();

//Get Topic Details or
//Send 404 status code show 404 page if topic doesn't exist in db
if(!$topic_meta = $quizzy->get_topic_meta( $topic_id )){
    header('The page can\'t be found', true, 404);
    include('404.php');
    exit();
}

//Set Page Title
$page_title = $topic_meta['topic_name'] . ' - ' . $topic_meta['category_name'] . ' - Quzzy Online Interactive Quiz Application';

//Include Header
include( INCLUDES_PATH . "/header.php");

$quizzes = $quizzy->get_quizzes( $topic_id );
?>
    <!-- Sticky Header -->
    <div class="sticky-wrapper">
        <div class="stick-fixed js-stick">
            <?php include_once( INCLUDES_PATH . "/header-nav.php"); ?>
        </div>
    </div><!-- End Sticky Header -->

<!-- Topic Description -->
<section class="small-section" id="description">
    <div class="container relative align-left">
        <!-- Section Title -->
        <h3 class="section-title align-center"><?php echo $topic_meta[ 'topic_name' ]; ?></h3><!-- End Section Title -->
        <div class="row">
            <div class="col-md-8 col-md-push-2 text-style-1 align-center">
                <?php
                    $topic_description = $topic_meta[ 'topic_description' ];
                    if(strlen($topic_description) != 0):
                ?>
                <p class="mb-0"><?php echo $topic_description; ?></p>
                <?php else: ?>
                <p class="mb-0">There's no description for this topic yet. Can you add one?</p>
                <a href="#" class="btn btn-md">Add Description</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section><!-- End Topic Description -->

<?php if($quizzes) : ?>
<!-- Quiz list -->
<section class="quiz-list">
    <div class="container relative">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Quiz Name</th>
                            <th>Popularity</th>
                            <th>No.of Qustions</th>
                            <th>Duration</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach( $quizzes as $quizz ): ?>
                        <?php printf( '<tr class="anchor" data-url="/quiz.php?quiz=%d" role="button">', $quizz['quiz_id'] ); ?>
                            <th scope="row"><?php echo $quizz['row_num']; ?></th>
                            <td><?php echo $quizz['quiz_name']; ?></td>
                            <td>
                                <?php printf( '<i class="fa fa-star %s"></i>',
                                    $quizzy->get_quiz_popularity( $quizz['quiz_id'] ) ); ?>
                            </td>
                            <td><?php echo $quizz['total_questions']; ?></td>
                            <td><?php echo $quizz['duration']; ?></td>
                        </tr>
                        <?php endforeach;$quizzy->close_db_conn(); ?>

                        </tbody>
                    </table>
                </div>
                <div class="align-center mb-15">
                    <?php if($quizzy->is_user_loggedin()): ?>
                        <a href="/addquiz.php?topic=<?php echo $topic_id; ?>" class="btn btn-md">Add Quizz</a>
                    <?php else: ?>
                        <a href="/login.php" class="btn btn-md">Add Quizz</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Quizz list -->
<?php else : ?>
    <!-- Divider -->
    <hr class="mt-0 mb-0 "/>
    <!-- End Divider -->

    <!-- Empty content -->
    <section class="small-section" id="empty-content">
        <div class="container relative align-left">
            <!-- Section Title -->
            <h3 class="section-title align-center">There's no quiz yet here...</h3><!-- End Section Title -->
            <div class="row">
                <div class="col-md-8 col-md-push-2 text-style-1 align-center">
                    <p class="mb-0">It looks so empty here, so why don't you add some quizzes?<br> You can help students learn new things and test themselves. So, go on..</p>
                    <?php if($quizzy->is_user_loggedin()): ?>
                        <a href="/addquiz.php?topic=<?php echo $topic_id; ?>" class="btn btn-md">Add Quizz</a>
                    <?php else: ?>
                        <a href="/login.php" class="btn btn-md">Add Quizz</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section><!-- End Empty Content -->
<?php endif; ?>
<?php
include( INCLUDES_PATH . "/footer.php");

