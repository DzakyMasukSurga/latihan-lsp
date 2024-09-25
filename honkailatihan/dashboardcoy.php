<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CDN -->
    <link href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: yellow;
            padding: 15px;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
            padding: 10px;
            display: block;
        }
        .sidebar a:hover {
            background-color: green;
            color: white;
        }
        .card {
            margin: 10px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .card h4 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .dashboard-header {
            text-align: center;
            margin: 20px 0;
        }
        /* Styling tambahan untuk form pencarian */
        .search-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .search-container input[type="text"] {
            width: 400px;
            height: 45px;
            padding: 10px;
            border: 2px solid #007bff;
            border-radius: 25px 0 0 25px;
            font-size: 16px;
        }
        .search-container button {
            height: 45px;
            padding: 0 20px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 0 25px 25px 0;
            font-size: 16px;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Dashboard</h3>
        <a href="dashboardcoy.php?page=inventory">Tabel Inventory</a>
        <a href="dashboardcoy.php?page=storage">Tabel Storage</a>
        <a href="dashboardcoy.php?page=vendor">Tabel Vendor</a>
        <hr>
        <a href="dashboardcoy.php">Halaman Utama</a>
    </div>

    <div class="content">
        <?php
        include 'koneksi.php'; // Koneksi ke database

        // Mengecek apakah ada query pencarian
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
            $query = mysqli_real_escape_string($conn, $query); // Mencegah SQL Injection

            // Query untuk mencari di tabel inventory, vendor, dan storage
            $sql_inventory = "SELECT * FROM inventory WHERE nama_barang LIKE '%$query%' OR jenis_barang LIKE '%$query%'";
            $sql_vendor = "SELECT * FROM vendor WHERE nama_vendor LIKE '%$query%' OR nama_barang LIKE '%$query%'";
            $sql_storage = "SELECT * FROM storage WHERE lokasi_gudang LIKE '%$query%'";

            $result_inventory = mysqli_query($conn, $sql_inventory);
            $result_vendor = mysqli_query($conn, $sql_vendor);
            $result_storage = mysqli_query($conn, $sql_storage);
        ?>

        <!-- Hasil Pencarian -->
        <h3>Hasil Pencarian untuk: "<?php echo htmlspecialchars($query); ?>"</h3>

        <!-- Tabel Inventory -->
        <h4>Inventory</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Kuantitas Stok</th>
                    <th>Harga Barang</th>
                    <th>Lokasi Gudang</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_inventory) > 0) {
                    while ($row = mysqli_fetch_assoc($result_inventory)) { ?>
                        <tr>
                            <td><?php echo $row['serial_number']; ?></td>
                            <td><?php echo $row['nama_barang']; ?></td>
                            <td><?php echo $row['jenis_barang']; ?></td>
                            <td><?php echo $row['kuantitas_stok']; ?></td>
                            <td><?php echo $row['harga_barang']; ?></td>
                            <td><?php echo $row['lokasi_gudang']; ?></td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data di inventory yang sesuai.</td></tr>";
                } ?>
            </tbody>
        </table>

        <!-- Tabel Vendor -->
        <h4>Vendor</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Vendor</th>
                    <th>Nama Barang</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_vendor) > 0) {
                    while ($row = mysqli_fetch_assoc($result_vendor)) { ?>
                        <tr>
                            <td><?php echo $row['nama_vendor']; ?></td>
                            <td><?php echo $row['nama_barang']; ?></td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='2'>Tidak ada data vendor yang sesuai.</td></tr>";
                } ?>
            </tbody>
        </table>

        <!-- Tabel Gudang -->
        <h4>Gudang</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Lokasi Gudang</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_storage) > 0) {
                    while ($row = mysqli_fetch_assoc($result_storage)) { ?>
                        <tr>
                            <td><?php echo $row['lokasi_gudang']; ?></td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td>Tidak ada data gudang yang sesuai.</td></tr>";
                } ?>
            </tbody>
        </table>

        <?php
        } else {
            // Konten utama dashboard
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'inventory':
                        include 'inventory.php';
                        break;
                    case 'storage':
                        include 'storage.php';
                        break;
                    case 'vendor':
                        include 'vendor.php';
                        break;
                    default:
                        echo "<h3>Selamat datang di dashboard!</h3>";
                        break;
                }
            } else {
                ?>

                <!-- Form Pencarian -->
                <div class="dashboard-header">
                    <h2>Selamat Datang di Dashboard</h2>
                    <p>Ringkasan informasi penting</p>

                    <!-- Form untuk pencarian -->
                    <div class="search-container">
                        <form action="dashboardcoy.php" method="GET">
                            <input type="text" class="form-control" id="search-input" name="query" required>
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <!-- Card Inventory -->
                    <div class="col-md-4">
                        <div class="card">
                            <h4>Jumlah Barang di Inventory</h4>
                            <?php
                            // Koneksi ke database
                            $query_inventory = "SELECT COUNT(*) as total FROM inventory";
                            $result_inventory = mysqli_query($conn, $query_inventory);
                            $data_inventory = mysqli_fetch_assoc($result_inventory);
                            echo "<p>Total Barang: " . $data_inventory['total'] . "</p>";
                            ?>
                        </div>
                    </div>

                    <!-- Card Storage -->
                    <div class="col-md-4">
                        <div class="card">
                            <h4>Jumlah Gudang</h4>
                            <?php
                            $query_storage = "SELECT COUNT(*) as total FROM storage";
                            $result_storage = mysqli_query($conn, $query_storage);
                            $data_storage = mysqli_fetch_assoc($result_storage);
                            echo "<p>Total Gudang: " . $data_storage['total'] . "</p>";
                            ?>
                        </div>
                    </div>

                    <!-- Card Vendor -->
                    <div class="col-md-4">
                        <div class="card">
                            <h4>Jumlah Vendor</h4>
                            <?php
                            $query_vendor = "SELECT COUNT(*) as total FROM vendor";
                            $result_vendor = mysqli_query($conn, $query_vendor);
                            $data_vendor = mysqli_fetch_assoc($result_vendor);
                            echo "<p>Total Vendor: " . $data_vendor['total'] . "</p>";
                            ?>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
        ?>
    </div>

    <!-- Placeholder Dinamis untuk Form Pencarian -->
    <script>
        const placeholders = [
            "Cari barang di inventory...",
            "Cari vendor...",
            "Cari gudang..."
        ];
        let index = 0;
        const searchInput = document.getElementById('search-input');

        function changePlaceholder() {
            searchInput.placeholder = placeholders[index];
            index = (index + 1) % placeholders.length;
        }

        setInterval(changePlaceholder, 3000); // Ganti placeholder setiap 3 detik
    </script>

    <!-- Bootstrap JS -->
    <script src="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
