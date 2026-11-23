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


$errors = [];
if (is_post_request()) {
    $car['menu_name'] = trim(form_value('menu_name'));
    $car['branch_id'] = trim(form_value('branch_id'));
    $car['brand'] = trim(form_value('brand'));
    $car['year'] = trim(form_value('year'));
    $car['price_per_day'] = trim(form_value('price_per_day'));
    $car['content'] = trim(form_value('content'));
    $car['position'] = trim(form_value('position'));
    $car['visible'] = trim(form_value('visible'));
    $result = update_car($car);
    if ($result === true) {
        $id = $car['id'];
        redirect_to(url_for('/staff/cars/show.php?id=' . u($id)));
    }
    $errors = $result;
}

$page_title = 'Edit car';
include('../../../private/shared/staff_header.php');
?>
<a class="back-link" href="<?php echo h(url_for('/staff/cars/index.php')); ?>">← All cars</a>
<h1><?php echo h($page_title); ?></h1>
<section class="panel form-panel" aria-label="<?php echo h($page_title); ?>">
    <?php include('../../../private/shared/form_errors.php'); ?>
    <form action="<?php echo h(url_for('/staff/cars/edit.php' . '?id=' . u($car['id']))); ?>" method="post" novalidate>
        <?php include('../../../private/shared/car_fields.php'); ?>
        <div class="form-actions">
            <button class="button" type="submit">Save changes</button>
            <a href="<?php echo h(url_for('/staff/cars/index.php')); ?>">Cancel</a>
        </div>
    </form>
</section>

<?php include('../../../private/shared/staff_footer.php'); ?>
