<?php
// Include necessary files and database connection
include('../includes/connect.php');

if (isset($_GET['file_name'])) {
    $file_name = $_GET['file_name'];

    // Sanitize the file name to prevent directory traversal
    $file_name = basename($file_name);

    // Construct the file path within the uploads directory
    $file_path = $_SERVER['DOCUMENT_ROOT'] . '/project-root/uploads/' . $file_name;

    // Check if the file exists
    if (file_exists($file_path)) {
        // Output appropriate header for the file type (e.g., image, PDF, etc.)
        $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
        $content_type = mime_content_type($file_path);

        header("Content-type: $content_type");
        header("Content-Disposition: inline; filename='" . basename($file_path) . "'");
        header("Content-Length: " . filesize($file_path));

        // Output the file content
        readfile($file_path);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "File name not provided.";
}
?>
