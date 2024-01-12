<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/vue_js.png') }}"  width="32px" height="32px" class="img-circle img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Request::is('/') ? ' active' : null }}">
                    <a class="nav-link" href="{{ route('home') }}">Главная </a>
                </li>
                <li class="nav-item {{ Request::is('employee') ? ' active' : null }}">
                    <a class="nav-link" href="{{ route('employee.index') }}">Сотрудники</a>
                </li>
                <li class="nav-item {{ Request::is('lock') ? ' active' : null }}">
                    <a class="nav-link" href="{{ route('lock.index') }}">Замки</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="nav-item dropdown pull-right">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="fa fa-user"></span> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item">
                                <a style="padding: 6px" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                    Выйти
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </a>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>