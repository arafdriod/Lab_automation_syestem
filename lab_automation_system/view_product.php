<?php
require 'config.php';
$product_id = $_GET['id'] ?? '';
if(!$product_id) { header('Location: index.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM products WHERE product_id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch();
if(!$product){ echo 'Product not found'; exit; }
$tstmt = $pdo->prepare('SELECT * FROM tests WHERE product_id = ? ORDER BY created_at DESC');
$tstmt->execute([$product_id]);
$tests = $tstmt->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
    <a href="index.php" class="btn btn-secondary mb-3">Back</a>
    <div class="card mb-3">
        <div class="card-body">
            <h4><?=htmlspecialchars($product['name'])?> <small class="text-muted"><?=htmlspecialchars($product['product_id'])?></small></h4>
            <p>Type: <?=htmlspecialchars($product['product_type'])?> | Revise: <?=htmlspecialchars($product['revise'])?></p>
            <p>Manufacture Date: <?=htmlspecialchars($product['manufacture_date'])?></p>
            <p>Remarks: <?=nl2br(htmlspecialchars($product['remarks']))?></p>
            <a href="add_test.php" class="btn btn-success">Add Test</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5>Tests</h5>
            <table id="tests" class="display table">
                <thead><tr><th>Test ID</th><th>Type</th><th>Result</th><th>Tester</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach($tests as $t): ?>
                    <tr>
                        <td><?=htmlspecialchars($t['test_id'])?></td>
                        <td><?=htmlspecialchars($t['test_type'])?></td>
                        <td><?=htmlspecialchars($t['result'])?></td>
                        <td><?=htmlspecialchars($t['tester_name'])?></td>
                        <td><?=htmlspecialchars($t['test_date'])?></td>
                        <td>
                            <a href="edit_test.php?id=<?=urlencode($t['test_id'])?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete.php?type=test&id=<?=urlencode($t['test_id'])?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this test?')">Delete</a>
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
<script>$(document).ready(function(){ $('#tests').DataTable(); });</script>
</body>
</html>
