<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        echo "<div class='error'>All fields are required!</div>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='error'>Invalid email format!</div>";
        exit;
    }

    // Koneksi ke database
    $servername = "localhost";
    $username = "root"; // Sesuaikan username database Anda
    $password = "";     // Sesuaikan password database Anda
    $dbname = "restoran_gacor";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Masukkan data ke tabel
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        // Redirect ke halaman terima kasih
        header('Location: thank_you.php');
        exit;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - RestoranGacor</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #28a745;
        }

        p {
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        a {
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        a.back-home {
            background-color: #007bff;
            color: #ffffff;
        }

        a.back-home:hover {
            background-color: #0056b3;
        }

        a.send-again {
            background-color: #ffc107;
            color: #343a40;
        }

        a.send-again:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank You!</h1>
        <p>Your message has been successfully submitted. We appreciate your feedback and will get back to you soon!</p>
        <div class="button-group">
            <a href="index.php" class="back-home">Back to Home</a>
            <a href="contact.php" class="send-again">Send Another Message</a>
        </div>
    </div>
</body>
</html>
