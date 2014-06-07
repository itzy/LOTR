<div id='tillbaka'><a href="../user">Gå tillbaka</a></div>
<?php
if(isset($success)) {
    if($success === true) {
        echo 'win';
    } else {
        echo 'fail';
    }
}
?>
<div class='user-form'>
<form method="POST">
    <input type="text" name="id" placeholder="id att ta bort" />
    <input type="submit" class="myButton" value="Ta bort" />
</form>
</div>