@extends('layouts.app')
@section('title', $student->name . ' - Results')

@section('content')
<div class="page-head">
    <h1>{{ $student->name }}</h1>
    <a href="{{ route('students.index') }}" class="btn ghost">&larr; Back</a>
</div>

<div class="card profile">
    <div><span class="muted">Roll</span><strong>{{ $student->roll }}</strong></div>
    <div><span class="muted">Department</span><strong>{{ $student->department }}</strong></div>
    <div><span class="muted">Email</span><strong>{{ $student->email }}</strong></div>
    <div><span class="muted">Average marks</span><strong>{{ $average !== null ? number_format($average, 1) : '-' }}</strong></div>
</div>

<div class="card">
    <h2>Results</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Course code</th><th>Marks</th><th>Grade</th>@auth<th></th>@endauth</tr></thead>
            <tbody>
            @forelse ($student->results as $result)
                <tr>
                    <td>{{ $result->course_code }}</td>
                    <td>{{ $result->marks }}</td>
                    <td><span class="grade g-{{ Str::slug($result->grade === 'A+' ? 'aplus' : $result->grade) }}">{{ $result->grade }}</span></td>
                    @auth
                    <td>
                        <form action="{{ route('results.destroy', $result) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="btn small danger" type="submit">Remove</button>
                        </form>
                    </td>
                    @endauth
                </tr>
            @empty
                <tr><td colspan="4" class="muted">No results added yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@auth
<div class="card">
    <h2>Add result</h2>
    <form method="POST" action="{{ route('results.store', $student) }}" class="inline-form">
        @csrf
        <div class="field">
            <label for="course_code">Course code</label>
            <input type="text" id="course_code" name="course_code" value="{{ old('course_code') }}" class="@error('course_code') invalid @enderror">
            @error('course_code') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
            <label for="marks">Marks (0-100)</label>
            <input type="number" id="marks" name="marks" min="0" max="100" value="{{ old('marks') }}" class="@error('marks') invalid @enderror">
            @error('marks') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn primary">Add result</button>
    </form>
    <p class="hint">Grade is calculated automatically: 80+ A+, 70+ A, 60+ A-, 50+ B, 40+ C, 33+ D, below 33 F.</p>
</div>
@endauth
@endsection
