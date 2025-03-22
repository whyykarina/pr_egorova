@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Категории Событий</h1>

        <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Создать Категорию</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-primary">Редактировать</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Нет доступных категорий.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection