<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $studentName = $_POST['studentName'] ?? '';
    $satsNo = $_POST['satsNo'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $category = $_POST['category'] ?? '';
    $address = $_POST['address'] ?? '';
    $class = $_POST['class'] ?? '';
    $institution = $_POST['institution'] ?? '';

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($_FILES['photo']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $photoPath = $targetFile;
            } else {
                echo "Error uploading photo.";
                exit;
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            exit;
        }
    } else {
        echo "Photo upload failed.";
        exit;
    }

    // Prepare data to save
    $data = "Student Name: $studentName\n";
    $data .= "SATS No.: $satsNo\n";
    $data .= "DOB: $dob\n";
    $data .= "Gender: $gender\n";
    $data .= "Category: $category\n";
    $data .= "Address: $address\n";
    $data .= "Class: $class\n";
    $data .= "Institution: $institution\n";
    $data .= "Photo Path: $photoPath\n";
    $data .= "----------------------------------------\n";

    // Save to a file
    $file = 'form_data.txt';
    if (file_put_contents($file, $data, FILE_APPEND)) {
        echo "Form submitted successfully! Data saved.";
    } else {
        echo "Error saving form data.";
    }
} else {
    echo "Invalid request.";
}
?>
