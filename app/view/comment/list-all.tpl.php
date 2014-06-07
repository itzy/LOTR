<?php if (is_array($comments) && !empty($comments)) : ?>

    <h2>Kommentarer</h2>

    <ul class="post-list">
    <li class="post">
    <div class="post-body">
            <?php foreach ($comments as $comment) : ?>
            <?php $thisComment = $comment->getProperties(); ?>

                    <div class="avatar">
                        <img class="avatar" src="../img/bird-pink.png" alt="Avatar">
                    </div>


                        <form method=post>
                            <p class='post-name'><?php echo $thisComment['name']?></p>
                            <p class='post-id'><?php echo $thisComment['content']?></p>
                            <br>
                            <p><div class="text">Email:</div><?php echo $thisComment['mail']?></p>
                            <p><div class="text">Hemsida:</div> <?php echo $thisComment['web']?></p>
                            <p><div class="text">IP:</div> <?php echo $thisComment['ip']?></p>

                            <input type=hidden name="redirect" value="<?php echo $this->url->create('comments')?>">
                            <input type=hidden name="id" value="<?php echo $thisComment['id']?>">
                            <input  class="myButton" type='submit' name='edit' value='Editera' onClick="this.form.action = '<?php echo $this->url->create('comment/edit/' . $thisComment['id'] . '/')?>'"/>
                            <input  class="myButton" type='submit' name='remove' value='Ta bort' onClick="this.form.action = '<?php echo $this->url->create('comment/remove/' . $thisComment['id'] . '/')?>'"/>

                        </form>
                <br><br>
            <?php endforeach; ?>
    </div>
    </li>
    </ul>

<?php endif; ?>