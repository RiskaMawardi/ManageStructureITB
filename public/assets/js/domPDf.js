document.addEventListener('DOMContentLoaded', function () {
    const rayonSelect = document.getElementById('rayonID');
    const hiddenRayonInput = document.getElementById('rayonIDForPdf');
    const generatePdfForm = document.querySelector('form[action*="generatePdf"]');
    const generatePdfButton = generatePdfForm ? generatePdfForm.querySelector('button[type="submit"]') : null;

    if (rayonSelect && hiddenRayonInput && generatePdfForm && generatePdfButton) {
        // Set nilai awal hidden input dan toggle tombol PDF
        const initialValue = rayonSelect.value;
        hiddenRayonInput.value = initialValue;
        togglePdfButton(initialValue);

        // Event saat pilihan RayonID berubah
        rayonSelect.addEventListener('change', function () {
            const selectedValue = this.value;
            hiddenRayonInput.value = selectedValue;
            togglePdfButton(selectedValue);
        });

        // Fungsi untuk mengatur status tombol PDF
        function togglePdfButton(selectedValue) {
            if (selectedValue) {
                generatePdfButton.disabled = false;
                generatePdfButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                generatePdfButton.disabled = true;
                generatePdfButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    }
});

// Validasi sebelum form PDF dikirim
const pdfForm = document.querySelector('#pdfForm');
if (pdfForm) {
    pdfForm.addEventListener('submit', function (e) {
        const rayon = document.getElementById('rayonID').value;
        if (!rayon) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'RayonID belum dipilih',
                text: 'Silakan pilih RayonID sebelum generate PDF.',
            });
        } else {
            this.setAttribute('target', '_blank');
        }
    });
}
