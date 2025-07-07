<?php
// Sertakan file koneksi di paling atas
include 'config.php';

// --- Ambil data statistik untuk kartu ---
// Mengambil total data dari tabel status_booking
$query_total_peminjaman = mysqli_query($conn, "SELECT COUNT(*) as total FROM status_booking");
$data_total_peminjaman = mysqli_fetch_assoc($query_total_peminjaman);
$total_peminjaman = $data_total_peminjaman['total'] ?? 0;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Ruang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        /* CSS Anda tidak diubah sama sekali */
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
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12 mb-3 mb-md-0">
            <div class="stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary mr-3"><i class="fas fa-calendar-check"></i></div>
                    <div>
                        <h6 class="mb-0 text-dark">Total Peminjaman</h6>
                        <h4 class="font-weight-bold text-dark"><?= $total_peminjaman ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card interactive-card">
        <div class="card-header">Laporan Peminjaman Ruang</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="create_booking.php" class="btn btn-primary"><i class="fas fa-plus"></i>Tambah Peminjaman</a>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari data peminjaman...">
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ruang</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Nama Peminjam</th>
                            <th>Keperluan</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="menuTableBody">
                        <?php
                        // Mengambil semua data dari tabel status_booking, diurutkan berdasarkan tanggal dan jam
                        // PENTING: Query ini mengambil kolom 'id_booking' untuk fungsi Edit dan Delete
                        $sql = mysqli_query($conn, "SELECT *, nama_ruang FROM status_booking ORDER BY tanggal ASC, jam ASC");
                        
                        if (!$sql) {
                            echo '<tr><td colspan="7" class="text-center text-danger"><strong>Terjadi Eror:</strong> ' . mysqli_error($conn) . '</td></tr>';
                        } else {
                            if (mysqli_num_rows($sql) > 0) {
                                $no = 1;
                                while ($r = mysqli_fetch_assoc($sql)) {
                        ?>
                                    <tr style="animation-delay: <?= ($no - 1) * 0.05 ?>s;">
                                        <th scope="row"><?= $no++; ?></th>
                                        <td><?= htmlspecialchars($r['nama_ruang']); ?></td>
                                        <td><?= htmlspecialchars($r['tanggal']); ?></td>
                                        <td><?= htmlspecialchars($r['jam']); ?></td>
                                        <td><?= htmlspecialchars($r['nama_user']); ?></td>
                                        <td><?= htmlspecialchars($r['keperluan']); ?></td>
                                        <td>
                                         
                                          <a href="delete_booking.php?nama_ruang=<?= urlencode($r['nama_ruang']); ?>" class="btn btn-danger btn-sm delete-button"> <i class="fas fa-trash-alt"></i> Delete</a>
                                        </td>
                                    </tr>
                        <?php 
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">Tidak ada data peminjaman ditemukan.</td></tr>';
                            }
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
    // Javascript tidak perlu diubah karena sudah dinamis
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const deleteUrl = this.href;
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });

        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('menuTableBody');
        const tableRows = tableBody.getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            for (let i = 0; i < tableRows.length; i++) {
                let row = tableRows[i];
                let cells = row.getElementsByTagName('td');
                let match = false;
                if (cells.length > 0) {
                     // Loop through all cells except the last one (Aksi)
                    for (let j = 0; j < cells.length - 1; j++) { 
                        if (cells[j] && cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                }
                if (match) {
                    row.style.display = "";
                } else if (row.getElementsByTagName('th').length === 0) { // Pastikan tidak menyembunyikan baris header
                    row.style.display = "none";
                }
            }
        });
    });
</script>

</body>
</html>