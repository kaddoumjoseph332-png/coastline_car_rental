<?php
require_once('../../../private/initialize.php');
require_login();

$car = [
    'menu_name' => '',
    'branch_id' => '',
    'brand' => '',
    'year' => '',
    'price_per_day' => '',
    'content' => '',
    'position' => '',
    'visible' => '1',
];

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
    $result = insert_car($car);
    if ($result === true) {
        $id = mysqli_insert_id($db);
        redirect_to(url_for('/staff/cars/show.php?id=' . u($id)));
    }
    $errors = $result;
}

$page_title = 'Create new car';
include('../../../private/shared/staff_header.php');
?>
<a class="back-link" href="<?php echo h(url_for('/staff/cars/index.php')); ?>">← All cars</a>
<h1><?php echo h($page_title); ?></h1>
<section class="panel form-panel" aria-label="<?php echo h($page_title); ?>">
    <?php include('../../../private/shared/form_errors.php'); ?>
    <form action="<?php echo h(url_for('/staff/cars/new.php')); ?>" method="post" novalidate>
        <?php include('../../../private/shared/car_fields.php'); ?>
        <div class="form-actions">
            <button class="button" type="submit">Create car</button>
            <a href="<?php echo h(url_for('/staff/cars/index.php')); ?>">Cancel</a>
        </div>
    </form>
</section>

<?php include('../../../private/shared/staff_footer.php'); ?>
