<?php
include ("config.php");

$stmt = $conn->prepare("SELECT * FROM nhanvien");
$stmt->execute();
$nhanvien = $stmt->get_result();
?>