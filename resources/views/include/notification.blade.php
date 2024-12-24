<div style="position: fixed; top: 20px; right: 20px; z-index: 1050; width: 300px;">
    @if (session('success'))
        <div class="alert alert-light-success color-success alert-dismissible fade show floating-notification" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('failed'))
        <div class="alert alert-light-danger color-danger alert-dismissible fade show floating-notification" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
