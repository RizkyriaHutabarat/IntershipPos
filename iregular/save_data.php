<?php
include 'config.php'; // Include database configuration

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);

// Check if we have data
if (!empty($data)) {
    // Prepare SQL statement
    $stmt = $koneksi->prepare("INSERT INTO iregular (id_sistem, reg_asal_p6, kantor_asal_p6, nopend_asal_p6, tanggal_berita_acara, bulan, week, produksi, target, tahun, reg_tujuan_p6, kantor_tujuan_p6, nopend_tujuan_p6, deskripsi, dnln, nomor_kiriman) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($data as $row) {
        // Assuming that $row corresponds to: [id_sistem, reg_asal_p6, kantor_asal_p6, nopend_asal_p6, ...]
        $id_sistem = $row[0];
        $reg_asal_p6 = $row[1];
        $kantor_asal_p6 = $row[2];
        $nopend_asal_p6 = $row[3];
        $tanggal_berita_acara = $row[4];
        $bulan = $row[5];
        $week = $row[6];
        $produksi = $row[7];
        $target = $row[8];
        $tahun = $row[9];
        $reg_tujuan_p6 = $row[10];
        $kantor_tujuan_p6 = $row[11];
        $nopend_tujuan_p6 = $row[12];
        $deskripsi = $row[13];
        $dnln = $row[14];
        $nomor_kiriman = $row[15];

        // Bind parameters
        $stmt->bind_param(
            'ssssssssssssssss', 
            $id_sistem, $reg_asal_p6, $kantor_asal_p6, $nopend_asal_p6, 
            $tanggal_berita_acara, $bulan, $week, $produksi, 
            $target, $tahun, $reg_tujuan_p6, $kantor_tujuan_p6, 
            $nopend_tujuan_p6, $deskripsi, $dnln, $nomor_kiriman
        );
        
        // Execute the statement
        $stmt->execute();
    }

    echo "Data successfully saved!";
    $stmt->close();
} else {
    echo "No data received!";
}

$koneksi->close();
?>
