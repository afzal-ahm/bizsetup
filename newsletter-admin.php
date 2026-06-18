<?php
// Newsletter Admin Panel
session_start();

// Simple authentication (you can enhance this with proper login system)
$admin_password = 'admin123'; // Change this to a secure password

if (isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['newsletter_admin'] = true;
    } else {
        $error = 'Invalid password';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: newsletter-admin.php');
    exit;
}

// Check if admin is logged in
if (!isset($_SESSION['newsletter_admin'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Newsletter Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { background-color: #f8f9fa; }
            .login-container { max-width: 400px; margin: 100px auto; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="login-container">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Newsletter Admin</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="password" class="form-label">Admin Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Database connection
include_once "secure-panel/config.php";
$host = $dbhost;
$username = $dbuser;
$password = $dbpass;
$database = $dbname;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle actions
if (isset($_POST['action'])) {
    $id = $_POST['id'];
    
    switch ($_POST['action']) {
        case 'delete':
            $stmt = $pdo->prepare("DELETE FROM newsletter_subscribers WHERE id = ?");
            $stmt->execute([$id]);
            $success = "Subscriber deleted successfully.";
            break;
            
        case 'unsubscribe':
            $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET status = 'unsubscribed' WHERE id = ?");
            $stmt->execute([$id]);
            $success = "Subscriber unsubscribed successfully.";
            break;
            
        case 'activate':
            $stmt = $pdo->prepare("UPDATE newsletter_subscribers SET status = 'active' WHERE id = ?");
            $stmt->execute([$id]);
            $success = "Subscriber activated successfully.";
            break;
    }
}

// Get subscribers with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Build query
$where_conditions = [];
$params = [];

if ($search) {
    $where_conditions[] = "email LIKE ?";
    $params[] = "%$search%";
}

if ($status_filter) {
    $where_conditions[] = "status = ?";
    $params[] = $status_filter;
}

$where_clause = $where_conditions ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Get total count
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM newsletter_subscribers $where_clause");
$countStmt->execute($params);
$total_subscribers = $countStmt->fetchColumn();
$total_pages = ceil($total_subscribers / $limit);

// Get subscribers
$query = "SELECT * FROM newsletter_subscribers $where_clause ORDER BY subscribed_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-active { color: #28a745; }
        .status-inactive { color: #ffc107; }
        .status-unsubscribed { color: #dc3545; }
        .table-responsive { overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-envelope me-2"></i>Newsletter Subscribers</h2>
                    <div>
                        <a href="?logout=1" class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </div>
                </div>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Search and Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="search" placeholder="Search by email..." value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="active" <?php echo $status_filter === 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo $status_filter === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    <option value="unsubscribed" <?php echo $status_filter === 'unsubscribed' ? 'selected' : ''; ?>>Unsubscribed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="newsletter-admin.php" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5>Total Subscribers</h5>
                                <h3><?php echo $total_subscribers; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5>Active</h5>
                                <h3><?php 
                                    $activeStmt = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'active'");
                                    echo $activeStmt->fetchColumn();
                                ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5>Inactive</h5>
                                <h3><?php 
                                    $inactiveStmt = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'inactive'");
                                    echo $inactiveStmt->fetchColumn();
                                ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5>Unsubscribed</h5>
                                <h3><?php 
                                    $unsubStmt = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'unsubscribed'");
                                    echo $unsubStmt->fetchColumn();
                                ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Subscribers Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Subscribers List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Subscribed Date</th>
                                        <th>IP Address</th>
                                        <th>Source</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($subscribers)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No subscribers found.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($subscribers as $subscriber): ?>
                                            <tr>
                                                <td><?php echo $subscriber['id']; ?></td>
                                                <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
                                                <td>
                                                    <span class="status-<?php echo $subscriber['status']; ?>">
                                                        <i class="fas fa-circle me-1"></i>
                                                        <?php echo ucfirst($subscriber['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M d, Y H:i', strtotime($subscriber['subscribed_at'])); ?></td>
                                                <td><?php echo htmlspecialchars($subscriber['ip_address']); ?></td>
                                                <td><?php echo htmlspecialchars($subscriber['source']); ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <?php if ($subscriber['status'] === 'active'): ?>
                                                            <form method="POST" style="display: inline;">
                                                                <input type="hidden" name="id" value="<?php echo $subscriber['id']; ?>">
                                                                <input type="hidden" name="action" value="unsubscribe">
                                                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Unsubscribe this user?')">
                                                                    <i class="fas fa-user-minus"></i>
                                                                </button>
                                                            </form>
                                                        <?php elseif ($subscriber['status'] === 'unsubscribed'): ?>
                                                            <form method="POST" style="display: inline;">
                                                                <input type="hidden" name="id" value="<?php echo $subscriber['id']; ?>">
                                                                <input type="hidden" name="action" value="activate">
                                                                <button type="submit" class="btn btn-success btn-sm">
                                                                    <i class="fas fa-user-check"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                        
                                                        <form method="POST" style="display: inline;">
                                                            <input type="hidden" name="id" value="<?php echo $subscriber['id']; ?>">
                                                            <input type="hidden" name="action" value="delete">
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this subscriber? This action cannot be undone.')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
