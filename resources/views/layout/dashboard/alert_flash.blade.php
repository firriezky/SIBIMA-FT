@if (session()->has('flash_notification.message'))
    <div class="alert alert-{{ session('flash_notification.level') }} alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{!! session('flash_notification.message') !!}</strong>
    </div>
@endif
