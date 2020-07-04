<style type="text/css">

    <?php
    $quiz_settings = array(
        'quiz_question_background'  =>  get_option('lds_quiz_bg'),
        'quiz_question_text'        =>  get_option('lds_quiz_txt'),
        'quiz_question_correct_text'        =>  get_option('lds_quiz_correct_txt'),
        'quiz_question_correct_background'  =>  get_option('lds_quiz_correct_bg'),
        'quiz_question_incorrect_text'      =>  get_option('lds_quiz_incorrect_txt'),
        'quiz_question_incorrect_background'    =>  get_option('lds_quiz_incorrect_bg'),
    );

    if( $quiz_settings['quiz_question_correct_background'] && $quiz_settings['quiz_question_correct_background'] != '' ): ?>

        .learndash-wrapper .wpProQuiz_correct {
            border: 0;
            background-color: <?php echo $quiz_settings['quiz_question_correct_background']; ?>;
        }

    <?php
    endif;
    if( $quiz_settings['quiz_question_correct_text'] && $quiz_settings['quiz_question_correct_text'] != '' ): ?>

        .learndash-wrapper .wpProQuiz_correct > .wpProQuiz_response,
        .learndash-wrapper .wpProQuiz_correct {
            color: <?php echo $quiz_settings['quiz_question_correct_text']; ?>;
        }

    <?php
    endif;

    if( $quiz_settings['quiz_question_incorrect_background'] && $quiz_settings['quiz_question_incorrect_background'] != '' ): ?>
        .learndash-wrapper .wpProQuiz_incorrect {
            border: 0;
            background-color: <?php echo $quiz_settings['quiz_question_incorrect_background']; ?>;
        }

    <?php
    endif;
    if( $quiz_settings['quiz_question_incorrect_text'] && $quiz_settings['quiz_question_incorrect_text'] != '' ): ?>
        .learndash-wrapper .wpProQuiz_incorrect > .wpProQuiz_response,
        .learndash-wrapper .wpProQuiz_incorrect {
            color: <?php echo $quiz_settings['quiz_question_incorrect_text']; ?>;
        }
    <?php
    endif;

    if( $quiz_settings['quiz_question_background'] && $quiz_settings['quiz_question_background'] != '' ): ?>
        .learndash-wrapper .wpProQuiz_content .wpProQuiz_questionListItem label {
            background-color: <?php echo $quiz_settings['quiz_question_background']; ?>;
        }
    <?php
    endif;
    if( $quiz_settings['quiz_question_text'] && $quiz_settings['quiz_question_text'] != '' ): ?>
        .learndash-wrapper .wpProQuiz_content .wpProQuiz_questionListItem label {
            color: <?php echo $quiz_settings['quiz_question_text']; ?>;
        }
    <?php
    endif; ?>

</style>
