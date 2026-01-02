<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!function_exists('sanitize')) {
        function sanitize($data) {
            global $conn;
            return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($data)));
        }
    }

    $user = sanitize($_POST['username']);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if (empty($user) || empty($pass)) {
        $message = "<div class='alert alert-error'>Please fill in all fields.</div>";
    } elseif ($pass !== $confirm_pass) {
        $message = "<div class='alert alert-error'>Passwords do not match!</div>";
    } else {
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $user);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $message = "<div class='alert alert-error'>Username already taken!</div>";
        } else {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $user, $hashed_password);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Account created! <a href='login.php'>Login here</a></div>";
            } else {
                $message = "<div class='alert alert-error'>Database Error: " . $conn->error . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Smart Inventory</title>
    <style>
        :root {
            --accent: #2166faff; /* Green for registration/success */
            --accent-hover: #001fd1ff;
            --glass: rgba(255, 255, 255, 0.95);
        }

        body { 
            font-family: 'Inter', 'Segoe UI', sans-serif; 
            background-color: #58aeffff;
            background-image: 
                radial-gradient(at 0% 100%, hsla(140,40%,20%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(225,39%,30%,1) 0, transparent 50%);
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
        }

        .reg-card { 
            background: var(--glass);
            backdrop-filter: blur(12px);
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); 
            width: 100%;
            max-width: 420px; 
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin: 20px;
        }

        .logo-icon {
            font-size: 3rem;
            margin-bottom: 10px;
            display: block;
        }

        h2 { color: #111827; margin: 0 0 10px; font-weight: 800; font-size: 1.8rem; }
        p.subtitle { color: #6b7280; margin-bottom: 30px; font-size: 0.95rem; }

        .input-group { text-align: left; margin-bottom: 15px; }
        label { display: block; font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 6px; margin-left: 4px; }

        input { 
            width: 100%; 
            padding: 12px 16px; 
            border: 1px solid #d1d5db; 
            border-radius: 12px; 
            box-sizing: border-box; 
            font-size: 1rem; 
            transition: all 0.2s ease;
            outline: none;
        }

        input:focus { 
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
        }

        button { 
            width: 100%; 
            padding: 14px; 
            background: var(--accent); 
            color: white; 
            border: none; 
            border-radius: 12px; 
            cursor: pointer; 
            font-weight: 700; 
            font-size: 1rem;
            margin-top: 15px; 
            transition: all 0.2s; 
        }

        button:hover { 
            background: var(--accent-hover); 
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(34, 197, 94, 0.3);
        }

        .alert { 
            padding: 12px; 
            border-radius: 12px; 
            font-size: 0.85rem; 
            margin-bottom: 20px;
            border: 1px solid transparent;
        }
        .alert-error { background: #fef2f2; color: #b91c1c; border-color: #fee2e2; }
        .alert-success { background: #f0fdf4; color: #166534; border-color: #dcfce7; }
        .alert-success a { font-weight: bold; color: #16a34a; }

        .footer { 
            margin-top: 25px; 
            font-size: 0.9rem; 
            color: #4b5563; 
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
        }

        .footer a { color: #2563eb; text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>

<div class="reg-card">
    <span class="logo-icon">📝</span>
    <h2>Get Started</h2>
    <p class="subtitle">Create an account to manage your inventory</p>

    <?php echo $message; ?>

    <form method="post" action="register.php">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Choose a unique username" required>
        </div>
        
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Create a strong password" required>
        </div>

        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Repeat your password" required>
        </div>

        <button type="submit">Create Account</button>
    </form>

    <div class="footer">
        Already have an account? <a href="login.php">Sign In</a>
    </div>
</div>

</body>
</html>