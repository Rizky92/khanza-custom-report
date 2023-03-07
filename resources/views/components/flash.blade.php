@if (session()->has(['flash.type', 'flash.message']))
    <div class="alert alert-{{ session('flash.type') }} alert-dismissible fade show">
        <button class="close text-white" data-dismiss="alert" type="button" aria-hidden="true">&times</button>
        <p>
            <i class="fas fa-{{ session('flash.icon') }} mr-2 fa-lg"></i>
            {{ session('flash.message') }}
        </p>
    </div>
@endif
