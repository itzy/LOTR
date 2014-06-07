<article class="article1">

    <?php echo $content?>

    <?php
    $this->db->select()
        ->from('projectquestion')
        ->orderBy('created DESC')
        ->execute();
    $questions = $this->db->fetchAll();

    $this->db->select()
        ->from('projecttags')
        ->orderBy('usedNoTimes DESC')
        ->execute();
    $tags = $this->db->fetchAll();

    $this->db->select()
    ->from('projectuser')
    ->orderBy('posts DESC')
    ->execute();
    $users = $this->db->fetchAll();?>

    <div class="index">
    <div class="questions">
        <?php if(count($questions) > 0)
        {
            echo '<h3>Latest questions</h3>';
            foreach($questions as $question)
            {
                echo '<a style="display: block" href="' . $this->url->create('questions/id/' . $question->id) .'">'. $question->title .'</a>';

            }
        }
        ?>
    </div>
    <div class="tags">
        <?php if(count($tags) > 0)
        {
            echo '<h3>Popular tags</h3>';
            foreach($tags as $tag)
            {
                echo '<a href="' . $this->url->create('questions/tagid/' . $tag->id) .'">'. $tag->tag .'</a>';

            }
        }
        ?>
    </div>
    <div class="users">
        <?php if(count($users) > 0)
        {
            echo '<h3>Most active users</h3>';
            foreach($users as $user)
            {
                echo '<a href="' . $this->url->create('users/id/' . $user->id) .'">'. $user->acronym .'</a>';

            }
        }
        ?>
    </div>
    </div>

</article>