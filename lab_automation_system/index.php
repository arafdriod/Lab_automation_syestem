<?php
require 'config.php';
// fetch all products with test counts
$stmt = $pdo->query('SELECT p.*, (SELECT COUNT(*) FROM tests t WHERE t.product_id = p.product_id) AS test_count FROM products p ORDER BY p.created_at DESC');
$products = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab Automation System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lab Automation System</h2>
        <div>
            <a href="add_product.php" class="btn btn-primary">Add Product</a>
            <a href="add_test.php" class="btn btn-success">Add Test</a>
            <a href="search.php" class="btn btn-secondary">Advanced Search</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="products" class="display table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Revise</th>
                        <th>Manufacture Date</th>
                        <th>Tests</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($products as $p): ?>
                    <tr>
                        <td><?=htmlspecialchars($p['product_id'])?></td>
                        <td><?=htmlspecialchars($p['name'])?></td>
                        <td><?=htmlspecialchars($p['product_type'])?></td>
                        <td><?=htmlspecialchars($p['revise'])?></td>
                        <td><?=htmlspecialchars($p['manufacture_date'])?></td>
                        <td><?=intval($p['test_count'])?></td>
                        <td>
                            <a href="view_product.php?id=<?=urlencode($p['product_id'])?>" class="btn btn-sm btn-info">View</a>
                            <a href="edit_product.php?id=<?=urlencode($p['product_id'])?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete.php?type=product&id=<?=urlencode($p['product_id'])?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete product and its tests?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){ $('#products').DataTable(); });
</script>
</body>
</html>
