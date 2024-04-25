<?php
class Shell {
    protected $jenisBahanBakar;
    protected $liter;
    protected $tarifPpn = 0.1;

    public function __construct($jenisBahanBakar, $liter) {
        $this->jenisBahanBakar = $jenisBahanBakar;
        $this->liter = $liter;
    }   

    protected function HargaPerLiter() {
        switch ($this->jenisBahanBakar) {
            case 'SSuper':
                return 15420; 
            case 'SVPower':
                return 16130;  
            case 'SVPowerDiesel':
                return 18310;  
            case 'SVPowerNitro':
                return 16510;  
            default:
                return 0;  
        }
    }

    public function BahanBakardibeli() {
        return $this->jenisBahanBakar;
    }

    public function jumlahLiter() {
        return $this->liter;
    }

    public function hitungtotal() {
        return $this->HargaPerLiter() * $this->liter;
    }

    public function hitungPpn() {
        return $this->hitungtotal() * $this->tarifPpn;
    }

    public function TotalHarga() {
        return $this->hitungtotal() + $this->hitungPpn();
    }
}

class Beli extends Shell {
    protected $uangDiberikan;

    public function __construct($jenisBahanBakar, $liter, $uangDiberikan) {
        parent::__construct($jenisBahanBakar, $liter);
        $this->uangDiberikan = $uangDiberikan;
    }

    public function cekUangCukup() {
        $totalHarga = $this->TotalHarga();
        return $this->uangDiberikan >= $totalHarga;
    }

    public function tampilkanstrukPembelian() {
        $totalHarga = $this->TotalHarga();
        $kembalian = $this->uangDiberikan - $totalHarga;

        echo "<hr><div class='strukbelanja'>";
        echo "<p>Anda membeli bahan bakar jenis {$this->BahanBakardibeli()}</p>";
        echo "<p>Dengan jumlah: {$this->jumlahLiter()} Liter</p>";
        echo "<p>Total yang harus anda bayar Rp. " . number_format($totalHarga, 2, ',', '.') . "</p>";
        echo "<p>Uang yang diberikan: Rp. " . number_format($this->uangDiberikan, 2, ',', '.') . "</p>";
        echo "<p>Kembalian: Rp. " . number_format($kembalian, 2, ',', '.') . "</p>";
        echo "</div><hr>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenisBahanBakar = $_POST['jenis_bahan_bakar'];
    $liter = $_POST['jumlah_liter'];
    $uangDiberikan = $_POST['uangdiberikan'];

    $pembelian = new Beli($jenisBahanBakar, $liter, $uangDiberikan);
    if ($pembelian->cekUangCukup()) {
        $pembelian->tampilkanstrukPembelian();
    } else {
        echo "<hr><p class='error'>Uang yang diberikan kurang dari total harga pembelian.<br>Silakan masukkan jumlah uang yang cukup.</p><hr>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian Bahan Bakar</title>
    <link rel="stylesheet" href="oop.css">
</head>
<body>
<div class="form_pembelian">
    <form id="Form-Pembelian" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="jumlah_liter">Masukkan Jumlah Liter :</label>
        <input type="text" id="jumlah_liter" name="jumlah_liter" pattern="[0-9]+" title="Masukkan hanya angka!" required>
        <br><br>
        <label for="jenis_bahan_bakar">Pilih Jenis Bahan Bakar:</label>
        <select id="jenis_bahan_bakar" name="jenis_bahan_bakar" required>
            <option value="SSuper">Shell Super</option>
            <option value="SVPower">Shell V-Power</option>
            <option value="SVPowerDiesel">Shell V-Power Diesel</option>
            <option value="SVPowerNitro">Shell V-Power Nitro</option>
        </select>
        <br><br>
        <label for="uangdiberikan">Masukan Nominal Uang (Rp):</label>
        <input type="text" id="uangdiberikan" name="uangdiberikan" pattern="[0-9]+" title="Masukkan hanya angka!" required>
        <br><br>
        <button type="submit" class="submit">Beli</button>
    </form>
</div>  
</body>
</html>
