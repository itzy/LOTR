<div id='tillbaka'><a href="../user">Gå tillbaka</a></div>

<div class='user-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?php echo$this->url->create('')?>">
        <fieldset>
            <legend>Leave a comment</legend>
            <p><label>Comment:<br/><textarea name='content'><?php echo $content?></textarea></label></p>
            <p><label>Name:<br/><input type='text' name='name' value='<?php echo$name?>'/></label></p>
            <p><label>Homepage:<br/><input type='text' name='web' value='<?php echo$web?>'/></label></p>
            <p><label>Email:<br/><input type='text' name='mail' value='<?php echo$mail?>'/></label></p>
            <p class=buttons>
                <input type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?php echo$this->url->create('comment/add')?>'"/>
                <input type='reset' value='Reset'/>
                <input type='submit' class="myButton" name='doRemoveAll' value='Remove all' onClick="this.form.action = '<?php echo$this->url->create('comment/remove-all')?>'"/>
            </p>
            <output><?php echo$output?></output>
        </fieldset>
    </form>
</div>
