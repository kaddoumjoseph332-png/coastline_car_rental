<?php
require_once('../../../private/initialize.php');
require_login();

$branch = find_branch_by_id(page_id());
if (!$branch) {
    http_response_code(404);
    $page_title = 'Record unavailable';
    include('../../../private/shared/staff_header.php');
    ?>
    <h1>Record unavailable</h1>
    <a class="button" href="<?php echo h(url_for('/staff/branches/index.php')); ?>">Return to branches</a>
    <?php
    include('../../../private/shared/staff_footer.php');
    exit;
}

$page_title = $branch['menu_name'];
include('../../../private/shared/staff_header.php');
?>
<a class="back-link" href="<?php echo h(url_for('/staff/branches/index.php')); ?>">← All branches</a>
<div class="page-heading">
    <h1><?php echo h($branch['menu_name']); ?></h1>
    <a class="button" href="<?php echo h(url_for('/staff/branches/edit.php?id=' . u($branch['id']))); ?>">Edit branch</a>
</div>
<section class="panel detail-panel">
    <dl class="record-details">
        <div><dt>ID</dt><dd><?php echo h($branch['id']); ?></dd></div>
        <div><dt>Name</dt><dd><?php echo h($branch['menu_name'] ?? '—'); ?></dd></div>
        <div><dt>City</dt><dd><?php echo h($branch['city'] ?? '—'); ?></dd></div>
        <div><dt>Phone</dt><dd><?php echo h($branch['phone'] ?? '—'); ?></dd></div>
        <div><dt>Position</dt><dd><?php echo h($branch['position'] ?? '—'); ?></dd></div>
        <div><dt>Visibility</dt><dd><?php echo $branch['visible'] == 1 ? 'Visible' : 'Hidden'; ?></dd></div>
    </dl>
    <a class="danger-link" href="<?php echo h(url_for('/staff/branches/delete.php?id=' . u($branch['id']))); ?>">Delete branch</a>
</section>

<?php include('../../../private/shared/staff_footer.php'); ?>
