@extends('layouts.app')
@section('title', 'Students')

@section('content')
<div class="page-head">
    <h1>Students</h1>
    @auth
        <a href="{{ route('students.create') }}" class="btn primary">+ Add student</a>
    @endauth
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Roll</th><th>Name</th><th>Department</th><th>Email</th><th>Results</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $student->roll }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->department }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->results_count }}</td>
                    <td class="actions">
                        <a href="{{ route('students.show', $student) }}" class="btn small">Results</a>
                        @auth
                            <a href="{{ route('students.edit', $student) }}" class="btn small">Edit</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this student and all results?')">
                                @csrf @method('DELETE')
                                <button class="btn small danger" type="submit">Delete</button>
                            </form>
                        @endauth
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">No students yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pager">{{ $students->links('pagination::simple-default') }}</div>
</div>
@endsection
