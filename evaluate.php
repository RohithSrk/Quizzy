<?php
/**
 * Quzzy Online Interactive Quiz Application
 * Quiz Evaluation Through Ajax...fast and simple
 * @package: Quizzy
 * @version: 0.1
 */
//Load base configuration file
require_once ( realpath(dirname(__FILE__)) . "/resources/config.php" );

//Load functions and definations
require_once ( INCLUDES_PATH . "/functions.php");

/*
 Sample User Data ($_POST)
Array
(
    [type] => submit
    [starttime] => 1456482650959
    [endtime] => 1456482659260
    [quizReportId] => QZRID-20
    [userAnswers] => Array
        (
            [QID-3] => Array
                (
                    [0] => OPID-12
                )

            [QID-2] => Array
                (
                    [0] => OPID-9
                )

            [QID-4] => Array
                (
                    [0] => OPID-16
                )

            [QID-1] => Array
                (
                    [0] => OPID-5
                )

        )

)
 */

//check if its an ajax request, exit if not
if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    if( strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' ) {
        //exit script outputting json data
        $output = json_encode( array( 'type' => 'error', 'text' => 'Request must come from Ajax' ));
        die($output);
    }

} else {
    //exit script outputting json data
    $output = json_encode( array( 'type' => 'error', 'text' => 'Request must come from Ajax' ));
    die($output);
}

//Handle Ajax Quiz Submit
if( isset($_POST['type']) and $_POST['type'] == 'submit' ){

    //Check if all $_POST vars are set or else exit
    if( !isset($_POST['quizReportId']) || !isset($_POST['starttime']) ||
        !isset($_POST['endtime']) || !isset($_POST['userAnswers'])) {

        $output = json_encode(array('type'=>'error', 'text' => 'One/more of required fields are empty.'));
        die($output);
    }

    $quizzy             = new Quizzy();
    $quiz_report_id     = $_POST['quizReportId'];

    // Validate quiz report ID
    if( !$quiz_report_id = $quizzy->validate_QZRID($quiz_report_id) ) {

        $output = json_encode(array('type' => 'error', 'text' => 'Invalid/Expired Quiz Report Id Provided.'));
        die($output);
    }

    $quiz_id            = $quizzy->get_quiz_id( $quiz_report_id );
    $user_start_time    = $_POST['starttime'];
    $user_end_time      = $_POST['endtime'];
    $server_end_time    = new DateTime();
    $quiz_meta          = $quizzy->get_quiz_meta( $quiz_id );

    // Validate timestamps
    if ( !($quizzy->validate_timestamps($user_start_time,
        $user_end_time, $server_end_time, $quiz_id, $quiz_report_id))) {

        $output = json_encode(array('type' => 'error', 'text' => 'Your quiz has expired.'));
        die($output);
    }

    // Validate User question and option IDs
    if (!($user_data = $quizzy->validate_user_answers($_POST['userAnswers']))) {

        $output = json_encode(array('type' => 'error', 'text' => "Your quiz data can't be validated"));
        die($output);
    }

    /*
     *  //loop through filtered user answers
     *  //keys are question IDs and values are option ID arrays
     *  array(3) {
     *    [2]=>
     *    array(1) {
     *      [0]=>
     *      string(1) "8"
     *    }
     *    [3]=>
     *    array(4) {
     *      [0]=>
     *      string(2) "11"
     *      [1]=>
     *      string(2) "12"
     *    }
     *    [1]=>
     *    array(1) {
     *      [0]=>
     *      string(1) "4"
     *    }
     *  }
     */

    $user_correct_ans_count = 0;
    $attempted_count = 0;

    foreach( $user_data as $qid => $opids ){

        $attempted_count++;

        //verify whether the questions belongs to quiz id
        if( $quizzy->verify_que_origin($qid, $quiz_id) ) {

            $correct_answers = $quizzy->get_answers($qid);

            //if all items on user_answers and correct_answers
            // are similar mark question as correct
            if( equal_arrays($correct_answers, $opids) ){
                $user_correct_ans_count++;
            }
        }
    }

    $result = $quizzy->get_result( $user_correct_ans_count, $quiz_meta['total_questions'] );

    $output = json_encode(array(
        'type' => 'success',
        'result' => array(
            'percentage' => $result['percentage'],
            'points' => $result['points'],
            'max_points' => $result['max_points'],
            'rightAnsCount' => $user_correct_ans_count,
            'totalQuestions' => $quiz_meta['total_questions'],
            'unaswered' => $quiz_meta['total_questions'] - $attempted_count,
            'averageTime' => $result['time_taken'] / $attempted_count,
            'timetaken' => $result['time_taken'],
            'correct_options' => array_map( function($opid) { return 'OPID-'. $opid; },
                $quizzy->get_all_quiz_answers($quiz_id) )
        )
    ), JSON_FORCE_OBJECT);

    //on success update quiz_report to finished with user data
    $quizzy->finish_quiz( $quiz_report_id, $user_start_time, $server_end_time, $result );

    die($output);
}


//send correct answers
//Final ajax response would be as
/*
{
    'percentage': 89
    'points': 485
    'max_points': 500
    'correct_options': {
            'OPID-15564',
            'OPID-15564'
     }
}
*/


