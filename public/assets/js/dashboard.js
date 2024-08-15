// Scroll to top
const scrollToTopBtn = document.getElementById('scrollToTopBtn');

function toggleScrollToTopButton() {
    const scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;
    scrollToTopBtn.style.display = scrollPosition > 20 ? 'block' : 'none';
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

window.addEventListener('scroll', toggleScrollToTopButton);
scrollToTopBtn.addEventListener('click', scrollToTop);

// Tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
});

// Toast
const toastElements = document.getElementsByClassName('toast');
for (let toastElement of toastElements) {
    toastElement.addEventListener('hidden.bs.toast', function () {
        this.classList.add('toast-fade-out');
    });
}

setTimeout(function () {
    for (let toastElement of toastElements) {
        let bsToast = new bootstrap.Toast(toastElement);
        bsToast.hide();
    }
}, 5000);

// DataTables
$(document).ready(function () {
    const orderOptions = $('#myTable').data('order');
    const jquery_datatable = $("#myTable").DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        },
        order: orderOptions || null
    });

    const setTableColor = () => {
        document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
            dt.classList.add('pagination-primary');
        });
    };

    setTableColor();
    jquery_datatable.on('draw', setTableColor);
});

// CKEditor
document.querySelectorAll('.cke-editor-form').forEach(function (textarea) {
    ClassicEditor
        .create(textarea, {
            toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'link', 'insertTable'],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' },
                ]
            }
        })
        .catch(error => {
            console.log(error);
        });
});

// Preview image
function previewImage() {
    const inputImgeFile = document.querySelector('#gambar');
    const imgPreview = document.querySelector('.form-img');

    const inputFile = inputImgeFile;

    if (inputFile) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(inputFile.files[0]);

        fileReader.onload = function (e) {
            imgPreview.src = e.target.result;
        }
    }
}

// SweetAlert
$('.btn-delete').on('click', function (e) {
    e.preventDefault();

    const form = $(this).closest('form');
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan dapat mengembalikannya!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

$('.btn-reset').on('click', function () {
    const resetUrl = $(this).data('reset-url');
    const fullname = $(this).data('reset-fullname');
    const role = $(this).data('reset-role');

    Swal.fire({
        title: 'Konfirmasi Reset Kata Sandi',
        html: "Reset kata sandi <strong>" + fullname + "</strong> dengan peran <strong>" + role + "</strong>?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = resetUrl; // Redirect user to reset URL
        }
    });
});
