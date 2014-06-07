<div id='user-form'>
   <h1>New question</h1>

    <?php
    // Include the form
    include('question_form.php');

    $form = str_replace('</form>', '', $form->GetHTML(array('id' => 'form1', 'columns' => 2)));
    $form = str_replace('</fieldset>', '', $form);


        echo $form;

    foreach($tags as $tag) {

        ?>
        <label>
            <?php echo $tag->tag; ?>
            <input type="checkbox" value="<?php echo $tag->id; ?>" name="tags[]">
        </label>
        <?php

        #$tag->tag
    }


    ?>
    <div class="cform-buttonbar">
        <p class="buttonbar">
            <span><input class="myButton" type="submit" value="Submit question" name="add" id="form-element-add"></span>
            &nbsp;
    </p></div>
    <?

    echo '</fieldset>';
    echo '</form>';

    ?>
