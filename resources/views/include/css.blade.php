{{-- CSS Files For Templating --}}

<link rel="stylesheet" href="{{ asset('template/assets/compiled/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('template/assets/compiled/css/app-dark.css') }}">
<link rel="stylesheet" href="{{ asset('template/assets/compiled/css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('template/assets/compiled/css/iconly.css') }}">

<link rel="stylesheet" href="{{ asset('template/assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('template/assets/compiled/css/table-datatable.css') }}">

{{-- Select Element Style --}}

<link rel="stylesheet" href="{{ asset('template/assets/extensions/choices.js/public/assets/styles/choices.css') }}">

<style>
    /* Floating notification styles */
    .floating-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        width: 300px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        animation: slide-in 0.5s ease-out;
    }

    @keyframes slide-in {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
