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

$has_cars = count_cars_in_branch($branch['id']) > 0;
$errors = [];
if (is_post_request()) {
    if ($has_cars) {
        $errors[] = 'Move or delete the cars assigned to this branch before deleting it.';
    } elseif (delete_branch($branch['id'])) {
        redirect_to(url_for('/staff/branches/index.php'));
    } else {
        $errors[] = 'Could not delete this branch. Check whether it still has assigned cars.';
    }
}

$page_title = 'Delete branch';
include('../../../private/shared/staff_header.php');
?>
<a class="back-link" href="<?php echo h(url_for('/staff/branches/index.php')); ?>">← All branches</a>
<h1>Delete branch</h1>
<section class="panel form-panel" aria-label="Delete confirmation">
    <?php include('../../../private/shared/form_errors.php'); ?>
    <?php if ($has_cars) { ?>
        <p>Move or delete the cars assigned to this branch before deleting it.</p>
        <a class="button" href="<?php echo h(url_for('/staff/cars/index.php')); ?>">Manage cars</a>
    <?php } else { ?>
    <p>Delete <strong><?php echo h($branch['menu_name']); ?></strong>?</p>
    <form action="<?php echo h(url_for('/staff/branches/delete.php?id=' . u($branch['id']))); ?>" method="post">
        <div class="form-actions">
            <button class="button button-danger" type="submit">Confirm delete</button>
            <a href="<?php echo h(url_for('/staff/branches/show.php?id=' . u($branch['id']))); ?>">Cancel</a>
        </div>
    </form>
    <?php } ?>
</section>

<?php include('../../../private/shared/staff_footer.php'); ?>
