<?php
include '../sample/include/dbcon.php';

$query = $con->query("SELECT * FROM ebooks WHERE ebook_id = '$_POST[ebook_id]'");
$row = $query->fetch_array();
$fileName = $row['fileName'];

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $fileName . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($fileName));
header('Accept-Ranges: bytes');
@readfile($fileName);