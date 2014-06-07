
<?php if(isset ($user)) :
    $thisUser = $user->getProperties();?>

<div id='user-form'>
    <h1>Edit profile</h1>

    <?php
    // Include the form
    include('useredit_form.php');
    echo $form->GetHTML(array('id' => 'form1', 'columns' => 2))
    ?>
    <div id="delete">
        <a href="<?php echo $this->url->create('users/deletecontrol/')?>/<?php echo $user->id?>">delete user</a>
    </div>
<?php endif;?>