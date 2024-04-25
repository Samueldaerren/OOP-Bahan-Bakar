<?php
class RentalMotor {
    protected $nama_pelanggan;
    protected $lama_waktu;
    private $nama_member = ["Samuel", "samuel", "Daerren", "daerren"];
    private $harga_motor = [
        "Scooter" => 50000,
        "SBike" => 70000,
        "NBike" => 80000,
        "Motorcross" => 60000
    ];

    public function __construct($nama_pelanggan, $lama_waktu) {
        $this->nama_pelanggan = $nama_pelanggan;
        $this->lama_waktu = $lama_waktu;
    }   
    
    public function hitungTotalHarga($jenis_motor) {
        $potongan_harga = 0;
        $diskon_info = "";

        if (in_array($this->nama_pelanggan, $this->nama_member)) {
            $potongan_harga = 0.05; 
            $diskon_info = "{$this->nama_pelanggan} berstatus sebagai member mendapatkan diskon sebesar 5%.<br>";
        }

        $harga_sewa = $this->harga_motor[$jenis_motor];
        $total_harga = $harga_sewa * $this->lama_waktu;
        $diskon = $total_harga * $potongan_harga;
        $total_harga_diskon = $total_harga - $diskon + 10000;

        $output = "<div class='strukbelanja'>"; 

        $output .= "<hr>";

        if ($potongan_harga > 0) {
            $output .= "{$this->nama_pelanggan} berstatus sebagai member mendapatkan diskon sebesar 5%.<br>";
        }

        $output .= "Jenis motor yang dirental adalah {$jenis_motor} selama {$this->lama_waktu} hari.<br>";
        $output .= "Harga rental per-harinya: Rp " . number_format($harga_sewa, 2) . ".<br>";
        $output .= "Total diskon: Rp " . number_format($diskon, 2) . ".<br>";
        $output .= "Besarnya yang harus dibayarkan adalah Rp " . number_format($total_harga_diskon, 2);
        $output .= "<hr>"; 
        $output .= "</div>";

    return $output;
    }
}
?>
<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama_pelanggan = $_POST["nama_pelanggan"];
            $lama_waktu = $_POST["lama_waktu"];
            $jenis_motor = $_POST["jenis_motor"];

            $rental_motor = new RentalMotor($nama_pelanggan, $lama_waktu);
            $output = $rental_motor->hitungTotalHarga($jenis_motor);

            echo "<br>{$output}";
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Motor</title>
    <link rel="stylesheet" href="oop2.css">
</head>
<body> 
    <h3>Rental Motor</h3><br>
<div class="form_penyewaan">   
        <form id="Form-penyewaan" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nama_pelanggan">Nama Pelanggan :</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" pattern="[a-zA-Z]+" title="Masukkan hanya huruf!" required>
            <br><br>
            <label for="lama_waktu">Lama Waktu Rental (per hari) :</label>
            <input type="text" id="lama_waktu" name="lama_waktu" pattern="[0-9]+" title="Masukkan hanya angka!" required>
            <br><br>
            <label for="jenis_motor">Pilih Jenis Motor:</label>
            <select id="jenis_motor" name="jenis_motor" required>
                <option value="Scooter">Scooter</option>
                <option value="SBike">Sport Bike</option>
                <option value="NBike">Naked Bike</option>
                <option value="Motorcross">Motorcross</option>
            </select>
            <br><br>
            <button type="submit" class="submit">Beli</button>
        </form>

    </div>
</body>
</html>
