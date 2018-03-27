(function ($) {
    "use strict"; // Start of use strict

    /* ---------------------------------------------
     Functions
     --------------------------------------------- */
    var mainNav = $('.main-nav'),
        mobileNavBtn = mainNav.find('.mobile-nav'),
        innerNav = mainNav.find('.inner-nav');
    
    function init_header() {
        
        mobileNavBtn.click(function(e){
            if(innerNav.hasClass('opened')){
                innerNav.slideUp('slow').removeClass('opened');
            }else{
                innerNav.slideDown('slow').addClass('opened');
            }
        });
        
        if( $(window).width() <= 768){
            innerNav.hide();
        }
    }
    
    /* --------------------------------------------
     Platform detect
     --------------------------------------------- */
    var mobileTest;
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
        mobileTest = true;
        $("html").addClass("mobile");
    }
    else {
        mobileTest = false;
        $("html").addClass("no-mobile");
    }
    
    var mozillaTest;
    if (/mozilla/.test(navigator.userAgent)) {
        mozillaTest = true;
    }
    else {
        mozillaTest = false;
    }
    var safariTest;
    if (/safari/.test(navigator.userAgent)) {
        safariTest = true;
    }
    else {
        safariTest = false;
    }
    
    // Detect touch devices    
    if (!("ontouchstart" in document.documentElement)) {
        document.documentElement.className += " no-touch";
    }
    
    
    function init_header_resize() {
        $('.js-stick').each(function (indx, ele) {
            $(ele).parent(".sticky-wrapper").height($(ele).height());
        });
        
        if($(window).width() > 768){
            innerNav.show();
        }
    }
    
    function init_grids() {
        $(".mason-grid").masonry({
            itemSelector: '.mason-grid-item'
        });
    }
    
    function update_masonry(){
        $(".mason-grid").masonry({
            itemSelector: '.mason-grid-item'
        });
    }
    
    function init_elements() {
        
        //Add Events to clickable elements
        $('.anchor').each(function(indx, ele){
            $(this).click(function(){
                window.location = $(this).data('url'); 
            });
        });
    }
    
    function timeFormat(ms) {
		var days = (ms / 86400000);
		var hours = ((days % 1) * 24);
		var minutes = ((hours % 1) * 60);
		var seconds = ((minutes % 1) * 60);
		var milliseconds = ((seconds % 1) * 1000);
		
		if(milliseconds < 0 || seconds < 0 || minutes < 0 || hours < 0 || days < 0) {
			
			clearInterval(intervalID);
			days = 0;
			hours = 0;
			minutes = 0;
			seconds = 0;
			milliseconds = 0;
		}
		
		return {
			days: String(Math.floor(days)).strPadLeft(3,'0'), 
			hours: String(Math.floor(hours)).strPadLeft(2, '0'),
			minutes: String(Math.floor(minutes)).strPadLeft(2, '0'),
			seconds: String(Math.floor(seconds)).strPadLeft(2, '0'),
			milliseconds: String(Math.floor(seconds)).strPadLeft(3, '0')
		};
	}
    
    function init_quiz() {
        
        //Question Navigation
        $("ul.item-wrap").owlCarousel({
            
//            animateOut: 'slideOutLeft',
//            animateIn: 'slideInRight',
//            animateOut: 'bounceOutLeft',
//            animateIn: 'bounceInRight',
//            animateOut: 'flipOutX',
//            animateIn: 'flipInX',
            
            margin: 10,
            touchDrag: false,
            mouseDrag: false,
            pullDrag: false,
            loop: false,
            autoHeight: true,
            items: 1
        });
        
        var queSection = $('#questions-section'),
            duration = queSection.data('duration'),
            quizReportId = queSection.data('quiz-report-id'),
            queStatus = $('#question-status'),
            timeStatus = $('#time-status'),
            quizProgBar = $('#quiz-progress'),
            nextQueBtn = queSection.find('.que-next'),
            prevQueBtn = queSection.find('.que-prev'),
            startQuizBtn = queSection.find('#start-quiz'),
            finishQuizBtn = queSection.find('#quiz-finish'),
            reviewQuizBtn = queSection.find('#quiz-review'),
            owl = queSection.find('.owl-carousel').owlCarousel(),
            questions =  queSection.find('.question-item'),
            allInputs = questions.find("input[type='radio'], input[type='checkbox']"),
            queCount = questions.length,
            quizResult = queSection.find('.quiz-result'),
            countDown = queSection.find('.countdown span'),
            allUserAnswerInputs = null,
            allUserAnswerIDs = new Array(),
            startTime = null,
            endTime = null,
            maxQuizTime = null,
            timeLeftItrvl = null,
            quizFinish = false,
            quizProgress = 0,
            currQueIndex = 0,
            userAnswers = {},
            countDownValue = 5,
            currQuestion;
        
        function navQuestion(direction, e) {
            
            //Get User Input data from recent question
            if (!quizFinish) {          
                collectUserInputs();
            }
            
            //move to other question
            if( direction == 'next' ){
                
                //Increment Index and show next question
                currQueIndex++;
                owl.trigger('next.owl.carousel');
            } else {
                
                //Decrement Index and show previous question
                currQueIndex--;
                owl.trigger('prev.owl.carousel');
            }
            
            //set currQuestion to current question html element
            currQuestion = questions.eq( currQueIndex - 1 );
            
            //Update Question Status
            updateQuizStatus();
        }
        
        function collectUserInputs(){
            //Get All checked input html elements from current question 
            var userAnswerInputs = currQuestion.find("input:checked");
            
            userAnswers[ currQuestion.attr('id') ] = {};
            userAnswerInputs.each(function(indx){
                //collect option id and question id from this input element
                userAnswers[ $(this).attr('name') ][ indx ] = $(this).attr('id');
            });
        }
        
        function updateQuizStatus(){
            queStatus.html( currQueIndex + " of " + queCount );
            questions.removeClass("current");
            currQuestion.addClass("current");
            
            if(!quizFinish){
                quizProgress = (currQueIndex / queCount) * 100; 
                quizProgBar.attr('aria-valuenow', quizProgress);
                quizProgBar.css('width', quizProgress + '%');
            }
        }
        
        function quizTimer() {
            //Remaining time for quiz finish
            var timeleft = maxQuizTime - (new Date).getTime();
            if(timeleft <= 0 && !quizFinish){
                clearInterval(timeLeftItrvl);
                finishQuiz( (new Date).getTime() );
            }
            
            //Update Time Status
            timeStatus.html( 
                timeFormat(timeleft).hours + ':' +
                timeFormat(timeleft).minutes + ':' + 
                timeFormat(timeleft).seconds );
        }
        
        function startQuiz(time) {
            owl.trigger('next.owl.carousel');
            
            startTime = new Date(time);
            
            //get remaining hours, minutes, seconds
            var durationPieces = duration.split(':');
            var hours = parseInt(durationPieces[0]);
            var minutes = parseInt( durationPieces[1] );
            var seconds = parseInt( durationPieces[2] );
            
            //get maxQuizTime by adding duration to quiz start time
            maxQuizTime = new Date( startTime.getTime() );
            maxQuizTime.setHours(maxQuizTime.getHours() + hours);
            maxQuizTime.setMinutes(maxQuizTime.getMinutes() + minutes);
            maxQuizTime.setSeconds(maxQuizTime.getSeconds() + seconds);
        
            //init timer
            timeLeftItrvl = setInterval( quizTimer, 1000);
            
            //start quiz
            currQueIndex = 1;
            currQuestion = questions.eq(currQueIndex - 1);

            //Update Question Status
            updateQuizStatus();
        }
        
        var points = 0;
        $('#canvas-progress').circleProgress({
            value: 0,
            size: 150,
            lineCap: 'round',
            fill: {
                color: '#31cc71',
            }
        }).on('circle-animation-progress', function(event, progress) {
            $(this).find('strong').html(parseInt(points * progress));
        });
        
        function submitAjaxHandler( data ){
 
//            quizResult.prepend('<pre>'+data+'</pre>');
            
            //Prepare js obj from server response json string
            var resultObj = JSON.parse(data);
            
            if( resultObj.type == 'success' ){
                
                //uncheck all inputs
                allInputs.prop('checked', false);
                //Remove Disabled
                allInputs.prop('disabled', false);
                
                //If user answers doesn't exist in correct options mark them wrong
                var correctOptions = $.map(resultObj.result['correct_options'], function(value, indx) {
                    return [value];
                });

                var wrongUserOptions = $(allUserAnswerIDs).not(correctOptions);
                $.each(wrongUserOptions, function(indx, val){
                    $('#' + val ).parent('li.option-item').addClass('checked red');
                });
                
                //mark correct inputs to checked
                $.each(resultObj.result['correct_options'], function(indx, val){
                    $( '#' + val ).prop('checked', true);
                });
                
                //underline all user options
                $.each(allUserAnswerIDs, function(indx, val){
                    $('#' + val ).siblings('label').css({
                        'text-decoration': 'underline',
                        'text-decoration-style': 'dotted'
                    });
                });

                //Disable All input elements
                allInputs.prop('disabled', true);
                owl.trigger('update.owl.carousel');
                owl.trigger('to.owl.carousel', queCount + 1);
                
                var result = resultObj.result;
                
                var timeTaken = timeFormat( result.timetaken * 1000 );
                
                //set time taken
                $("#quiz-result").find('.result-left:eq(0) span')
                    .text( timeTaken.minutes + 'mins ' + timeTaken.seconds + 'secs' );
                
                //set total correct answers
                $("#quiz-result").find('.result-left:eq(1) span').text( result.rightAnsCount );
                
                //set percentage
                $("#quiz-result").find('.result-left:eq(2) span').text( result.percentage + '%' );
                
                //set score
                $("#quiz-result").find('.result-right:eq(2) span').text( Number(result.points).toFixed(1) );
                
                //set unaswered
                $("#quiz-result").find('.result-right:eq(1) span').text( result.unaswered );
                
                $("#quiz-result").find('.result-right:eq(0) span').text( result.averageTime + 'secs' );
                
                
                points = result.points;
                
                setTimeout(function(){
                    $('#canvas-progress').circleProgress('value', points / 500);
                    $('#quiz-result').addClass('show');
                }, 600);
                
            }else{
                alert(resultObj.text);
            }

        }
        
        function finishQuiz(time) {
            if( quizFinish ){
                owl.trigger('to.owl.carousel', queCount + 1);
            }
            
            if( !quizFinish ){
                
                endTime = new Date( time );
                //Get User Input data from final question
                collectUserInputs();
                
                //disable all answer inputs
                allInputs.prop('disabled', true);
                quizFinish = true;
                
                //Get All checked input html elements from all question 
                var allUserAnswerInputs = questions.find("input:checked");
                allUserAnswerInputs.each(function(indx){
                    //collect option id and question id from this input element
                    allUserAnswerIDs[ indx ]= $(this).attr('id');
                });

                //ajax submit (if error show dialog and reload page to restart)
                $.ajax( './evaluate.php', {
                    method: "POST",
                    data: {
                        'type' : 'submit',
                        'starttime' : startTime.getTime(),
                        'endtime' : endTime.getTime(),
                        'quizReportId' : quizReportId,
                        'userAnswers' : userAnswers
                    },
                    success: submitAjaxHandler
                });
                
                //mark Right and wrong options
                //Manage Pop Ups and their Buttons
                //show result
            }
        }
        
        //star quiz either after 5 seconds or on clicking start button
        var countDownItrvl = setInterval(function(){
            countDown.html(--countDownValue);
            if( countDownValue == 0 ){
                startQuiz( (new Date).getTime() );
                clearInterval( countDownItrvl );
            }
        }, 1000);
        
        startQuizBtn.click(function (e) {
            //start new quiz with current time
            startQuiz( (new Date).getTime() );
            // Stop Countdown for starting quiz
            clearInterval( countDownItrvl );
        });
        
        //Attach Events to question nav buttons
        prevQueBtn.click(function (e) {
            navQuestion('prev', e);
        });
        
        nextQueBtn.click(function (e) {
            navQuestion('next', e);
        });
        
        finishQuizBtn.click(function (e) {
            //stop quiz timer
            clearInterval(timeLeftItrvl);
            //finish quiz with current time
            finishQuiz( (new Date).getTime() );
        });
        
        reviewQuizBtn.click(function(e){
            owl.trigger('to.owl.carousel', 1);
            
            //reset to first question for reviewing
            currQueIndex = 1;
            currQuestion = questions.eq( currQueIndex - 1 );
            updateQuizStatus();
        });
        
        //Remove events and hide starting prev and ending next navigation buttons 
        questions.eq(0).find('a.que-prev').off().css('visibility', 'hidden');
        quizResult.find('a.que-next').off().css('visibility', 'hidden');

    }
    
    
    function init_home() {
        
        //Add Topic Management
        var categorySec = $('#categories'),
            categories = categorySec.find('.category-box');
        
        //Listen for bubbling events on category's parent
        categorySec.delegate( '.add-topic', 'click', (function(e){
            
            //if the addtopic anchor is active
            if($(this).hasClass('active')){
                
                var inputEle = '<input type="text" placeholder="Type Here">';
                
                //insert input element to category box before this button
                $(this).before( inputEle );
                
                //remove active class and add submit class and text
                $(this).removeClass('active').addClass('submit').text('submit');
                
                //update grids
                update_masonry();
            } else 
                if($(this).hasClass('submit') && !$(this).hasClass('prog')){
                    
                    //Get Input value
                    var topicName = $(this).siblings('input').val();
                    
                    //Get Category Id
                    var categoryId = $(this).parent('.category-box').data('id');
                    
                    //topics list - category-menu
                    var categoryMenu = $(this).siblings('.category-menu');
                    
                    //submit and add prog class
                    $(this).addClass('prog');
                    
                    $.ajax( './add.php', {
                        method: "POST",
                        data: {
                            'type' : 'topic',
                            'topic_name' : topicName,
                            'category_id' : categoryId
                        },
                        success: function(data){
                            //Prepare js obj from server response json string
                            var resultObj = JSON.parse(data);
                            
                            //if success create topic list element with ajax resp and append to topic list
                            if( resultObj.type == 'success' ){
                                categoryMenu.append( resultObj['new_topic'] );
                                
                            } else if ( resultObj.type == 'error' ) {
                                alert( resultObj.text );
                            }
                            
                            //remove input element and prog class and add active
                            categoryMenu.siblings('a').removeClass('submit prog').addClass('active').text('Add Topic').siblings('input').remove();
                            
                            //update grids
                            update_masonry();
                        }
                    });
                    

                    
                    
                }
            
        }));
        
        //Add Category Management
        var addCatBtn = $('#add-category.active');
        
        //Category box ele
        var catBox = $( '<div class="mason-grid-item">' + 
                        '<div class="category-box" data-id="5">' +
                            '<input type="text" class="category-name" placeholder="Enter Title">' +
                            '<a href="javascript:void(0)" class="add-topic active hidden">Add Topic</a>' +
                            '<a href="javascript:void(0)" class="submit-category">Submit</a>' +
                        '</div>' +
                    '</div>' );
        
        
        //on addCatBtn click 
        addCatBtn.click(function(e){
            
            //create a category box clone and insert into category section's mason grid
            var newCatBox = catBox.clone();
            
            $(".mason-grid").masonry({
                itemSelector: '.mason-grid-item'
            }).append(newCatBox).masonry( 'appended', newCatBox );
            
            //on submit btn click
            newCatBox.find('.submit-category').click(function(){
                
                var newCategoryBox = $(this).parent('.category-box');
                
                //collect input element's value
                var newCategoryName = $(this).siblings('input').val();
                
                //add prog class to this anchor to show cursor progress
                $(this).addClass('prog');

                //send ajax
                $.ajax( '/add.php', {
                    method: "POST",
                    data: {
                        'type' : 'category',
                        'category_name' : newCategoryName
                    },
                    success: function (data) {
                        //Prepare js obj from server response json string
                        var resultObj = JSON.parse(data);

                        //on success add data-id to category box from ajax response
                        if( resultObj.type == 'success' ){
                            //remove input and submit-category anchor
                            newCategoryBox.find('.submit-category, input').remove();
                            
                            //show hidden add-topic anchor
                            newCategoryBox.find('a.add-topic').removeClass('hidden');
                            
                            //set title of category box
                            newCategoryBox.prepend('<h3 class="category-heading">'+ newCategoryName +'</h3>');
                            
                            //add data id to category box
                            newCategoryBox.data('id', resultObj.new_category_id );
                            
                        } else if ( resultObj.type == 'error' ){
                            //on error show error
                            alert( resultObj.text );
                            
                            //remove entire category-box
                            newCategoryBox.remove();
                        }
                    }
                });
                
            });
            
        });
        
        

        
        //TODO: Add Enter event to submit - shortcut
    }
    
    function init_edit_quiz(){
        //TODO: edit quiz
    }
    
    function init_add_quiz(){
        
        //Question Navigation
        $("ul.item-wrap").owlCarousel({
            
//            animateOut: 'slideOutLeft',
//            animateIn: 'slideInRight',
//            animateOut: 'bounceOutLeft',
//            animateIn: 'bounceInRight',
//            animateOut: 'flipOutX',
//            animateIn: 'flipInX',
            
            margin: 10,
            touchDrag: false,
            mouseDrag: false,
            pullDrag: false,
            loop: false,
            autoHeight: true,
            items: 1
        });
        
        //Get elements
        var questionsSection = $('#questions-section.edit-mode'),
            owl = questionsSection.find('ul.item-wrap').owlCarousel(),
            quizProgBar = $('#quiz-progress'),
            queStatus = $('#question-status'),
            timeStatus = $('#time-status'),
            statusBar = $('#status-bar'),
            quizMeta = questionsSection.find('.quiz-meta'),
            quizCategorySelect = questionsSection.find('#quiz-category'),
            quizTopicSelect = questionsSection.find('#quiz-topic'),
            totalQuestionsInput = questionsSection.find('#total-questions'),
            questionItems = questionsSection.find('li.question-item'),
            quizEditResult = questionsSection.find('li.quiz-edit-result'),
            currQueIndex = 0;
        
        //Get Anchors
        var quizMetaNextBtn = quizMeta.find('a.que-next'),
            queNavNextBtns = questionItems.find('a.que-next'),
            queNavPrevBtns = questionItems.find('a.que-prev');
            
        //Variables
        var currQueItemsCount = questionItems.length;
        
        //assign a new id for each question item like TQID-1
        //foreach questionItem basing on id, set ids on options and inputs
        questionItems.each(function(indx, ele){
            var newId = indx+1;
            var questionItem = $(this);
            
            setQuestionMeta( $(this), newId );
        });
        
        //on change of category, fetch new topics of it and update meta
        quizCategorySelect.change(function(){
            
            var categoryId = $(this).val();
            
            $.ajax('/get.php', {
                type: 'POST',
                data: {
                    'type': 'topics',
                    'cid': categoryId
                },
                success: function( data ){
                    var topics = JSON.parse(data);
                    
                    //remove all options from topic selector
                    quizTopicSelect.empty();
                    
                    $.each(topics, function(indx, option){
                        var newOption = $( '<option>' ).val( option.topic_id ).text( option.topic );
                        quizTopicSelect.append( newOption );
                    });
                }
            });
            
        });
        
        //on change of totalquestion val
        totalQuestionsInput.change(function(e){
            var value = $(this).val();
            
            if( value < 4 ){
                alert('Minmum of 4 question are required for a quiz!')
                $(this).val(4);
                return false;
            }
        });
        
    
        quizMetaNextBtn.click(function(e){
            
            //Get Meta Fields
            var category = quizCategorySelect.find('option:selected').text(),
                topic = quizTopicSelect.find('option:selected').text(),
                quizName = $('#quiz-name').val(),
                duration = $('#duration').val(),
                totalQuestions = $('#total-questions').val();
            
            //TODO: if these fields are empty show error and prevent next
            
            var proceed = true;
            if($('#total-questions').val().length == 0 
               || $('#duration').val().length == 0 
               || $('#quiz-name').val().length == 0){
                proceed = false;
                alert("All these fields are mandatory");
            }

            if( proceed ){
                
            
            //if all meta information is filled
                //remove hidden class
                statusBar.find('a.category').text( category );
                statusBar.find('a.topic').text( topic );
                statusBar.find('span.name').text( quizName );
                timeStatus.text( duration );
                statusBar.find('.breadcrumbs').removeClass('hidden');
            
            
                //add or remove quesionItems based on totalQuesitons and currQueItemsCount
                var count = totalQuestions - currQueItemsCount;
            
                if( count > 0 ){
                    //add new Question Items at last
                    for(var i = 0; i < count; i++){
                        owl.trigger('add.owl.carousel', [createQuestionItem(), -1]);
                        owl.trigger('refresh.owl.carousel');
                    }
                }else{
                    //remove question items from last
                    for(var i = 0; i < Math.abs(count); i++){
                        currQueItemsCount--;
                        questionsSection.find('li.question-item').last().remove();
                    }
                }
                currQueIndex = 0;
                currQueIndex++;
                //update status bar
                updateQuizStatus();
            
                //make last question next btn as submit or finish
                //id="quiz-edit-finish" class="quiz-edit-finish"
                $('li.question-item:eq(-1) .que-next').attr('id', 'quiz-edit-finish').addClass('quiz-edit-finish').removeClass('que-next').find('span').contents().first()[0].textContent = 'Submit ';
            
                //move to editing questions
                owl.trigger('next.owl.carousel');
            }
        });
        
        
        //question navigation next
        questionsSection.delegate('li.question-item a.que-next', 'click', function(e){
            
            //Traverse question item
            var questionItem = $(this).closest('li.question-item');
            
            if( validateQuestionItem(questionItem) ){
                currQueIndex++;
                updateQuizStatus();
                owl.trigger('next.owl.carousel');
            }else{
                alert('Please fill all the required fields to continue');
            }
        });
        
        //Validates input fields of question item and alerts
        function validateQuestionItem(questionItem){
            var proceed = true;
            //check whether all inputs are filled else alert and prevent next
            if(questionItem.find('textarea').val().length == 0){
                proceed = false;
            }
            
            //check questio-type single or multiple checked
            if(questionItem.find('.question-type input:checked').length == 0){
//                alert('Please choose a question type to move next');
                proceed = false;
            }
            //check all options are filled
            $.each(questionItem.find('.options input[type="text"]'), function(){
                if($(this).val().length == 0){
                    proceed = false;
                }
            })

            //check one of them is checked
            if(questionItem.find('.options input:checked').length == 0){
                proceed = false;
            }
            
            return proceed;
        }
        
        //question navigation previous
        questionsSection.delegate('li.question-item a.que-prev', 'click', function(e){
//            quizNavigate('prev', e);
            //if prev btn is from first question-item don't decrement
            if(currQueIndex != 1){
                
                currQueIndex--;
            }
            updateQuizStatus();    
            owl.trigger('prev.owl.carousel');
        });
        
        //Finsh Editing - submit
        questionsSection.delegate('li.question-item:eq(-1) .quiz-edit-finish', 'click', function(e){
            //Traverse question item
            var questionItem = $(this).closest('li.question-item');
            
            if( validateQuestionItem( questionItem ) ){
                
                //Get Meta Fields
                var category = quizCategorySelect.find('option:selected').text(),
                    topic = quizTopicSelect.find('option:selected').text(),
                    topicId = quizTopicSelect.find('option:selected').val(),
                    quizName = $('#quiz-name').val(),
                    duration = $('#duration').val(),
                    totalQuestions = $('#total-questions').val();


                //collect data from inputs of all questions
                var questionItems = $('#questions-section').find('li.question-item');
                
                var questions = {};
                
                $.each(questionItems, function(e){
                    
                    var textAreaInput = $(this).find('textarea').val(),
                        isMultiAnswerQue = $(this).find('.question-type input:checked').val(),
                        options = new Array(),
                        correctOpts = new Array();
                    
                    $.each($(this).find('.options input[type="text"]'), function(indx){
                        options[ indx ] = $(this).val();
                        if( $(this).closest('li.option-item').children('input').is(":checked") ){
                            correctOpts[indx] = $(this).val();
                        }
                    });
                    
                    questions[ textAreaInput ] = {
                        'multiple_answers': isMultiAnswerQue,
                        'options': options,
                        'correct': correctOpts
                    }
                });
                
                //TODO: Prevent Multiple submissions by adding progress class
                
                //submit and get response
                $.ajax( '/addquiz.php', {
                    type: 'POST',
                    data: {
                        'type': 'quiz-submit',
                        'topic_id': topicId,
                        'quiz_name': quizName,
                        'total_questions': totalQuestions,
                        'duration': duration,
                        'questions': questions
                    },
                    success: function( data ){
                        $('#quiz-edit-result').prepend('<pre>' + data + '</pre>');
                        
                        var resultObj = JSON.parse(data);
                        owl.trigger('next.owl.carousel');
                    }
                });
                
            } else {
                alert('Please fill all the required fields to submit');
            }
        });
        
        
        //choose single or multiple answers option
        questionsSection.delegate( '.question-type label', 'click', function(){
            var inputType = $(this).siblings('input').data('val');
            
            //Toggle Radios / Chekboxes
            if( inputType == 'radio' ){
                $(this).closest('.question-item').find('.options li')
                    .addClass('radio')
                    .removeClass('checkbox')
                    .children('input[type="checkbox"]').attr('type', inputType);
            }else{
                $(this).closest('.question-item').find('.options li')
                    .addClass('checkbox')
                    .removeClass('radio')
                    .children('input[type="radio"]').attr('type', inputType);
            }
            
        });
        
        //add option
        questionsSection.delegate( '.add-option a', 'click', function(){
            
            var questionItem = $(this).closest('.question-item');
            var count = questionItem.data('option-count');
            
            if( count == 6 ){
                alert('Maximum options limit reached.');
                return false;
            }
            
            //clone a current option and append by clearing input
            var newOption = questionItem.find('li.option-item').eq(0).clone();
            
            newOption.find('input[type="text"]').val('');
            
            var newOptId = questionItem.data('quetempid') + '-' + (count+1);
            newOption.children('input').attr('name', questionItem.data('quetempid'));
            newOption.children('input').eq(0).attr('id', newOptId );
            newOption.children('label').eq(0).attr('for', newOptId );
            //newOption.find('input[type="text"]').attr('tabindex', count+1);
            questionItem.data('option-count', count + 1);
            
            //append to list
            $(this).parent('.add-option').before( newOption );
            
            //update carousel
            owl.trigger('refresh.owl.carousel');
        });
        
        //remove option
        questionsSection.delegate( '.rm-opt', 'click', function(){
            
            //count current options
            var optionsCount = $(this).closest('.options').find('li.option-item').length;
            
            if( !(optionsCount <= 2) ){
                //decrement option count data of parent
                var questionItem = $(this).closest('.question-item');
                var count = questionItem.data('option-count');
                questionItem.data('option-count', count - 1 );
                
                //remove element
                $(this).parent('li').remove();
                
            } else {
                alert('Minimum of 2 options are required');
            }
            
            //update carousel
            owl.trigger('refresh.owl.carousel');
        });
        
        //Quiz Edit Navigation
        function quizNavigate(direction, e){
            
            //Check User Input data from recent question else prevent nav
            
            //move to other question
            if( direction == 'next' ){
                
                //Increment Index and show next question
                currQueIndex++;
                owl.trigger('next.owl.carousel');
            } else {
                
                //Decrement Index and show previous question
                currQueIndex--;
                owl.trigger('prev.owl.carousel');
            }
            
            //Update Question Status
            updateQuizStatus();
        }
        
        //it creates a clone of first question item in the list and cleans it
        function createQuestionItem(){
            var newQuestionItem = questionsSection.find('.question-item').eq(0).clone();
            
            currQueItemsCount++;
            setQuestionMeta(newQuestionItem, currQueItemsCount);
            return newQuestionItem;
        }
        
        //sets ids, names and required attributes for new questionItem
        function setQuestionMeta(questionItem, newId){
            
            questionItem.data('quetempid', 'TQID-' + newId);
            questionItem.data('option-count', 0);
            
            var queTypeInpts = questionItem.find('.question-type input');
            
            queTypeInpts.eq(0).attr({
                'id': 'TQID-' + newId + '-single',
                'name': 'TQID-' + newId + '-type'
            });
            queTypeInpts.eq(0).siblings('label').attr('for', 'TQID-' + newId + '-single' );
            queTypeInpts.eq(1).attr({
                'id': 'TQID-' + newId + '-multiple',
                'name': 'TQID-' + newId + '-type'
            });
            queTypeInpts.eq(1).siblings('label').attr('for', 'TQID-' + newId + '-multiple' );
            
            //foreach option of this question set set ids
            var optItems = questionItem.find('ul.options li.option-item');
            
            optItems.each(function(indx, ele){
                var newOptId = questionItem.data('quetempid') + '-' + (indx+1);
            
                $(this).children('input').attr('name', questionItem.data('quetempid'));
                $(this).children('input').attr('id', newOptId );
                $(this).children('label').eq(0).attr('for', newOptId );
                //$(this).find('input[type="text"]').attr('tabindex', indx+1)
                questionItem.data('option-count', questionItem.data('option-count') + 1);
            });
        }

        function updateQuizStatus(){
            queStatus.html( currQueIndex + " of " + currQueItemsCount );
            
            if(true){
                var quizProgress = (currQueIndex / currQueItemsCount) * 100; 
                quizProgBar.attr('aria-valuenow', quizProgress);
                quizProgBar.css('width', quizProgress + '%');
            }
        }
    }
    
    function init_typeit() {
        $('#home .typedjs').typed({
            strings: ["Welcome To Quizzy.", 
                      "Now you can enhance your knowledge", 
                      "Test your skills", 
                      "Compete with your fellows", 
                      "And its completely free", 
                      "Are you ready to take a challenge ?"],
            typeSpeed: 50,
        });
    
    }
    
    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */
    $(window).load(function () {
        //TODO: Manage page loader
        //Page loader
        $(".page-loader div").delay(300).fadeOut();
        $(".page-loader").delay(600).fadeOut("slow");
        
        //Manage Scroll Functions      
        
        //Hash menu forwarding
        if (window.location.hash){
            var hash_offset = $(window.location.hash).offset().top;
            $("html, body").animate({
                scrollTop: hash_offset
            });
        }
    });
    
    $(document).ready(function () {
        init_header();
        init_grids();
        init_elements();
        init_header_resize();
        init_home();
        if (window.location.pathname == '/quiz.php' || 
            window.location.pathname == '/quiz.html') {
            init_quiz();
        }
        if( window.location.pathname == '/addquiz2.html' ||
           window.location.pathname == '/addquiztest.html' ||
            window.location.pathname == '/addquiz.php' ){
            init_add_quiz();
        }
        init_typeit();
    });
    
    $(window).resize(function () {
        init_header_resize();
    });
    
})(jQuery);

String.prototype.strPadLeft = function(padLength, padString){
    var padding = '';
    for(var i = 0; i < padLength; i++) padding+=padString;
    return String(padString+this).slice(-padLength);
}
