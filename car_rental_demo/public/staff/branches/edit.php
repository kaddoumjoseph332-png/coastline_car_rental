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


$errors = [];
if (is_post_request()) {
    $branch['menu_name'] = trim(form_value('menu_name'));
    $branch['city'] = trim(form_value('city'));
    $branch['phone'] = trim(form_value('phone'));
    $branch['position'] = trim(form_value('position'));
    $branch['visible'] = trim(form_value('visible'));
    $result = update_branch($branch);
    if ($result === true) {
        $id = $branch['id'];
        redirect_to(url_for('/staff/branches/show.php?id=' . u($id)));
    }
    $errors = $result;
}

$page_title = 'Edit branch';
include('../../../private/shared/staff_header.php');
?>
<a class="back-link" href="<?php echo h(url_for('/staff/branches/index.php')); ?>">← All branches</a>
<h1><?php echo h($page_title); ?></h1>
<section class="panel form-panel" aria-label="<?php echo h($page_title); ?>">
    <?php include('../../../private/shared/form_errors.php'); ?>
    <form action="<?php echo h(url_for('/staff/branches/edit.php' . '?id=' . u($branch['id']))); ?>" method="post" novalidate>
        <?php include('../../../private/shared/branch_fields.php'); ?>
        <div class="form-actions">
            <button class="button" type="submit">Save changes</button>
            <a href="<?php echo h(url_for('/staff/branches/index.php')); ?>">Cancel</a>
        </div>
    </form>
</section>

<?php include('../../../private/shared/staff_footer.php'); ?>
