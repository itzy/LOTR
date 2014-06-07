<div id='tillbaka'><a href="../user">Gå tillbaka</a></div>

<h1><?php echo $title?></h1>

<?php foreach ($users as $user) : ?>

    <pre><?php echo var_dump($user->getProperties())?></pre>

<?php endforeach; ?>

<p><a href='<?php echo $this->url->create('')?>'>Home</a></p>