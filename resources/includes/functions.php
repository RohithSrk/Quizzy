<?php
/**
 * Quizzy Functions, Classes and Definitions
 * @package: Quizzy
 * @version: 0.1
 */
require_once ( realpath(dirname(dirname(__FILE__))) . '/config.php' );

class Quizzy{
    protected $db_name = '';
    protected $db_conn = null;
    protected $time_taken = null;
    protected $duration = null;

    /**
     * Quizzy constructor.
     * @param string $db_name quizzy database name
     */
    public function __construct( $db_name = '' )
    {
        //Initialize db_name
        if( $db_name != '' ){
            $this->db_name = $db_name;
        } else {
            $this->db_name = DB_NAME;
        }
    }

    /**
     * Makes a db connection
     * @return mysqli|null
     */
    public function connect_db()
    {
        //Make mysqli database connection
        $this->db_conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, $this->db_name );

        // Exit on db connection error
        if( $this->db_conn->connect_errno ){
            exit( "Database connection failed: " . $this->db_conn->connect_error );
        }

        // return mysqli connection
        return $this->db_conn;
    }

    /**
     * Makes database connection implicitly
     * if there are no previous connections
     */
    public function check_db_conn()
    {
        // make db connection incase you didn't
        if( $this->db_conn == null ){
            $this->connect_db();
        }
    }

    /**
     * Authenticates a user by checking
     * username and password in the db
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function authenticate_user($username = null, $password = null ){

        if( isset($username) and isset( $password ) ){
                

            //validate username and password using regex
            if( preg_match( "/^[A-Za-z0-9_-]{2,12}$/", $username ) ){

                $this->check_db_conn();


                //check whether the user exists and his password is correct
                $sql = "SELECT COUNT(*) as count FROM `users` WHERE username = '{$username}' and password = md5('{$password}')";

                $result = $this->db_conn->query( $sql );

                if( $result->num_rows ) {

                    $count = intval( $result->fetch_assoc()['count'] );

                    //Free result set
                    $result->free_result();

                    if($count){

                        $sql = "SELECT users.id as user_id, users.username, users.first_name, users.last_name, ".
                            "privileges.add_content, privileges.modify_content, privileges.manage_users FROM users ".
                            "LEFT JOIN privileges on users.user_type = privileges.id WHERE users.username = '{$username}'";

                        $result = $this->db_conn->query( $sql );

                        if( $result->num_rows ) {

                            //Fetch user details and privileges
                            $user_details = $result->fetch_assoc();

                            //Free result set
                            $result->free_result();

                            //return user details and privileges
                            return $user_details;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Returns user loggedin status
     * @return bool
     */
    public function is_user_loggedin(){
        if(PHP_SESSION_ACTIVE and isset($_SESSION['user_id'])){
            return true;
        }
        return false;
    }
    public function get_categories()
    {
        $this->check_db_conn();

        $sql = "SELECT * FROM `categories` ORDER BY `id` ASC";
        $result = $this->db_conn->query( $sql );

        if( $result->num_rows ){

            while( $row = $result->fetch_assoc() ) {
                $rows[] = $row;
            }

            //Free result set
            $result->free_result();

            //Return rows
            return $rows;
        }

        return false;
    }
    public function get_topics( $category_id = null )
    {
        $this->check_db_conn();

        //Fetch all categories's topics if $category empty else only topics of $category
        if( is_null($category_id) ){
            $sql = "SELECT `id` as topic_id, `topic`, category_id FROM `topics`";
        } else {
            $sql = "SELECT `id` as topic_id, `topic` FROM `topics` WHERE `category_id` = {$category_id}";
        }

        $result = $this->db_conn->query( $sql );

        if( $result->num_rows ){

            while( $row = $result->fetch_assoc() ) {
                $rows[] = $row;
            }

            //Free result set
            $result->free_result();

            //Return rows
            return $rows;
        }

        return false;
    }
    public function get_topic_meta( $topic_id = null )
    {
        if( isset($topic_id) ){

            $this->check_db_conn();

            $sql = "SELECT tp.id as topic_id, tp.topic as topic_name, tp.topic_description, cat.id as category_id,".
                " cat.category as category_name FROM `topics` as tp LEFT JOIN categories as cat on tp.category_id = cat.id WHERE tp.id = {$topic_id}";

            $result = $this->db_conn->query( $sql );

            if( $result->num_rows ){

                $topic_meta = $result->fetch_assoc();

                //Free result set
                $result->free_result();

                //Return description
                return $topic_meta;
            }
        }

        return false;
    }
    public function get_quizzes( $topic = null, $get_count = false )
    {
        if( isset($topic) ){

            $this->check_db_conn();

            if( $get_count ) {
                $sql = "SELECT COUNT(*) as count FROM `quizzes` WHERE `topic_id` = {$topic}";

                $result = $this->db_conn->query( $sql );

                if( $result->num_rows ) {
                    $count = $result->fetch_assoc();

                    //Free result set
                    $result->free_result();

                    //Return total quizzes count for topic_id
                    return $count['count'];
                }

            } else {
                $sql = "SELECT `id` as quiz_id, `quiz_name`, `total_questions`, `duration` ".
                    " FROM `quizzes` WHERE `topic_id` = {$topic}";

                $result = $this->db_conn->query( $sql );

                if( $result->num_rows ){

                    $row_count = 0;
                    while( $row = $result->fetch_assoc() ) {
                        //Add Numbers for rows
                        $row['row_num'] = ++$row_count;

                        //collect row
                        $rows[] = $row;
                    }

                    //Free result set
                    $result->free_result();

                    //Return quizz rows
                    return $rows;
                }
            }
        }

        return false;
    }
    public function get_quiz_meta( $quiz_id = null )
    {
        if( isset($quiz_id) ){

            $this->check_db_conn();

            $sql = "SELECT quizzes.quiz_name, quizzes.description as quiz_description, quizzes.total_questions, ".
                "quizzes.duration, topics.id as topic_id, topics.topic as topic_name, categories.category as category_name FROM `quizzes` LEFT JOIN ".
                "topics on quizzes.topic_id = topics.id LEFT JOIN categories on topics.category_id = categories.id WHERE quizzes.id = {$quiz_id}";

            $result = $this->db_conn->query( $sql );

            if( $result->num_rows ){

                $quiz_meta = $result->fetch_assoc();

                //Free result set
                $result->free_result();

                //Return quiz details
                return $quiz_meta;
            }
        }

        return false;
    }
    public function get_questions( $quiz_id = null )
    {
        if( isset($quiz_id) ){

            $this->check_db_conn();

            $sql = "SELECT * FROM `questions` WHERE quiz_id = {$quiz_id} ORDER BY rand()";

            $result = $this->db_conn->query( $sql );

            if( $result->num_rows ){

                while( $row = $result->fetch_assoc() ) {
                    $rows[] = $row;
                }

                //Free result set
                $result->free_result();

                //Return question rows
                return $rows;
            }
        }

        return false;
    }
    public function get_quiz_popularity( $quiz_id = null ){
        if (isset($quiz_id)) {

            $this->check_db_conn();

            //Get Topic Id for $quiz_id
            if( !$quiz_meta = $this->get_quiz_meta( $quiz_id ) ){
                return false;
            }
            $topic_id = $quiz_meta['topic_id'];


            //we'll calculate popularity based on number of test takers for a quiz
            //test takers for this quiz / total test takers of all quizzes in this quiz's topic

            /*
             * Test takers count for this quiz $quiz_id
             */
            $sql = "SELECT COUNT(*) as test_takers FROM `quiz_report` WHERE `quiz_id` = {$quiz_id} and is_finished = 'Y'";

            $result = $this->db_conn->query( $sql );

            if( ! $result->num_rows ) {
                return false;
            }

            $count = $result->fetch_assoc();

            //Free result set
            $result->free_result();

            //Test Takers count for quiz_id
            $test_takers =  $count['test_takers'];

            /*
             * Total Test takers count of all quizzes in this quiz's topic
             */
            $sql = "SELECT COUNT(*) as total_test_takers FROM `quiz_report` WHERE quiz_id IN ".
                "(SELECT id FROM quizzes WHERE topic_id = {$topic_id}) and is_finished = 'Y'";

            $result = $this->db_conn->query( $sql );

            if( ! $result->num_rows ) {
                return false;
            }

            $count = $result->fetch_assoc();

            //Free result set
            $result->free_result();

            $total_test_takers =  $count['total_test_takers'];

            if( $test_takers != 0 ){

                //calculate popularity in percentage
                $percentage = ($test_takers / $total_test_takers) * 100;

                //represent popularity in 5 star rating string like 4.5 as P-4-5
                $rating = round((($percentage / 100) * 5 ) * 2) / 2 ;

                $rating_string = 'P-'. str_replace( '.', '-', strval( $rating ) );

                //Return five star rating string
                return $rating_string;
            } else {
                return 'P-0';
            }
        }

        return false;
    }
    public function get_options( $question_id = null )
    {
        if( isset($question_id) ){

            $this->check_db_conn();

            $sql = "SELECT `id` as option_id, `option_val` FROM `options` WHERE qid = {$question_id} ORDER BY rand()";

            $result = $this->db_conn->query( $sql );

            if( $result->num_rows ){

                while( $row = $result->fetch_assoc() ) {
                    $rows[] = $row;
                }

                //Free result set
                $result->free_result();

                //Return options rows
                return $rows;
            }
        }

        return false;
    }
    public function add_topic( $new_topic_name, $category_id ){

        if(isset($new_topic_name) and isset( $category_id ) ) {

            //validate $category_id
            if( preg_match("/^\d+$/", $category_id)
                and preg_match("/^[0-9A-Za-z$@$!%*#?&\s]{2,16}$/", $new_topic_name ) ) {

                $this->check_db_conn();

                //check whether $category_id exists in db
                $sql = "SELECT COUNT(*) as count FROM `categories` WHERE `id` = {$category_id}";

                $result = $this->db_conn->query( $sql );

                if( $result->num_rows ) {

                    $count = intval($result->fetch_assoc()['count']);

                    //Free result set
                    $result->free_result();

                    //TODO: Check whether the topic_name already exists or add unique key to topic_name

                    if( $count ){

                        $sql = "INSERT INTO `topics`(`topic`, `category_id`) VALUES ('{$new_topic_name}', {$category_id})";

                        $result = $this->db_conn->query( $sql );

                        if( $result ) {

                            $sql = "SELECT `id` as topic_id FROM topics WHERE topic = '{$new_topic_name}'";

                            $result = $this->db_conn->query( $sql );

                            if( $result->num_rows ) {

                                //Return Topic Id of newly added topic
                                return $result->fetch_assoc()['topic_id'];
                            }
                        }
                    }
                }
            }
        }

        return false;
    }
    public function add_category( $category_name ){
        if( isset($category_name) ){
            if(preg_match("/^[0-9A-Za-z$@$!%*#?&\s]{2,18}$/", $category_name)){

                $this->check_db_conn();

                $sql = "INSERT INTO `categories`(`category`) VALUES ('{$category_name}')";

                $result = $this->db_conn->query( $sql );

                if( $result ) {

                    $sql = "SELECT `id` as category_id FROM categories WHERE category = '{$category_name}'";

                    $result = $this->db_conn->query( $sql );

                    if( $result->num_rows ) {

                        //Return Category ID of newly added category
                        return $result->fetch_assoc()['category_id'];
                    }
                }
            }
        }
        return false;
    }
    public function add_quiz( $quiz_name = null, $description = null,
                              $topic_id = null, $total_questions, $duration = null, $user_id = null ){

        if( isset($quiz_name) and isset( $description)
            and isset( $topic_id ) and isset( $total_questions ) and isset($user_id) ){

            if( preg_match("/^.{4,}$/", $quiz_name) and preg_match("/^.{8,}$/", $description)
                and preg_match("/^\d+$/", $topic_id) and preg_match("/^\d+$/", $total_questions)
                and preg_match("/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/", $duration)){

                $this->check_db_conn();

                $sql = "INSERT INTO `quizzes`(`quiz_name`, `description`, `topic_id`, `total_questions`, `duration`, `created_by`)".
                    " VALUES ('{$quiz_name}','{$description}','{$topic_id}','{$total_questions}', '{$duration}','{$user_id}')";

                $result = $this->db_conn->query( $sql );

                if( $result ){

                    //Return new Quiz id
                    return $this->db_conn->insert_id;
                }
            }

            //Insert quiz item and return new quiz id
        }
        return false;
    }
    public function add_question( $quiz_id = null, $question = null, $is_multi_ans_que = null){
        if( isset($quiz_id) and isset($question) and isset( $is_multi_ans_que ) ){

            $this->check_db_conn();

            $question = htmlentities( $question );

            $sql = "INSERT INTO `questions`(`question`, `is_multi_ans_que`, `quiz_id`) ".
                "VALUES ('{$question}','{$is_multi_ans_que}', {$quiz_id})";

            $result = $this->db_conn->query( $sql );

            if( $result ){

                //Return new question id
                return $this->db_conn->insert_id;
            }
        }
        return false;
    }
    public function add_option( $question_id, $option ){
        if( isset($question_id) and isset( $option ) ){

            $this->check_db_conn();

            $option = htmlentities( $option );

            $sql = "INSERT INTO `options`(`qid`, `option_val`) VALUES ('{$question_id}','{$option}')";

            $result = $this->db_conn->query( $sql );

            if( $result ){

                //Return new optioin id
                return $this->db_conn->insert_id;
            }
        }
        return false;
    }
    public function add_answer( $question_id, $option_id  ){
        if( isset( $question_id ) and isset( $option_id) ){

            $this->check_db_conn();

            $sql = "INSERT INTO `answers`(`qid`, `ans_opt_id`) VALUES ({$question_id},{$option_id})";

            $result = $this->db_conn->query( $sql );

            if( $result ){

                //Return new answer id
                return $this->db_conn->insert_id;
            }

        }
        return false;
    }
    public function start_new_quiz( $quiz_id = null ){

        $this->check_db_conn();

        //Get new quiz_report_id
        $sql = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->db_name}' AND TABLE_NAME = 'quiz_report'";
        $result = $this->db_conn->query( $sql );
        $row = $result->fetch_assoc();
        $new_id = $row['AUTO_INCREMENT'];
        $result->close();

        //Current Time
        $objDateTime = new DateTime();
//        $objDateTime = new DateTime( 'now', new DateTimeZone("Asia/Kolkata"));
        $str_curr_time = $objDateTime->format('Y:m:d H:i:s');

        //Insert current timestamp and new id into quiz_report
        if( PHP_SESSION_ACTIVE and isset( $_SESSION['user_id'] ) ){
            $sql = "INSERT INTO `quiz_report`(`id`, `quiz_id`, `start_time`, `user_id`, `is_finished` ) ".
                "VALUES ('{$new_id}', '{$quiz_id}', '{$str_curr_time}', '{$_SESSION['user_id']}', 'N')";
        } else {
            $sql = "INSERT INTO `quiz_report`(`id`, `quiz_id`, `start_time`, `is_finished` ) ".
                "VALUES ('{$new_id}', '{$quiz_id}', '{$str_curr_time}', 'N')";
        }

        if(!$result = $this->db_conn->query( $sql )){
            exit( 'Failed to create new quiz: ' . $this->db_conn->error );
        }

        return $new_id;
    }
    public function get_answers( $question_id = null ){

        if( isset($question_id) ){

            $this->check_db_conn();

            $sql = "SELECT `ans_opt_id` FROM `answers` WHERE `qid` = {$question_id}";

            $result = $this->db_conn->query( $sql );

            if( $result->num_rows ) {

                while ($row = $result->fetch_assoc()) {
                    $answers[] = $row['ans_opt_id'];
                }

                //Free result set
                $result->free_result();

                //Return options rows
                return $answers;
            }
        }

        return false;
    }
    public function get_all_quiz_answers( $quiz_id = null ){

        if( isset($quiz_id) ){

            $this->check_db_conn();

            $sql = "SELECT `ans_opt_id` FROM `answers` WHERE `qid` IN ".
                "(SELECT qid FROM questions WHERE quiz_id = {$quiz_id})";

            $result = $this->db_conn->query( $sql );

            if( $result->num_rows ) {

                while ($row = $result->fetch_assoc()) {
                    $answers[] = $row['ans_opt_id'];
                }

                //Free result set
                $result->free_result();

                //Return options rows
                return $answers;
            }
        }

        return false;
    }
    public function delete_quiz( $quiz_id = null ){
        if( isset( $quiz_id ) ){

            $this->check_db_conn();

            //Delete answers
            $sql1 = "DELETE FROM `answers` WHERE id IN (SELECT qid FROM questions WHERE quiz_id = {$quiz_id})";
            //DELETE options
            $sql2 = "DELETE FROM `options` WHERE `qid` IN (SELECT qid FROM questions WHERE questions.quiz_id = {$quiz_id})";
            //DELETE questions
            $sql3 = "DELETE FROM `questions` WHERE `quiz_id` = {$quiz_id}";
            //DELTE quiz
            $sql4 = "DELETE FROM `quizzes` WHERE `id` = {$quiz_id}";

            $this->db_conn->query( $sql1 );
            $this->db_conn->query( $sql2 );
            $this->db_conn->query( $sql3 );
            $this->db_conn->query( $sql4 );

            return true;
        }

        return false;
    }
    public function validate_QZRID( $quiz_report_id = null ){

        if( isset($quiz_report_id) ){

            $this->check_db_conn();

            //Validate quiz report id
            if( preg_match( "/^QZRID-(\d+)$/", $quiz_report_id, $matches, PREG_OFFSET_CAPTURE ) ){
                $quiz_report_id = $matches[1][0];

                //check whether the quizz is finished or active
                $sql = "SELECT `is_finished` FROM `quiz_report` WHERE `id` = {$quiz_report_id}";

                $result = $this->db_conn->query( $sql );
                if( $result->num_rows ){
                    //get quiz report finish status
                    $row = $result->fetch_assoc();

                    if($row['is_finished'] == 'N'){

                        //Free result set
                        $result->free_result();

                        return $quiz_report_id;
                    }
                }
            }
        }

        return false;
    }
    public function get_quiz_id( $quiz_report_id = null ){

        if( isset($quiz_report_id) ){

            $this->check_db_conn();

            $sql = "SELECT `quiz_id` FROM `quiz_report` WHERE `id` = {$quiz_report_id}";

            $result = $this->db_conn->query( $sql );

            if( $result->num_rows ){

                //get quiz report finish status
                $row = $result->fetch_assoc();
                $quiz_id = $row['quiz_id'];

                //Free result set
                $result->free_result();

                return $quiz_id;
            }
        }

        return false;
    }
    public function get_quiz_duration( $quiz_id = null ){

        if( isset($quiz_id) ){

            $this->check_db_conn();

            $sql = "SELECT `duration` FROM `quizzes` WHERE `id` = {$quiz_id}";

            $result = $this->db_conn->query( $sql );

            if( $result->num_rows ){

                //get quiz report finish status
                $row = $result->fetch_assoc();
                $duration = $row['duration'];

                //Free result set
                $result->free_result();

                return $duration;
            }
        }

        return false;
    }
    public function validate_timestamps( $user_start_time_epoch = null, $user_end_time_epoch = null,
                       $server_end_time = null, $quiz_id = null, $quiz_report_id = null ){

        //validate time stamps
        if( preg_match( "/^\d+$/", $user_start_time_epoch ) and
            preg_match( "/^\d+$/", $user_end_time_epoch ) ) {

            //check whether the quizz has sumitted in intime...
            $this->check_db_conn();

            $sql = "SELECT `start_time` FROM `quiz_report` WHERE `id` = {$quiz_report_id}";

            $result = $this->db_conn->query( $sql );

            if( $result->num_rows ){

                //get quiz report finish status
                $row = $result->fetch_assoc();
                $server_start_time = $row['start_time'];

                //Free result set
                $result->free_result();

                $duration = $this->get_quiz_duration( $quiz_id );

                /*
                 *  USER TIMESTAMPS VALIDATION LOGIC
                 * ----------------------------------
                 * + Server start time (quiz start)[Trusted time]
                 * |
                 * | + User start time (user quiz start) [Untrusted]
                 * |
                 * |    + User end time (user quiz end) [Untrusted]
                 * | + Server end time ( ajax quiz submit request time + {wait} ) [Trusted time]
                 * |
                 * + Max server end time ( Server start time + quiz duration + {wait} ) [Trusted time]
                 *
                 * The user has to submit on or before Max server end time.
                 * Wait Time comes into consideration only if [user start time] is in between
                 * [server start time] and [server start time + 5 seconds] and
                 * wait time is the diffrence of server start and user start times
                 */

                $user_start_time = new DateTime();
                $user_start_time->setTimestamp( intval( substr( $user_start_time_epoch, 0, -3 ) ) );
                $user_end_time = new DateTime();
                $user_end_time->setTimestamp( intval( substr( $user_end_time_epoch, 0, -3 ) ) );
                $server_start_time = new DateTime( $server_start_time );
                $wait_seconds = 0;
                $temp = clone  $server_start_time;
                $temp->modify('+5 seconds');

                //Check for codsidering wait
                if( $user_start_time >= $server_start_time and $user_start_time <= $temp ){
                    //yo, user has started quiz in time so, we must consider wait
                    $wait_seconds = $user_start_time->diff( $server_start_time )->s;
                }

                $max_server_end_time = clone $server_start_time;
                list($hours, $minutes, $seconds) = explode(':', $duration);
                $max_server_end_time->add(new DateInterval('PT'. $hours .'H'. $minutes .'M'. ($seconds + $wait_seconds) .'S'));


                //Check if the user has submitted before or on Max server end time
                if( $server_end_time <= $max_server_end_time ){
                    //user end time must be before or on server end time [not essential]
                    //if( $user_end_time <= $server_end_time );

                    //Caculated Duration
//                    $this->duration = $max_server_end_time->diff( $user_start_time );
                    $this->duration = $max_server_end_time->getTimestamp() - $user_start_time->getTimestamp();

                    //Time taken by user
//                    $this->time_taken = $server_end_time->diff( $user_start_time );
                    $this->time_taken = $server_end_time->getTimestamp() - $server_start_time->getTimestamp();
                    //echo  $time_taken->format("%H:%I:%S");
                    return true;
                }
            }
        }
        return false;
    }

    public function validate_user_answers( $raw_user_answers = null ){

        if( !is_array( $raw_user_answers ) ) {
            return false;
        }

        $user_answers = array();

        //preg match and extaract option suffixes (IDs )
        foreach( $raw_user_answers as $qid => $raw_user_options ){
            if( preg_match( "/^QID-(\d+)$/", $qid, $matches, PREG_OFFSET_CAPTURE ) ) {
                $qid = $matches[1][0];

                foreach( $raw_user_options as $raw_user_option ){
                    if( preg_match( "/^OPID-(\d+)$/", $raw_user_option, $matches, PREG_OFFSET_CAPTURE ) ){

                        $opid = $matches[1][0];

                        //Collect validated and filtered IDs
                        $user_answers[ $qid ][] = $opid;
                    } else {
                        return false;
                    }
                }

            } else {
                return false;
            }
        }

        //return filtered user data
        return $user_answers;
    }
    public function verify_que_origin($qid = null, $quiz_id = null){
        if( isset($qid) and isset( $quiz_id) ){

            //TODO: Verify questions origin
            return true;
        }

        return false;
    }
    public function get_result( $correct_ans_count = null, $total_questions ){
        if( isset($correct_ans_count) and isset( $total_questions ) ){

            $percentage = ($correct_ans_count / $total_questions) * 100;
            $percentage = round( $percentage, 2 );

            $time_taken = ($this->time_taken / $this->duration);
            $points = $percentage + abs( ( ( $time_taken ) * 100 ) - 100 );
            $points = ($points / 2 )*5;

            return array(
                'percentage' => $percentage,
                'points' => $points,
                'max_points' => 500,
                'time_taken' => $this->time_taken
            );
        }

        return false;
    }
    public function finish_quiz( $quiz_report_id, $user_start_time_epoch, $server_end_time, $result ){
        if( isset($quiz_report_id) and isset( $user_start_time_epoch )
            and isset( $server_end_time ) and isset( $result )){

            $this->check_db_conn();

            $user_start_time = new DateTime();
            $user_start_time->setTimestamp( intval( substr( $user_start_time_epoch, 0, -3 ) ) );
            $user_start_time = $user_start_time->format('Y:m:d H:i:s');

            $server_end_time = $server_end_time->format('Y:m:d H:i:s');

            $sql = "UPDATE `quiz_report` SET `user_start_time`='{$user_start_time}',`user_end_time`= ".
                " '{$server_end_time}', `is_finished`='Y',`percentage`='{$result['percentage']}',`points`='{$result['points']}' WHERE id = {$quiz_report_id}";

            $result = $this->db_conn->query( $sql );

            if( $result ){

                //Return options rows
                return true;
            }
        }

        return false;
    }

    /**
     * Closes existing db connection
     */
    public function close_db_conn()
    {
        //Close database connection and set db_conn to null
        if($this->db_conn != null){
            $this->db_conn->close();
            $this->db_conn = null;
        }
    }
}

function equal_arrays($arr1, $arr2){
    if(is_array($arr1) and is_array($arr2)){
        if(array_diff($arr1, $arr2) == array_diff($arr2, $arr1)){
            return true;
        }
    }

    return false;
}

//TODO: Add User Registration
//TODO: Implement session expiry after 15 minutes of inactivity
//TODO: Implement logging of user activity - who added what
//TODO: Implement Edit/Remove Categories, Topics and their descriptions
