@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Создать Событие</h1>

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Название:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Описание:</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="start_time">Дата и время начала:</label>
            <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
        </div>

        <div class="form-group">
            <label for="end_time">Дата и время окончания:</label>
            <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
        </div>

        <div class="form-group">
            <label for="location">Место проведения:</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}">
        </div>

        <div class="form-group">
            <label for="category_id">Категория:</label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="">Нет категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="recurring_type">Повторение:</label>
            <select class="form-control" id="recurring_type" name="recurring_type">
                <option value="none">Не повторяется</option>
                <option value="daily">Ежедневно</option>
                <option value="weekly">Еженедельно</option>
                <option value="monthly">Ежемесячно</option>
            </select>
        </div>

        <div class="form-group">
            <label for="recurring_end_date">Дата окончания повторения:</label>
            <input type="date" class="form-control" id="recurring_end_date" name="recurring_end_date" value="{{ old('recurring_end_date') }}">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection