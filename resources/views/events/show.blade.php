@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $event->title }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $event->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    {{ $event->start_time->format('d.m.Y H:i') }} - {{ $event->end_time->format('d.m.Y H:i') }}
                </h6>
                @if($event->location)
                    <p class="card-text">Место проведения: {{ $event->location }}</p>
                @endif
                @if($event->category)
                    <p class="card-text">Категория: {{ $event->category->name }}</p>
                @endif
                <p class="card-text">{{ $event->description }}</p>

                <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">Редактировать</a>

                <form action="{{ route('events.destroy', $event) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                </form>

            </div>
        </div>
        <a href="{{ route('events.index') }}" class="btn btn-secondary mt-3">Назад к календарю</a>

    </div>
@endsection