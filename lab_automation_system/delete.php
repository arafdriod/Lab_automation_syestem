<?php
require 'config.php';
$type = $_GET['type'] ?? '';
$id = $_GET['id'] ?? '';
if(!$type || !$id){ header('Location: index.php'); exit; }
if($type === 'product'){
    $stmt = $pdo->prepare('DELETE FROM products WHERE product_id = ?');
    $stmt->execute([$id]);
    header('Location: index.php');
    exit;
} elseif($type === 'test'){
    $stmt = $pdo->prepare('DELETE FROM tests WHERE test_id = ?');
    $stmt->execute([$id]);
    // redirect back to index
    header('Location: index.php');
    exit;
}
header('Location: index.php');
