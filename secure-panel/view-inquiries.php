<?php
/**
 * Contact Inquiries Management Panel
 * View and manage contact form submissions
 */

error_reporting(0);
ob_start();
session_start();
include_once 'config.php';

// Check if user is logged in (you may need to adjust this based on your auth system)
// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header('Location: login.php');
//     exit;
// }

// Handle status updates
if (isset($_POST['update_status']) && isset($_POST['inquiry_id']) && isset($_POST['new_status'])) {
    $inquiry_id = intval($_POST['inquiry_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);
    $notes = isset($_POST['notes']) ? mysqli_real_escape_string($conn, $_POST['notes']) : '';
    
    $update_query = "UPDATE contact_inquiries SET status = ?, notes = ?, updated_at = NOW()";
    if ($new_status === 'responded') {
        $update_query .= ", responded_at = NOW()";
    }
    $update_query .= " WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $update_query);
    if ($new_status === 'responded') {
        mysqli_stmt_bind_param($stmt, 'ssi', $new_status, $notes, $inquiry_id);
    } else {
        mysqli_stmt_bind_param($stmt, 'ssi', $new_status, $notes, $inquiry_id);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Inquiry status updated successfully!";
    } else {
        $error_message = "Error updating inquiry status.";
    }
    mysqli_stmt_close($stmt);
}

// Pagination settings
$records_per_page = 20;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $records_per_page;

// Filter settings
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$source_filter = isset($_GET['source']) ? $_GET['source'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query with filters
$where_conditions = [];
$params = [];
$param_types = '';

if (!empty($status_filter)) {
    $where_conditions[] = "status = ?";
    $params[] = $status_filter;
    $param_types .= 's';
}

if (!empty($source_filter)) {
    $where_conditions[] = "source = ?";
    $params[] = $source_filter;
    $param_types .= 's';
}

if (!empty($search)) {
    $where_conditions[] = "(first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR message LIKE ? OR service_name LIKE ?)";
    $search_param = '%' . $search . '%';
    $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param, $search_param]);
    $param_types .= 'sssss';
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Get total count for pagination
$count_query = "SELECT COUNT(*) as total FROM contact_inquiries $where_clause";
if (!empty($params)) {
    $count_stmt = mysqli_prepare($conn, $count_query);
    mysqli_stmt_bind_param($count_stmt, $param_types, ...$params);
    mysqli_stmt_execute($count_stmt);
    $count_result = mysqli_stmt_get_result($count_stmt);
} else {
    $count_result = mysqli_query($conn, $count_query);
}
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $records_per_page);

// Get inquiries with pagination
$main_query = "SELECT * FROM contact_inquiries $where_clause ORDER BY created_at DESC LIMIT $records_per_page OFFSET $offset";
if (!empty($params)) {
    $main_stmt = mysqli_prepare($conn, $main_query);
    mysqli_stmt_bind_param($main_stmt, $param_types, ...$params);
    mysqli_stmt_execute($main_stmt);
    $inquiries_result = mysqli_stmt_get_result($main_stmt);
} else {
    $inquiries_result = mysqli_query($conn, $main_query);
}

// Get statistics
$stats_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new_count,
    SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read_count,
    SUM(CASE WHEN status = 'responded' THEN 1 ELSE 0 END) as responded_count,
    SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed_count,
    SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) as today_count
FROM contact_inquiries";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Contact Inquiries - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .inquiry-card {
            transition: all 0.3s ease;
            border-left: 4px solid #dee2e6;
        }
        .inquiry-card.status-new { border-left-color: #dc3545; }
        .inquiry-card.status-read { border-left-color: #ffc107; }
        .inquiry-card.status-responded { border-left-color: #28a745; }
        .inquiry-card.status-closed { border-left-color: #6c757d; }
        
        .priority-badge.priority-urgent { background: #dc3545; }
        .priority-badge.priority-high { background: #fd7e14; }
        .priority-badge.priority-medium { background: #ffc107; color: #000; }
        .priority-badge.priority-low { background: #6c757d; }
        
        .source-badge.source-contact_page { background: #007bff; }
        .source-badge.source-service_detail { background: #28a745; }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="fas fa-envelope me-2"></i>Contact Inquiries
                    </h1>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary" onclick="location.reload()">
                            <i class="fas fa-sync-alt me-1"></i>Refresh
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>

                <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card stats-card text-center">
                            <div class="card-body">
                                <h3 class="mb-1"><?php echo $stats['total']; ?></h3>
                                <small>Total Inquiries</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-danger text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-1"><?php echo $stats['new_count']; ?></h3>
                                <small>New</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-warning text-dark text-center">
                            <div class="card-body">
                                <h3 class="mb-1"><?php echo $stats['read_count']; ?></h3>
                                <small>Read</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-success text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-1"><?php echo $stats['responded_count']; ?></h3>
                                <small>Responded</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-secondary text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-1"><?php echo $stats['closed_count']; ?></h3>
                                <small>Closed</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-info text-white text-center">
                            <div class="card-body">
                                <h3 class="mb-1"><?php echo $stats['today_count']; ?></h3>
                                <small>Today</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    <option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>New</option>
                                    <option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>Read</option>
                                    <option value="responded" <?php echo $status_filter === 'responded' ? 'selected' : ''; ?>>Responded</option>
                                    <option value="closed" <?php echo $status_filter === 'closed' ? 'selected' : ''; ?>>Closed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Source</label>
                                <select name="source" class="form-select">
                                    <option value="">All Sources</option>
                                    <option value="contact_page" <?php echo $source_filter === 'contact_page' ? 'selected' : ''; ?>>Contact Page</option>
                                    <option value="service_detail" <?php echo $source_filter === 'service_detail' ? 'selected' : ''; ?>>Service Detail</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" class="form-control" placeholder="Search by name, email, or message..." value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="view-inquiries.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Inquiries List -->
                <div class="row">
                    <?php if (mysqli_num_rows($inquiries_result) > 0): ?>
                        <?php while ($inquiry = mysqli_fetch_assoc($inquiries_result)): ?>
                        <div class="col-12 mb-3">
                            <div class="card inquiry-card status-<?php echo $inquiry['status']; ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="card-title mb-0">
                                                    <?php echo htmlspecialchars($inquiry['first_name'] . ' ' . $inquiry['last_name']); ?>
                                                    <?php if ($inquiry['status'] === 'new'): ?>
                                                        <span class="badge bg-danger ms-2">NEW</span>
                                                    <?php endif; ?>
                                                </h5>
                                                <div class="d-flex gap-1">
                                                    <span class="badge priority-badge priority-<?php echo $inquiry['priority']; ?>">
                                                        <?php echo strtoupper($inquiry['priority']); ?>
                                                    </span>
                                                    <span class="badge source-badge source-<?php echo $inquiry['source']; ?>">
                                                        <?php echo $inquiry['source'] === 'contact_page' ? 'Contact' : 'Service'; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-envelope me-1"></i>
                                                <a href="mailto:<?php echo $inquiry['email']; ?>"><?php echo htmlspecialchars($inquiry['email']); ?></a>
                                                <?php if (!empty($inquiry['phone'])): ?>
                                                    <span class="ms-3">
                                                        <i class="fas fa-phone me-1"></i>
                                                        <a href="tel:<?php echo $inquiry['phone']; ?>"><?php echo htmlspecialchars($inquiry['phone']); ?></a>
                                                    </span>
                                                <?php endif; ?>
                                            </p>
                                            
                                            <?php if (!empty($inquiry['service_name'])): ?>
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-cog me-1"></i>
                                                <strong>Service:</strong> <?php echo htmlspecialchars($inquiry['service_name']); ?>
                                                <?php if (!empty($inquiry['service_category'])): ?>
                                                    <small class="text-muted">(<?php echo htmlspecialchars($inquiry['service_category']); ?>)</small>
                                                <?php endif; ?>
                                            </p>
                                            <?php endif; ?>
                                            
                                            <p class="card-text">
                                                <?php echo nl2br(htmlspecialchars(strlen($inquiry['message']) > 200 ? substr($inquiry['message'], 0, 200) . '...' : $inquiry['message'])); ?>
                                            </p>
                                            
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                <?php echo date('M j, Y g:i A', strtotime($inquiry['created_at'])); ?>
                                                <?php if (!empty($inquiry['responded_at'])): ?>
                                                    <span class="ms-3">
                                                        <i class="fas fa-reply me-1"></i>
                                                        Responded: <?php echo date('M j, Y g:i A', strtotime($inquiry['responded_at'])); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <form method="POST" class="d-flex flex-column gap-2">
                                                <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                                
                                                <select name="new_status" class="form-select form-select-sm" required>
                                                    <option value="new" <?php echo $inquiry['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                                    <option value="read" <?php echo $inquiry['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                                                    <option value="responded" <?php echo $inquiry['status'] === 'responded' ? 'selected' : ''; ?>>Responded</option>
                                                    <option value="closed" <?php echo $inquiry['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                                                </select>
                                                
                                                <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Add notes..."><?php echo htmlspecialchars($inquiry['notes']); ?></textarea>
                                                
                                                <button type="submit" name="update_status" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-save me-1"></i>Update
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                        
                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                        <div class="col-12">
                            <nav aria-label="Inquiries pagination">
                                <ul class="pagination justify-content-center">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo ($page - 1); ?>&status=<?php echo $status_filter; ?>&source=<?php echo $source_filter; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo $status_filter; ?>&source=<?php echo $source_filter; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($page < $total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo ($page + 1); ?>&status=<?php echo $status_filter; ?>&source=<?php echo $source_filter; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                            
                            <p class="text-center text-muted">
                                Showing <?php echo ($offset + 1); ?>-<?php echo min($offset + $records_per_page, $total_records); ?> of <?php echo $total_records; ?> inquiries
                            </p>
                        </div>
                        <?php endif; ?>
                        
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No inquiries found</h4>
                                <p class="text-muted">No contact inquiries match your current filters.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
