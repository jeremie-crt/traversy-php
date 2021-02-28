<a href="<?php echo URLROOT; ?>/posts" class="btn btn-ligth"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
    <?php flash('post_add_error'); ?>

    <h2>Add a new post</h2>
    <form action="<?php echo URLROOT; ?>/posts/add" method="post">
        <div class="form-group">
            <label for="title">Title: <sup>*</sup></label>
            <input type="text" name="title"
                   class="form-control form-control-lg <?php echo !empty($data['title_err']) ? 'is-invalid' : ''; ?>"
                   value="<?php echo $data['title']; ?>">
            <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
        </div>

        <div class="form-group mt-3">
            <label for="body">Password: <sup>*</sup></label>
            <textarea id="body" name="body"
                      class="form-control form-control-lg <?php echo !empty($data['body_err']) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
            <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
        </div>

        <div class="row mt-3">
            <div class="col">
                <input type="submit" value="Add Post" class="btn btn-success btn-block">
            </div>
        </div>
    </form>
</div>

