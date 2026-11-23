<?php
require_once('../../../private/initialize.php');
require_login();

$records = find_all_cars();
$page_title = 'Cars';
include('../../../private/shared/staff_header.php');
?>

<div class="page-heading">
    <h1>Cars</h1>
    <a class="button" href="<?php echo h(url_for('/staff/cars/new.php')); ?>">Create New Car</a>
</div>
<div class="table-wrap panel">
    <table>
        <thead>
            <tr><th scope="col">Name</th><th scope="col">Branch</th><th scope="col">Position</th><th scope="col">Visibility</th><th scope="col">Actions</th></tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($records) === 0) { ?>
            <tr><td colspan="5">No cars have been added.</td></tr>
        <?php } ?>
        <?php while ($car = mysqli_fetch_assoc($records)) { ?>
            <?php $parent = find_branch_by_id($car['branch_id']); ?>
            <tr>
                <th scope="row"><?php echo h($car['menu_name']); ?></th>
                <td><?php echo h($parent['menu_name'] ?? '—'); ?></td>
                <td><?php echo h($car['position']); ?></td>
                <td><span class="status <?php echo $car['visible'] == 1 ? 'is-visible' : 'is-hidden'; ?>"><?php echo $car['visible'] == 1 ? 'Visible' : 'Hidden'; ?></span></td>
                <td class="table-actions">
                    <a href="<?php echo h(url_for('/staff/cars/show.php?id=' . u($car['id']))); ?>">View</a>
                    <a href="<?php echo h(url_for('/staff/cars/edit.php?id=' . u($car['id']))); ?>">Edit</a>
                    <a class="danger-link" href="<?php echo h(url_for('/staff/cars/delete.php?id=' . u($car['id']))); ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php mysqli_free_result($records); ?>

<?php include('../../../private/shared/staff_footer.php'); ?>
