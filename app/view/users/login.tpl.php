<div id='user-form'>
    <h1>Login</h1>
    <?php
    // Include the form
    include('login_form.php');
    echo $form->GetHTML(array('id' => 'form1', 'columns' => 2))
    ?>
