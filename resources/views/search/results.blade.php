@extends('layouts.main')

@section('content')

<div class="container mt-4">
    <h2>Search Results</h2>
    @if($books->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genres</th>
                    <th>Release Date</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>
                            @foreach($book->genres as $genre)
                                <span class="badge bg-secondary">{{ $genre->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $book->release_date }}</td>
                        <td>{{ $book->description }}</td>
                        <td><a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">View Book</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No results found for '{{ request('query') }}'</p>
    @endif
</div>

@endsection
