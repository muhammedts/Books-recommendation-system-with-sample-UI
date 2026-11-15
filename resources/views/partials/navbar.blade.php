<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold letter-spaced" href="{{ route('books.index') }}">
            <i class="bi bi-book-half me-1"></i> READIT
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('books.index')]) href="{{ route('books.index') }}">Books</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('dashboard')]) href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endauth
                @can('create', App\Models\Book::class)
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('books.create')]) href="{{ route('books.create') }}">Add book</a>
                    </li>
                @endcan
            </ul>

            <form class="d-flex me-lg-3 my-2 my-lg-0" role="search" action="{{ route('books.index') }}" method="GET">
                <input class="form-control form-control-sm" type="search" name="q" placeholder="Search title or author"
                       aria-label="Search" value="{{ request('q') }}">
            </form>

            <ul class="navbar-nav">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Log in</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Log out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
