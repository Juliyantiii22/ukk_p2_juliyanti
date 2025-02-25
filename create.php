<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Tugas</title>
    <style>
        /* Basis Reset */
        * { 
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 600px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 14px;
            color: #333;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        a.btn-info {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-align: center;
            background-color: #17a2b8;
            color: white;
            text-decoration: none;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        a.btn-info:hover {
            background-color: #138496;
        }

        .alert {
            padding: 15px;
            background-color: #f8d7da;
            color: #712c24;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
<div class="container">
    <?php
    include "koneksi.php";

    // Function to sanitize user input
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $no_id = input($_POST["no_id"]);
        $namaTugas = input($_POST["namaTugas"]);
        $status = input($_POST["status"]);
        $prioritas = input($_POST["prioritas"]);
        $tanggal = input($_POST["tanggal"]);
        
        // SQL query to insert the new task into the database
        $sql = "INSERT INTO tugas (no_id, namaTugas, status, prioritas, tanggal) 
                VALUES ('$no_id', '$namaTugas', '$status', '$prioritas', '$tanggal')";

        $hasil = mysqli_query($kon, $sql);

        if ($hasil) {
            header("Location: index.php"); // Redirect to the index page after insertion
            exit();
        } else {
            echo "<div class='alert'>Data Gagal Disimpan</div>";
        }
    }
    ?>

    <h2>Input Data Tugas</h2>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <div class="form-group">
            <label for="no_id">No ID:</label>
            <input type="text" name="no_id" class="form-control" id="no_id" placeholder="Masukkan NO ID" required />
        </div>

        <div class="form-group">
            <label for="namaTugas">Nama Tugas:</label>
            <input type="text" name="namaTugas" class="form-control" id="namaTugas" placeholder="Masukkan Nama Tugas" required />
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" class="form-control" id="status" required>
                <option value="Belum Selesai">Belum Selesai</option>
                <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>

        <div class="form-group">
            <label for="prioritas">Prioritas:</label>
            <select name="prioritas" class="form-control" id="prioritas" required>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" id="tanggal" required />
        </div>

        <button type="submit">Tambah Tugas</button>
    </form>
</div>

</body>
</html>
