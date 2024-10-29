<?php

$sekolah = [
    "TK Bina Anaprasa",
    "SDN Jati No 22",
    "SMPN 2 Sidoarjo",
    "SMKN 2 Buduran"
]; //Array satu Dimensi
$sekolahs = [
    "TK" => "TK Bina Anaprasa",
    "SD" => "SDN Jati No 22",
    "SMP" => "SMPN 2 Sidoarjo",
    "SMK" => "SMKN 2 Buduran",
    "PT" => "Universitas Negeri Surabaya"
]; //Array Associatif
$skills = [
    "c++" => "Expert",
    "HTML" => "Newbie",
    "Css" => "Newbie",
    "PHP" => "Intermediate",
    "JavaScript" => "Intermediate"
];
$identitas = ["nama" => "Tirta Cahya Buana", "Jenis Kelamin" => "Laki-Laki", "alamat" => "Kahuripan Nirwana Blok AA8 No 3A", "email" => "TirtaCahyaBuana@gmail.com", "IG" => "@MrBlueSweet12", "TikTok" => "@MrBlueSweet12"];

$hobby = ["Coding", "Mancing", "Sepeda", "Membaca", "NgeGame"];

// echo $sekolah[0];
// echo "<br>";
// echo $sekolahs["TK"];
// echo "<br>";
// echo $sekolah[1];
// echo "<br>";
// echo $sekolahs["SD"];

// echo "<br>";
// for ($i = 0; $i < 4; $i++) {
//     echo $sekolah[$i];
//     echo "<br>";
// }

// foreach ($sekolah as $key) {
//     echo $key;
//     echo "<br>";
// }

// foreach ($sekolahs as $key => $value) {
//     echo $key;
//     echo "=";
//     echo $value;
//     echo "<br>";
// }

// foreach ($skills as $key => $value) {
//     echo $key;
//     echo "<br>";
// }

if (isset($_GET["menu"])) {
    $menu = $_GET ["menu"];
echo $menu;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <hr>
    <ul>
        <li><a href="?menu=home">Home</a></li>
        <li><a href="?menu=cv">CV</a></li>
        <li><a href="?menu=project">Project</a></li>
        <li><a href="?menu=contact">Contact</a></li>
    </ul>
    <h2>Identitas</h2>
    <table border=1>
    <thead>
        <tr>
            <th>Identitas</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($identitas as $key => $value) {
        ?>
        <tr>
            <td><?= $key ?></td>
            <td><?= $value ?></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
    </table>
    <h2>Riwayat Sekolah</h2>
    <table border=1>
        <thead>
            <tr>
                <th>Jenjang</th>
                <th>Nama Sekolah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($sekolahs as $key => $value) {
                echo "<tr>";
                echo "<td>";
                echo $key;
                echo "</td>";
                echo "<td>";
                echo $value;
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <hr>
    <h2>Skills</h2>
    <table border=1>
        <thead>
            <tr>
                <th>Skills</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($skills as $key => $value) {
            ?>
            <tr>
                <td><?= $key ?></td>
                <td><?= $value ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <hr>
    <h2>Hobby</h2>
    <ol>
        <?php
        foreach ($hobby as $key) {
            ?>
            <li><?= $key ?></li>
        <?php
        }
        ?>
    </ol>
</body>
</html>