@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Календарь Событий</h1>

    <div class="mb-3">
    <a href="{{ route('events.index', ['date' => $prevDate, 'view' => $view]) }}" class="btn btn-secondary">&laquo; Предыдущий</a>
    <a href="{{ route('events.index', ['date' => \Carbon\Carbon::now()->toDateString(), 'view' => $view]) }}" class="btn btn-primary">Сегодня</a>
    <a href="{{ route('events.index', ['date' => $nextDate, 'view' => $view]) }}" class="btn btn-secondary">Следующий &raquo;</a>

    <div class="btn-group" role="group">
      <a href="{{ route('events.index', ['date' => $date, 'view' => 'month']) }}" class="btn btn-outline-primary {{ $view == 'month' ? 'active' : '' }}">Месяц</a>
      <a href="{{ route('events.index', ['date' => $date, 'view' => 'week']) }}" class="btn btn-outline-primary {{ $view == 'week' ? 'active' : '' }}">Неделя</a>
      <a href="{{ route('events.index', ['date' => $date, 'view' => 'day']) }}" class="btn btn-outline-primary {{ $view == 'day' ? 'active' : '' }}">День</a>
    </div>

    <a href="{{ route('events.create') }}" class="btn btn-success float-right">Создать Событие</a>
</div>

<form action="{{ route('events.index') }}" method="GET" class="mb-3">
    <div class="form-row align-items-center">
        <div class="col-auto">
            <input type="text" class="form-control" name="search" placeholder="Поиск по названию/описанию" value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <input type="date" class="form-control" name="date_filter" value="{{ request('date_filter') }}">
        </div>
        <div class="col-auto">
            <select class="form-control" name="category_filter">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_filter') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
         <div class="col-auto">
            <select class="form-control" name="recurring_filter">
                <option value="">Все повторения</option>
                <option value="none" {{ request('recurring_filter') == 'none' ? 'selected' : '' }}>Не повторяется</option>
                <option value="daily" {{ request('recurring_filter') == 'daily' ? 'selected' : '' }}>Ежедневно</option>
                <option value="weekly" {{ request('recurring_filter') == 'weekly' ? 'selected' : '' }}>Еженедельно</option>
                <option value="monthly" {{ request('recurring_filter') == 'monthly' ? 'selected' : '' }}>Ежемесячно</option>
            </select>
        </div>
        <div class="col-auto">
            <input type="hidden" name="view" value="{{ $view }}">
            <button type="submit" class="btn btn-primary">Поиск</button>
            <a href="{{ route('events.index', ['view' => $view, 'date' => $date]) }}" class="btn btn-secondary">Сбросить</a>
        </div>
    </div>
</form>

<h2>
    @if ($view == 'month')
        {{ \Carbon\Carbon::parse($date)->format('F Y') }}
    @elseif ($view == 'week')
        {{ \Carbon\Carbon::parse($date)->startOfWeek(\Carbon\Carbon::MONDAY)->format('d M Y') }} - {{ \Carbon\Carbon::parse($date)->endOfWeek(\Carbon\Carbon::SUNDAY)->format('d M Y') }}
    @elseif ($view == 'day')
        {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
    @endif
</h2>

    @if ($view == 'month')
        @include('events.partials.month_view')
    @elseif ($view == 'week')
        @include('events.partials.week_view')
    @elseif ($view == 'day')
        @include('events.partials.day_view')
    @endif

</div>
@endsection