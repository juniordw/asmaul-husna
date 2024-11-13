<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    // Data dari https://islam.nu.or.id/
    private $all_asmaul_husna = [
        ['name' => 'Ar-Rahman', 'meaning' => 'Yang Maha Pengasih'],
        ['name' => 'Ar-Rahim', 'meaning' => 'Yang Maha Penyayang'],
        ['name' => 'Al-Malik', 'meaning' => 'Yang Maha Merajai/Memerintah'],
        ['name' => 'Al-Quddus', 'meaning' => 'Yang Maha Suci'],
        ['name' => 'As-Salam', 'meaning' => 'Yang Maha Memberi Kesejahteraan'],
        ['name' => 'Al-Mu\'min', 'meaning' => 'Yang Maha Memberi Keamanan'],
        ['name' => 'Al-Muhaimin', 'meaning' => 'Yang Maha Mengatur'],
        ['name' => 'Al-Aziz', 'meaning' => 'Yang Maha Perkasa'],
        ['name' => 'Al-Jabbar', 'meaning' => 'Yang Maha Gagah'],
        ['name' => 'Al-Mutakabbir', 'meaning' => 'Yang Maha Megah'],
        ['name' => 'Al-Khaliq', 'meaning' => 'Yang Maha Pencipta'],
        ['name' => 'Al-Bari\'', 'meaning' => 'Yang Maha Melepaskan'],
        ['name' => 'Al-Mushawwir', 'meaning' => 'Yang Maha Membentuk Rupa'],
        ['name' => 'Al-Ghaffar', 'meaning' => 'Yang Maha Pengampun'],
        ['name' => 'Al-Qahhar', 'meaning' => 'Yang Maha Memaksa'],
        ['name' => 'Al-Wahhab', 'meaning' => 'Yang Maha Pemberi Karunia'],
        ['name' => 'Ar-Razzaq', 'meaning' => 'Yang Maha Pemberi Rezeki'],
        ['name' => 'Al-Fattah', 'meaning' => 'Yang Maha Pembuka Rahmat'],
        ['name' => 'Al-\'Alim', 'meaning' => 'Yang Maha Mengetahui'],
        ['name' => 'Al-Qabidh', 'meaning' => 'Yang Maha Menyempitkan'],
        ['name' => 'Al-Basith', 'meaning' => 'Yang Maha Melapangkan'],
        ['name' => 'Al-Khafidh', 'meaning' => 'Yang Maha Merendahkan'],
        ['name' => 'Ar-Rafi\'', 'meaning' => 'Yang Maha Meninggikan'],
        ['name' => 'Al-Mu\'izz', 'meaning' => 'Yang Maha Memuliakan'],
        ['name' => 'Al-Mudzil', 'meaning' => 'Yang Maha Menghinakan'],
        ['name' => 'As-Sami\'', 'meaning' => 'Yang Maha Mendengar'],
        ['name' => 'Al-Bashir', 'meaning' => 'Yang Maha Melihat'],
        ['name' => 'Al-Hakam', 'meaning' => 'Yang Maha Menetapkan'],
        ['name' => 'Al-\'Adl', 'meaning' => 'Yang Maha Adil'],
        ['name' => 'Al-Latif', 'meaning' => 'Yang Maha Lembut'],
        ['name' => 'Al-Khabir', 'meaning' => 'Yang Maha Mengenal'],
        ['name' => 'Al-Halim', 'meaning' => 'Yang Maha Penyantun'],
        ['name' => 'Al-\'Azhim', 'meaning' => 'Yang Maha Agung'],
        ['name' => 'Al-Ghafur', 'meaning' => 'Yang Maha Pengampun'],
        ['name' => 'As-Syakur', 'meaning' => 'Yang Maha Pembalas Budi'],
        ['name' => 'Al-\'Aliy', 'meaning' => 'Yang Maha Tinggi'],
        ['name' => 'Al-Kabir', 'meaning' => 'Yang Maha Besar'],
        ['name' => 'Al-Hafizh', 'meaning' => 'Yang Maha Memelihara'],
        ['name' => 'Al-Muqit', 'meaning' => 'Yang Maha Pemberi Kecukupan'],
        ['name' => 'Al-Hasib', 'meaning' => 'Yang Maha Membuat Perhitungan'],
        ['name' => 'Al-Jalil', 'meaning' => 'Yang Maha Mulia'],
        ['name' => 'Al-Karim', 'meaning' => 'Yang Maha Pemurah'],
        ['name' => 'Ar-Raqib', 'meaning' => 'Yang Maha Mengawasi'],
        ['name' => 'Al-Mujib', 'meaning' => 'Yang Maha Mengabulkan'],
        ['name' => 'Al-Wasi\'', 'meaning' => 'Yang Maha Luas'],
        ['name' => 'Al-Hakim', 'meaning' => 'Yang Maha Bijaksana'],
        ['name' => 'Al-Wadud', 'meaning' => 'Yang Maha Mengasihi'],
        ['name' => 'Al-Majid', 'meaning' => 'Yang Maha Mulia'],
        ['name' => 'Al-Ba\'its', 'meaning' => 'Yang Maha Membangkitkan'],
        ['name' => 'As-Syahid', 'meaning' => 'Yang Maha Menyaksikan'],
        ['name' => 'Al-Haqq', 'meaning' => 'Yang Maha Benar'],
        ['name' => 'Al-Wakil', 'meaning' => 'Yang Maha Memelihara'],
        ['name' => 'Al-Qawiyy', 'meaning' => 'Yang Maha Kuat'],
        ['name' => 'Al-Matin', 'meaning' => 'Yang Maha Kokoh'],
        ['name' => 'Al-Waliy', 'meaning' => 'Yang Maha Melindungi'],
        ['name' => 'Al-Hamid', 'meaning' => 'Yang Maha Terpuji'],
        ['name' => 'Al-Muhshi', 'meaning' => 'Yang Maha Menghitung'],
        ['name' => 'Al-Mubdi\'', 'meaning' => 'Yang Maha Memulai'],
        ['name' => 'Al-Mu\'id', 'meaning' => 'Yang Maha Mengembalikan'],
        ['name' => 'Al-Muhyi', 'meaning' => 'Yang Maha Menghidupkan'],
        ['name' => 'Al-Mumit', 'meaning' => 'Yang Maha Mematikan'],
        ['name' => 'Al-Hayy', 'meaning' => 'Yang Maha Hidup'],
        ['name' => 'Al-Qayyum', 'meaning' => 'Yang Maha Berdiri Sendiri'],
        ['name' => 'Al-Wajid', 'meaning' => 'Yang Maha Penemu'],
        ['name' => 'Al-Majid', 'meaning' => 'Yang Maha Mulia'],
        ['name' => 'Al-Wahid', 'meaning' => 'Yang Maha Tunggal'],
        ['name' => 'Al-Ahad', 'meaning' => 'Yang Maha Esa'],
        ['name' => 'As-Shamad', 'meaning' => 'Yang Maha Dibutuhkan'],
        ['name' => 'Al-Qadir', 'meaning' => 'Yang Maha Menentukan'],
        ['name' => 'Al-Muqtadir', 'meaning' => 'Yang Maha Berkuasa'],
        ['name' => 'Al-Muqaddim', 'meaning' => 'Yang Maha Mendahulukan'],
        ['name' => 'Al-Mu\'akkhir', 'meaning' => 'Yang Maha Mengakhirkan'],
        ['name' => 'Al-Awwal', 'meaning' => 'Yang Maha Awal'],
        ['name' => 'Al-Akhir', 'meaning' => 'Yang Maha Akhir'],
        ['name' => 'Az-Zahir', 'meaning' => 'Yang Maha Nyata'],
        ['name' => 'Al-Bathin', 'meaning' => 'Yang Maha Ghaib'],
        ['name' => 'Al-Wali', 'meaning' => 'Yang Maha Memerintah'],
        ['name' => 'Al-Muta\'ali', 'meaning' => 'Yang Maha Tinggi'],
        ['name' => 'Al-Barr', 'meaning' => 'Yang Maha Penderma'],
        ['name' => 'At-Tawwab', 'meaning' => 'Yang Maha Penerima Tobat'],
        ['name' => 'Al-Muntaqim', 'meaning' => 'Yang Maha Pemberi Balasan'],
        ['name' => 'Al-Afuw', 'meaning' => 'Yang Maha Pemaaf'],
        ['name' => 'Ar-Ra\'uf', 'meaning' => 'Yang Maha Pengasuh'],
        ['name' => 'Malik-ul-Mulk', 'meaning' => 'Yang Maha Penguasa Kerajaan'],
        ['name' => 'Dzul-Jalal-wal-Ikram', 'meaning' => 'Yang Maha Pemilik Kebesaran dan Kemuliaan'],
        ['name' => 'Al-Muqsith', 'meaning' => 'Yang Maha Pemberi Keadilan'],
        ['name' => 'Al-Jami\'', 'meaning' => 'Yang Maha Mengumpulkan'],
        ['name' => 'Al-Ghaniy', 'meaning' => 'Yang Maha Kaya'],
        ['name' => 'Al-Mughni', 'meaning' => 'Yang Maha Pemberi Kekayaan'],
        ['name' => 'Al-Mani\'', 'meaning' => 'Yang Maha Mencegah'],
        ['name' => 'Ad-Dharr', 'meaning' => 'Yang Maha Penimpa Kemudharatan'],
        ['name' => 'An-Nafi\'', 'meaning' => 'Yang Maha Memberi Manfaat'],
        ['name' => 'An-Nur', 'meaning' => 'Yang Maha Bercahaya'],
        ['name' => 'Al-Hadi', 'meaning' => 'Yang Maha Pemberi Petunjuk'],
        ['name' => 'Al-Badi\'', 'meaning' => 'Yang Maha Pencipta'],
        ['name' => 'Al-Baqi', 'meaning' => 'Yang Maha Kekal'],
        ['name' => 'Al-Warits', 'meaning' => 'Yang Maha Pewaris'],
        ['name' => 'Ar-Rasyid', 'meaning' => 'Yang Maha Pandai'],
        ['name' => 'As-Shabur', 'meaning' => 'Yang Maha Sabar']
    ];

    public function index()
    {
        // Mengambil 5 nama secara acak
        $random_keys = array_rand($this->all_asmaul_husna, 5);
        $asmaul_husna = [];
        
        foreach ($random_keys as $key) {
            $asmaul_husna[] = $this->all_asmaul_husna[$key];
        }

        return view('game.index', compact('asmaul_husna'));
    }
}