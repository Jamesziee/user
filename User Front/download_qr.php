<?php
require 'connection.php'; // Ensure this connects to your database

// Check if the child_id is provided
if (isset($_GET['child_id']) && is_numeric($_GET['child_id'])) {
    $child_id = intval($_GET['child_id']);

    // Fetch QR code details for the specific student
    $stmt = $pdo->prepare('SELECT qrimage FROM child_acc WHERE id = ?');
    $stmt->execute([$child_id]);
    $result = $stmt->fetch();

    if ($result && !empty($result['qr_code'])) {
        // Assuming the QR code is stored as binary data in the database
        $qr_code_data = $result['qrimage'];

        // Set headers to trigger download
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="qrimage_' . $child_id . '.png"');
        echo $qr_code_data;
        exit;
    } else {
        echo "QR Code not found for this student.";
    }
} else {
    echo "Invalid request. No student ID provided.";
}
?>
