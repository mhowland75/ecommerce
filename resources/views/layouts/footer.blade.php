<div id="footer">
    <div id='innerfooter'>
        <div id='footerlinks'>
            <ul>
                <li><a href="#">Home</a></li>-
                <li><a href="#">Portfolio</a></li>-
                <li><a href="#">Blog</a></li>-
                <li><a href="#">About</a></li>-
                <li><a href="#">Contact</a></li>-
                 @if (Auth::guest())
                 <li><a href="{{ route('login') }}">Login</a></li>
                 
                 @else
                 <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Logout</a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     {{ csrf_field() }}
                 </form>
                        @endif
            </ul>
            
        </div>
        <div id='footertext'>
            <p>Copywright &copy Michael Howland - Web Development Artisan </p>
        </div>
        <div id='medialinks'>
            <a href="#" class="fa fa-facebook"></a>
            <a href="#" class="fa fa-twitter"></a>
            <a href="#" class="fa fa-google"></a>
            <a href="#" class="fa fa-linkedin"></a>
        </div>
    </div>
</div>

