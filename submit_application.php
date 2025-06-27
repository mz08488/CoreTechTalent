<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $position = $_POST['position'];
    $message  = $_POST['message'];

    // Handle resume upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === 0) {
        $resumeTmp  = $_FILES['resume']['tmp_name'];
        $resumeName = basename($_FILES['resume']['name']);
        $resumePath = "resumes/" . $resumeName;

        // Ensure resumes/ folder exists
        if (!file_exists('resumes')) {
            mkdir('resumes', 0777, true);
        }

        move_uploaded_file($resumeTmp, $resumePath);
    } else {
        $resumePath = "Not uploaded";
    }

    // Save to CSV
    $data = [$name, $email, $phone, $position, $message, $resumePath];
    $file = fopen("applications.csv", "a");
    fputcsv($file, $data);
    fclose($file);

    echo "<h2>Thank you for applying, $name!</h2>";
    echo "<p>Your application has been submitted successfully.</p>";
} else {
    echo "<p>Error: Form not submitted properly.</p>";
}
?>
