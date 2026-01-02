<?php
require_once "config.php";
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = sanitize($_POST['username']);
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: menu.php");
            exit();
        }
    }
    $error = "Invalid username or password!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Inventory</title>
    <style>
        :root {
            --accent: #4f46e5;
            --accent-hover: #4338ca;
            --glass: rgba(255, 255, 255, 0.95);
        }

        body { 
            font-family: 'Inter', 'Segoe UI', sans-serif; 
            /* Modern Mesh Gradient Background */
            background-color: #58aeffff;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }

        .login-card { 
            background: var(--glass);
            backdrop-filter: blur(10px);
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); 
            width: 100%;
            max-width: 400px; 
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .logo-circle {
            width: 60px;
            height: 60px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }

        h2 { color: #111827; margin: 0 0 8px; font-weight: 800; font-size: 1.75rem; }
        p.desc { color: #6b7280; margin-bottom: 30px; font-size: 0.95rem; }

        .input-group {
            text-align: left;
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
            margin-left: 5px;
        }

        input { 
            width: 100%; 
            padding: 12px 16px; 
            border: 1px solid #d1d5db; 
            border-radius: 12px; 
            box-sizing: border-box; 
            font-size: 1rem; 
            transition: all 0.2s;
            outline: none;
        }

        input:focus { 
            border-color: var(--accent);
            ring: 4px rgba(79, 70, 229, 0.1);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
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
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        button:hover { 
            background: var(--accent-hover); 
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .error { 
            color: #b91c1c; 
            background: #fef2f2; 
            padding: 12px; 
            border-radius: 12px; 
            font-size: 0.85rem; 
            margin-bottom: 20px;
            border: 1px solid #fee2e2;
        }

        .footer { 
            margin-top: 25px; 
            font-size: 0.9rem; 
            color: #4b5563; 
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
        }

        .footer a { color: var(--accent); text-decoration: none; font-weight: 700; }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-circle">📦</div>
        <h2>Welcome Back</h2>
        <p class="desc">Please enter your credentials to continue</p>

        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required autofocus>
            </div>
            
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit">
                Sign In
            </button>
        </form>

        <div class="footer">
            New here? <a href="register.php">Create an account</a>
        </div>
    </div>
</body>
</html>