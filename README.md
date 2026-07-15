# 🌻 CozyCorner

A cozy, comforting little website for blogs, baking inspiration, anonymous
letters, and visitor feedback — built with **HTML, CSS, Bootstrap 5,
JavaScript, and PHP/MySQL**.

This is the enhanced & debugged version of the original project. The look,
colors, and overall theme have **not** been changed — everything has just
been made more solid, more secure, and easier to read for a student project.

---

## 🚀 How to run it (XAMPP / WAMP / Laragon)

1. Copy the whole `cozycorner` folder into your server's web root:
   - XAMPP: `C:\xampp\htdocs\cozycorner`
   - WAMP: `C:\wamp64\www\cozycorner`
   - Laragon: `C:\laragon\www\cozycorner`
2. Start **Apache** and **MySQL** from your control panel.
3. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
4. Click **Import**, choose `database/cozycorner.sql`, and click **Go**.
   (This creates the `cozycorner` database and all its tables for you.)
5. Visit **`http://localhost/cozycorner/index.php`** in your browser. 🎉

If your MySQL username/password is different from the default
(`root` with no password), open `config.php` and update the values at the top.

---

## 📁 Project structure

```
cozycorner/
├── config.php              <- DB settings & site settings (edit this if needed)
├── includes/
│   ├── db.php               <- opens the database connection
│   ├── functions.php        <- helper functions (login check, CSRF, escaping...)
│   ├── header.php           <- shared <head> + navbar for every page
│   └── footer.php           <- shared footer for every page
├── assets/
│   ├── css/style.css        <- every page's styling, in one organized file
│   └── js/script.js         <- small JS touches (password show/hide, etc.)
├── database/
│   └── cozycorner.sql       <- import this to create the database
├── index.php / about.php / baking.php / blog.php ...   <- the actual pages
└── ...
```

Every page follows the same simple pattern:

```php
require_once 'includes/functions.php';   // session + db + helpers
// ...page logic here (handle a form, load some data)...
$pageTitle = 'Page Name';
require 'includes/header.php';           // <head> + navbar
?>
<!-- your HTML goes here -->
<?php require 'includes/footer.php'; ?>
```

---

## 🔒 What was fixed from the original version

The original site worked, but had several real security holes and bugs.
Here's what changed, in plain language:

| Issue | Before | Now |
|---|---|---|
| **SQL Injection** | Login, signup, comments, letters and the blog page built SQL queries by gluing `$_POST`/`$_GET` straight into a string | Every query uses **prepared statements** (`?` placeholders + `bind_param`) |
| **XSS (script injection)** | Blog posts, comments, letters and feedback were printed straight into the page | Every bit of user content is passed through an `e()` helper (`htmlspecialchars`) before being shown |
| **Passwords stored in plain text** | `password_hash`/`password_verify` were missing | Passwords are hashed with PHP's built-in `password_hash()` |
| **No login required on key pages** | `cozypicks.php` (the dashboard) and `publish_blog.php` could be opened by anyone, even logged out | Added a `require_login()` check |
| **`send_letter.php` had no login check** | You could post directly to it even though `letter.php` itself was guarded | Added the same login check to the handler, not just the form page |
| **Broken link** | `blog.php` linked to `view_blogs.php`, a file that didn't exist | Fixed to point to the real `view_blog.php` |
| **No logout page at all** | There was simply no way to log out | Added `logout.php`, properly destroys the session |
| **Feedback stored in a public `.txt` file** | Anyone's name + email was visible to any visitor in plain text | Feedback now lives in the database, and emails are partially masked (`sa**@example.com`) on the public feedback page |
| **No CSRF protection** | Any other website could trick a logged-in visitor's browser into submitting CozyCorner's forms | Every form includes a one-time CSRF token that's checked on submit |
| **Raw DB errors shown to visitors** | A failed DB connection printed the raw MySQL error (leaking server details) | Visitors now see one friendly sentence; the real error is logged for the developer |
| **No mobile navigation** | The navbar didn't collapse on small screens | Now uses Bootstrap's responsive navbar with a hamburger menu |
| **"Reply" box on letters didn't work** | The HTML existed but had no real form behind it | Added a working `reply_letter.php` so replies actually save |
| **Inconsistent style blocks** | Every page had its own `<style>` block, copy-pasted and slightly different each time | Consolidated into one `assets/css/style.css` |

---

## 🎨 Design notes

The original blush-pink, cream, and warm-mauve "cozy" palette and the
Poppins font are kept exactly as they were — nothing about the *feel* of the
site has changed. What's new is consistency: one shared navbar/footer, a
responsive grid (Bootstrap) instead of fixed pixel layouts, visible focus
states for keyboard users, and a small "folded corner" detail on hero cards
as a nod to the site's name.

---

## 🧪 A couple of things worth trying

- Sign up for an account, then try **logging in with the wrong password** —
  you'll get a friendly message instead of a crash.
- Try opening `cozypicks.php` in a private/incognito tab without logging in
  — you'll be redirected straight to the login page.
- Publish a blog post and leave a comment with some `<b>HTML</b>` in it —
  it will show up as plain text, not bold, because it's safely escaped.
