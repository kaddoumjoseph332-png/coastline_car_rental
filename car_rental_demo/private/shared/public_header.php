<?php $navigation_branches = find_visible_branches(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo h($page_title ?? 'Home'); ?> | Coastline Car Rental</title>
    <link rel="stylesheet" href="<?php echo h(url_for('/stylesheets/public.css')); ?>">
</head>
<body>
<header class="site-header">
    <div class="container header-row">
        <a class="wordmark" href="<?php echo h(url_for('/index.php')); ?>">
            Coastline <span>Car Rental</span>
        </a>
        <a class="staff-link" href="<?php echo h(url_for('/login.php')); ?>">Staff login</a>
    </div>
    <nav class="container branch-nav" aria-label="Rental branches">
        <?php while ($nav_branch = mysqli_fetch_assoc($navigation_branches)) { ?>
            <a href="<?php echo h(url_for('/index.php?id=' . u($nav_branch['id']))); ?>"
                <?php if (($branch['id'] ?? null) === $nav_branch['id']) { ?>class="current"<?php } ?>>
                <?php echo h($nav_branch['menu_name']); ?>
            </a>
        <?php } ?>
        <?php mysqli_free_result($navigation_branches); ?>
    </nav>
</header>
<main>
