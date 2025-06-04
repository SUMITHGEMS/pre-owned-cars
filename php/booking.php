<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pre_owned_cars";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include PHPMailer classes
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $license = $conn->real_escape_string($_POST['license']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $pin = $conn->real_escape_string($_POST['pin']);

    // SQL query to insert the data
    $sql = "INSERT INTO bookings (name, email, phone, license, dob, address, city, state, pin) 
            VALUES ('$name', '$email', '$phone', '$license', '$dob', '$address', '$city', '$state', '$pin')";

    if ($conn->query($sql) === TRUE) {
        // Send confirmation email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'paulsumith15@gmail.com';       // 🔁 Your Gmail
            $mail->Password   = 'wpof djnb pwhx syzk';          // 🔁 App password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Email content
            $mail->setFrom('paulsumith15@gmail.com', 'Pre-Owned Cars');
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = 'Booking Confirmation';
            $mail->Body    = "<h3>Hello $name,</h3>
                              <p>Your car booking has been confirmed.</p>
                              <p>Thank you for choosing Pre-Owned Cars!</p>";

            $mail->send();
        } catch (Exception $e) {
            echo "❌ Email could not be sent. Error: {$mail->ErrorInfo}";
        }

        // ✅ Success message instead of redirect
    echo "<h2>✅ Booking Successful!</h2>";
    echo "<p>Thank you, <strong>$name</strong>. Your booking has been saved. A confirmation email has been sent to <strong>$email</strong>.</p>";

}
}

// Close connection
$conn->close();
?>
