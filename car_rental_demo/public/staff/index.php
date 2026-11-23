<?php
require_once('../../private/initialize.php');
require_login();

$page_title = 'Staff dashboard';
include('../../private/shared/staff_header.php');
?>
<h1>Staff dashboard</h1>
<p class="muted">Manage the pickup branches and rental cars shown on the public site.</p>
<div class="dashboard-grid">
    <section class="panel">
        <h2>Branches</h2>
        <p>Manage pickup locations, contact details, and visibility.</p>
        <a class="button" href="<?php echo h(url_for('/staff/branches/index.php')); ?>">Manage branches</a>
    </section>
    <section class="panel">
        <h2>Cars</h2>
        <p>Manage the fleet, daily rates, and branch assignments.</p>
        <a class="button" href="<?php echo h(url_for('/staff/cars/index.php')); ?>">Manage cars</a>
    </section>
</div>
<?php include('../../private/shared/staff_footer.php'); ?>
