<?php
require_once('../private/initialize.php');

$errors = [];
$username = '';

if (is_post_request()) {
    $username = trim(form_value('username'));
    $password = form_value('password');

    if (is_blank($username)) { $errors[] = 'Username cannot be blank.'; }
    if (is_blank($password)) { $errors[] = 'Password cannot be blank.'; }

    if (empty($errors)) {
        $admin = find_admin_by_username($username);
        if ($admin && $admin['password'] === md5($password)) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            redirect_to(url_for('/staff/index.php'));
        }
        $errors[] = 'The username or password is incorrect.';
    }
}

$page_title = 'Staff login';
include('../private/shared/staff_header.php');
?>

<section class="panel login-panel">
    <h1>Staff login</h1>
    <p class="muted">Sign in to manage branches and cars.</p>
    <?php include('../private/shared/form_errors.php'); ?>
    <form action="<?php echo h(url_for('/login.php')); ?>" method="post" novalidate>
        <div class="field">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" value="<?php echo h($username); ?>" autocomplete="username" required>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" autocomplete="current-password" required>
        </div>
        <button class="button login-button" type="submit">Sign in</button>
    </form>
</section>

<?php include('../private/shared/staff_footer.php'); ?>
