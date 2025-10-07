<?php
require 'config.php';
$where = [];
$params = [];
if($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['q']) || isset($_GET['type']))){
    $q = trim($_GET['q'] ?? '');
    $type = trim($_GET['type'] ?? '');
    if($q !== ''){
        $where[] = '(p.product_id LIKE ? OR p.name LIKE ? OR t.test_id LIKE ? OR t.tester_name LIKE ?)';
        $like = '%' . $q . '%';
        array_push($params, $like, $like, $like, $like);
    }
    if($type !== ''){
        $where[] = 'p.product_type = ?';
        $params[] = $type;
    }
}
$sql = 'SELECT p.*, t.test_id, t.test_type, t.result FROM products p LEFT JOIN tests t ON p.product_id = t.product_id';
if($where) $sql .= ' WHERE ' . implode(' AND ', $where);
$sql .= ' ORDER BY p.created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3>Advanced Search</h3>
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-6"><input class="form-control" name="q" placeholder="Search by Product ID, Name, Test ID, Tester"></div>
        <div class="col-md-4"><input class="form-control" name="type" placeholder="Product Type (optional)"></div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Search</button></div>
    </form>
    <div class="card">
        <div class="card-body">
            <?php if(!$rows): ?>
                <div class="alert alert-info">No results</div>
            <?php else: ?>
                <table class="table">
                    <thead><tr><th>Product ID</th><th>Name</th><th>Test ID</th><th>Test Type</th><th>Result</th></tr></thead>
                    <tbody>
                    <?php foreach($rows as $r): ?>
                        <tr>
                            <td><?=htmlspecialchars($r['product_id'])?></td>
                            <td><?=htmlspecialchars($r['name'])?></td>
                            <td><?=htmlspecialchars($r['test_id'])?></td>
                            <td><?=htmlspecialchars($r['test_type'])?></td>
                            <td><?=htmlspecialchars($r['result'])?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <a href="index.php" class="btn btn-secondary mt-3">Back</a>
</div>
</body>
</html>
