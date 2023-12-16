<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your To-Do List App</title>
    <style>
        /* CSS Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .user-actions {
            display: flex;
            align-items: center;
        }

        .user-actions button {
            margin-left: 10px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include_once 'includes/auth.php'; ?>
    <header>
        <div class="logo">To do list app</div>
        <div class="user-actions">
            <?php if (isUserLoggedIn()): ?>
                <!-- User is logged in -->
                <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                <form action="logout.php" method="post">
                    <button type="submit">Sign Out</button>
                </form>
            <?php else: ?>
                <!-- User is not logged in -->
                <a href="login.php"><button>Sign In</button></a>
            <?php endif; ?>
        </div>
    </header>
</body>
