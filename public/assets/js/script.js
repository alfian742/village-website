// AOS
AOS.init();

// Navbar Blur
window.addEventListener('scroll', function () {
    var navbar = document.getElementById('navbar');
    if (window.scrollY > 0) {
        navbar.classList.add('bg-navbar-blur');
        navbar.classList.add('shadow-sm');
    } else {
        navbar.classList.remove('bg-navbar-blur');
        navbar.classList.remove('shadow-sm');
    }
});

// Scroll to top
const scrollToTopBtn = document.getElementById('scrollToTopBtn');
function toggleScrollToTopButton() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        scrollToTopBtn.style.display = 'block';
    } else {
        scrollToTopBtn.style.display = 'none';
    }
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
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

// dataTables
$(document).ready(function () {
    let orderOptions = $('#myTable').data('order');
    let jquery_datatable;

    // Check order options
    if (orderOptions) {
        jquery_datatable = $("#myTable").DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            },
            "order": orderOptions, // with order
        });
    } else {
        jquery_datatable = $("#myTable").DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            }
        });
    }

    const setTableColor = () => {
        document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
            dt.classList.add('pagination-primary');
        });
    };

    setTableColor();
    jquery_datatable.on('draw', setTableColor);
});

// Toasts
var toastElements = document.getElementsByClassName('toast');
for (var i = 0; i < toastElements.length; i++) {
    toastElements[i].addEventListener('hidden.bs.toast', function () {
        this.classList.add('toast-fade-out');
    });
}

setTimeout(function () {
    for (var i = 0; i < toastElements.length; i++) {
        var bsToast = new bootstrap.Toast(toastElements[i]);
        bsToast.hide();
    }
}, 5000);

// SweetAlert
$('.btn-delete').on('click', function (e) {
    e.preventDefault();

    var form = $(this).closest('form');
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