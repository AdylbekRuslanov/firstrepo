@if(Auth::user() && Auth::user()->type == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">Гланая</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('new') }}">Новые брони</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('show_all') }}">Все брони</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('show_bookings', ['id' => Auth::user()->id]) }}">Мои брони</a>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Туры
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="nav-link" href="{{ route('tours') }}">Показать туры</a>
            <a class="nav-link" href="{{ route('set_tours') }}">Набор туров</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Бронировавший человек
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach($bookers as $booker)
                <a class="dropdown-item" href="{{ route('show_bookings', ['id' => $booker->id]) }}">{{ $booker->name }}</a>
            @endforeach
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('booker_details') }}">Подробности</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Гиды
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach($guides as $guide)
                <a class="dropdown-item" href="{{ route('guide', ['id' => $guide->id]) }}">{{ $guide->name }}</a>
            @endforeach
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('new_guide') }}">Добавить Гида</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Продукты питания
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach($items as $item)
                <a class="dropdown-item">{{ $item->name }}</a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('new_item') }}">Добавить</a>
        </div>
    </li>

@elseif(Auth::user() && Auth::user()->type == 'booker')

    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">Главная</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('show_bookings', ['id' => Auth::user()->id]) }}">Брони</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('new') }}">Новые брони</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Показать мои месяцы
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach($months as $month)
                <a class="dropdown-item" href="{{ route('month', ['month' => $month->month]) }}">{{ date("F", mktime(0, 0, 0, $month->month, 1)) }}</a>
            @endforeach
        </div>
    </li>
    @endif