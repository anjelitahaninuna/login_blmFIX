<?php

require "koneksi.php";
session_start();

// validasi bahwa user sudah login
if (isset($_SESSION['login']) && $_SESSION['login']===true){
    header ("location:halamanutama.php");
    exit();
}
 

// untuk loginnya

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cari pengguna berdasarkan username
    $sql = "SELECT * FROM users WHERE username='$username' AND pass='$password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $dataUser = mysqli_fetch_assoc($result);
        
        // simpan session dengan usn 
        $_SESSION['username'] = $username;
        $_SESSION['id_user'] = $dataUser['id'];
        $_SESSION['login']=true;
        $name = $dataUser['name'];
        setcookie("name", $name, time() + 3600);

        header("Location:halamanutama.php");
        exit();
    } else {

        echo"<script> alert('Invalid username or password');
        window.location= 'login.php'; </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logiin</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="isi">
        <div class="login_form">
        <form  method="post" action="">
            <div class="kolom_usn">
                <label for="username"> Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" required >
            </div>
            <div class="kolom_pass">
                <label for="pass">Password</label>
                <input type="password" name="password" id="password" placeholder=" Masukkan password" required >
            </div>
            <button type="submit" name="loginbtn">Login</button>
        </form> 
        </div>
        <div class="gambar">
            <img src="img/logo.png" alt="">
        </div>
    </div>

    
</body>
</html>