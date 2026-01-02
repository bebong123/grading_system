<?php
require_once "config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$product = null;

// 1. Fetch the product details
if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Cast to int for security
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

// 2. Handle the Update Action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $name = sanitize($_POST['name']);
    $qty = (int)$_POST['qty'];
    $price = (float)$_POST['price'];

    $update_stmt = $conn->prepare("UPDATE products SET name=?, quantity=?, price=? WHERE id=?");
    $update_stmt->bind_param("sidi", $name, $qty, $price, $id);

    if ($update_stmt->execute()) {
        $message = "<div class='alert alert-success'>✨ Product updated successfully! <a href='dashboard.php' style='color: inherit; font-weight:bold;'>View Changes</a></div>";
        // Refresh product data to show updated values in form
        $product['name'] = $name;
        $product['quantity'] = $qty;
        $product['price'] = $price;
    } else {
        $message = "<div class='alert alert-error'>❌ Update failed.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Smart System</title>
    <style>
        :root {
            --primary: #0369a1;
            --primary-hover: #0284c7;
            --glass: rgba(255, 255, 255, 0.9);
        }

        /* The Blurred Sky Blue Background */
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

        .edit-box { 
            background: var(--glass);
            backdrop-filter: blur(10px);
            padding: 40px; 
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; 
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        h2 { color: #0369a1; text-align: center; margin-bottom: 25px; font-weight: 800; margin-top: 0; }

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

        .btn-update { 
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

        .btn-update:hover { 
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

        .cancel-link { 
            display: block;
            margin-top: 25px; 
            text-align: center; 
            text-decoration: none; 
            color: #64748b; 
            font-size: 0.9rem; 
            font-weight: 600; 
        }
        .cancel-link:hover { color: #ef4444; }
    </style>
</head>
<body>

<div class="edit-box">
    <h2>Edit Product</h2>
    
    <?php echo $message; ?>

    <?php if($product): ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        
        <div class="input-group">
            <label>Product Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        
        <div class="input-group">
            <label>Quantity</label>
            <input type="number" name="qty" value="<?php echo $product['quantity']; ?>" required>
        </div>
        
        <div class="input-group">
            <label>Price ($)</label>
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
        </div>
        
        <button type="submit" name="update" class="btn-update">Update Product</button>
    </form>
    <?php else: ?>
        <div class="alert alert-error">Product not found.</div>
    <?php endif; ?>

    <a href="dashboard.php" class="cancel-link">← Cancel and Go Back</a>
</div>

</body>
</html>