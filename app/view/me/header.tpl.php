<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<div id="above">
    <span class="left">
        <a href="<?php echo $this->url->create('users/add'); ?>">Sign up</a> |
        <?php
            if($this->session->get('logged_in') == false) {
        ?>
        <a href="<?php echo $this->url->create('users/login'); ?>">Login</a> |
        <?php
            } else {
                ?>
                <a href="<?php echo $this->url->create('users/logout'); ?>">Logout</a> |
                 <?
            }
        ?>
    </span>
    <?php
    if($this->session->get('logged_in') == true) {

        ?>
        <div id="user-loggedin">
            Logged in as:
        <a href="<?php echo $this->url->create('users/id/')?>/<?php echo $this->session->get('user_info')['id']?>"><?php echo $this->session->get('user_info')['acronym'] ?></a>
        </div>
            <?
    } else {

    }?>
    <span class="right">


    <div id="search">
            <form method="post" class="searchForm">
                <select name="searchIn">
                    <option>Category...</option>
                    <option>Users</option>
                    <option>Questions</option>
                    <option>Tags</option>
                </select>
                <input type="search" name="keyword" placeholder="keyword">
                <input type="submit" name="doSearch" value="Sök" onClick="this.form.action = '<?php echo $this->url->create('search/for/')?>'">
            </form>
        </form></div>

    </span>
</div>

<img class='header' src='<?php echo $this->url->asset("img/header.png")?>' alt='LOTR Logo'/>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">