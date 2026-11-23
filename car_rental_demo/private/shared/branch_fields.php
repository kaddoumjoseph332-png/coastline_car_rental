    <div class="field">
        <label for="menu_name">Name</label>
        <input id="menu_name" name="menu_name" type="text" value="<?php echo h($branch['menu_name']); ?>" required>
    </div>
    <div class="field">
        <label for="city">City</label>
        <input id="city" name="city" type="text" value="<?php echo h($branch['city']); ?>" required>
    </div>
    <div class="field">
        <label for="phone">Phone</label>
        <input id="phone" name="phone" type="tel" value="<?php echo h($branch['phone']); ?>" required>
    </div>
    <div class="field">
        <label for="position">Position</label>
        <input id="position" name="position" type="text" inputmode="numeric" value="<?php echo h($branch['position']); ?>" required>
    </div>
    <div class="field">
        <label for="visible">Visibility</label>
        <select id="visible" name="visible">
            <option value="1" <?php if ((string)$branch['visible'] === '1') { ?>selected<?php } ?>>Visible</option>
            <option value="0" <?php if ((string)$branch['visible'] === '0') { ?>selected<?php } ?>>Hidden</option>
        </select>
    </div>
