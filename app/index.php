<?php
include "koneksi.php";

// Query untuk mengambil semua data dari tabel penerima
$query = "SELECT * FROM penerima";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Sorting Site</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .header {
            background-color: #003d7a;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-left h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        .header-left p {
            font-size: 14px;
            opacity: 0.9;
        }
        .header-right {
            text-align: right;
        }
        .header-right .time {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .header-right .user {
            font-size: 16px;
            font-weight: bold;
        }
        .container {
            max-width: 1400px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .btn-tambah {
            display: inline-block;
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .btn-tambah:hover {
            background-color: #0052a3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background-color: #0066cc;
            color: white;
        }
        th {
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Dropdown Status */
        .status-dropdown {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-weight: bold;
            cursor: pointer;
        }

        /* Warna dropdown sesuai status */
        .status-diproses {
            color: blue;
        }
        .status-perjalanan {
            color: orange;
        }
        .status-selesai {
            color: green;
        }

        .btn-aksi {
            padding: 5px 12px;
            margin: 0 3px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            display: inline-block;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-hapus {
            background-color: #dc3545;
            color: white;
        }
        .btn-hapus:hover {
            background-color: #c82333;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }

        /* Toast notif */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 18px;
            border-radius: 6px;
            display: none;
            font-size: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <h1>Location Sorting</h1>
            <p>Location Sorting Site</p>
        </div>
        <div class="header-right">
            <div class="time">
                <?php
                date_default_timezone_set('Asia/Jakarta');
                echo date('l, F j, Y');
                echo '<br>';
                echo date('H:i:s');
                ?>
            </div>
            <div class="user">Hallo Admin</div>
        </div>
    </div>

    <div class="container">
        <h2>Data Lokasi Resi</h2>
        
        <a href="tambah.php" class="btn-tambah">+ Tambah Data</a>
        
        <table>
            <thead>
                <tr>
                    <th>No Resi</th>
                    <th>Lokasi Penerima</th>
                    <th>ID Penerima</th>
                    <th>Gudang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
              <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    // menentukan class warna dropdown
                    if ($row['status_pengiriman'] == 'Selesai') {
                        $status_class = 'status-selesai';
                    } elseif ($row['status_pengiriman'] == 'Dalam Pengiriman') {
                        $status_class = 'status-perjalanan';
                    } else {
                        $status_class = 'status-diproses';
                    }

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['no_resi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lokasi_penerima']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['id_penerima']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['gudang']) . "</td>";

                    // ✅ Status menjadi dropdown di tabel
                    echo "<td>
                            <select class='status-dropdown $status_class' data-id='" . $row['id'] . "'>
                                <option value='Diproses' " . ($row['status_pengiriman']=="Diproses" ? "selected" : "") . ">Diproses</option>
                                <option value='Dalam Pengiriman' " . ($row['status_pengiriman']=="Dalam Pengiriman" ? "selected" : "") . ">Dalam Pengiriman</option>
                                <option value='Selesai' " . ($row['status_pengiriman']=="Selesai" ? "selected" : "") . ">Selesai</option>
                            </select>
                          </td>";

                    echo "<td>
                            <a href='edit.php?id=" . $row['id'] . "' class='btn-aksi btn-edit'>Edit</a>
                            <a href='hapus.php?id=" . $row['id'] . "' class='btn-aksi btn-hapus' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='no-data'>Belum ada data. Silakan tambah data baru.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Toast notif -->
    <div class="toast" id="toast">Status berhasil diupdate ✅</div>

    <script>
        // fungsi toast
        function showToast() {
            const toast = document.getElementById("toast");
            toast.style.display = "block";
            setTimeout(() => {
                toast.style.display = "none";
            }, 2000);
        }

        // Update status via AJAX (Fetch)
        document.querySelectorAll(".status-dropdown").forEach(dropdown => {
            dropdown.addEventListener("change", function() {
                let id = this.getAttribute("data-id");
                let status = this.value;

                fetch("update_status.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id=" + id + "&status_pengiriman=" + encodeURIComponent(status)
                })
                .then(response => response.text())
                .then(data => {
                    if(data.trim() === "success"){
                        showToast();
                    } else {
                        alert("Gagal update status!");
                    }
                })
                .catch(error => console.error("Error:", error));
            });
        });

        // Refresh waktu setiap 1 menit
        setInterval(function() {
            location.reload();
        }, 60000);
    </script>
</body>
</html>
<?php
mysqli_close($koneksi);
?>
