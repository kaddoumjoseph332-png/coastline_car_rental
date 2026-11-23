<?php
require_once('../../../private/initialize.php');
require_login();

$records = find_all_branches();
$page_title = 'Branches';
include('../../../private/shared/staff_header.php');
?>

<div class="page-heading">
    <h1>Branches</h1>
    <a class="button" href="<?php echo h(url_for('/staff/branches/new.php')); ?>">Create New Branch</a>
</div>
<div class="table-wrap panel">
    <table>
        <thead>
            <tr><th scope="col">Name</th><th scope="col">City</th><th scope="col">Position</th><th scope="col">Visibility</th><th scope="col">Actions</th></tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($records) === 0) { ?>
            <tr><td colspan="5">No branches have been added.</td></tr>
        <?php } ?>
        <?php while ($branch = mysqli_fetch_assoc($records)) { ?>
            <tr>
                <th scope="row"><?php echo h($branch['menu_name']); ?></th>
                <td><?php echo h($branch['city']); ?></td>
                <td><?php echo h($branch['position']); ?></td>
                <td><span class="status <?php echo $branch['visible'] == 1 ? 'is-visible' : 'is-hidden'; ?>"><?php echo $branch['visible'] == 1 ? 'Visible' : 'Hidden'; ?></span></td>
                <td class="table-actions">
                    <a href="<?php echo h(url_for('/staff/branches/show.php?id=' . u($branch['id']))); ?>">View</a>
                    <a href="<?php echo h(url_for('/staff/branches/edit.php?id=' . u($branch['id']))); ?>">Edit</a>
                    <a class="danger-link" href="<?php echo h(url_for('/staff/branches/delete.php?id=' . u($branch['id']))); ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php mysqli_free_result($records); ?>

<?php include('../../../private/shared/staff_footer.php'); ?>
