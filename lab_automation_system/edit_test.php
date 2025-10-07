<?php
require 'config.php';
$test_id = $_GET['id'] ?? '';
if(!$test_id){ header('Location: index.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM tests WHERE test_id = ?');
$stmt->execute([$test_id]);
$test = $stmt->fetch();
if(!$test){ echo 'Not found'; exit; }
$errors = [];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $test_type = trim($_POST['test_type'] ?? '');
    $result = $_POST['result'] ?? 'Pending';
    $tester_name = trim($_POST['tester_name'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');
    $test_date = $_POST['test_date'] ?? null;
    if($test_type==='') $errors[]='Test type required';
    if(!$errors){
        $stmt = $pdo->prepare('UPDATE tests SET test_type=?, result=?, tester_name=?, remarks=?, test_date=? WHERE test_id=?');
        $stmt->execute([$test_type,$result,$tester_name,$remarks,$test_date,$test_id]);
        header('Location: view_product.php?id=' . urlencode($test['product_id']));
        exit;
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Test</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container py-4">
<h3>Edit Test</h3>
<?php if($errors): ?><div class="alert alert-danger"><?=implode('<br>', $errors)?></div><?php endif; ?>
<form method="post">
    <div class="mb-3"><label class="form-label">Test Type</label><input class="form-control" name="test_type" value="<?=htmlspecialchars($test['test_type'])?>"></div>
    <div class="mb-3">
        <label class="form-label">Result</label>
        <select name="result" class="form-select">
            <option <?=($test['result']=='Pending')?'selected':''?>>Pending</option>
            <option <?=($test['result']=='Pass')?'selected':''?>>Pass</option>
            <option <?=($test['result']=='Fail')?'selected':''?>>Fail</option>
        </select>
    </div>
    <div class="mb-3"><label class="form-label">Tester Name</label><input class="form-control" name="tester_name" value="<?=htmlspecialchars($test['tester_name'])?>"></div>
    <div class="mb-3"><label class="form-label">Test Date</label><input type="date" class="form-control" name="test_date" value="<?=htmlspecialchars($test['test_date'])?>"></div>
    <div class="mb-3"><label class="form-label">Remarks</label><textarea class="form-control" name="remarks"><?=htmlspecialchars($test['remarks'])?></textarea></div>
    <button class="btn btn-primary">Save</button>
    <a href="view_product.php?id=<?=urlencode($test['product_id'])?>" class="btn btn-secondary">Cancel</a>
</form>
</div></body></html>
