<?php
require_once "config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize($_POST['name']);
    $qty = sanitize($_POST['qty']);
    $price = sanitize($_POST['price']);

    if (!empty($name) && !empty($qty) && !empty($price)) {
        $stmt = $conn->prepare("INSERT INTO products (name, quantity, price) VALUES (?, ?, ?)");
        $stmt->bind_param("sid", $name, $qty, $price);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>✨ Product added successfully!</div>";
        } else {
            $message = "<div class='alert alert-error'>❌ Error: Could not save product.</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert alert-error'>⚠️ Please fill in all fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Smart Inventory</title>
    <style>
        :root {
            --primary: #0369a1; /* Matching the sky blue dashboard theme */
            --primary-hover: #0284c7;
            --glass: rgba(255, 255, 255, 0.9);
        }

        /* The blurred Sky Blue background layer */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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
            background-color: rgba(255, 255, 255, 0.3); 
        }

        .form-card { 
            background: var(--glass);
            backdrop-filter: blur(10px);
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; 
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        h2 { color: #0369a1; text-align: center; margin-bottom: 25px; font-weight: 800; }

        .input-group { margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 8px; }

        input { 
            width: 100%; 
            padding: 12px 16px; 
            border: 1px solid #bae6fd; 
            border-radius: 12px; 
            box-sizing: border-box; 
            font-size: 1rem; 
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        input:focus { 
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(3, 105, 161, 0.1);
            background: #fff;
        }

        .btn-save { 
            width: 100%; 
            padding: 14px; 
            background: var(--primary); 
            color: white; 
            border: none; 
            border-radius: 12px; 
            cursor: pointer; 
            font-weight: 700; 
            font-size: 1rem;
            margin-top: 10px;
            transition: all 0.2s;
        }

        .btn-save:hover { 
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(3, 105, 161, 0.3);
        }

        .alert { 
            padding: 14px; 
            border-radius: 12px; 
            font-size: 0.9rem; 
            margin-bottom: 20px; 
            text-align: center;
        }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
        .alert-error { background: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }

        .nav-links { 
            margin-top: 25px; 
            text-align: center; 
            border-top: 1px solid #e0f2fe;
            padding-top: 20px;
            display: flex;
            justify-content: space-around;
        }
        .nav-links a { 
            text-decoration: none; 
            color: #0369a1; 
            font-size: 0.85rem; 
            font-weight: 600; 
        }
        .nav-links a:hover { opacity: 0.7; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Add New Item</h2>
    
    <?php echo $message; ?>

    <form method="POST">
        <div class="input-group">
            <label>Product Name</label>
            <input type="text" name="name" placeholder="e.g. Mechanical Keyboard" required>
        </div>
        
        <div class="input-group">
            <label>Quantity in Stock</label>
            <input type="number" name="qty" placeholder="Enter amount" required>
        </div>
        
        <div class="input-group">
            <label>Unit Price ($)</label>
            <input type="number" step="0.01" name="price" placeholder="0.00" required>
        </div>
        
        <button type="submit" class="btn-save">Save Product</button>
    </form>

    <div class="nav-links">
        <a href="menu.php">🏠 Main Menu</a>
        <a href="dashboard.php">📦 View Inventory</a>
    </div>
</div>

</body>
</html>