// Menghitung durasi halaman loading agar loading screen menghilang dengan smooth
const loadingScreen = document.getElementById('loading-screen');
const startTime = Date.now();

// Setelah halaman selesai dimuat, hilangkan loading screen
window.addEventListener('load', function() {
    const loadDuration = Date.now() - startTime;
    const minimumDuration = 800; // Durasi minimum untuk menampilkan loading screen
    const remainingTime = Math.max(minimumDuration - loadDuration, 0); // Waktu sisa yang perlu ditunggu

    // Setelah waktu yang cukup, menghilangkan loading screen dengan efek fade-out
    setTimeout(() => {
        loadingScreen.classList.add('fade-out');
        setTimeout(() => loadingScreen.style.display = 'none', 500);
    }, remainingTime);
});
// Sidebar toggle
// Buat buka/tutup sidebar waktu tombol toggle diklik
document.getElementById("menu-toggle").addEventListener("click", function() {
    const sidebar = document.getElementById("sidebar-wrapper");
    sidebar.classList.toggle("hide"); // Tambah/hapus class 'hide' biar sidebar sembunyi/muncul
});