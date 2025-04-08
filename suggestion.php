<?php
// 1. Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Database config (use your confirmed credentials)
$db_host = "127.0.0.1:3307"; // IP + port
$db_user = "root";
$db_pass = ""; // Empty password
$db_name = "student_maintenance";

// 3. Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("<div style='color:red;padding:20px;font-family:Arial;'>
        <h2>Database Error</h2>
        <p>".$conn->connect_error."</p>
        <p>Check your XAMPP MySQL is running on port 3307</p>
        </div>");
}

// 4. Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $regNo = $conn->real_escape_string($_POST['regNo']);
    $studentName = $conn->real_escape_string($_POST['studentName']);
    $block = $conn->real_escape_string($_POST['block']);
    $roomNo = $conn->real_escape_string($_POST['roomNo']);
    $improvementType = $conn->real_escape_string($_POST['improvementType']);
    $suggestion = $conn->real_escape_string($_POST['suggestion']);

    // 5. Insert into database
    $sql = "INSERT INTO suggestions (regNo, studentName, block, roomNo, improvementType, suggestion)
            VALUES ('$regNo', '$studentName', '$block', '$roomNo', '$improvementType', '$suggestion')";

    if ($conn->query($sql) === TRUE) {
        // Success message
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Success</title>
            <link rel="stylesheet" href="suggestion.css">
        </head>
        <body>
            <div class="form-container">
                <div class="success-message">
                    <h1>✅ Suggestion Submitted!</h1>
                    <p>Reference ID: '.$conn->insert_id.'</p>
                    <a href="index.html" class="btn btn-card">Return Home</a>
                </div>
            </div>
        </body>
        </html>';
    } else {
        echo "<div style='color:red;padding:20px;'>
              <h2>Error</h2>
              <p>".$conn->error."</p>
              <a href='suggestion.html'>Try again</a>
              </div>";
    }
} else {
    header("Location: suggestion.html");
    exit();
}

$conn->close();
?>