<?php

echo "<h1>Searchresult for: " . $title . "</h1>";

foreach($searchResults as $result)
{
    if($for == "Users")
    {
        ?>
        <a href="<?php echo $this->url->create('users/id/')?>/<?php echo $result->id?>"><?php echo $result->acronym?></a><br>
    <?php
    }
    else if($for == "Questions")
    {
        ?>
        <a href="<?php echo $this->url->create('questions/id/')?>/<?php echo $result->id?>"><?php echo $result->title?></a><br>
    <?php
    }
    else if($for == "Tags")
    {
        ?>
        <a href="<?php echo $this->url->create('questions/tagid/')?>/<?php echo $result->id?>"><?php echo $result->tag?></a><br>
    <?php
    }

}