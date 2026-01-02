<?php
require_once "config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 1. Fetch Summary Data
$summary_query = "SELECT 
                    COUNT(id) as total_products, 
                    SUM(quantity) as total_items, 
                    SUM(quantity * price) as total_value 
                  FROM products";
$summary_result = $conn->query($summary_query);
$summary = $summary_result->fetch_assoc();

// 2. Fetch Detailed List
$products = $conn->query("SELECT * FROM products ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Report - Smart System</title>
    <?php

// 1. Fetch Summary Data
$summary_query = "SELECT 
                    COUNT(id) as total_products, 
                    SUM(quantity) as total_items, 
                    SUM(quantity * price) as total_value 
                  FROM products";
$summary_result = $conn->query($summary_query);
$summary = $summary_result->fetch_assoc();

// 2. Fetch Detailed List
$products = $conn->query("SELECT * FROM products ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Report - Smart System</title>
    <style>
        :root {
            --primary: #0369a1;
            --glass: rgba(255, 247, 247, 0.9);
        }

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
            padding: 40px 20px;
            color: #1e293b;
            background-color: rgba(255, 255, 255, 0.3); 
        }

        .report-container { 
            max-width: 1000px; 
            margin: 0 auto; 
            background: var(--glass);
            backdrop-filter: blur(10px);
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .header { 
            text-align: center; 
            border-bottom: 2px solid #e0f2fe; 
            margin-bottom: 15px; 
            padding-bottom: 20px; 
        }
        
        .header h2 { color: var(--primary); margin: 0; font-size: 1.8rem; }
        .header p { color: #64748b; margin-top: 5px; font-weight: 500; }

        /* Navigation placement above the right column */
        .top-action-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }

        .btn-menu {
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.5);
            padding: 8px 15px;
            border-radius: 10px;
            border: 1px solid #bae6fd;
            transition: 0.2s;
        }

        .btn-menu:hover {
            background: white;
            transform: translateY(-2px);
        }

        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 20px; 
            margin-bottom: 35px; 
        }

        .stat-card { 
            text-align: center; 
            padding: 20px; 
            background: rgba(255, 255, 255, 0.6); 
            border-radius: 15px; 
            border: 1px solid #91989cff; 
        }

        .stat-card h3 { margin: 0; color: #64748b; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-card p { margin: 10px 0 0; font-size: 1.6rem; font-weight: 800; color: var(--primary); }

        table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; border-radius: 12px; overflow: hidden; }
        th { background: #1f2020ff; color: #eff3f5ff; padding: 15px; text-align: left; font-size: 0.85rem; }
        td { padding: 15px; border-bottom: 1px solid #888d91ff; background: rgba(202, 197, 197, 0.4); }
        
        .low-stock { color: #ef4444; font-weight: 700; background: #fee2e2; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; }
        
        .btn-print { 
            background: var(--primary); 
            color: white; 
            padding: 12px 24px; 
            text-decoration: none; 
            border-radius: 10px;  
            display: inline-block; 
            margin-bottom: 25px; 
            font-weight: 600;
            transition: 0.2s;
        }

        @media print { 
            body::before, .top-action-bar, .btn-print { display: none; }
            body { background: white; padding: 0; }
            .report-container { box-shadow: none; border: none; width: 100%; max-width: 100%; padding: 0; }
            .stat-card { border: 1px solid #ccc; background: white; }
            th { background: #eee !important; color: black; border: 1px solid #ccc; }
            td { border: 1px solid #ccc; }
        }
    </style>
</head>
<body>

<div class="report-container">
    <div class="header">
        <h2>Smart Inventory Management System</h2>
        <p>Valuation Report • <?php echo date('F d, Y'); ?></p>
    </div>

    <div class="top-action-bar">
        <a href="menu.php" class="btn-menu">🏠 Return to Menu</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Unique Products</h3>
            <p><?php echo $summary['total_products'] ?? 0; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Stock Volume</h3>
            <p><?php echo $summary['total_items'] ?? 0; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Value</h3>
            <p>$<?php echo number_format($summary['total_value'] ?? 0, 2); ?></p>
        </div>
    </div>

    <a href="#" class="btn-print" onclick="window.print()">🖨️ Print Detailed Report</a>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($products && $products->num_rows > 0): ?>
                <?php while($row = $products->fetch_assoc()): 
                    $subtotal = $row['quantity'] * $row['price'];
                    $isLow = $row['quantity'] < 5;
                ?>
                <tr>
                    <td style="font-weight:600;"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td style="font-weight:600; color: #334155;">$<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <?php if($isLow): ?>
                            <span class="low-stock">⚠️ Low Stock</span>
                        <?php else: ?>
                            <span style="color: #10b981; font-weight:600;">✓ Healthy</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding: 30px;">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
