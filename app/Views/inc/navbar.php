<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <p class="h5 my-0 me-md-auto fw-normal"><a href="<?php echo URLROOT; ?>" style="text-decoration: none"><?php echo SITENAME; ?></a></p>
    <nav class="my-2 my-md-0 me-md-3">
        <a class="p-2 text-dark" href="<?php echo URLROOT; ?>">Home</a>
        <a class="p-2 text-dark" href="<?php echo URLROOT; ?>/pages/about">About</a>

    </nav>
    <?php if(isset($_SESSION['user_id'])) :?>
        <a class="btn" href="#">Welcome <?php echo ucfirst($_SESSION['user_name']); ?></a>
        <a class="btn btn-outline-warning" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
    <?php else: ?>
        <a class="btn btn-outline-primary" href="<?php echo URLROOT; ?>/users/login">Login</a>
        <a class="btn btn-outline-info" href="<?php echo URLROOT; ?>/users/register">Sign up</a>
    <?php endif ;?>
</header>