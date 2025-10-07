<?php
require 'config.php';
function generate_product_id($pdo){
    // 10-character product id: PRD + 7-digit zero-padded number (auto-increment like)
    $stmt = $pdo->query("SELECT MAX(id) AS mx FROM products");
    $row = $stmt->fetch();
    $next = ($row && $row['mx']) ? intval($row['mx']) + 1 : 1;
    return 'PRD' . str_pad($next, 7, '0', STR_PAD_LEFT); // e.g., PRD0000001
}
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = trim($_POST['name'] ?? '');
    $product_type = trim($_POST['product_type'] ?? '');
    $revise = trim($_POST['revise'] ?? '');
    $manufacture_date = $_POST['manufacture_date'] ?? null;
    $remarks = trim($_POST['remarks'] ?? '');
    if($name==='') $errors[]='Product name required';
    if(empty($errors)){
        $product_id = generate_product_id($pdo);
        $stmt = $pdo->prepare('INSERT INTO products (product_id,name,product_type,revise,manufacture_date,remarks) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$product_id,$name,$product_type,$revise,$manufacture_date,$remarks]);
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3>Add Product</h3>
    <?php if($errors): ?>
        <div class="alert alert-danger"><?=implode('<br>', array_map('htmlspecialchars', $errors))?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3"><label class="form-label">Product Name</label><input class="form-control" name="name"></div>
        <div class="mb-3"><label class="form-label">Product Type</label><input class="form-control" name="product_type"></div>
        <div class="mb-3"><label class="form-label">Revise</label><input class="form-control" name="revise"></div>
        <div class="mb-3"><label class="form-label">Manufacture Date</label><input class="form-control" type="date" name="manufacture_date"></div>
        <div class="mb-3"><label class="form-label">Remarks</label><textarea class="form-control" name="remarks"></textarea></div>
        <button class="btn btn-primary">Save Product</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
