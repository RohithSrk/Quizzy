<?php
/**
 * Quzzy Online Interactive Quiz Application
 * The actual Quiz Page
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

if( !isset( $_GET['quiz'] ) ){
    //redirect to home
    header('location: /');
    die();
}

//start session or resume
session_start();

$quizz_id = $_GET['quiz'];

//validate quizz_id
if( !preg_match( "/^\d+$/", $quizz_id ) ){
    //redirect to home
    header('location: /');
    die();
}

$quizzy = new Quizzy();
if(!$quiz_meta = $quizzy->get_quiz_meta( $quizz_id )){
    //send 404 status code and show 404 page
    header('The page can\'t be found', true, 404);
    include('404.php');
    exit();
}

//Set Page Title
$page_title = $quiz_meta['quiz_name'] . ' - ' . $quiz_meta['topic_name'];

//Include Header
include( INCLUDES_PATH . "/header.php");

//start new quiz
$quiz_report_id = $quizzy->start_new_quiz( $quizz_id );
?>
    <!-- Sticky Header -->
    <div class="sticky-wrapper">
        <div class="stick-fixed js-stick">

            <?php include_once( INCLUDES_PATH . "/header-nav.php"); ?>

            <!-- Status Bar -->
            <div class="status-bar">
                <div class="full-wrapper">
                    <div class="row">
                        <div class="col-md-6 col-xs-12 hidden-xs">
                            <div class="breadcrumbs">
                                <a href="/"><?php echo $quiz_meta['category_name']; ?></a> /
                                <?php printf( '<a href="/topic.php?id=%d">%s</a>',
                                    $quiz_meta['topic_id'], $quiz_meta['topic_name'] ); ?> /
                                <?php echo $quiz_meta['quiz_name']; ?>
                            </div>
                            <hr class="mt-0 mb-0" style="margin: 0 -2.5%"/>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <span id="time-status" class="time-left"><?php echo $quiz_meta['duration']; ?></span>
                            <span id="question-status" class="question-num">0 of <?php echo $quiz_meta['total_questions']?></span>
                        </div>
                    </div>
                </div>
            </div><!-- End End Status Bar -->

            <!-- Test Progress -->
            <div class="test-progress">
                <div class="progress">
                    <div id="quiz-progress" class="progress-bar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" role="progressbar"></div>
                </div>
            </div><!-- End Test Progress -->
        </div>
    </div><!-- End Sticky Header -->

    <!-- Questions -->
    <section id="questions-section" class="questions-section edit-mod" data-quiz-report-id="<?php printf( 'QZRID-%d', $quiz_report_id ); ?>"
            data-duration="<?php echo $quiz_meta['duration']; ?>">
        <!-- container -->
        <div class="container relative">
            <!-- row -->
            <div class="row">
                <!-- column -->
                <div class="col-md-8 col-md-push-2">
                    <!-- quiz slides -->
                    <ul class="item-wrap clearlist owl-carousel">
                        <li class="quiz-intro">
                            <h3 class="quiz-title"><?php echo $quiz_meta['quiz_name']; ?></h3>
                            <p><?php echo $quiz_meta['quiz_description']; ?></p>
                            <div class="countdown">This quiz will auto start in <span>5</span> seconds.</div>
                            <div class="align-center">
                                <a href="#" id="start-quiz" class="start-quiz btn btn-md green">Start Quiz</a>
                            </div>
                        </li>
                        <?php
                            $questions = $quizzy->get_questions( $quizz_id );
                            $total_ques = count( $questions );
                            $curr_que_indx = 0;
                            $last_que = false;
                            foreach( $questions as $question ):

                                $curr_que_indx++;
                                $question_id = $question['qid'];
                                if( $curr_que_indx == $total_ques ){
                                    $last_que = true;
                                }
                                if( $question['is_multi_ans_que'] == 'Y' ){
                                    $input_type = 'checkbox';
                                }else{
                                    $input_type = 'radio';
                                }
                        ?>
                        <li class="question-item" id="<?php printf( "QID-%s", $question_id ); ?>">
                            <p class="question"><?php echo $question['question']; ?></p>
                            <ul class="options">
                                <?php
                                    $options = $quizzy->get_options( $question_id );
                                    foreach( $options as $option ):
                                        $option_id = $option['option_id'];
                                ?>
                                <li class="option-item <?php echo $input_type; ?>">
                                    <?php printf( '<input type="%s" id="OPID-%d" name="QID-%d">', $input_type, $option_id, $question_id )?>
                                    <?php printf( '<label for="OPID-%d">%s</label>', $option_id, $option['option_val'] ); ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <nav class="question-nav clearfix mt-25">
                                <a href="#" class="que-prev"><span><i class="fa fa-chevron-left"></i> Prev</span></a>
                                <?php if( $last_que ): ?>
                                <a href="#" id="quiz-finish" class="quiz-finish"><span>Submit <i class="fa fa-chevron-right"></i></span></a>
                                <?php else: ?>
                                <a href="#" class="que-next"><span>Next <i class="fa fa-chevron-right"></i></span></a>
                                <?php endif; ?>
                            </nav>
                        </li>
                        <?php endforeach; ?>
                        <li class="quiz-result" id="quiz-result">
                            <div class="relative">
                                <div class="row">
                                    <div class="col-sm-12 align-center">
                                        <h3 class="section-title">Your Scores</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 align-right">
                                        <div class="mt-20 result-left">Time taken : <span>5mins</span></div>
                                        <div class="mt-20 result-left">Total correct answers : <span>15</span></div>
                                        <div class="mt-20 result-left">Your Percentage : <span>65.55%</span></div>
                                    </div>
                                    <div class="col-md-4 align-center">
                                        <div class="canvas-progress" id="canvas-progress" title="500">
                                            <strong></strong>
                                        </div>
                                    </div>
                                    <div class="col-md-4 align-left">
                                        <div class="mt-20 result-right">Average Time : <span>5mins</span></div>
                                        <div class="mt-20 result-right">Unanswered : <span>15</span></div>
                                        <div class="mt-20 result-right">Your Score : <span>485</span></div>
                                    </div>
                                </div>
                            </div>
                            <p></p>
                            <nav class="question-nav clearfix mt-25">
                                <a href="#" id="quiz-review" class="quiz-review">
                                    <span>
                                       <i class="fa fa-chevron-left"></i>
                                        Review
                                    </span>
                                </a>
                                <a href="#" class="que-next">
                                    <span>
                                        Next
                                        <i class="fa fa-chevron-right"></i>
                                    </span>
                                </a>
                            </nav>
                        </li>
                    </ul><!-- End quiz slides -->
                </div><!-- End column -->
            </div><!-- End row-->
        </div><!-- End Container -->
    </section><!-- End Questions -->
<?php
include( INCLUDES_PATH . "/footer.php");
