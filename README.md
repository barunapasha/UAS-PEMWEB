<h1> Panduan UAS Pemweb 2024/2025 </h1> 

<i> Base Url : http://127.0.0.1:8000/event </i> (Port sebagai Contoh)

<h3> Contoh consume API dengan Jquery : </h3>
<code>
$.ajax({
    method: "", // GET atau POST
    url: "", // Isi Route
    data: {}, // Tuliskan Atribut (Parameter) disini
    success: function (res) {
    	// Proses data API disini
    },
});
</code>

<h3> Panduan menjawab soal : </h3>
<ol>
    <li> Form untuk login yaitu : <code> route('auth') </code>. Pastikan bisa login dengan contoh akun :
        <ol>
            <li> Email : <code>105221012@example.com</code> dan Password : <code>password</code> </li>
            <li> Username : <code>105221012</code> dan Password : <code>password</code> </li>
        </ol>
    </li>
    <li> Form untuk menambah jadwal : <code> route('event.submit') </code> </li>
    <li> Pada nomor ini : 
        <ul>
            <li> Mengambil data 1 jadwal : <code> route('event.get-selected-data') </code> </li>
            <li> Form Mengupdate data jadwal : <code> route('event.update') </code> </li>
            <li> Form Menghapus data jadwal : <code> route('event.delete') </code> </li>
        </ul>
    </li>
    <li> API Mengambil semua data jadwal : <code> route('event.get-json') </code>. Gunakan variabel <code> calendar </code> yang sudah didefinisikan pada script untuk melakukan visualisasi jadwal ke dalam kalender </li>
</ol>

<h3> Contoh Perintah untuk trigger tombol  </h3>
<code>
$('#idTombol').on('click', function() {
    // Logika saat tombol edit diklik
});
</code>
<br /> Atau
<code>
document.getElementById('btn-edit').addEventListener('click', function() {
    // Logika saat tombol edit diklik
});
</code>

<h3> Menambah Event (Visualisasi Kalender) : </h3>
<code>
calendar.addEvent({
	id: 4,
	title: "Nama Event - Nama User", // Ini Adalah Format penamaan sesuai perintah soal
	start: "", // Gunakan Tanggal, format YYYY-MM-DD
	end: "", // Gunakan Tanggal, format YYYY-MM-DD
	backgroundColor: "", // Gunakan format pewarnaan RGB atau Hex
});
</code>
-------------------------------------------

<b> Jika Terdapat Pertanyaan, anda bisa membuat Issue di repositori ini </b>
