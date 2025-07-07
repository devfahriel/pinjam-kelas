<?php
// Sertakan file koneksi di paling atas
include 'config.php';

// --- Ambil data statistik untuk kartu ---

// 1. Ambil total semua mahasiswa
$query_total_mahasiswa = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_mahasiswa");
$data_total_mahasiswa = mysqli_fetch_assoc($query_total_mahasiswa);
$total_mahasiswa = $data_total_mahasiswa['total'] ?? 0;

// 2. Ambil total per role (admin, super user, user) dengan satu query efisien
$role_counts = [
    'admin' => 0,
    'super user' => 0,
    'user' => 0
];
$query_roles = mysqli_query($conn, "SELECT role, COUNT(*) as total_per_role FROM data_mahasiswa GROUP BY role");
if ($query_roles) {
    while ($data = mysqli_fetch_assoc($query_roles)) {
        // Cek jika role dari database ada di array $role_counts
        if (array_key_exists($data['role'], $role_counts)) {
            $role_counts[$data['role']] = $data['total_per_role'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Mahasiswa</title>
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
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stat-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary mr-3"><i class="fas fa-users"></i></div>
                    <div>
                        <h6 class="mb-0 text-dark">Total Mahasiswa</h6>
                        <h4 class="font-weight-bold text-dark"><?= $total_mahasiswa ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stat-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-danger mr-3"><i class="fas fa-user-shield"></i></div>
                    <div>
                        <h6 class="mb-0 text-dark">Total Admin</h6>
                        <h4 class="font-weight-bold text-dark"><?= $role_counts['admin'] ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stat-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning mr-3"><i class="fas fa-user-cog"></i></div>
                    <div>
                        <h6 class="mb-0 text-dark">Total Super User</h6>
                        <h4 class="font-weight-bold text-dark"><?= $role_counts['super user'] ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stat-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success mr-3"><i class="fas fa-user"></i></div>
                    <div>
                        <h6 class="mb-0 text-dark">Total User</h6>
                        <h4 class="font-weight-bold text-dark"><?= $role_counts['user'] ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card interactive-card">
        <div class="card-header">Laporan Data Mahasiswa</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="create_mahasiswa.php" class="btn btn-primary"><i class="fas fa-plus"></i>Tambah Data</a>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari data mahasiswa...">
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User id</th>
                            <th>Nama</th>
                            <th>Nim/Nidn</th>
                            <th>Role</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="menuTableBody">
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM data_mahasiswa ORDER BY id_user ASC");
                        
                        if (!$sql) {
                            echo '<tr><td colspan="6" class="text-center text-danger"><strong>Terjadi Eror:</strong> ' . mysqli_error($conn) . '</td></tr>';
                        } else {
                            if (mysqli_num_rows($sql) > 0) {
                                $no = 1;
                                while ($r = mysqli_fetch_assoc($sql)) {
                        ?>
                                    <tr style="animation-delay: <?= ($no - 1) * 0.05 ?>s;">
                                        <th scope="row"><?= $no++; ?></th>
                                        <td><?= htmlspecialchars($r['id_user']); ?></td>
                                        <td><?= htmlspecialchars($r['nama']); ?></td>
                                        <td><?= htmlspecialchars($r['nim_nidn']); ?></td>
                                        <td><?= htmlspecialchars($r['role']); ?></td>
                                        <td>
                                            <a href="edit_mahasiswa.php?id_user=<?= $r['id_user']; ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="delete_mahasiswa.php?id_user=<?= $r['id_user']; ?>" class="btn btn-danger btn-sm delete-button"><i class="fas fa-trash-alt"></i> Delete</a>
                                        </td>
                                    </tr>
                        <?php 
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center">Tidak ada data ditemukan di dalam tabel.</td></tr>';
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
                     for (let j = 0; j < cells.length - 1; j++) {
                        if (cells[j] && cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                }
                if (match) {
                    row.style.display = "";
                } else if(row.getElementsByTagName('th').length === 0) {
                    row.style.display = "none";
                }
            }
        });
    });
</script>

</body>
</html>