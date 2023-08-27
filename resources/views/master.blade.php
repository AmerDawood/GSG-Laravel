<!doctype html>
<html lang="en" dir="{{ Auth::user()->profile->local  == 'ar'? 'rtl' : 'ltr' }}">

@include('layouts.head')
  <body>

    <div class="container">
    @include('layouts.header')

   @yield('content')
    </div>
    {{-- @include('layouts.footer') --}}

     @include('layouts.scripts')
  </body>
</html>
