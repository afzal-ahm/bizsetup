<?php
ob_start();
session_start();
error_reporting(0);
require('config.php');

// Handle actions
if (isset($_POST['action'])) {
    $id = $_POST['id'];
    
    switch ($_POST['action']) {
        case 'delete':
            $stmt = mysqli_prepare($conn, "DELETE FROM newsletter_subscribers WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $success = "Subscriber deleted successfully.";
            break;
            
        case 'unsubscribe':
            $stmt = mysqli_prepare($conn, "UPDATE newsletter_subscribers SET status = 'unsubscribed', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $success = "Subscriber unsubscribed successfully.";
            break;
            
        case 'activate':
            $stmt = mysqli_prepare($conn, "UPDATE newsletter_subscribers SET status = 'active', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $success = "Subscriber activated successfully.";
            break;
    }
}

// Handle bulk actions
if (isset($_POST['bulk_action']) && isset($_POST['selected_ids'])) {
    $selected_ids = $_POST['selected_ids'];
    $bulk_action = $_POST['bulk_action'];
    
    if (!empty($selected_ids) && $bulk_action != '') {
        $ids = implode(',', array_map('intval', $selected_ids));
        
        switch ($bulk_action) {
            case 'delete':
                $query = "DELETE FROM newsletter_subscribers WHERE id IN ($ids)";
                mysqli_query($conn, $query);
                $success = count($selected_ids) . " subscribers deleted successfully.";
                break;
                
            case 'unsubscribe':
                $query = "UPDATE newsletter_subscribers SET status = 'unsubscribed', updated_at = CURRENT_TIMESTAMP WHERE id IN ($ids)";
                mysqli_query($conn, $query);
                $success = count($selected_ids) . " subscribers unsubscribed successfully.";
                break;
                
            case 'activate':
                $query = "UPDATE newsletter_subscribers SET status = 'active', updated_at = CURRENT_TIMESTAMP WHERE id IN ($ids)";
                mysqli_query($conn, $query);
                $success = count($selected_ids) . " subscribers activated successfully.";
                break;
        }
    }
}

// Get filters
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$status_filter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

// Build query
$where_conditions = [];
if ($search) {
    $where_conditions[] = "email LIKE '%$search%'";
}
if ($status_filter) {
    $where_conditions[] = "status = '$status_filter'";
}
if ($date_from) {
    $where_conditions[] = "DATE(subscribed_at) >= '$date_from'";
}
if ($date_to) {
    $where_conditions[] = "DATE(subscribed_at) <= '$date_to'";
}

$where_clause = $where_conditions ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Get total count
$count_query = "SELECT COUNT(*) as total FROM newsletter_subscribers $where_clause";
$count_result = mysqli_query($conn, $count_query);
$total_subscribers = mysqli_fetch_assoc($count_result)['total'];

// Get statistics
$stats_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive,
    SUM(CASE WHEN status = 'unsubscribed' THEN 1 ELSE 0 END) as unsubscribed,
    COUNT(CASE WHEN DATE(subscribed_at) = CURDATE() THEN 1 END) as today,
    COUNT(CASE WHEN DATE(subscribed_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END) as this_week
FROM newsletter_subscribers";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;
$total_pages = ceil($total_subscribers / $limit);

// Get subscribers
$query = "SELECT * FROM newsletter_subscribers $where_clause ORDER BY subscribed_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html><!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title>:: Admin :: Newsletter Subscribers</title>
    <meta name="keywords" content="HTML5 Template, CSS3, All Purpose Admin Template, Vendroid" />
    <meta name="description" content="Newsletter Subscribers - Admin Panel">
    <meta name="author" content="Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="img/ico/favicon.png">

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/font-entypo.css" rel="stylesheet" type="text/css">
    <link href="css/fonts.css"  rel="stylesheet" type="text/css">
    <link href="plugins/jquery-ui/jquery-ui.custom.min.css" rel="stylesheet" type="text/css">
    <link href="plugins/dataTables/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
    <link href="plugins/dataTables/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/theme.min.css" rel="stylesheet" type="text/css">
    <link href="css/theme-responsive.min.css" rel="stylesheet" type="text/css">
    <link href="custom/custom.css" rel="stylesheet" type="text/css">



    <!-- Head SCRIPTS -->
    <script type="text/javascript" src="js/modernizr.js"></script>
    <script type="text/javascript" src="js/mobile-detect.min.js"></script>
    <script type="text/javascript" src="js/mobile-detect-modernizr.js"></script>
</head>

<body id="tables" class="full-layout nav-right-hide nav-right-start-hide nav-top-fixed responsive clearfix" data-active="tables" data-smooth-scrolling="1">
<div class="vd_body">
    <!-- Header Start -->
    <?php include "header.php"; ?>
    <!-- Header Ends -->
    
    <div class="content">
        <div class="container">
            <?php include "adminleftmenu.php"; ?>
            
            <!-- Right Navbar -->
            <div class="vd_navbar vd_nav-width vd_navbar-chat vd_bg-black-80 vd_navbar-right">
                <!-- Right navbar content (keeping original structure) -->
            </div>

            <!-- Middle Content Start -->
            <div class="vd_content-wrapper">
                <div class="vd_container">
                    <div class="vd_content clearfix">
                        <div class="vd_head-section clearfix">
                            <div class="vd_panel-header">
                                <ul class="breadcrumb">
                                    <li><a href="index.php">HOME</a></li>
                                    <li class="active">Newsletter Subscribers</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="vd_title-section clearfix">
                            <div class="vd_panel-header">
                                <h1>Newsletter Subscribers</h1>
                                <small class="subtitle">Manage newsletter subscribers</small>
                            </div>
                        </div>

                        <?php if (isset($success)): ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Statistics Cards -->
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-2">
                                <div class="newsletter-stats-card text-center">
                                    <div class="newsletter-stats-number"><?php echo $stats['total']; ?></div>
                                    <div class="newsletter-stats-label">Total Subscribers</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="newsletter-stats-card text-center">
                                    <div class="newsletter-stats-number newsletter-status-active"><?php echo $stats['active']; ?></div>
                                    <div class="newsletter-stats-label">Active</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="newsletter-stats-card text-center">
                                    <div class="newsletter-stats-number newsletter-status-inactive"><?php echo $stats['inactive']; ?></div>
                                    <div class="newsletter-stats-label">Inactive</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="newsletter-stats-card text-center">
                                    <div class="newsletter-stats-number newsletter-status-unsubscribed"><?php echo $stats['unsubscribed']; ?></div>
                                    <div class="newsletter-stats-label">Unsubscribed</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="newsletter-stats-card text-center">
                                    <div class="newsletter-stats-number"><?php echo $stats['today']; ?></div>
                                    <div class="newsletter-stats-label">Today</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="newsletter-stats-card text-center">
                                    <div class="newsletter-stats-number"><?php echo $stats['this_week']; ?></div>
                                    <div class="newsletter-stats-label">This Week</div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="newsletter-filter-form">
                            <form method="GET" class="form-inline">
                                <div class="form-group" style="margin-right: 15px;">
                                    <input type="text" name="search" class="form-control" placeholder="Search by email..." value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                                <div class="form-group" style="margin-right: 15px;">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="active" <?php echo ($status_filter == 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($status_filter == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                        <option value="unsubscribed" <?php echo ($status_filter == 'unsubscribed') ? 'selected' : ''; ?>>Unsubscribed</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-right: 15px;">
                                    <input type="date" name="date_from" class="form-control" placeholder="From Date" value="<?php echo $date_from; ?>">
                                </div>
                                <div class="form-group" style="margin-right: 15px;">
                                    <input type="date" name="date_to" class="form-control" placeholder="To Date" value="<?php echo $date_to; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="view-newsletter.php" class="btn btn-default">Reset</a>
                                 
                            </form>
                        </div>

                        <div class="vd_content-section clearfix">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel widget">
                                        <div class="panel-heading vd_bg-grey">
                                            <h3 class="panel-title">
                                                <span class="menu-icon"><i class="fa fa-envelope-o"></i></span>
                                                Newsletter Subscribers (<?php echo $total_subscribers; ?> total)
                                            </h3>
                                        </div>
                                        
                                        <div class="panel-body">
                                            <!-- Bulk Actions -->
                                            <form method="POST" id="bulk-form">
                                                <div class="row" style="margin-bottom: 15px;">
                                                    <div class="col-md-6">
                                                        <select name="bulk_action" class="form-control" style="width: 200px; display: inline-block;">
                                                            <option value="">Bulk Actions</option>
                                                            <option value="activate">Activate Selected</option>
                                                            <option value="unsubscribe">Unsubscribe Selected</option>
                                                            <option value="delete">Delete Selected</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to perform this action on selected items?')">Apply</button>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <small class="text-muted">
                                                            Showing <?php echo (($page - 1) * $limit + 1); ?> to <?php echo min($page * $limit, $total_subscribers); ?> of <?php echo $total_subscribers; ?> entries
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="30">
                                                                    <input type="checkbox" id="select-all">
                                                                </th>
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
                                                            <?php if (mysqli_num_rows($result) > 0): ?>
                                                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox" name="selected_ids[]" value="<?php echo $row['id']; ?>" class="select-item">
                                                                        </td>
                                                                        <td><?php echo $row['id']; ?></td>
                                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                                                                                                <td>
                                                            <span class="newsletter-status-<?php echo $row['status']; ?>">
                                                                <i class="fa fa-circle"></i>
                                                                <?php echo ucfirst($row['status']); ?>
                                                            </span>
                                                        </td>
                                                                        <td><?php echo date('M d, Y H:i', strtotime($row['subscribed_at'])); ?></td>
                                                                        <td><?php echo htmlspecialchars($row['ip_address']); ?></td>
                                                                        <td><?php echo htmlspecialchars($row['source']); ?></td>
                                                                        <td>
                                                                            <div class="btn-group btn-group-sm">
                                                                                <?php if ($row['status'] != 'active'): ?>
                                                                                    <button type="button" class="btn btn-success btn-xs" onclick="performAction('activate', <?php echo $row['id']; ?>)" title="Activate">
                                                                                        <i style="color: white;" class="fa fa-check"></i>
                                                                                    </button>
                                                                                <?php endif; ?>
                                                                                
                                                                                <?php if ($row['status'] == 'active'): ?>
                                                                                    <button type="button" class="btn btn-warning btn-xs" onclick="performAction('unsubscribe', <?php echo $row['id']; ?>)" title="Unsubscribe">
                                                                                        <i  style="color: white;"  class="fa fa-minus-circle"></i>
                                                                                    </button>
                                                                                <?php endif; ?>
                                                                                
                                                                                <button type="button" class="btn btn-danger btn-xs" onclick="performAction('delete', <?php echo $row['id']; ?>)" title="Delete">
                                                                                    <i  style="color: white;"  class="fa fa-trash"></i>
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endwhile; ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="8" class="text-center">No subscribers found.</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>

                                            <!-- Pagination -->
                                            <?php if ($total_pages > 1): ?>
                                                <div class="text-center">
                                                    <ul class="pagination">
                                                        <?php if ($page > 1): ?>
                                                            <li><a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">&laquo; Previous</a></li>
                                                        <?php endif; ?>
                                                        
                                                        <?php for ($i = max(1, $page - 5); $i <= min($total_pages, $page + 5); $i++): ?>
                                                            <li <?php echo ($i == $page) ? 'class="active"' : ''; ?>>
                                                                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                                                            </li>
                                                        <?php endfor; ?>
                                                        
                                                        <?php if ($page < $total_pages): ?>
                                                            <li><a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next &raquo;</a></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <footer class="footer-1" id="footer">
        <div class="vd_bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="copyright">
                            Copyright &copy;2024 Admin. All Rights Reserved
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer END -->
</div>

<!-- Hidden form for actions -->
<form id="action-form" method="POST" style="display: none;">
    <input type="hidden" name="action" id="action-input">
    <input type="hidden" name="id" id="id-input">
</form>

<!-- Javascript -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/theme.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Select all checkbox functionality
    $('#select-all').change(function() {
        $('.select-item').prop('checked', this.checked);
    });
    
    $('.select-item').change(function() {
        if (!this.checked) {
            $('#select-all').prop('checked', false);
        }
        if ($('.select-item:checked').length == $('.select-item').length) {
            $('#select-all').prop('checked', true);
        }
    });
});

function performAction(action, id) {
    var confirmMessage = '';
    switch(action) {
        case 'delete':
            confirmMessage = 'Are you sure you want to delete this subscriber?';
            break;
        case 'unsubscribe':
            confirmMessage = 'Are you sure you want to unsubscribe this user?';
            break;
        case 'activate':
            confirmMessage = 'Are you sure you want to activate this subscriber?';
            break;
    }
    
    if (confirm(confirmMessage)) {
        document.getElementById('action-input').value = action;
        document.getElementById('id-input').value = id;
        document.getElementById('action-form').submit();
    }
}
</script>

</body>
</html>
