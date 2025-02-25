<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIST</title>
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
            padding-top: 20px;
        }

        nav {
            background-color: #343a40;
            padding: 10px;
        }

        nav .navbar-brand {
            color: white;
            font-size: 20px;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h4 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            text-align: center;
            margin: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .alert {
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .my-3 {
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <nav>
        <span class="navbar-brand mb-0 h1">juliyanti</span>
    </nav>

    <div class="container">
        <h4> TO DO LIST </h4>

        <!-- Create New Task Button -->
        <a href="create.php" class="btn btn-primary">Create New Task</a>

        <?php
        include "koneksi.php";

        // Delete task if 'no_id' is set in the URL
        if (isset($_GET['no_id'])) {
            $no_id = htmlspecialchars($_GET["no_id"]);

            // Deleting task from the database
            $sql = "DELETE FROM tugas WHERE no_id = '$no_id'";
            $hasil = mysqli_query($kon, $sql);

            if ($hasil) {
                header("Location: index.php"); // Redirect after delete
                exit;
            } else {
                echo "<div class='alert'>Data Gagal dihapus</div>";
            }
        }
        ?>

        <table class="my-3">
            <thead>
                <tr>
                    <th> No </th>
                    <th> Nama Tugas </th>
                    <th> Status </th>
                    <th> Prioritas </th>
                    <th> Tanggal </th>
                    <th colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Fetching tasks from the database
            $sql = "SELECT * FROM tugas";
            $result = mysqli_query($kon, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Loop through each task and display it
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['no_id'] . "</td>";
                    echo "<td>" . $row['namaTugas'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['prioritas'] . "</td>";
                    echo "<td>" . $row['tanggal'] . "</td>";
                    
                    // Action buttons: Update and Delete
                    echo "<td><a href='update.php?no_id=" . $row['no_id'] . "' class='btn btn-warning'>Update</a> | 
                              <a href='index.php?no_id=" . $row['no_id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this task?\")'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='alert'>No tasks found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

</body>
</html>
