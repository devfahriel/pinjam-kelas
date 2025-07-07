<?php
// Sertakan file koneksi di paling atas
include 'config.php';

// --- Ambil data statistik untuk kartu ---
// 1. Total Ruangan
$query_total_ruangan = mysqli_query($conn, "SELECT COUNT(*) as total_ruangan FROM data_ruangan");
$data_total_ruangan = mysqli_fetch_assoc($query_total_ruangan);
$total_ruangan = $data_total_ruangan['total_ruangan'] ?? 0;

// 2. Total Ruangan yang Tersedia
$query_ruangan_tersedia = mysqli_query($conn, "SELECT COUNT(*) as total_tersedia FROM data_ruangan WHERE status = 'available'");
$data_ruangan_tersedia = mysqli_fetch_assoc($query_ruangan_tersedia);
$ruangan_tersedia = $data_ruangan_tersedia['total_tersedia'] ?? 0;

// 3. Total Ruangan yang Tidak Tersedia (TAMBAHAN BARU)
$query_ruangan_tidak_tersedia = mysqli_query($conn, "SELECT COUNT(*) as total_tidak_tersedia FROM data_ruangan WHERE status = 'not available'");
$data_ruangan_tidak_tersedia = mysqli_fetch_assoc($query_ruangan_tidak_tersedia);
$ruangan_tidak_tersedia = $data_ruangan_tidak_tersedia['total_tidak_tersedia'] ?? 0;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Ruangan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        /* Style tidak diubah */
        body { background-color: #f8f9fa; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        .interactive-card { background-color: #fff; border-radius: 12px; border: none; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07); animation: fadeIn 0.5s ease-out; }
        .stat-card { background-color: #fff; border-radius: 0.75rem; border: 1px solid #e9ecef; transition: transform 0.3s ease, box-shadow 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .stat-card .stat-icon { font-size: 1.5rem; color: #fff; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;}
        .card-header { background-color: #fff; border-bottom: 1px solid #e9ecef; padding: 1.5rem; border-top-left-radius: 12px; border-top-right-radius: 12px; font-size: 1.25rem; font-weight: 600; color: #343a40; }
        .table thead th { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057; }
        .table tbody tr { opacity: 0; animation: tableRowFadeIn 0.5s ease-out forwards; }
        @keyframes tableRowFadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .table tbody tr:hover { background-color: #f1f1f1; }
        .btn i { margin-right: 5px; }

        /* --- STYLE BARU UNTUK SCROLL TABEL --- */
        .table-scroll-container {
            max-height: 400px; /* Cukup untuk sekitar 5-6 baris, bisa disesuaikan */
            overflow-y: auto;  /* Tambahkan scrollbar vertikal jika konten lebih tinggi */
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary mr-3"><i class="fas fa-door-closed"></i></div>
                    <div>
                        <h6 class="mb-0 text-dark">Total Ruangan</h6>
                        <h4 class="font-weight-bold text-dark"><?= $total_ruangan ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success mr-3"><i class="fas fa-door-open"></i></div>
                    <div>
                        <h6 class="mb-0 text-dark">Ruangan Tersedia</h6>
                        <h4 class="font-weight-bold text-dark"><?= $ruangan_tersedia ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-danger mr-3"><i class="fas fa-ban"></i></div>
                    <div>
                        <h6 class="mb-0 text-dark">Ruangan Tidak Tersedia</h6>
                        <h4 class="font-weight-bold text-dark"><?= $ruangan_tidak_tersedia ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card interactive-card">
        <div class="card-header">Laporan Data Ruangan</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="create_barang.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i>Tambah Ruangan
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari data ruangan...">
                    </div>
                </div>
            </div>
            
            <div class="table-responsive table-scroll-container">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Ruangan</th>
                            <th>Nama Ruangan</th>
                            <th>Nomor Ruangan</th>
                            <th>Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="ruanganTableBody">
                        <?php
                        $no = 1;
                        $sql = mysqli_query($conn, "SELECT * FROM data_ruangan ORDER BY id_ruangan ASC");
                        
                        if (!$sql) {
                            echo '<tr><td colspan="6" class="text-center text-danger"><strong>Terjadi Eror:</strong> ' . mysqli_error($conn) . '</td></tr>';
                        } else if (mysqli_num_rows($sql) > 0) {
                            while ($r = mysqli_fetch_assoc($sql)) {
                        ?>
                                <tr style="animation-delay: <?= ($no - 1) * 0.05 ?>s;">
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= htmlspecialchars($r['id_ruangan']); ?></td>
                                    <td><?= htmlspecialchars($r['nama_ruangan']); ?></td>
                                    <td><?= htmlspecialchars($r['nomor_ruangan']); ?></td>
                                    <td><?= htmlspecialchars($r['status']); ?></td>
                                    <td>
                                        <a href="edit_barang.php?id_ruangan=<?= $r['id_ruangan']; ?>" class="btn btn-success btn-sm text-white"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="delete_barang.php?id_ruangan=<?= $r['id_ruangan']; ?>" class="btn btn-danger btn-sm delete-button"><i class="fas fa-trash-alt"></i> Delete</a>
                                    </td>
                                </tr>
                        <?php 
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center">Belum ada data ruangan.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Script tidak diubah
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const deleteUrl = this.href;
                Swal.fire({
                    title: 'Apakah Anda yakin?', text: "Data ini akan dihapus permanen!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) { window.location.href = deleteUrl; }
                });
            });
        });

        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('ruanganTableBody');
        const tableRows = tableBody.getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            for (let i = 0; i < tableRows.length; i++) {
                let row = tableRows[i];
                let cells = row.getElementsByTagName('td');
                let match = false;
                if (cells.length > 0) {
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j] && cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                }
                if (match) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
        
        const rows = document.querySelectorAll('#ruanganTableBody tr');
        rows.forEach((row, index) => {
            row.style.animationDelay = (index * 0.05) + 's';
        });
    });
</script>

</body>
</html>