<div id='tillbaka'><a href="../user">Gå tillbaka</a></div>
<?php
if(isset($success)) {
    if($success === true) {
        $url = $this->url->create('users/id/' . $this->users->id);
        $this->response->redirect($url);
    } else {
        echo 'fail';
    }
}
?>
<div class='user-form'>
    <form method="POST">
        <input type="text" name="id" placeholder="Visa användare" />
        <input type='submit' class="myButton" value='Visa'>
    </form>
</div>