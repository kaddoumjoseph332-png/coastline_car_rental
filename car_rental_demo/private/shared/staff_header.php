<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo h($page_title ?? 'Staff'); ?> | Coastline Staff</title>
    <link rel="stylesheet" href="<?php echo h(url_for('/stylesheets/staff.css')); ?>">
</head>
<body>
<header class="staff-header">
    <div class="container staff-bar">
        <a class="wordmark" href="<?php echo h(url_for('/staff/index.php')); ?>">Coastline <span>Staff</span></a>
        <?php if (isset($_SESSION['admin_id'])) { ?>
            <nav aria-label="Staff navigation">
                <a href="<?php echo h(url_for('/staff/branches/index.php')); ?>">Branches</a>
                <a href="<?php echo h(url_for('/staff/cars/index.php')); ?>">Cars</a>
                <a href="<?php echo h(url_for('/index.php')); ?>">Public site</a>
                <a href="<?php echo h(url_for('/logout.php')); ?>">Logout</a>
            </nav>
        <?php } else { ?>
            <a class="public-link" href="<?php echo h(url_for('/index.php')); ?>">← Public site</a>
        <?php } ?>
    </div>
</header>
<main class="container staff-main">
