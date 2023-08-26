<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Claim System</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header-container">
        <div class="container">
            <h1 class="header-title">E-Claim System</h1>
            <nav class="header-nav">
                <ul class="nav-list">
                    <li><a href="dashboard.php">Home</a></li>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) : ?>
                            <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
                        <?php else : ?>
                            <li><a href="dashboard.php">User Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="logout.php">Logout</a></li>
                         <?php else : ?>
                        <li><a href="admin_dashboard.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
