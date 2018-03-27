<?php
/**
 * Quzzy Online Interactive Quiz Application
 * Add a new quiz page
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

//start session or resume
session_start();

$quizzy = new Quizzy();

//check login
if( $quizzy->is_user_loggedin() ){

    if( !($_SESSION['add_content'] == 'Y') ) {

        //exit script outputting json data
        $output = json_encode( array( 'type' => 'error', 'text' => 'You don\'t have enough privileges to make this request.' ));
        die($output);
    }

} else {
    //redirect to login
    header('location: /login.php');
    die();
}

//Handle add quiz Submit
if( isset( $_POST['type'] ) ){

    if( $_POST['type'] == 'quiz-submit' ){
        $topic_id = $_POST[ 'topic_id' ];
        $quiz_name = $_POST[ 'quiz_name' ];
        $total_questions = $_POST[ 'total_questions' ];
        $duration = $_POST[ 'duration' ];
        $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ";

        //TODO: Validate Questions Array
        $questions = $_POST[ 'questions' ];
        $error = false;

        if( $new_quiz_id = $quizzy->add_quiz($quiz_name, $description,
            $topic_id, $total_questions, $duration, $_SESSION['user_id']) ) {

            //with the new quiz id insert questions
            foreach( $questions as $question => $que_data ){

                //Insert each question and get new question id
                if($question_id = $quizzy->add_question( $new_quiz_id, $question, $que_data['multiple_answers'] )){

                    //with the new question id insert options
                    foreach( $que_data['options'] as $option ){

                        if($option_id = $quizzy->add_option( $question_id, $option )){

                            //if this option is in answers array add this optioin to answers table
                            if(in_array( $option, $que_data['correct'] )){
                                $quizzy->add_answer( $question_id, $option_id );
                            }

                        } else {
                            $error = true;
                        }
                    }
                } else {
                    $error = true;
                }
            }

            if( !$error ){
                //quiz created successfully
                //exit script outputting json data
                $output = json_encode( array( 'type' => 'success', 'new_quiz_id' => $new_quiz_id ));
                die($output);
            }

        } else {
            //exit script outputting json data
            $output = json_encode( array( 'type' => 'error', 'text' => 'Your data can\'t be validated.' ));
            die($output);
        }
    }
}

$categories = $quizzy->get_categories();

$category_id = 1;
$topic_id = 1;

if( isset($_GET['topic']) ){
    //get categories and topics and fill select element
    if( preg_match("/^\d+$/", $_GET['topic']) ){

        $topic_meta = $quizzy->get_topic_meta( $_GET['topic'] );
        $category_id = $topic_meta['category_id'];
        $topic_id = $topic_meta['topic_id'];
    }
}


//Set Page Title
//$page_title = $quiz_meta['quiz_name'] . ' - ' . $quiz_meta['topic_name'];
$page_title = "Add your own Quiz";

//Include Header
include( INCLUDES_PATH . "/header.php");

?>
<!-- Sticky Header -->
<div class="sticky-wrapper">
    <div class="stick-fixed js-stick">

        <?php include_once( INCLUDES_PATH . "/header-nav.php"); ?>

        <!-- Status Bar -->
        <div class="status-bar" id="status-bar">
            <div class="full-wrapper">
                <div class="row">
                    <div class="col-md-6 col-xs-12 hidden-xs">
                        <div class="breadcrumbs hidden">
                            <a class="category" href="/"></a> /
                            <a class="topic" href="/topic.php?id=<?php echo $topic_id; ?>"></a> /
                            <span class="name"></span>
                        </div>
                        <hr class="mt-0 mb-0" style="margin: 0 -2.5%"/>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <span id="time-status" class="time-left">00:00:00</span>
                        <span id="question-status" class="question-num">0 of 0</span>
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
<section id="questions-section" class="questions-section edit-mode">
    <!-- container -->
    <div class="container relative">
        <!-- row -->
        <div class="row">
            <!-- column -->
            <div class="col-md-8 col-md-push-2">
                <!-- quiz slides -->
                <ul class="item-wrap clearlist owl-carousel">
                    <li class="quiz-meta clearfix">

                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control form-control-sm" id="quiz-category">
                                <?php if($categories):
                                    foreach( $categories as $category ):
                                        if($category_id == $category['id']):
                                            printf( '<option value="%d" selected>%s</option>', $category['id'], $category['category'] );
                                        else:
                                            printf( '<option value="%d">%s</option>', $category['id'], $category['category'] );
                                        endif;
                                    endforeach;
                                endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mt-sm-15">
                                <select class="form-control form-control-sm" id="quiz-topic">
                                <?php
                                    if($topics = $quizzy->get_topics( $category_id )):
                                        foreach($topics as $topic):
                                            if( $topic_id == $topic['topic_id'] ):
                                                printf( '<option value="%d" selected>%s</option>', $topic['topic_id'], $topic['topic'] );
                                            else:
                                                printf( '<option value="%d">%s</option>', $topic['topic_id'], $topic['topic'] );
                                            endif;
                                        endforeach;
                                    endif;
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 mt-15">
                                <input class="form-control" type="text" placeholder="Quiz Name" id="quiz-name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-15">
                                <input class="form-control" type="text" placeholder="Total Questions" id="total-questions" value="5">
                            </div>
                            <div class="col-md-6 mt-15">
                                <input class="form-control" type="text" placeholder="Duration" id="duration">
                            </div>
                        </div>
                        <nav class="question-nav clearfix mt-25">
                            <a href="#" class="que-prev " style="visibility: hidden;">
                                        <span>
                                           <i class="fa fa-chevron-left"></i>
                                            Prev
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
                    <li class="question-item">
                        <div class="question-edit">
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                        <div class="question-type">
                            <div class="option-item radio">
                                <input type="radio" id="TQID-1-single" name="TQID-1-type" value="N" data-val="radio">
                                <label for="TQID-1-single">Single Answer</label>
                            </div>
                            <div class="option-item radio">
                                <input type="radio" id="TQID-1-multiple" name="TQID-1-type" value="Y" checked="" data-val="checkbox">
                                <label for="TQID-1-multiple">Multiple Answers</label>
                            </div>
                        </div>
                        <ul class="options">
                            <li class="option-item checkbox">
                                <span class="rm-opt" title="Remove this option"><i class="fa fa-close"></i></span>
                                <input type="checkbox" id="8" name="TQID-1">
                                <label for="8"></label>
                                <input type="text" class="form-control" style="position: absolute;right: 0;top: 0; width: 95%;">
                            </li>
                            <li class="option-item checkbox">
                                <span class="rm-opt" title="Remove this option"><i class="fa fa-close"></i></span>
                                <input type="checkbox" id="5" name="TQID-18">
                                <label for="5"></label>
                                <input type="text" class="form-control" style="position: absolute;right: 0;top: 0; width: 95%;">
                            </li>
                            <li class="add-option">
                                <a href="javascript:void(0)"><i class="fa fa-plus"></i> Add Option</a>
                            </li>
                        </ul>
                        <nav class="question-nav clearfix mt-25">
                            <a href="#" class="que-prev">
                                <span>
                                   <i class="fa fa-chevron-left"></i>
                                    Prev
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
                    <li class="quiz-edit-result" id="quiz-edit-result">
                        <nav class="question-nav clearfix mt-25">
                            <a href="#" id="quiz-re-edit" class="quiz-re-edit">
                                <span>
                                   <i class="fa fa-chevron-left"></i>
                                    Re-Edit
                                </span>
                            </a>
                            <a href="#" class="que-next hidden">
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