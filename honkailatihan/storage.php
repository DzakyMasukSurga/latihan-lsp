<?php
include 'koneksi.php';

// Proses Tambah Data Storage
if (isset($_POST['tambah'])) {
    $nama_gudang = $_POST['nama_gudang'];
    $lokasi_gudang = $_POST['lokasi_gudang'];

    $sql = "INSERT INTO storage (nama_gudang, lokasi_gudang) 
            VALUES ('$nama_gudang', '$lokasi_gudang')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Data storage berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Proses Hapus Data Storage
if (isset($_GET['hapus'])) {
    $id_gudang = $_GET['hapus'];
    $sql = "DELETE FROM storage WHERE id_storage='$id_gudang'";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Data storage berhasil dihapus.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Proses Perbarui Data Storage
if (isset($_POST['perbarui'])) {
    $id_gudang = $_POST['id_storage'];
    $nama_gudang = $_POST['nama_gudang'];
    $lokasi_gudang = $_POST['lokasi_gudang'];

    $sql = "UPDATE storage SET 
                nama_gudang='$nama_gudang', 
                lokasi_gudang='$lokasi_gudang' 
            WHERE id_storage='$id_gudang'";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Data storage berhasil diperbarui.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Mengambil semua data storage untuk ditampilkan
$result = mysqli_query($conn, "SELECT * FROM storage");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Storage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Bagian Menampilkan Data Storage -->
            <div class="col-md-8">
                <h3>Data Gudang</h3>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ID Storage</th>
                            <th>Nama Gudang</th>
                            <th>Lokasi Gudang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['id_storage']; ?></td>
                                <td><?php echo $row['nama_gudang']; ?></td>
                                <td><?php echo $row['lokasi_gudang']; ?></td>
                                <td>
                                    <a href="dashboardcoy.php?page=storage&edit=<?php echo $row['id_storage']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="dashboardcoy.php?page=storage&hapus=<?php echo $row['id_storage']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Bagian Form Tambah/Edit Data Storage -->
            <div class="col-md-4">
                <?php
                // Jika ada permintaan edit, tampilkan form edit dengan data terisi
                if (isset($_GET['edit'])) {
                    $id_gudang = $_GET['edit'];
                    $editResult = mysqli_query($conn, "SELECT * FROM storage WHERE id_storage='$id_gudang'");
                    $editRow = mysqli_fetch_assoc($editResult);
                ?>
                    <h3>Edit Data Gudang</h3>
                    <form action="dashboardcoy.php?page=storage" method="post">
                        <input type="hidden" name="id_storage" value="<?php echo $editRow['id_storage']; ?>">
                        <div class="mb-3">
                            <label for="nama_gudang" class="form-label">Nama Gudang</label>
                            <input type="text" class="form-control" id="nama_gudang" name="nama_gudang" value="<?php echo $editRow['nama_gudang']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi_gudang" class="form-label">Lokasi Gudang</label>
                            <input type="text" class="form-control" id="lokasi_gudang" name="lokasi_gudang" value="<?php echo $editRow['lokasi_gudang']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="perbarui">Perbarui Gudang</button>
                        <button type="cancel" class="btn btn-primary" hreft="inventory.php">batalkan</button>
                    </form>
                <?php } else { ?>
                    <h3>Tambah Data Gudang</h3>
                    <form action="dashboardcoy.php?page=storage" method="post">
                        <div class="mb-3">
                            <label for="nama_gudang" class="form-label">Nama Gudang</label>
                            <input type="text" class="form-control" id="nama_gudang" name="nama_gudang" required>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi_gudang" class="form-label">Lokasi Gudang</label>
                            <input type="text" class="form-control" id="lokasi_gudang" name="lokasi_gudang" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="tambah">Tambah Gudang</button>
                        <button type="cancel" class="btn btn-primary" hreft="inventory.php">batalkan</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
