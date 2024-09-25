<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f8f9fa; /* Light background for better contrast */
        }

        .upload-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px; /* Add space below upload section */
        }

        .upload-section input[type="file"] {
            flex: 1;
            margin-right: 10px;
        }

        .upload-section button {
            flex-shrink: 0;
        }

        table {
            width: 100%;
            margin-top: 20px; /* Add margin on top */
        }

        th {
            background-color: #0000FF; /* Warna latar belakang hitam */
            color: black; /* Warna teks putih */
            text-align: center; /* Centered header text */
            position: sticky; /* Sticky header */
            top: 0; /* Pastikan efek sticky */
            z-index: 1; /* Keep it above other rows */
            padding: 10px; /* Add padding to prevent text collision */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for better visibility */
        }

        td {
            text-align: center; /* Centered data text */
        }

        tr:nth-child(even) {
            background-color: #e9ecef; /* Bootstrap light grey for even rows */
        }

        tr:hover {
            background-color: #d1ecf1; /* Light blue on hover */
        }

        .btn {
            margin-top: 10px; /* Spacing for buttons */
        }
    </style>
</head>
<body>
    <h1 class="mb-4">Upload and Display Excel Data</h1>

    <div class="upload-section">
        <input type="file" id="uploadExcel" accept=".xlsx, .xls" class="form-control" />
        <button id="uploadButton" class="btn btn-primary">Upload</button>
    </div>

    <table id="excelTable" class="table table-bordered table-hover">
        <!-- Excel data will be displayed here -->
    </table>

    <button id="saveButton" class="btn btn-success">Save Data</button>

    <script>
        document.getElementById('uploadButton').addEventListener('click', function () {
            var fileInput = document.getElementById('uploadExcel');
            if (fileInput.files.length === 0) {
                alert("Please choose a file to upload.");
                return;
            }

            var file = fileInput.files[0];
            var reader = new FileReader();
            
            reader.onload = function (e) {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, { type: 'array' });
                
                // Mengambil sheet pertama
                var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                
                // Mengonversi sheet menjadi JSON
                var excelData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

                // Menampilkan data ke tabel
                var table = document.getElementById('excelTable');
                table.innerHTML = ""; // Kosongkan tabel sebelum menambahkan data baru
                
                excelData.forEach(function (row, rowIndex) {
                    var rowElement = table.insertRow(-1);
                    
                    // Jika baris pertama, buat sebagai header (th)
                    if (rowIndex === 0) {
                        row.forEach(function (cell) {
                            var headerCell = document.createElement("th");
                            headerCell.textContent = cell;
                            rowElement.appendChild(headerCell);
                        });
                    } else {
                        // Baris berikutnya buat sebagai data (td)
                        row.forEach(function (cell, cellIndex) {
                            var cellElement = rowElement.insertCell(-1);
                            
                            // Format tanggal
                            if (cellIndex === 4) { // Misalkan kolom ke-5 adalah tanggal
                                var cellValue = cell; // Ambil nilai cell
                                var date;

                                // Cek jika nilai cell berupa angka (tanggal serial Excel)
                                if (typeof cellValue === 'number') {
                                    date = XLSX.SSF.parse_date_code(cellValue);
                                    date = new Date(date.y, date.m - 1, date.d, date.h || 0, date.M || 0);
                                } else if (typeof cellValue === 'string') {
                                    // Misalnya, jika formatnya adalah "DD/MM/YYYY" atau "YYYY-MM-DD"
                                    var parts = cellValue.split(/[/\s:-]/); // Memisahkan berdasarkan / atau spasi atau :
                                    
                                    // Cek format yang berbeda
                                    if (parts.length >= 3) {
                                        var day = parseInt(parts[0], 10);
                                        var month = parseInt(parts[1], 10) - 1; // JavaScript bulan dimulai dari 0
                                        var year = parseInt(parts[2], 10);
                                        var hours = parts.length > 3 ? parseInt(parts[3], 10) : 0;
                                        var minutes = parts.length > 4 ? parseInt(parts[4], 10) : 0;

                                        // Buat objek Date
                                        date = new Date(year, month, day, hours, minutes);
                                    } else {
                                        console.error("Format tanggal tidak dikenali:", cellValue);
                                    }
                                } else {
                                    // Jika cellValue sudah dalam format Date, langsung gunakan
                                    date = cellValue instanceof Date ? cellValue : null;
                                }

                                // Format tanggal
                                if (date) {
                                    var formattedDate = 
                                        ("0" + date.getDate()).slice(-2) + "/" + 
                                        ("0" + (date.getMonth() + 1)).slice(-2) + "/" + 
                                        date.getFullYear() + " " + 
                                        ("0" + date.getHours()).slice(-2) + ":" + 
                                        ("0" + date.getMinutes()).slice(-2);
                                    
                                    cellElement.textContent = formattedDate;
                                } else {
                                    cellElement.textContent = "Invalid date";
                                }
                            }
                            // Format produksi
                            else if (cellIndex === 7) { // Misalkan kolom ke-8 adalah produksi
                                cellElement.textContent = Number(cell).toLocaleString('id-ID'); // Format dengan titik
                            } 
                            // Format target menjadi persentase
                            else if (cellIndex === 8) { // Misalkan kolom ke-13 adalah target
                                cellElement.textContent = (cell * 100) + '%'; // Format ke %
                            } else {
                                cellElement.textContent = cell;
                            }
                        });
                    }
                });
            };

            reader.readAsArrayBuffer(file);
        });

        document.getElementById('saveButton').addEventListener('click', function () {
            var table = document.getElementById('excelTable');
            var excelData = [];
        
            // Mengambil data dari tabel
            for (var i = 1; i < table.rows.length; i++) { // Mulai dari 1 untuk melewati header
                var row = table.rows[i];
                var rowData = [];
                for (var j = 0; j < row.cells.length; j++) {
                    rowData.push(row.cells[j].textContent);
                }
                excelData.push(rowData);
            }
        
            // Kirim data ke backend menggunakan fetch
            fetch('save_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(excelData),
            })
            .then(response => response.text())
            .then(data => {
                alert("Data saved successfully!");
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    </script>
</body>
</html>
