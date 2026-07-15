<?php
/**
 * login.php
 * Signs an existing member in.
 */
require_once 'includes/functions.php';

if (is_logged_in()) {
    header('Location: cozypicks.php');
    exit();
}

$error = '';
$old = ['email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $old['email'] = $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    // Prepared statement - the #1 fix for the old SQL-injection bug.
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($pass, $row['password'])) {
            session_regenerate_id(true);

            $_SESSION['user']    = $row['username'];
            $_SESSION['user_id'] = $row['id'];

            header('Location: cozypicks.php');
            exit();
        } else {
            $error = 'Incorrect password. Please try again.';
        }
    } else {
        // Same generic message either way, so visitors can't use this
        // form to discover which emails are registered.
        $error = 'We could not find an account with those details.';
    }
    $stmt->close();
}

$pageTitle = 'Login';
require 'includes/header.php';
?>

<div class="hero-page page-auth">
    <div class="auth-card cozy-fold">
        <h2>Welcome back 🌷</h2>

        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success py-2">Account created! Please log in below.</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <input type="email" name="email" class="form-control" placeholder="Email"
                   value="<?= e($old['email']) ?>" required>

            <div class="password-wrap">
                <input type="password" id="login-password" name="password" class="form-control"
                       placeholder="Password" required>
                <span class="password-toggle" data-target="login-password">Show</span>
            </div>

            <button type="submit" name="login" class="btn btn-cozy mt-2">Login</button>
        </form>

        <p class="mt-3 mb-0">Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
