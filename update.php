<?php
include "koneksi.php";

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Ambil data untuk update
if (isset($_GET['no_id'])) {
    $no_id = input($_GET["no_id"]);
    $sql = "SELECT * FROM tugas WHERE no_id=$no_id";
    $hasil = mysqli_query($kon, $sql);
    if ($hasil) {
        $data = mysqli_fetch_assoc($hasil);
    } else {
        echo "Error fetching data: " . mysqli_error($kon);
        exit;
    }
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_id = htmlspecialchars($_POST["no_id"]);
    $namaTugas = input($_POST["namaTugas"]);
    $status = input($_POST["status"]);
    $prioritas = input($_POST["prioritas"]);
    $tanggal = input($_POST["tanggal"]);

    // Check if the no_id is not empty
    if (!empty($no_id)) {
        // Prepare the UPDATE query
        $sql = "UPDATE tugas SET
                namaTugas='$namaTugas',
                status='$status',
                prioritas='$prioritas',
                tanggal='$tanggal'
                WHERE no_id='$no_id'";

        // Execute the query
        $hasil = mysqli_query($kon, $sql);

        if ($hasil) {
            // Redirect to index.php if the update is successful
            header("Location: index.php");
            exit;
        } else {
            // If query fails, show error message
            echo "<div class='alert alert-danger'>Data Gagal Disimpan. Error: " . mysqli_error($kon) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>No ID is missing or invalid!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO DO LIST TUGAS</title>
    <style>
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
        <h2>Update Data</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>No ID: </label>
                <input type="text" name="no_id" class="form-control" value="<?php echo $data['no_id']; ?>" required>
            </div>
            <div class="form-group">
                <label>Nama Tugas: </label>
                <input type="text" name="namaTugas" class="form-control" value="<?php echo $data['namaTugas']; ?>" required>
            </div>
            <div class="form-group">
                <label>Status: </label>
                <select name="status" class="form-control" required>
                    <option value="Belum Selesai" <?php echo $data['status'] == 'Belum Selesai' ? 'selected' : ''; ?>>Belum Selesai</option>
                    <option value="Sedang Dikerjakan" <?php echo $data['status'] == 'Sedang Dikerjakan' ? 'selected' : ''; ?>>Sedang Dikerjakan</option>
                    <option value="Selesai" <?php echo $data['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal: </label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo $data['tanggal']; ?>" required/>
            </div>
            <button type="submit">Update</button>
            <a href="index.php" class="btn-info text-white">Kembali</a>
        </form>
    </div>
</body>
</html>
