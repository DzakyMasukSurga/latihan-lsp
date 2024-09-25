<?php
include 'koneksi.php';

// Proses Tambah Data Inventory
if (isset($_POST['tambah'])) {
    $serial_number = $_POST['serial_number'];
    $nama_barang = $_POST['nama_barang'];
    $jenis_barang = $_POST['jenis_barang'];
    $kuantitas_stok = $_POST['kuantitas_stok'];
    $harga_barang = $_POST['harga_barang'];
    $lokasi = $_POST['lokasi_gudang'];

    $sql = "INSERT INTO inventory (serial_number, nama_barang, jenis_barang, kuantitas_stok, harga_barang, lokasi_gudang) 
            VALUES ('$serial_number', '$nama_barang', '$jenis_barang', '$kuantitas_stok', '$harga_barang', '$lokasi')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Data inventory berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Proses Hapus Data Inventory
if (isset($_GET['hapus'])) {
    $serial_number = $_GET['hapus'];
    $sql = "DELETE FROM inventory WHERE serial_number='$serial_number'";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Data inventory berhasil dihapus.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Proses Perbarui Data Inventory
if (isset($_POST['perbarui'])) {
    $serial_number = $_POST['serial_number'];
    $jenis_barang = $_POST['jenis_barang'];
    $kuantitas_stok = $_POST['kuantitas_stok'];
    $harga_barang = $_POST['harga_barang'];
   
    $sql = "UPDATE inventory SET 
                jenis_barang='$jenis_barang', 
                kuantitas_stok='$kuantitas_stok', 
                harga_barang='$harga_barang'  
            WHERE serial_number='$serial_number'";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Data inventory berhasil diperbarui.</div>";
        if ($kuantitas_stok < 3) {
            echo "<div class='alert alert-warning'>Peringatan: Stok barang Menipis</div>";
        }
        
        if ($kuantitas_stok <= 0) {
            echo "<div class='alert alert-danger'>Peringatan: Stok barang Habis</div>";
        }
    }
    else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Mengambil semua data dari tabel inventory untuk ditampilkan
$result = mysqli_query($conn, "SELECT * FROM inventory");
$vendorResult = mysqli_query($conn, "SELECT nama_barang FROM vendor");
$strgResult = mysqli_query($conn, "SELECT lokasi_gudang FROM storage");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Inventory</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tambahkan CSS untuk stok habis -->
    <style>
        .stok-habis {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Bagian 1: Menampilkan Data Inventory -->
            <div class="col-md-8">
                <h3>Data Inventory</h3>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Kuantitas Stok</th>
                            <th>Harga Barang</th>
                            <th>Lokasi Gudang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['serial_number']; ?></td>
                                <td><?php echo $row['nama_barang']; ?></td>
                                <td><?php echo $row['jenis_barang']; ?></td>
                                <!-- Cek apakah stok habis, jika ya tambahkan kelas 'stok-habis' -->
                                <td class="<?php echo ($row['kuantitas_stok'] == 0) ? 'stok-habis' : ''; ?>">
                                    <?php echo $row['kuantitas_stok']; ?>
                                </td>
                                <td><?php echo $row['harga_barang']; ?></td>
                                <td><?php echo $row['lokasi_gudang']; ?></td>
                                <td>
                                    <a href="dashboardcoy.php?page=inventory&edit=<?php echo $row['serial_number']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="dashboardcoy.php?page=inventory&hapus=<?php echo $row['serial_number']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Bagian 2: Form CRUD untuk Tambah/Edit Data Inventory -->
            <div class="col-md-4">
                <?php
                // Jika ada permintaan edit, tampilkan form edit dengan data terisi
                if (isset($_GET['edit'])) {
                    $serial_number = $_GET['edit'];
                    $editResult = mysqli_query($conn, "SELECT * FROM inventory WHERE serial_number='$serial_number'");
                    $editRow = mysqli_fetch_assoc($editResult);
                ?>
                    <h3>Edit Data Inventory</h3>
                    <form action="dashboardcoy.php?page=inventory" method="post">
                        <input type="hidden" name="serial_number" value="<?php echo $editRow['serial_number']; ?>">
                        <p>Nama Barang: <strong><?php echo $editRow['nama_barang']; ?></strong></p>
                        <div class="mb-3">
                            <label for="jenis_barang" class="form-label">Jenis Barang</label>
                            <input type="dropdown" class="form-control" id="jenis_barang" name="jenis_barang" value="<?php echo $editRow['jenis_barang']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kuantitas_stok" class="form-label">Kuantitas Stok</label>
                            <input type="number" class="form-control" id="kuantitas_stok" name="kuantitas_stok" value="<?php echo $editRow['kuantitas_stok']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_barang" class="form-label">Harga Barang</label>
                            <input type="number" step="0.01" class="form-control" id="harga_barang" name="harga_barang" value="<?php echo $editRow['harga_barang']; ?>" required>
                        </div>
                        <p>Lokasi Gudang: <strong><?php echo $editRow['lokasi_gudang']; ?></strong></p>
                        <button type="submit" class="btn btn-primary" name="perbarui">Perbarui Inventory</button>
                        <button type="cancel" class="btn btn-primary" hreft="inventory.php">batalkan</button>
                    </form>
                <?php } else { ?>
                    <h3>Tambah Data Inventory</h3>
                    <form action="dashboardcoy.php?page=inventory" method="post">
                        <div class="mb-3">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <select class="form-control" id="nama_barang" name="nama_barang" required>
                                <option value="" disabled selected>Pilih Nama Barang</option>
                                <?php while ($row = mysqli_fetch_assoc($vendorResult)) { ?>
                                    <option value="<?php echo $row['nama_barang']; ?>"><?php echo $row['nama_barang']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_barang" class="form-label">Jenis Barang</label>
                            <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="kuantitas_stok" class="form-label">Kuantitas Stok</label>
                            <input type="number" class="form-control" id="kuantitas_stok" name="kuantitas_stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_barang" class="form-label">Harga Barang</label>
                            <input type="number" step="0.01" class="form-control" id="harga_barang" name="harga_barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi_gudang" class="form-label">Lokasi Gudang</label>
                            <select class="form-control" id="lokasi_gudang" name="lokasi_gudang" required>
                                <option value="" disabled selected>Pilih Lokasi</option>
                                <?php while ($row = mysqli_fetch_assoc($strgResult)) { ?>
                                    <option value="<?php echo $row['lokasi_gudang']; ?>"><?php echo $row['lokasi_gudang']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="tambah">Tambah Inventory</button>
                        <button type="cancel" class="btn btn-primary" hreft="inventory.php">batalkan</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
