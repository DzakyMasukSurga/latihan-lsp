<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomor_id = $_POST['nomor_id'];
    $nama = $_POST['nama'];

    // Mengambil data pengguna dari database
    $sql = "SELECT * FROM user WHERE nomor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nomor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['nama'] === $nama) {
        $_SESSION['nomor_id'] = $nomor_id;
        $_SESSION['nama'] = $nama;
        header("Location: dashboardcoy.php");
        exit();
    } else {
        $error = "Nomor ID atau nama salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tambahkan CSS ini untuk memperbaiki tampilan login */
body {
    background: linear-gradient(135deg, #74ebd5, #ACB6E5); /* Gradient background */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

.login-container {
    background-color: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
    text-align: center;
    width: 350px;
}

.login-container h2 {
    font-size: 2em;
    color: #333;
    margin-bottom: 20px;
}

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1em;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    margin-top: 20px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 1.1em;
    width: 100%;
}

button:hover {
    background-color: #45a049;
    box-shadow: 0 6px 20px rgba(0, 128, 0, 0.3);
}


    </style>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form action="loginbro.php" method="POST">
        <input type="text" name="id" placeholder="Nomor ID" required>
        <input type="text" name="name" placeholder="Nama" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>