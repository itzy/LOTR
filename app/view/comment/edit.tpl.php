<?php if(is_object($comment)): ?>
<div id="kontaktform">
    <div class='edit-form'>
        <form method=post>
        <input type=hidden name="redirect" value="<?php echo $this->url->create($key) ?>">
            <input type=hidden name="id" value="<?php echo $comment->id?>">
        <input type=hidden name="pageKey" value="<?php echo $key ?>">
        <fieldset>
            <legend>Edit your comment</legend>
            <label>Kommentar:<br><textarea name='content'><?php echo $comment->content?></textarea></label><br>
            <label>Namn:<br><input type='text' name='name' value='<?php echo $comment->name ?>'/></label><br>
            <label>Hemsida:<br><input type='text' name='web' value='<?php echo $comment->web ?>'/></label><br>
            <label>Email:<br><input type='text' name='mail' value='<?php echo $comment->mail ?>'/></label>
            <div class=buttons>
                <input type='submit' class="myButton" name='doSave' value='Spara' onClick="this.form.action = '<?php echo $this->url->create('comment/saveChanges') ?>'"/>
                <input type='reset' class="myButton" value='Återställ'/>
                <input type='submit' class="myButton" name='doCancel' value='Avbryt' onClick="this.form.action = '<?php echo $this->url->create('comments') ?>'"/>
            </div>
            <?php endif?>
        </fieldset>
    </form>
</div>
    </div>
