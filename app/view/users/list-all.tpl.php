<h1 class="center">Users</h1>
<hr>

<?php foreach ($users as $user) : ?>
<div id="users">
<?php
    $thisUser = $user->getProperties();?>
    <?php $gravatar = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($thisUser['email']))) . '.jpg?s=100';
    ?>
    <a href="<?php echo $this->url->create('users/id/')?>/<?php echo $thisUser['id']?>"><img class="gravatarleft" src="<?php echo $gravatar?>" alt="<?php echo $thisUser['name']?>'s Gravatar"><h1>
       <?php echo $thisUser['acronym']?></a></h1>
<p><br>
        Name: <?php echo $thisUser['name']?><br>
        Email: <?php echo $thisUser['email']?><br>
        Birthday: <?php echo $thisUser['birthday']?><br>
        Number of posts: <?php echo $thisUser['posts']?><br>
        Created: <?php echo $thisUser['created']?><br>
        Last active: <?php echo $thisUser['active']?><br>
        <?php
        if($thisUser['updated'])
        {
            echo "<i>Updated: </i>" . $thisUser['updated'];
        }

        if($thisUser['deleted'])
        {
            echo "<i>Deleted: </i>" . $thisUser['deleted'] . "<br>";
        }
        ?>
</p>
</div>

<?php endforeach;?>
<hr>