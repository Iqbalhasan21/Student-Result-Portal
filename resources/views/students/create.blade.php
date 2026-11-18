@extends('layouts.app')
@section('title', 'Add student')
@section('hide_error_summary', true)

@section('content')
<div class="card narrow">
    <h1>Add student</h1>
    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        @include('students._form')
    </form>
</div>
@endsection
