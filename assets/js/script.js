// Sidebar toggle
// Buat buka/tutup sidebar waktu tombol toggle diklik
document.getElementById("menu-toggle").addEventListener("click", function () {
    const sidebar = document.getElementById("sidebar-wrapper");
    sidebar.classList.toggle("hide"); // Tambah/hapus class 'hide' biar sidebar sembunyi/muncul
});

// Search function
// Fitur pencarian realtime di tabel pegawai
document.getElementById("search").addEventListener("keyup", function () {
    let keyword = this.value.toLowerCase(); // Ambil keyword dari input dan ubah jadi huruf kecil
    let rows = document.querySelectorAll("#pegawaiTable tbody tr"); // Ambil semua baris di tabel

    rows.forEach(row => {
        let text = row.textContent.toLowerCase(); // Ambil semua teks dari baris dan ubah ke huruf kecil
        row.style.display = text.includes(keyword) ? "" : "none"; // Tampilkan baris kalau mengandung keyword
    });
});

// Hapus alert dari DOM setelah 3 detik
setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
        alert.classList.remove('show'); // Hapus class 'show'
        alert.classList.add('fade');    // Tambahkan efek fade
        setTimeout(() => alert.remove(), 300); // Setelah 300ms, hapus elemen alert dari DOM
    }
}, 3000);

// Animasi loading screen
const loadingScreen = document.getElementById('loading-screen');
const startTime = Date.now(); // Catat waktu mulai load halaman

window.addEventListener('load', function () {
    const loadDuration = Date.now() - startTime; // Hitung durasi load halaman
    const minimumDuration = 800; // Durasi minimum loading screen ditampilkan (dalam ms)
    const remainingTime = Math.max(minimumDuration - loadDuration, 0); // Hitung sisa waktu yang perlu ditunggu

    setTimeout(() => {
        loadingScreen.classList.add('fade-out'); // Tambahkan animasi fade-out
        setTimeout(() => loadingScreen.style.display = 'none', 500); // Setelah animasi selesai, sembunyikan loading screen
    }, remainingTime);
});

// Yg di bawah ini versi lama animasi load yang udah dikomen
// window.addEventListener('load', () => {
//     const loading = document.getElementById('loading-screen');
//     loading.classList.add('hidden');
// });
