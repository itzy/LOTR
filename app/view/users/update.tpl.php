<?php if(is_object($user)): ?>
    <form method="post" class="profileForm">
    <fieldset>
        <legend><font size="5px">Uppdatera <?php echo $user->name?>'s profil</font></legend>
        <input type="hidden" name="redirect" value="<?php echo $this->url->create('')?>">
        <input type="hidden" name="id" value="<?php echo $user->id?>">
        <p><label>Acronym:</label> <input type="text" name="acronym" value="<?php echo $user->acronym?>"></p>
        <p><label>Användarnamn: </label><input type="text" name="username" value="<?php echo $user->username?>"></p>
        <p><label>Namn: </label><input type="text" name="name" value="<?php echo $user->name?>"></p>
        <p><label>Födelsedatum</label> <input type="text" name="birthdate" value="<?php echo $user->birthdate?>"></p>
        <p><label>Email:</label> <input type="text" name="email" value="<?php echo $user->email?>"></p>
        <p><label></label><input type="submit" name="doSubmit" value="Spara" onClick="this.form.action = '<?php echo $this->url->create('users/save')?>'"></p>
    </fieldset>
<?php else : ?>
    <p>No user with that id was found</p>
<?php endif; ?>