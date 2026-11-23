    <div class="field">
        <label for="menu_name">Name</label>
        <input id="menu_name" name="menu_name" type="text" value="<?php echo h($car['menu_name']); ?>" required>
    </div>
    <div class="field">
        <label for="branch_id">Branch</label>
        <select id="branch_id" name="branch_id" required>
            <option value="">Choose a branch</option>
            <?php $branch_options = find_all_branches(); ?>
            <?php while ($option = mysqli_fetch_assoc($branch_options)) { ?>
                <option value="<?php echo h($option['id']); ?>" <?php if ((string)$car['branch_id'] === (string)$option['id']) { ?>selected<?php } ?>>
                    <?php echo h($option['menu_name']); ?>
                </option>
            <?php } ?>
            <?php mysqli_free_result($branch_options); ?>
        </select>
    </div>
    <div class="field">
        <label for="brand">Brand</label>
        <input id="brand" name="brand" type="text" value="<?php echo h($car['brand']); ?>" required>
    </div>
    <div class="field">
        <label for="year">Model year</label>
        <input id="year" name="year" type="text" inputmode="numeric" value="<?php echo h($car['year']); ?>" required>
    </div>
    <div class="field">
        <label for="price_per_day">Price per day (USD)</label>
        <input id="price_per_day" name="price_per_day" type="text" inputmode="decimal" value="<?php echo h($car['price_per_day']); ?>" required>
    </div>
    <div class="field">
        <label for="content">Description</label>
        <textarea id="content" name="content" rows="5" required><?php echo h($car['content']); ?></textarea>
    </div>
    <div class="field">
        <label for="position">Position</label>
        <input id="position" name="position" type="text" inputmode="numeric" value="<?php echo h($car['position']); ?>" required>
    </div>
    <div class="field">
        <label for="visible">Visibility</label>
        <select id="visible" name="visible">
            <option value="1" <?php if ((string)$car['visible'] === '1') { ?>selected<?php } ?>>Visible</option>
            <option value="0" <?php if ((string)$car['visible'] === '0') { ?>selected<?php } ?>>Hidden</option>
        </select>
    </div>
