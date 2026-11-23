<?php
require_once('../private/initialize.php');

$branch = null;
$car = null;
$missing = false;
if (isset($_GET['car'])) {
    $car = find_car_by_id(page_id('car'));
    if ($car && $car['visible'] == 1) {
        $branch = find_branch_by_id($car['branch_id']);
    }
    $missing = !$branch || $branch['visible'] != 1;
} elseif (isset($_GET['id'])) {
    $branch = find_branch_by_id(page_id());
    $missing = !$branch || $branch['visible'] != 1;
}

if ($missing) {
    http_response_code(404);
    $page_title = 'Page unavailable';
    $branch = null;
} else {
    $page_title = $car['menu_name'] ?? $branch['menu_name'] ?? 'Home';
}

include('../private/shared/public_header.php');
?>

<?php if ($missing) { ?>
    <section class="container section">
        <h1>This page is unavailable</h1>
        <a class="button" href="<?php echo h(url_for('/index.php')); ?>">Browse branches</a>
    </section>
<?php } elseif ($car) { ?>
    <section class="container section">
        <a class="back-link" href="<?php echo h(url_for('/index.php?id=' . u($branch['id']))); ?>">← Back to <?php echo h($branch['menu_name']); ?></a>
        <div class="detail-grid">
            <article class="detail-card">
                <p class="eyebrow"><?php echo h($branch['city']); ?></p>
                <h1><?php echo h($car['menu_name']); ?></h1>
                <p class="description"><?php echo h($car['content']); ?></p>
                <dl class="specs">
                    <div><dt>Brand</dt><dd><?php echo h($car['brand'] ?? '—'); ?></dd></div>
                    <div><dt>Model year</dt><dd><?php echo h($car['year'] ?? '—'); ?></dd></div>
                    <div><dt>Pickup branch</dt><dd><?php echo h($branch['menu_name']); ?></dd></div>
                </dl>
            </article>
            <aside class="booking-card" aria-label="Rental price and branch contact">
                <p class="eyebrow">Daily rate</p>
                <?php if ($car['price_per_day'] !== null) { ?>
                    <p class="price">$<?php echo h(number_format((float)$car['price_per_day'], 2)); ?> <small>/ day</small></p>
                <?php } else { ?>
                    <p>Call for pricing.</p>
                <?php } ?>
                <?php if (!is_blank($branch['phone'])) { ?>
                    <a class="button" href="tel:<?php echo h(preg_replace('/[^0-9+]/', '', $branch['phone'])); ?>">Call to book</a>
                    <p class="contact"><?php echo h($branch['phone']); ?></p>
                <?php } else { ?>
                    <p>Branch phone number unavailable.</p>
                <?php } ?>
            </aside>
        </div>
    </section>
<?php } elseif ($branch) { ?>
    <section class="section-banner">
        <div class="container">
            <a class="back-link" href="<?php echo h(url_for('/index.php#branches')); ?>">← All branches</a>
            <h1><?php echo h($branch['menu_name']); ?></h1>
            <p><?php echo h($branch['city']); ?> <?php if (!is_blank($branch['phone'])) { ?> · <?php echo h($branch['phone']); ?><?php } ?></p>
        </div>
    </section>
    <section class="container section">
        <h2>Available cars</h2>
        <?php $car_set = find_visible_cars_by_branch_id($branch['id']); ?>
        <?php if (mysqli_num_rows($car_set) === 0) { ?>
            <p class="empty-state">No cars are currently listed at this branch.</p>
        <?php } else { ?>
            <div class="card-grid">
                <?php while ($listed_car = mysqli_fetch_assoc($car_set)) { ?>
                    <article class="listing-card">
                        <p class="eyebrow"><?php echo h($listed_car['brand']); ?> <?php echo h($listed_car['year']); ?></p>
                        <h3><?php echo h($listed_car['menu_name']); ?></h3>
                        <p class="listing-description"><?php echo h($listed_car['content']); ?></p>
                        <div class="card-bottom">
                            <?php if ($listed_car['price_per_day'] !== null) { ?>
                                <span class="price">$<?php echo h(number_format((float)$listed_car['price_per_day'], 2)); ?> <small>/ day</small></span>
                            <?php } else { ?>
                                <span>Call for pricing</span>
                            <?php } ?>
                            <a class="text-link" href="<?php echo h(url_for('/index.php?car=' . u($listed_car['id']))); ?>" aria-label="View details for <?php echo h($listed_car['menu_name']); ?>">View details <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
        <?php mysqli_free_result($car_set); ?>
    </section>
<?php } else { ?>
    <section class="hero">
        <div class="container hero-copy">
            <h1>Find your<br>perfect ride.</h1>
            <p>Choose a pickup branch and browse rental cars across Lebanon.</p>
            <a class="button" href="#branches">Explore branches <span aria-hidden="true">↓</span></a>
        </div>
    </section>
    <section id="branches" class="container section">
        <h2>Choose your pickup branch</h2>
        <?php $branch_set = find_visible_branches(); ?>
        <?php if (mysqli_num_rows($branch_set) === 0) { ?>
            <p class="empty-state">No branches are currently listed.</p>
        <?php } else { ?>
            <div class="card-grid">
                <?php while ($listed_branch = mysqli_fetch_assoc($branch_set)) { ?>
                    <?php
                    $visible_cars = find_visible_cars_by_branch_id($listed_branch['id']);
                    $car_count = mysqli_num_rows($visible_cars);
                    mysqli_free_result($visible_cars);
                    ?>
                    <article class="listing-card">
                        <p class="eyebrow"><?php echo h($listed_branch['city']); ?></p>
                        <h3><?php echo h($listed_branch['menu_name']); ?></h3>
                        <p><?php echo h($listed_branch['phone']); ?></p>
                        <div class="card-bottom">
                            <span class="count"><?php echo h($car_count); ?> <?php echo $car_count === 1 ? 'car' : 'cars'; ?></span>
                            <a class="text-link" href="<?php echo h(url_for('/index.php?id=' . u($listed_branch['id']))); ?>" aria-label="View cars at <?php echo h($listed_branch['menu_name']); ?>">View cars <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
        <?php mysqli_free_result($branch_set); ?>
    </section>
<?php } ?>

<?php include('../private/shared/public_footer.php'); ?>
