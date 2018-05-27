<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/ecommerce.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/ionicons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Latest compiled and minified CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
      @media screen and (max-width: 600px) {
        #page{
          padding:1%;
          width:95%;
          height: inherit;
          margin-left: 2.5%;
          background-color: white;
        }
      }
    </style>
    <script>
    function hideSearchBox() {
        var x = document.getElementById('result');

            x.style.display = 'none';

      }
    </script>
    <!-- Ajax code -->
    <script type="application/javascript">
    $(document).ready(function(){
        $('#txtSearch').on('keyup', function(){
            var text = $('#txtSearch').val();
            $.ajax({
                type:"GET",
                url: '/products/search',
                data: {text: $('#txtSearch').val()},
                success: function(data) {
                  if(data === 'undefined'){
                      document.getElementById("result").style.display = 'none';
                      console.log(data +2);
                  }
                  else if (data === 'minimum 3 characters')
                  {
                    document.getElementById("result").style.display = 'block';
                      document.getElementById("result").innerHTML = 'minimum 3 characters';
                      console.log(data +3);
                  }
                  else if (data === 'no results')
                  {
                    document.getElementById("result").style.display = 'block';
                      document.getElementById("result").innerHTML = 'No results';
                      console.log(data +4);
                  }
                  else{

                    document.getElementById("result").style.display = 'block';
                    var x;

                      for (i = 0; i < data.length; i++) {
                        if(i == 0){
                          x =  "<a href='/products/"+data[i]['id']+"'><div id='searchContainer'><img id='searchImage' src='"+data[i]['image']+"'><div id='search'>" + data[i]['name'] + "</div></div></a>";
                        }
                        else{
                            x = x + "<a href='/products/"+data[i]['id']+"'><div id='searchContainer'><img id='searchImage' src='"+data[i]['image']+"'><div id='search'>" + data[i]['name'] + "</div></div></a>";
                        }
                      }

                      document.getElementById("result").innerHTML = x;
                      console.log(data);
                  }

                 }
            });
        });
    });
    </script>

</head>
<body  onclick="hideSearchBox()">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                      @forelse ($navBar as $nav=>$subnav)
                      <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{$nav}}</a>
                          <ul class="dropdown-menu" role="menu">

                          @forelse ($subnav as $x)
                               <li><a href="/products/primary/{{$nav}}/secondary/{{$x}}">{{$x}}</a></li>
                          @empty
                          <h1>No Results</h1>
                          @endforelse
                        </ul>
                     </li>
                       <?php //print_r($nav)?>
                      @empty
                      <h1>No Results</h1>
                      @endforelse
                          <form class="navbar-form navbar-left" method="get" action="/products/DetailedSearch">
                           <div class="input-group">
                             <input type="text" class="form-control" placeholder="Search" id="txtSearch" name="txtSearch">
                             <div class="input-group-btn">
                               <button class="btn btn-default" type="submit">
                                 <i class="ion-ios-search-strong"></i>
                               </button>
                             </div>
                           </div>
                          </form>
                        <div id="result"></div>
                          <div class="btn-group">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                            <li><a href="/basket"><i style="font-size:25px" class="ion-android-cart"></i> £{{$basketTotal}}</a></li>

                        @else
                        <li><a href="/basket"><i style="font-size:25px" class="ion-android-cart"></i> £{{$basketTotal}}</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                    <li><a href="/orders">My Orders</a></li>
                                    <li><a href="/address">My Address</a></li>
                                    <li><a href="/users/password/edit">Change Password</a></li>
                                      <li><a href="/user/edit">Change Account Information</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
