<div class="bg-light shadow-sm border mt-2 p-2">

    @if(Auth::check() && Auth::user()->role='admin kampus')
    
    selamat datang
    
    @endif
</div>