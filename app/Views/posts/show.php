<a href="<?php echo URLROOT; ?>/posts" class="btn btn-ligth"><i class="fa fa-backward"></i> Back</a>
<hr>
<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by: <?php echo ucfirst($data['user']->name); ?> on <?php echo $data['post']->created_at; ?>
</div>
<p><?php echo $data['post']->body; ?></p>

<?php if($data['user']->id == $_SESSION['user_id']) :?>
    <hr>
    <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Edit my post</a>

    <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" class="pull-right" method="post">
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>

<?php endif ;?>
