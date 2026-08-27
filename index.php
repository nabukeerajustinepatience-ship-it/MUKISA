<?php
require_once '../backend/config/config.php';

if (!isAdminLoggedIn()) {
    redirect('login.php');
}

$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pending_orders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
$total_revenue = $pdo->query("SELECT COALESCE(SUM(total_amount), 0) FROM orders WHERE status != 'cancelled'")->fetchColumn();
$recent_orders = $pdo->query("SELECT * FROM orders ORDER BY order_date DESC LIMIT 10")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AgroSmart Store</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 250px;
            background: #1a1a1a;
            color: white;
            padding: 1.5rem;
        }
        .admin-sidebar h3 {
            color: #2E7D32;
            margin-bottom: 2rem;
        }
        .admin-sidebar a {
            display: block;
            color: #ccc;
            text-decoration: none;
            padding: 0.75rem 0;
            transition: color 0.3s;
        }
        .admin-sidebar a:hover {
            color: #E65100;
        }
        .admin-content {
            flex: 1;
            padding: 2rem;
            background: #f5f5f5;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card h3 {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #2E7D32;
        }
        .orders-table {
            background: white;
            border-radius: 12px;
            overflow-x: auto;
            padding: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #2E7D32;
            color: white;
        }
        .logout-btn {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #333;
        }
        .logout-btn a {
            color: #E65100;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-sidebar">
            <h3>🌾 AgroSmart Admin</h3>
            <a href="index.php">📊 Dashboard</a>
            <a href="products.php">📦 Manage Products</a>
            <a href="orders.php">📋 Manage Orders</a>
            <div class="logout-btn">
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>
        <div class="admin-content">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
            <p>Here's what's happening with your store today.</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Products</h3>
                    <div class="number"><?php echo $total_products; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Total Orders</h3>
                    <div class="number"><?php echo $total_orders; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Pending Orders</h3>
                    <div class="number"><?php echo $pending_orders; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Total Revenue</h3>
                    <div class="number"><?php echo formatMoney($total_revenue); ?></div>
                </div>
            </div>
            
            <h2>Recent Orders</h2>
            <div class="orders-table">
                <table>
                    <thead>
                        <tr><th>Order ID</th><th>Customer</th><th>Phone</th><th>Total</th><th>Status</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($recent_orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                            <td><?php echo formatMoney($order['total_amount']); ?></td>
                            <td><?php echo ucfirst($order['status']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($order['order_date'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(count($recent_orders) == 0): ?>
                        <tr><td colspan="6" style="text-align: center;">No orders yet</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>