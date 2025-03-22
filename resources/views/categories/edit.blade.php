@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактировать Категорию</h1>

        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Название:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection