<?php if (isset ($tags)) :


    ?>


    <h1>All questions wih <u><?php echo $tag->tag ?></u>-tag</h1>
    <div id="question-table">

        <?php
        if (count($tags) > 0) {
            echo '<ul>';
            foreach ($tags as $taggen) {
                ?>
                <li><a href="<?php echo $this->url->create('questions/id/') ?>/<?php echo $taggen->question_id ?>"><?php echo $taggen->title ?></a></li>
            <?php
            }
            echo '</ul>';
        } else {
            echo 'This tag is not used in any questions.';
        }?>
<?php endif; ?>
