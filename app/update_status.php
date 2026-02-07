<?php
// File: app/update_status.php

include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $status = $_POST['status_pengiriman'] ?? '';
    
    if ($id && $status) {
        // Update status
        $query = "UPDATE penerima SET status_pengiriman = ? WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $status, $id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "success";
            } else {
                echo "error";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo "prepare_failed";
        }
    } else {
        echo "invalid_data";
    }
} else {
    echo "invalid_method";
}

mysqli_close($koneksi);
?>