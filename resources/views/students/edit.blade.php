@extends('layouts.app')
@section('title', 'Edit student')
@section('hide_error_summary', true)

@section('content')
<div class="card narrow">
    <h1>Edit student</h1>
    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf @method('PUT')
        @include('students._form')
    </form>
</div>
@endsection
