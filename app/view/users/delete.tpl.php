<div id='delete-form'><a href="<?php echo $this->url->create('users/delete/')?>/<?php echo $this->session->get('user_info')['id']?>">Yes</a>
    |
<a href="<?php echo $this->url->create('users/edit/')?>/<?php echo $this->session->get('user_info')['id']?>">No</a></div>
<?php
if(isset($success)) {
    if($success === true) {
        echo 'win';
    } else {
        echo 'fail';
    }
}
?>
