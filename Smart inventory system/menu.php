<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu - Smart Inventory System</title>
    <style>
        :root {
            --primary: #0369a1; /* Sky blue primary */
            --glass: rgba(255, 255, 255, 0.85);
            --dark: #0f172a;
            --secondary: #64748b;
        }

        /* Consistent Sky Blue Blurred Background */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #87CEEB, #00BFFF);
            filter: blur(20px);
            transform: scale(1.1);
            z-index: -1;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--dark);
        }

        .dashboard-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            width: 90%;
            max-width: 800px;
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            text-align: center;
        }

        h2 {
            color: var(--primary);
            font-size: 2.2rem;
            margin-bottom: 10px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        p.subtitle {
            color: var(--secondary);
            margin-bottom: 45px;
            font-size: 1.1rem;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 35px 20px;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-item:hover {
            transform: translateY(-8px);
            background: white;
            box-shadow: 0 15px 30px rgba(3, 105, 161, 0.15);
            border-color: var(--primary);
        }

        .icon {
            font-size: 50px;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        .menu-item span {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .menu-item p {
            font-size: 0.85rem;
            color: var(--secondary);
            margin: 8px 0 0 0;
            font-weight: 400;
        }

        .logout-container {
            margin-top: 50px;
            padding-top: 25px;
            border-top: 1px solid rgba(3, 105, 161, 0.1);
        }

        .logout-link {
            color: #ef4444;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            transition: background 0.2s;
        }

        .logout-link:hover {
            background: rgba(239, 68, 68, 0.08);
            text-decoration: none;
        }

        /* Bottom Accent Bars */
        .view-inv { border-bottom: 5px solid #0ea5e9; }
        .add-inv { border-bottom: 5px solid #22c55e; }
        .gen-rep { border-bottom: 5px solid #f59e0b; }
    </style>
</head>
<body>

<div class="dashboard-card">
    <h2>Smart Inventory System</h2>
    <p class="subtitle">Welcome back! Manage your business with ease.</p>
    
    <div class="menu-grid">
        <a href="dashboard.php" class="menu-item view-inv">
            <div class="icon">📦</div>
            <span>View Inventory</span>
            <p>Track your current stock</p>
        </a>

        <a href="add_product.php" class="menu-item add-inv">
            <div class="icon">➕</div>
            <span>Add Product</span>
            <p>Register new items</p>
        </a>

        <a href="reports.php" class="menu-item gen-rep">
            <div class="icon">📊</div>
            <span>Reports</span>
            <p>Value & status analysis</p>
        </a>
    </div>

    <div class="logout-container">
        <a href="logout.php" class="logout-link">
            <span>🚪 Logout System</span>
        </a>
    </div>
</div>

</body>
</html>