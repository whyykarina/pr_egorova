@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактировать Событие</h1>

        <form action="{{ route('events.update', $event) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Название:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}" required>
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_time">Дата и время начала:</label>
                <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i')) }}" required>
                @error('start_time')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_time">Дата и время окончания:</label>
                <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i')) }}" required>
                @error('end_time')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="location">Место проведения:</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $event->location) }}">
                @error('location')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Категория:</label>
                <select class="form-control" id="category_id" name="category_id">
                    <option value="">Нет категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

             <div class="form-group">
                <label for="recurring_type">Повторение:</label>
                <select class="form-control" id="recurring_type" name="recurring_type">
                    <option value="none" {{ old('recurring_type', $event->recurring_type) == 'none' ? 'selected' : '' }}>Не повторяется</option>
                    <option value="daily" {{ old('recurring_type', $event->recurring_type) == 'daily' ? 'selected' : '' }}>Ежедневно</option>
                    <option value="weekly" {{ old('recurring_type', $event->recurring_type) == 'weekly' ? 'selected' : '' }}>Еженедельно</option>
                    <option value="monthly" {{ old('recurring_type', $event->recurring_type) == 'monthly' ? 'selected' : '' }}>Ежемесячно</option>
                </select>
                @error('recurring_type')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="recurring_end_date">Дата окончания повторения:</label>
                <input type="date" class="form-control" id="recurring_end_date" name="recurring_end_date" value="{{ old('recurring_end_date', $event->recurring_end_date ? $event->recurring_end_date->format('Y-m-d') : null) }}">
                 @error('recurring_end_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('events.index') }}" class="btn btn-secondary">Отмена</a>
        </form>

    </div>
@endsection