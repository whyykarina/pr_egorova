@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создать Категорию</h1>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Название:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection