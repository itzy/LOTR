<div id="kontaktform">
<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?php echo $this->url->create('comments')?>">
        <fieldset>
                <legend>Leave a comment</legend>
            <p><label>Namn:*<br/><input type='text' name='name' required value='<?php echo $name?>'/></label></p>
            <p><label>Kommentar:*<br/><textarea name='content' required><?php echo $content?></textarea></label></p>
            <p><label>Email:*<br/><input type='text' name='mail' required value='<?php echo $mail?>'/></label></p>
            <p><label>Hemsida:<br/><input type='text' name='web' value='<?php echo $web?>'/></label></p>

            <p class=buttons>
                <input type='submit' class="myButton" name='addComment' value='Kommentera' onClick="this.form.action = '<?php echo $this->url->create('comment/add')?>'"/>
                <input type='reset' class="myButton" value='Återställ'/>
            </p>
            <output><?php echo $output?></output>
        </fieldset>
    </form>
</div>
</div>