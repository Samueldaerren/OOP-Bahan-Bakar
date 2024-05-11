<?php
session_start();

if (!isset($_SESSION['dataSiswa'])) {
    $_SESSION['dataSiswa'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["kirim"]) || isset($_POST["update"])) {
        $nama = $_POST['nama'];
        $nis = $_POST['nis'];
        $rayon = $_POST['rayon'];

        if (isset($_POST["update"])) {
            $edit_id = $_POST["edit_id"];
 
            $_SESSION['dataSiswa'][$edit_id] = array(
                "nama" => $nama,
                "nis" => $nis,
                "rayon" => $rayon
            );
        } else {
     
            if ($nama == "" || $nis == "" || $rayon == "") {
                echo "<div class='alert alert-danger mt-3' role='alert'>Data kosong</div>";
            } else {

                $duplicate = false;
                foreach ($_SESSION['dataSiswa'] as $siswa) {
                    if ($siswa['nis'] == $nis) {
                        $duplicate = true;
                        break;
                    }
                }

                if (!$duplicate) {
                    $siswa = array(
                        "nama" => $nama,
                        "nis" => $nis,
                        "rayon" => $rayon
                    );

                    $_SESSION['dataSiswa'][] = $siswa;
                } else {
                    echo "<div class='alert alert-warning mt-3' role='alert'>Data siswa dengan NIS $nis sudah ada.</div>";
                }
            }
        }
    }
}

if (isset($_GET['hapus'])) {
    $key = $_GET['hapus'];
    unset($_SESSION['dataSiswa'][$key]);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['edit_key'])) {
    $edit_id = $_GET['edit_key'];
    $edit_nama = $_SESSION['dataSiswa'][$edit_id]["nama"];
    $edit_nis = $_SESSION['dataSiswa'][$edit_id]["nis"];
    $edit_rayon = $_SESSION['dataSiswa'][$edit_id]["rayon"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Data Siswa</title>
    <style>
        a {
            text-decoration: none;
            color: white;
        }

        .form-label {
            text-align: left;
            display: block;
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-12 col-md-6 m-auto">
                <div class="card text-center">
                    <div class="card-body">
                        <h1>DATA SISWA</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                            class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nama Siswa:</label>
                                <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Siswa"
                                    name="nama" pattern="[A-Za-z\s]+" title="Hanya teks yang diperbolehkan"
                                    value="<?php echo isset($edit_nama) ? $edit_nama : ''; ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">NIS Siswa:</label>
                                <input type="number" class="form-control" id="nis"
                                    placeholder="Masukkan NIS Siswa" name="nis" pattern="[0-9]+"
                                    title="Hanya angka yang diperbolehkan"
                                    value="<?php echo isset($edit_nis) ? $edit_nis : ''; ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Rayon:</label>
                                <input type="text" class="form-control" id="rayon"
                                    placeholder="Masukkan Rayon Siswa" name="rayon"
                                    value="<?php echo isset($edit_rayon) ? $edit_rayon : ''; ?>" required>
                            </div>
                            <div class="col mt-3">
                                <div class="center">
                                    <button class="btn btn-primary mx-2" type="submit"
                                        name="<?php echo isset($edit_id) ? 'update' : 'kirim'; ?>">
                                        <i class='bx bx-plus'></i>
                                        <?php echo isset($edit_id) ? 'Update' : 'Tambah'; ?></button>
                                    <button class="btn btn-danger mx-2" type="button" id="printBtn">
                                        <i class='bx bx-printer'></i> Print</button>
                                    <button class="btn btn-secondary mx-2" type="reset">
                                        Reset</button>
                                </div>
                            </div>
                            <input type="hidden" name="edit_id"
                                value="<?php echo isset($edit_id) ? $edit_id : ''; ?>">
                        </form>
                        <?php
                        if (!empty($_SESSION['dataSiswa'])) {
                            echo "<div id='tableContainer' class='table-responsive mt-5'>";
                            echo "<table class='table table-bordered'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Nama Siswa</th>";
                            echo "<th>NIS Siswa</th>";
                            echo "<th>Rayon</th>";
                            echo "<th>Action</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach ($_SESSION['dataSiswa'] as $key => $value) {
                                echo "<tr>";
                                echo "<td>" . $value["nama"] . "</td>";
                                echo "<td>" . $value["nis"] . "</td>";
                                echo "<td>" . $value["rayon"] . "</td>";
                                echo "<td>
                                    <a href='?hapus=$key' class='btn btn-danger'>Hapus</a>
                                    <a href='?edit_key=$key' class='btn btn-warning'>Edit</a>
                                </td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        function printTable() {
            var printContents = document.getElementById("tableContainer").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        document.getElementById("printBtn").addEventListener("click", function () {
            printTable();
        });
        document.getElementById("resetBtn").addEventListener("click", function () {
            document.getElementById("tableContainer").innerHTML = "";
        });
    </script>
</body>

</html>
