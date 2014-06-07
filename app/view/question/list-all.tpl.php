<h1 class="center">Questions</h1>
<?php if($this->session->get('logged_in') == true)
{
?>
<a href="<?php echo $this->url->create('question/add'); ?>">New question</a>
    <?php } ?>

<?php
$orderLink = 'desc';
if(isset($_GET['order_by'])) {
    $orderLink = 'desc';
    if($_GET['order_by'] == 'desc') {
        $orderLink = 'asc';
    }

} ?>
<a style="float: right;" href="?order_by=<?php echo $orderLink; ?>">Order by points</a>

<hr>

<?php foreach ($questions as $question) : ?>
    <p>
        <?php
        $thisQuestion = $question->getProperties();
        ?>
    <h1>    <?php if ($thisQuestion['points'] >= '0')
        {
            ?><span class="goodvote"><?php echo $thisQuestion['points']?></span>
        <?php
        }
        else if ($thisQuestion['points'] < '0')
        {
            ?><span class="badvote"><?php echo $thisQuestion['points']?></span>
        <?php
        }

        ?><a href="<?php echo $this->url->create('questions/id/')?>/<?php echo $thisQuestion['id']?>"><?php echo $thisQuestion['title']?></a></h1>
    <p>
        <?php echo $thisQuestion['content']?><br>
        <?php echo $thisQuestion['numComments']; ?> answers<br>
        Created: <?php echo $thisQuestion['created']?><br>
        Created by:
        <?php if($thisQuestion['exists']) { ?>
        <a href="<?php echo $this->url->create('users/acronym/')?>/<?php echo $thisQuestion['acronym']?>"><?php echo $thisQuestion['acronym']?></a>
        <?php } else { ?>
            <?php echo $thisQuestion['acronym']?>
        <?php } ?>

    <hr>
    </p>

<?php endforeach;?>