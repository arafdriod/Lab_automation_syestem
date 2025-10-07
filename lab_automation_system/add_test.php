<?php
require 'config.php';
function generate_test_id($pdo, $product_id){
    // 12-character test id: product short + 3-digit counter
    // We'll take numeric suffix from product and append a 3-digit counter based on tests count
    $stmt = $pdo->prepare('SELECT COUNT(*) as c FROM tests WHERE product_id = ?');
    $stmt->execute([$product_id]);
    $row = $stmt->fetch();
    $count = ($row) ? intval($row['c']) + 1 : 1;
    // make a compact id: product's last 7 chars + 3-digit counter => total ~10 but safe
    $suffix = substr($product_id, -7);
    return strtoupper($product_id . str_pad($count, 3, '0', STR_PAD_LEFT)); // e.g., PRD0000001001
}
// fetch products for selection
$prodStmt = $pdo->query('SELECT product_id, name FROM products ORDER BY created_at DESC');
$products = $prodStmt->fetchAll();
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $product_id = $_POST['product_id'] ?? '';
    $test_type = trim($_POST['test_type'] ?? '');
    $result = $_POST['result'] ?? 'Pending';
    $tester_name = trim($_POST['tester_name'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');
    $test_date = $_POST['test_date'] ?? null;
    if($product_id==='') $errors[]='Select product';
    if($test_type==='') $errors[]='Test type required';
    if(empty($errors)){
        $test_id = generate_test_id($pdo, $product_id);
        $stmt = $pdo->prepare('INSERT INTO tests (test_id, product_id, test_type, result, tester_name, remarks, test_date) VALUES (?,?,?,?,?,?,?)');
        $stmt->execute([$test_id,$product_id,$test_type,$result,$tester_name,$remarks,$test_date]);
        header('Location: view_product.php?id=' . urlencode($product_id));
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3>Add Test Record</h3>
    <?php if($errors): ?>
        <div class="alert alert-danger"><?=implode('<br>', array_map('htmlspecialchars', $errors))?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Product</label>
            <select name="product_id" class="form-select">
                <option value="">-- Select Product --</option>
                <?php foreach($products as $p): ?>
                    <option value="<?=htmlspecialchars($p['product_id'])?>"><?=htmlspecialchars($p['product_id'].' - '.$p['name'])?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Test Type</label><input class="form-control" name="test_type"></div>
        <div class="mb-3">
            <label class="form-label">Result</label>
            <select name="result" class="form-select">
                <option>Pending</option>
                <option>Pass</option>
                <option>Fail</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Tester Name</label><input class="form-control" name="tester_name"></div>
        <div class="mb-3"><label class="form-label">Test Date</label><input class="form-control" type="date" name="test_date"></div>
        <div class="mb-3"><label class="form-label">Remarks</label><textarea class="form-control" name="remarks"></textarea></div>
        <button class="btn btn-success">Save Test</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
