<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AgroSmart Store</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .login-container h2 {
            color: #2E7D32;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }
        .error-msg {
            background: #f8d7da;
            color: #721c24;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .success-msg {
            background: #d4edda;
            color: #155724;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        button {
            width: 100%;
            cursor: pointer;
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #2E7D32 0%, #E65100 100%); min-height: 100vh;">
    <div class="login-container">
        <h2>🌾 AgroSmart Admin</h2>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="error-msg">Invalid username or password</div>
        <?php endif; ?>
        
        <?php if (isset($_GET['logged_out'])): ?>
            <div class="success-msg">You have been logged out</div>
        <?php endif; ?>
        
        <form action="authenticate.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Enter username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p style="text-align: center; margin-top: 1rem; font-size: 0.85rem; color: #666;">
            Default: username: admin, password: admin123
        </p>
    </div>
</body>
</html>