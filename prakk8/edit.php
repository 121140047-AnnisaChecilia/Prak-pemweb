<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="hdr">
    <h1>Edit Data Mahasiswa</h1>
    <?php
    $host = "localhost";
    $username = "root";
    $password = ""; 
    $database = "mahasiswa";
    $koneksi = new mysqli('localhost', 'root', '', 'mahasiswa');

    if ($koneksi->connect_error) {
        die("Koneksi database gagal: " . $koneksi->connect_error);
    }
    $nim_edit = "";
    $nama = "";
    $prodi = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nim'])) {
        $nim = $_GET['nim'];

        $query_edit = "SELECT * FROM datamahasiswa WHERE nim = '$nim'";
        $result_edit = $koneksi->query($query_edit);

        if ($result_edit->num_rows > 0) {
            $row = $result_edit->fetch_assoc();
            $nim_edit = $row['nim'];
            $nama = $row['nama'];
            $prodi = $row['prodi'];
        } else {
            echo "Data mahasiswa tidak ditemukan.";
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $nim_edit = $_POST['nim_edit']; 
        $nim_baru = $_POST['nim'];
        $nama = $_POST['nama'];
        $prodi = $_POST['prodi'];

        $query_check_nim = "SELECT * FROM datamahasiswa WHERE nim = '$nim_baru'";
        $result_check_nim = $koneksi->query($query_check_nim);

        if ($result_check_nim->num_rows > 0 && $nim_baru !== $nim_edit) {
            echo "NIM sudah ada dalam database. Harap gunakan NIM yang berbeda.";
        } else {

            $query_update = "UPDATE datamahasiswa SET nim = '$nim_baru', nama = '$nama', prodi = '$prodi' WHERE nim = '$nim_edit'";
            
            if ($koneksi->query($query_update) === TRUE) {
                echo "Data mahasiswa dengan NIM $nim_edit berhasil diperbarui.";

                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $query_update . "<br>" . $koneksi->error;
            }
        }
    }
    ?>
    
    <form action="" method="post">
        <input type="hidden" name="nim_edit" value="<?php echo $nim_edit; ?>">
        <input type="text" name="nim" value="<?php echo $nim_edit; ?>" required>
        <input type="text" name="nama" value="<?php echo $nama; ?>" required>
        <input type="text" name="prodi" value="<?php echo $prodi; ?>" required>
        <button type="submit" name="update">Update Data</button>
    </form>
    </div>
</body>
</html>
