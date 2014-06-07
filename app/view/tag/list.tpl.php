<h1 class="center">Tags</h1>

<?php
foreach ($tags as $tag) : ?>
    <p>

        <?php
        $thisTag = $tag->getProperties();
        ?>
    <p>
        <a href="<?php echo $this->url->create('questions/tagid/')?>/<?php echo $thisTag['id']?>"><?php echo $thisTag['tag']?></a>

        <a href<?php echo $thisTag['tag'];
        ?><br>

    </p>

<?php endforeach;?>