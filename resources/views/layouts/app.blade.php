@include('partials.header')

@yield('content')

@include('partials.chat-switcher')

@auth
    @if(auth()->user()->isAdmin())
        @include('partials.admin-shortcut')
    @endif
@endauth

@include('partials.footer')
