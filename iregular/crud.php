<?php
include 'config.php'; // Include database configuration

// Handle delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $koneksi->prepare("DELETE FROM iregular WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header("Location: crud.php"); // Redirect to avoid resubmission
}

// Fetch existing data for editing
$editData = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $stmt = $koneksi->prepare("SELECT * FROM iregular WHERE id = ?");
    $stmt->bind_param('i', $edit_id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}

// Handle insert or update operation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $id_sistem = $_POST['id_sistem'];
    $reg_asal_p6 = $_POST['reg_asal_p6'];
    $kantor_asal_p6 = $_POST['kantor_asal_p6'];
    $nopend_asal_p6 = $_POST['nopend_asal_p6'];
    $tanggal_berita_acara = $_POST['tanggal_berita_acara'];
    $bulan = $_POST['bulan'];
    $week = $_POST['week'];
    $produksi = $_POST['produksi'];
    $target = $_POST['target'];
    $tahun = $_POST['tahun'];
    $reg_tujuan_p6 = $_POST['reg_tujuan_p6'];
    $kantor_tujuan_p6 = $_POST['kantor_tujuan_p6'];
    $nopend_tujuan_p6 = $_POST['nopend_tujuan_p6'];
    $deskripsi = $_POST['deskripsi'];
    $dnln = $_POST['dnln'];
    $nomor_kiriman = $_POST['nomor_kiriman'];

    if ($id) {
        // Update existing record
        $stmt = $koneksi->prepare("UPDATE iregular SET id_sistem=?, reg_asal_p6=?, kantor_asal_p6=?, nopend_asal_p6=?, tanggal_berita_acara=?, bulan=?, week=?, produksi=?, target=?, tahun=?, reg_tujuan_p6=?, kantor_tujuan_p6=?, nopend_tujuan_p6=?, deskripsi=?, dnln=?, nomor_kiriman=? WHERE id=?");
        $stmt->bind_param('ssssssssssssssssi', $id_sistem, $reg_asal_p6, $kantor_asal_p6, $nopend_asal_p6, $tanggal_berita_acara, $bulan, $week, $produksi, $target, $tahun, $reg_tujuan_p6, $kantor_tujuan_p6, $nopend_tujuan_p6, $deskripsi, $dnln, $nomor_kiriman, $id);
    } else {
        // Insert new record
        $stmt = $koneksi->prepare("INSERT INTO iregular (id_sistem, reg_asal_p6, kantor_asal_p6, nopend_asal_p6, tanggal_berita_acara, bulan, week, produksi, target, tahun, reg_tujuan_p6, kantor_tujuan_p6, nopend_tujuan_p6, deskripsi, dnln, nomor_kiriman) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssssssssssss', $id_sistem, $reg_asal_p6, $kantor_asal_p6, $nopend_asal_p6, $tanggal_berita_acara, $bulan, $week, $produksi, $target, $tahun, $reg_tujuan_p6, $kantor_tujuan_p6, $nopend_tujuan_p6, $deskripsi, $dnln, $nomor_kiriman);
    }
    $stmt->execute();
    header("Location: crud.php");
}

// Fetch data for display
$result = $koneksi->query("SELECT * FROM iregular");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Data Iregular</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto; /* Adjust table layout */
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
            white-space: nowrap; /* Prevent line break */
            overflow: hidden; /* Hide overflow */
            text-overflow: ellipsis; /* Add ellipsis for overflow text */
        }
        th {
            background-color: #f2f2f2;
        }
        /* th:nth-child(1) { width: 50px; } ID */
        th:nth-child(2) { width: 100px; } /* ID Sistem */
        th:nth-child(3) { width: 120px; } /* Reg Asal P6 */
        th:nth-child(4) { width: 150px; } /* Kantor Asal P6 */
        th:nth-child(5) { width: 120px; } /* No Pend Asal P6 */
        th:nth-child(6) { width: 120px; } /* Tanggal Berita */
        th:nth-child(7) { width: 80px; }  /* Bulan */
        th:nth-child(8) { width: 80px; }  /* Week */
        th:nth-child(9) { width: 120px; } /* Produksi */
        th:nth-child(10) { width: 100px; } /* Target */
        th:nth-child(11) { width: 80px; } /* Tahun */
        th:nth-child(12) { width: 120px; } /* Reg Tujuan P6 */
        th:nth-child(13) { width: 150px; } /* Kantor Tujuan P6 */
        th:nth-child(14) { width: 120px; } /* No Pend Tujuan P6 */
        th:nth-child(15) { width: 150px; } /* Deskripsi */
        th:nth-child(16) { width: 100px; } /* DNLN */
        th:nth-child(17) { width: 120px; } /* Nomor Kiriman */
        th:nth-child(18) { width: 150px; } /* Actions */
        
        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            table, th, td {
                font-size: 12px; /* Smaller text on small screens */
            }
            th, td {
                padding: 5px; /* Less padding */
            }
        }
    </style>
</head>
<body>

<h2>Data Iregular</h2>

<table>
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>ID Sistem</th>
            <th>Reg Asal P6</th>
            <th>Kantor Asal P6</th>
            <th>No Pend Asal P6</th>
            <th>Tanggal Berita</th>
            <th>Bulan</th>
            <th>Week</th>
            <th>Produksi</th>
            <th>Target</th>
            <th>Tahun</th>
            <th>Reg Tujuan P6</th>
            <th>Kantor Tujuan P6</th>
            <th>No Pend Tujuan P6</th>
            <th>Deskripsi</th>
            <th>DNLN</th>
            <th>Nomor Kiriman</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
 
                <td><?= $row['id_sistem'] ?></td>
                <td><?= $row['reg_asal_p6'] ?></td>
                <td><?= $row['kantor_asal_p6'] ?></td>
                <td><?= $row['nopend_asal_p6'] ?></td>
                <td><?= $row['tanggal_berita_acara'] ?></td>
                <td><?= $row['bulan'] ?></td>
                <td><?= $row['week'] ?></td>
                <td><?= $row['produksi'] ?></td>
                <td><?= $row['target'] ?></td>
                <td><?= $row['tahun'] ?></td>
                <td><?= $row['reg_tujuan_p6'] ?></td>
                <td><?= $row['kantor_tujuan_p6'] ?></td>
                <td><?= $row['nopend_tujuan_p6'] ?></td>
                <td><?= $row['deskripsi'] ?></td>
                <td><?= $row['dnln'] ?></td>
                <td><?= $row['nomor_kiriman'] ?></td>
                <td>
                    <a href="?edit=<?= $row['id'] ?>">Edit</a>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
