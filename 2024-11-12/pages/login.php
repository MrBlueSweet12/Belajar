<div class="login">
    <h1>login</h1>
    <form action="" method="post">
        <input type="email" name="email" placeholder="Masukkan email" required>
        <input type="password" name="password" placeholder="Masukkan Password" required>
        <input type="submit" name="login" value="login" id="">
    </form>
</div>

<?php
    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM  customer WHERE email = '$email' AND password = '$password'";
        $hasil = mysqli_query($koneksi, $sql);
        $baris = mysqli_num_rows($hasil);
        
        if ($baris == 0) {
            echo "<h2>Email atau Password Salah</h2>";
        } else {
            $_SESSION["email"]=$email;
            header("location:index.php");
        }
    }
?>