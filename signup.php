<?php
/**
 * signup.php
 * Creates a new CozyCorner account.
 */
require_once 'includes/functions.php';

if (is_logged_in()) {
    header('Location: cozypicks.php');
    exit();
}

$errors = [];
$old = ['username' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $old['username'] = $username = trim($_POST['username'] ?? '');
    $old['email']    = $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // ---- Validation ----
    if ($username === '' || strlen($username) < 3) {
        $errors[] = 'Username must be at least 3 characters.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    // ---- Check this email/username isn't already taken ----
    if (!$errors) {
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ? OR username = ?');
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = 'That username or email is already registered. Try logging in instead.';
        }
        $stmt->close();
    }

    // ---- Create the account ----
    if (!$errors) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $username, $email, $hashed);

        if ($stmt->execute()) {
            $stmt->close();
            header('Location: login.php?registered=1');
            exit();
        } else {
            $errors[] = 'Something went wrong creating your account. Please try again.';
        }
    }
}

$pageTitle = 'Sign Up';
require 'includes/header.php';
?>

<div class="hero-page page-auth">
    <div class="auth-card cozy-fold">
        <h2>Create your account 🌸</h2>

        <?php foreach ($errors as $err): ?>
            <div class="alert alert-danger py-2"><?= e($err) ?></div>
        <?php endforeach; ?>

        <form method="POST" novalidate>
            <input type="text" name="username" class="form-control" placeholder="Username"
                   minlength="3" maxlength="50" value="<?= e($old['username']) ?>" required>

            <input type="email" name="email" class="form-control" placeholder="Email"
                   maxlength="100" value="<?= e($old['email']) ?>" required>

            <div class="password-wrap">
                <input type="password" id="signup-password" name="password" class="form-control"
                       placeholder="Password (min. 6 characters)" minlength="6" required>
                <span class="password-toggle" data-target="signup-password">Show</span>
            </div>

            <button type="submit" name="register" class="btn btn-cozy mt-2">Sign Up</button>
        </form>

        <p class="mt-3 mb-0">Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
