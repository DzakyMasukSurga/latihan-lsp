<?php
include 'koneksi.php';

// Proses Tambah Data Vendor
if (isset($_POST['tambah'])) {
    $nama_vendor = $_POST['nama_vendor'];
    $kontak_v = $_POST['kontak_v'];
    $nama_barang = $_POST['nama_barang'];

    $sql = "INSERT INTO vendor (nama_vendor, kontak_v, nama_barang) 
            VALUES ('$nama_vendor', '$kontak_v', '$nama_barang')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Data vendor berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Proses Hapus Data Vendor
if (isset($_GET['hapus'])) {
    $id_vendor = $_GET['hapus'];
    $sql = "DELETE FROM vendor WHERE id_vendor='$id_vendor'";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Data vendor berhasil dihapus.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Proses Perbarui Data Vendor
if (isset($_POST['perbarui'])) {
    $id_vendor = $_POST['id_vendor'];
    $nama_vendor = $_POST['nama_vendor'];
    $kontak_v = $_POST['kontak_v'];
    $nama_barang = $_POST['nama_barang'];

    // Tidak mengizinkan perubahan pada kolom nama_barang
    $sql = "UPDATE vendor SET 
                nama_vendor='$nama_vendor', 
                kontak_v='$kontak_v',
                nama_barang='$nama_barang' 
            WHERE id_vendor='$id_vendor'";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Data vendor berhasil diperbarui.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Mengambil semua data dari tabel vendor untuk ditampilkan
$result = mysqli_query($conn, "SELECT * FROM vendor");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Vendor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Bagian Menampilkan Data Vendor -->
            <div class="col-md-8">
                <h3>Data Vendor</h3>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ID Vendor</th>
                            <th>Nama Vendor</th>
                            <th>Kontak</th>
                            <th>Nama Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['id_vendor']; ?></td>
                                <td><?php echo $row['nama_vendor']; ?></td>
                                <td><?php echo $row['kontak_v']; ?></td>
                                <td><?php echo $row['nama_barang']; ?></td>
                                <td>
                                    <a href="dashboardcoy.php?page=vendor&edit=<?php echo $row['id_vendor']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="dashboardcoy.php?page=vendor&hapus=<?php echo $row['id_vendor']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Bagian Form Tambah/Edit Data Vendor -->
            <div class="col-md-4">
                <?php
                // Jika ada permintaan edit, tampilkan form edit dengan data terisi
                if (isset($_GET['edit'])) {
                    $id_vendor = $_GET['edit'];
                    $editResult = mysqli_query($conn, "SELECT * FROM vendor WHERE id_vendor='$id_vendor'");
                    $editRow = mysqli_fetch_assoc($editResult);
                ?>
                    <h3>Edit Data Vendor</h3>
                    <form action="dashboardcoy.php?page=vendor" method="post">
                        <input type="hidden" name="id_vendor" value="<?php echo $editRow['id_vendor']; ?>">
                        <div class="mb-3">
                            <label for="nama_vendor" class="form-label">Nama Vendor</label>
                            <input type="text" class="form-control" id="nama_vendor" name="nama_vendor" value="<?php echo $editRow['nama_vendor']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kontak_v" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="kontak_v" name="kontak_v" value="<?php echo $editRow['kontak_v']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kontak_v" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $editRow['nama_barang']; ?>" required>
                        </div>
                        <!-- Tidak memungkinkan untuk mengedit nama_barang -->
                        <button type="submit" class="btn btn-primary" name="perbarui">Perbarui Vendor</button>
                        <button type="cancel" class="btn btn-primary" hreft="inventory.php">batalkan</button>
                    </form>
                <?php } else { ?>
                    <h3>Tambah Data Vendor</h3>
                    <form action="dashboardcoy.php?page=vendor" method="post">
                        <div class="mb-3">
                            <label for="nama_vendor" class="form-label">Nama Vendor</label>
                            <input type="text" class="form-control" id="nama_vendor" name="nama_vendor" required>
                        </div>
                        <div class="mb-3">
                            <label for="kontak_v" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="kontak_v" name="kontak_v" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="tambah">Tambah Vendor</button>
                        <button type="cancel" class="btn btn-primary" hreft="inventory.php">batalkan</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
