<?php
require_once "config.php";
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: dashboard.php");
}
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Dashboard - Sky Blue</title>
    <style>
        /* Creates the blurred Sky Blue background layer */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Using a gradient to give the sky blue some depth */
            background: linear-gradient(135deg, #87CEEB, #00BFFF);
            filter: blur(20px); /* Heavy blur for a smooth "aura" look */
            transform: scale(1.1);
            z-index: -1;
        }

        body { 
            font-family: 'Segoe UI', sans-serif; 
            margin: 0; 
            color: #1e293b;
            min-height: 100vh;
            /* A very light white tint so the blue isn't too overwhelming */
            background-color: rgba(255, 255, 255, 0.3); 
        }

        .header { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px);
            padding: 20px 40px; 
            box-shadow: 0 1px 10px rgba(0,0,0,0.05); 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .container { padding: 40px; max-width: 1100px; margin: auto; }
        .action-bar { display: flex; gap: 15px; margin-bottom: 25px; }
        
        .btn { padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.2s; display: inline-flex; align-items: center; }
        
        /* Styled buttons to match the sky blue theme */
        .btn-outline { 
            border: 1px solid #bae6fd; 
            color: #0369a1; 
            background: rgba(255, 255, 255, 0.7); 
        }
        .btn-outline:hover { 
            background: #e0f2fe; 
            transform: translateY(-1px); 
        }
        
        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0; 
            background: rgba(255, 255, 255, 0.95); 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); 
        }

        th { 
            background: #272829ff; /* Very light blue for headers */
            padding: 15px; 
            text-align: left; 
            color: #e5e8e9ff; 
            font-weight: 700; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            border-bottom: 2px solid #e0f2fe;
        }

        td { padding: 15px; border-bottom: 2px solid #f1f5f9; }
        tr:hover { background: #e7e3e3ff; }
        
        .badge { padding: 5px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; }
        .badge-edit { background: #e0f2fe; color: #0369a1; }
        .badge-delete { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0; color:#0369a1;">💎 Smart Inventory Dashboard</h2>
        <a href="logout.php" class="btn btn-outline" style="color:#ef4444; border-color:#fecaca;">Logout</a>
    </div>

    <div class="container">
        <div class="action-bar">
            <a href="menu.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="add_product.php" class="btn btn-outline">➕ Add Product</a>
            <a href="reports.php" class="btn btn-outline">📊 Reports</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Total Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $products->fetch_assoc()): ?>
                <tr>
                    <td style="font-weight:600; color:#0f172a;"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td style="color:#64748b; font-weight:500;">$<?php echo number_format($row['quantity'] * $row['price'], 2); ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="badge badge-edit">Edit</a>
                        <a href="dashboard.php?delete=<?php echo $row['id']; ?>" class="badge badge-delete" onclick="return confirm('Delete item?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>