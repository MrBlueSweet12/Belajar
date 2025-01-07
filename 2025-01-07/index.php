<?php
// File: index.php
require_once 'config.php';
require_once 'Barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $barang->nama_barang = $_POST['nama_barang'];
        $barang->harga = $_POST['harga'];
        $barang->stok = $_POST['stok'];
        $barang->gambar = $_FILES['gambar']['name'];

        // Upload file
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $barang->gambar);

        if ($barang->create()) {
            echo "Barang berhasil ditambahkan.";
        }
    } elseif (isset($_POST['update'])) {
        $barang->id = $_POST['id'];
        $barang->nama_barang = $_POST['nama_barang'];
        $barang->harga = $_POST['harga'];
        $barang->stok = $_POST['stok'];
        $barang->gambar = $_FILES['gambar']['name'] ? $_FILES['gambar']['name'] : $_POST['existing_gambar'];

        // Upload file if new file is provided
        if ($_FILES['gambar']['name']) {
            move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $barang->gambar);
        }

        if ($barang->update()) {
            echo "Barang berhasil diperbarui.";
        }
    } elseif (isset($_POST['delete'])) {
        $barang->id = $_POST['id'];
        if ($barang->delete()) {
            echo "Barang berhasil dihapus.";
        }
    }
}

// Read all items
$stmt = $barang->read();
$barang_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-bottom: 20px;
        }
        form input, form button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CRUD Barang</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id">
            <input type="text" name="nama_barang" id="nama_barang" placeholder="Nama Barang" required>
            <input type="number" name="harga" id="harga" placeholder="Harga" required>
            <input type="number" name="stok" id="stok" placeholder="Stok" required>
            <input type="file" name="gambar" id="gambar">
            <input type="hidden" name="existing_gambar" id="existing_gambar">
            <button type="submit" name="create" id="create">Tambah Barang</button>
            <button type="submit" name="update" id="update" style="display:none;">Simpan Perubahan</button>
        </form>

        <h2>Daftar Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang_list as $barang): ?>
                    <tr>
                        <td><?= $barang['id'] ?></td>
                        <td><?= $barang['nama_barang'] ?></td>
                        <td><?= $barang['harga'] ?></td>
                        <td><?= $barang['stok'] ?></td>
                        <td><img src="uploads/<?= $barang['gambar'] ?>" alt="" width="50"></td>
                        <td class="actions">
                            <button onclick="editBarang(<?= htmlspecialchars(json_encode($barang)) ?>)">Edit</button>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $barang['id'] ?>">
                                <button type="submit" name="delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function editBarang(barang) {
            document.getElementById('id').value = barang.id;
            document.getElementById('nama_barang').value = barang.nama_barang;
            document.getElementById('harga').value = barang.harga;
            document.getElementById('stok').value = barang.stok;
            document.getElementById('existing_gambar').value = barang.gambar;

            document.getElementById('create').style.display = 'none';
            document.getElementById('update').style.display = 'block';
        }
    </script>
</body>
</html>
