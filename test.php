<?php
header ("Content-Type: text/plain;");
include("upload.php");

$upload = new Upload();

echo json_encode(['files' => $upload->list_files('.')], JSON_PRETTY_PRINT);
echo json_encode(['users' => $upload->list_users('..')], JSON_PRETTY_PRINT);
