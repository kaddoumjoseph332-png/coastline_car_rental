<?php
require_once('../../../private/initialize.php');
require_login();

$car = find_car_by_id(page_id());
if (!$car) {
    http_response_code(404);
    $page_title = 'Record unavailable';
    include('../../../private/shared/staff_header.php');
    ?>
    <h1>Record unavailable</h1>
    <a class="button" href="<?php echo h(url_for('/staff/cars/index.php')); ?>">Return to cars</a>
    <?php
    include('../../../private/shared/staff_footer.php');
    exit;
}

$parent = find_branch_by_id($car['branch_id']);
$page_title = $car['menu_name'];
include('../../../private/shared/staff_header.php');
?>
<a class="back-link" href="<?php echo h(url_for('/staff/cars/index.php')); ?>">← All cars</a>
<div class="page-heading">
    <h1><?php echo h($car['menu_name']); ?></h1>
    <a class="button" href="<?php echo h(url_for('/staff/cars/edit.php?id=' . u($car['id']))); ?>">Edit car</a>
</div>
<section class="panel detail-panel">
    <dl class="record-details">
        <div><dt>ID</dt><dd><?php echo h($car['id']); ?></dd></div>
        <div><dt>Name</dt><dd><?php echo h($car['menu_name'] ?? '—'); ?></dd></div>
        <div><dt>Branch</dt><dd><?php echo h($parent['menu_name'] ?? '—') . ' (#' . h($car['branch_id']) . ')'; ?></dd></div>
        <div><dt>Brand</dt><dd><?php echo h($car['brand'] ?? '—'); ?></dd></div>
        <div><dt>Model year</dt><dd><?php echo h($car['year'] ?? '—'); ?></dd></div>
        <div><dt>Price per day (USD)</dt><dd><?php echo $car['price_per_day'] === null ? '—' : '$' . h(number_format((float)$car['price_per_day'], 2)); ?></dd></div>
        <div><dt>Description</dt><dd><?php echo h($car['content'] ?? '—'); ?></dd></div>
        <div><dt>Position</dt><dd><?php echo h($car['position'] ?? '—'); ?></dd></div>
        <div><dt>Visibility</dt><dd><?php echo $car['visible'] == 1 ? 'Visible' : 'Hidden'; ?></dd></div>
    </dl>
    <a class="danger-link" href="<?php echo h(url_for('/staff/cars/delete.php?id=' . u($car['id']))); ?>">Delete car</a>
</section>

<?php include('../../../private/shared/staff_footer.php'); ?>
