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
    if (delete_car($car['id'])) {
        redirect_to(url_for('/staff/cars/index.php'));
    }
    $errors[] = 'Could not delete this record. Please try again.';
}

$page_title = 'Delete car';
include('../../../private/shared/staff_header.php');
?>
<a class="back-link" href="<?php echo h(url_for('/staff/cars/index.php')); ?>">← All cars</a>
<h1>Delete car</h1>
<section class="panel form-panel" aria-label="Delete confirmation">
    <?php include('../../../private/shared/form_errors.php'); ?>
    <p>Delete <strong><?php echo h($car['menu_name']); ?></strong>?</p>
    <form action="<?php echo h(url_for('/staff/cars/delete.php?id=' . u($car['id']))); ?>" method="post">
        <div class="form-actions">
            <button class="button button-danger" type="submit">Confirm delete</button>
            <a href="<?php echo h(url_for('/staff/cars/show.php?id=' . u($car['id']))); ?>">Cancel</a>
        </div>
    </form>
</section>

<?php include('../../../private/shared/staff_footer.php'); ?>
