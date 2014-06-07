<?php if (isset ($questions)) :
    $thisQuestion = $questions->getProperties();

    $content = $thisQuestion['content'];
    $content = $this->textFilter->doFilter($content, 'shortcode, markdown');
    ?>

    <h1><?php echo $thisQuestion['title'] ?></h1>
    <div id="question-table">
        <a href="<?php echo $this->url->create('questions/vote/' . $thisQuestion['id'] . '/' . 'up') ?>"><span
                class="upvote"><i class="fa fa-chevron-circle-up fa-3x"></i></span></a>

        <?php if ($thisQuestion['points'] >= '0') {
            ?><span class="goodvote"><?php echo $thisQuestion['points'] ?></span>
        <?php
        } else if ($thisQuestion['points'] < '0') {
            ?><span class="badvote"><?php echo $thisQuestion['points'] ?></span>
        <?php
        }

        ?>

        <a href="<?php echo $this->url->create('questions/vote/' . $thisQuestion['id'] . '/' . 'down') ?>"><span
                class="downvote"><i class="fa fa-chevron-circle-down fa-3x"></i></span></a>
        <?php echo $content ?><br>

            <span class="right-question">Asked by
                <?php

                if ($userExists) {
                    ?>
                    <a href="<?php echo $this->url->create('users/acronym/') ?>/<?php echo $thisQuestion['acronym'] ?>"><?php echo $thisQuestion['acronym'] ?></a>
                <?php } else { ?>
                    <?php echo $thisQuestion['acronym'] ?>
                <?php } ?>
                <br>
            Created: <?php echo $thisQuestion['created'] ?><br>
                Tags:
                <?php
                foreach ($thisQuestion['tags'] as $tag) {
                    ?>
                    <?php echo $tag; ?>,
                <?php } ?><br>

        <form id="questionComment" name="questionComment" method="post" action=" ">
            <input type="hidden" name="q_id" value="<?php echo $thisQuestion['id'] ?>">
            <textarea name="content" id="content" cols="30" rows="2"></textarea>
            <input class="myButton" type="submit" name="questionComment" id="questionComment" value="Comment"
                   onClick="this.form.action = '<?php echo $this->url->create('questions/addQuestionComment/') ?>'"/>
        </form>
                <?php if (count($questionComments) > 0) {
                    echo '<button class="toggleComments">Show comments</button>';
                }?>
                <div class="containerofquestions">
                    <?php foreach ($questionComments as $questionComment) :

                        echo "<div class='questionC'>$questionComment->content";
                        echo "<i class='posted'>" . $questionComment->created . "</i></div>";

                    endforeach;?>
                </div>
</span>

    </div>
    <?php foreach ($answers as $answer) :
    if ($answer->thumbs >= 20) {

        echo "<div id='accepted'><h2>Accepted as best answer:</h2>";
        echo "<span class='goodvote'><i class='fa fa-check fa-2x'></i>$answer->thumbs</span>$answer->content";?>
        <span class="right-answer">
                Answer by: <a
                href="<?php echo $this->url->create('users/acronym/') ?>/<?php echo $answer->acronym ?>"><?php echo $answer->acronym ?></a><br>
                <i class="posted">Created: <?php echo $answer->created ?></i><br>

        </span></div>
        <?php
        break;
    }
endforeach;?>

    <h1>Answers:</h1>

    <?php foreach ($answers as $answer) :


    $questionId = $thisQuestion['id'];
    ?>


    <a href="<?php echo $this->url->create('questions/voteAnswer/' . $answer->question_id . '/' . $answer->id . '/' . 'up') ?>"><span
            class="upvote"><i class="fa fa-thumbs-o-up fa-2x"></i></span></a>

    <?php if ($answer->thumbs >= '0') {
    ?><span class="goodvote"><?php echo $answer->thumbs ?></span>
<?php
} else if ($answer->thumbs < '0') {
    ?><span class="badvote"><?php echo $answer->thumbs ?></span>
<?php
}

    ?>
    <a href="<?php echo $this->url->create('questions/voteAnswer/' . $answer->question_id . '/' . $answer->id . '/' . 'down') ?>"><span
            class="downvote"><i class="fa fa-thumbs-o-down fa-2x"></i></span></a>

    <?php
    $answercontent = $answer->content;

    $answercontent = $this->textFilter->doFilter($answercontent, 'shortcode, markdown');?>
    <div id="answer-table">

        <?php echo $answer->content; ?>
        <span class="right-answer">
        Answer by: <a
                href="<?php echo $this->url->create('users/acronym/') ?>/<?php echo $answer->acronym ?>"><?php echo $answer->acronym ?></a><br>
        <i class="posted">Created: <?php echo $answer->created ?></i><br>
                   <form id="answerComment" name="answerComment" method="post" action=" ">
                       <input type="hidden" name="a_id" value="<?php echo $answer->id ?>">
                       <input type="hidden" name="q_id" value="<?php echo $answer->question_id ?>">
                       <textarea name="content" id="content" cols="30" rows="2"></textarea>
                       <input class="myButton" type="submit" name="answerComment" id="answerComment" value="Comment"
                              onClick="this.form.action = '<?php echo $this->url->create('questions/addAnswerComment/') ?>'"/>
                   </form>
            <?php if (count($answerComments) > 0) {
                echo '<button class="toggleComments">Show comments</button>';
            }?>
            <div class="containerofquestions">
                <?php foreach ($answer->comments as $questionComment) :

                    echo "<div class='questionC'>$questionComment->content";
                    echo "<i class='posted'>" . $questionComment->created . "</i></div>";

                endforeach;?>
            </div>
        </span>
        <br>
        <hr>
    </div>

<?php endforeach;

    if ($this->session->get('logged_in') == true) {
        ?>
        <form method="post" class="profileForm">
            <input type="hidden" name="q_id" value="<?php echo $thisQuestion['id'] ?>">

            <p><label><?php echo $this->session->get('user_info')['acronym']; ?>: </label><textarea
                    name="content"></textarea></p>

            <p><input class="myButton" type="submit" value="Submit answer" name="doAnswer"
                      onClick="this.form.action = '<?php echo $this->url->create('questions/addAnswer/') ?>'"></p>
        </form>
    <?php
    }

endif;?>