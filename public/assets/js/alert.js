document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.body.dataset.success;
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: successMessage,
            timer: 3000,
            showConfirmButton: false
        });
    }

    const errorMessages = document.body.dataset.errors;
    if (errorMessages) {
        const parsedErrors = JSON.parse(errorMessages);
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: parsedErrors.join('<br>')
        });
    }
});
