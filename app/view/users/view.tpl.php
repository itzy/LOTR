
<?php if(isset ($user)) :
$thisUser = $user->getProperties();?>
<h1><?php echo $thisUser['acronym']?></h1>
<p>
    <?php if($thisUser['acronym'] == $this->session->get('user_info')['acronym'])
    {?>
        <a href="<?php echo $this->url->create('users/edit/')?>/<?php echo $this->session->get('user_info')['id']?>">Edit profile</a>
    <?php }
    $gravatar = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($thisUser['email']))) . '.jpg?s=180';
    ?>
    </p>
    <p><img class="gravatar" src="<?php echo $gravatar?>" alt="<?php echo $thisUser['name']?>'s Gravatar">
    Name: <?php echo $thisUser['name']?><br>
    Email: <?php echo $thisUser['email']?><br>
    Birthday: <?php echo $thisUser['birthday']?><br>
    Posts: <?php echo $thisUser['posts']?><br>
    Created: <?php echo $thisUser['created']?><br>
    Last active: <?php echo $thisUser['active']?><br>
    <?php
    if($thisUser['updated'])
    {
        echo "<i>Updated: </i>" . $thisUser['updated'] . "<br>";
    }

    if($thisUser['deleted'])
    {
        echo "<i>Deleted: </i>" . $thisUser['deleted'] . "<br>";
    }

	$content = $thisUser['content'];
    $content = $this->textFilter->doFilter($content, 'shortcode, markdown');

    if($thisUser['content'])
        {
            ?><div id="content-box">
            <?php echo $content;?>
            </div>
            <?php
        }
    ?>
    <h2>Questions asked by <?php echo $thisUser['acronym']?></h2>
    <?php
   foreach ($questions as $question) : ?>
    <p>
<div id="user-questions">
       <a href="<?php echo $this->url->create('questions/id/')?>/<?php echo $question->id?>"><?php echo $question->title?></a><br>

       <?php echo $question->content?><br>
       <i class="posted">Posted: <?php echo $question->created?><br></i>
       </div>
<?php endforeach;

    if(count($questions) == '0')
    {
        echo "This user has not asked any questions yet.";
    }

    ?>

<h2>Answers by <?php echo $thisUser['acronym']?></h2>
<?php

foreach ($answers as $answer) :

    ?>
    <p>
    <div id="user-answers">
        <a href="<?php echo $this->url->create('questions/id/')?>/<?php echo $answer->question_id?>"><?php echo $answer->content?></a>
        <i class="posted">Posted: <?php echo $answer->created?><br></i>
    </div>
<?php endforeach;

if(count($answers) == '0')
{
    echo "This user has not posted any answers yet.";
}

endif;?>