<?php
require 'config.php';
$product_id = $_GET['id'] ?? '';
if(!$product_id){ header('Location: index.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM products WHERE product_id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch();
if(!$product){ echo 'Not found'; exit; }
$errors = [];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = trim($_POST['name'] ?? '');
    $product_type = trim($_POST['product_type'] ?? '');
    $revise = trim($_POST['revise'] ?? '');
    $manufacture_date = $_POST['manufacture_date'] ?? null;
    $remarks = trim($_POST['remarks'] ?? '');
    if($name==='') $errors[]='Name required';
    if(!$errors){
        $stmt = $pdo->prepare('UPDATE products SET name=?, product_type=?, revise=?, manufacture_date=?, remarks=? WHERE product_id=?');
        $stmt->execute([$name,$product_type,$revise,$manufacture_date,$remarks,$product_id]);
        header('Location: view_product.php?id=' . urlencode($product_id));
        exit;
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container py-4">
<h3>Edit Product</h3>
<?php if($errors): ?><div class="alert alert-danger"><?=implode('<br>', $errors)?></div><?php endif; ?>
<form method="post">
    <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" value="<?=htmlspecialchars($product['name'])?>"></div>
    <div class="mb-3"><label class="form-label">Type</label><input class="form-control" name="product_type" value="<?=htmlspecialchars($product['product_type'])?>"></div>
    <div class="mb-3"><label class="form-label">Revise</label><input class="form-control" name="revise" value="<?=htmlspecialchars($product['revise'])?>"></div>
    <div class="mb-3"><label class="form-label">Manufacture Date</label><input type="date" class="form-control" name="manufacture_date" value="<?=htmlspecialchars($product['manufacture_date'])?>"></div>
    <div class="mb-3"><label class="form-label">Remarks</label><textarea class="form-control" name="remarks"><?=htmlspecialchars($product['remarks'])?></textarea></div>
    <button class="btn btn-primary">Save</button>
    <a href="view_product.php?id=<?=urlencode($product_id)?>" class="btn btn-secondary">Cancel</a>
</form>
</div></body></html>
