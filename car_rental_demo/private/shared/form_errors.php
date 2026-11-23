<?php if (!empty($errors)) { ?>
    <div class="form-errors" role="alert">
        <strong>Please correct the following</strong>
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?php echo h($error); ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
