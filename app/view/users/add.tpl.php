<div id='user-form'>
    <h1>Signup</h1>
<?php
// Include the form
include('user_form.php');
echo $form->GetHTML(array('id' => 'form1', 'columns' => 2))
?>
