<?php

$nama = "TIRTA CAHYA BUANA";
$status = "Programmer";
$aboutMe = "Seorang siswa lulusan smpn 2 sidoarjo yang suka dengan programming dan IT, Saya sangat bersemangat saat belajar tentang programming dikarenakan rasa penasaran yang kuat dan saya juga suka belajar hal baru di kehidupan saya.";
$educations = ["SMKN 2 Buduran 2024 - Sekarang", "SMPN 2 Sidoarjo 2020 - 2023"];
$email = "TirtaCahyaBuana@gmail.com";
$alamat = "Kahuripan Nirwana Blok AA8 no 3A RT 03 RW 10";
$noTelp = "+6281249754745";

$skills = ["Java", "teamwork", "communication skills", "critical thinking", "problem solving", "c++"]

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    <link rel="stylesheet" href="style.css">
</head>
<div class="row">
    <div class="column-left" style="background-color: #2d7cdb">
      <div class="inner-column-container">
        <div class="inner-column-atas">
          <img src="images/Tirta Cahya Buana.jpg" alt="">
          <h1 style="font-size: large; color: whitesmoke;"><?= $nama ?></h1>
          <h2 style="font-size: large; color: whitesmoke;"><?= $status ?></h2>
        </div>
        <div class="inner-column-bawah">
          <p><?= $email ?></p>
          <p><?= $alamat ?></p>
          <p><?= $noTelp ?></p>
        </div>
      </div>
    </div>

    <div class="column" style="background-color: wheat">
      <b><li>About Me</li></b>
      <p><?= $aboutMe ?></p>
      <b><li>Education</li></b>
      <?php foreach ($educations as $education): ?>
      <p><?= $education; ?></p>
      <?php endforeach; ?>
      <b><li>Skills</li></b>
      <?php foreach ($skills as $skill): ?>
        <p><?= $skill; ?></p>
        <?php endforeach; ?>
    </div>
  </div>
</html>