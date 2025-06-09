document.addEventListener('DOMContentLoaded', function () {
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('.select2').select2({
            placeholder: '-- Pilih--',
            allowClear: true,
            width: '100%'
        });
    } else {
        console.warn('Select2 tidak ditemukan.');
    }
});
