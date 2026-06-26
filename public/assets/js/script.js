// File: public/assets/js/script.js
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Validasi Dinamis Kalender Booking
    const tglAmbil = document.getElementById('tanggal_ambil');
    const tglKembali = document.getElementById('tanggal_kembali');

    if (tglAmbil && tglKembali) {
        tglAmbil.addEventListener('change', function() {
            // Set nilai minimal tanggal kembali sama dengan tanggal ambil
            tglKembali.min = this.value;
            
            // Jika tanggal kembali yang sudah dipilih ternyata lebih kecil dari tanggal ambil baru, reset nilainya
            if (tglKembali.value && tglKembali.value < this.value) {
                tglKembali.value = this.value;
            }
        });
    }

    // 2. Interaksi UI untuk Input File (KTP & SIM)
    // Karena kita pakai pure CSS, input file bawaan browser biasanya jelek. 
    // Script ini akan menampilkan nama file yang di-upload agar user tahu file-nya sudah terpilih.
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            let fileName = e.target.files[0].name;
            let wrapper = this.parentElement;
            
            // Buat elemen text jika belum ada
            let textDisplay = wrapper.querySelector('.file-name-display');
            if (!textDisplay) {
                textDisplay = document.createElement('div');
                textDisplay.className = 'file-name-display';
                textDisplay.style.marginTop = '10px';
                textDisplay.style.color = '#10b981'; // Warna hijau sukses
                textDisplay.style.fontWeight = 'bold';
                wrapper.appendChild(textDisplay);
            }
            
            textDisplay.innerHTML = `<i class="fas fa-check"></i> ${fileName}`;
            wrapper.style.borderColor = '#10b981'; // Ubah warna border kotak
            wrapper.style.backgroundColor = '#ecfdf5';
        });
    });

    // 3. Auto-hide Alert Messages (Jika nantinya ada notifikasi flash message dari PHP)
    const alertBox = document.querySelector('.alert');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500);
        }, 3000);
    }
});