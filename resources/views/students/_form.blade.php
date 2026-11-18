@php $departments = ['CSE', 'EEE', 'BBA', 'English', 'Civil Engineering']; @endphp

<div class="field">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $student->name ?? '') }}" class="@error('name') invalid @enderror">
    @error('name') <span class="error">{{ $message }}</span> @enderror
</div>

<div class="row">
    <div class="field">
        <label for="roll">Roll</label>
        <input type="text" id="roll" name="roll" value="{{ old('roll', $student->roll ?? '') }}" class="@error('roll') invalid @enderror">
        @error('roll') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="field">
        <label for="department">Department</label>
        <select id="department" name="department" class="@error('department') invalid @enderror">
            <option value="">Select department</option>
            @foreach ($departments as $d)
                <option value="{{ $d }}" @selected(old('department', $student->department ?? '') === $d)>{{ $d }}</option>
            @endforeach
        </select>
        @error('department') <span class="error">{{ $message }}</span> @enderror
    </div>
</div>

<div class="field">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email', $student->email ?? '') }}" class="@error('email') invalid @enderror">
    @error('email') <span class="error">{{ $message }}</span> @enderror
</div>

<div class="actions">
    <button type="submit" class="btn primary">Save student</button>
    <a href="{{ route('students.index') }}" class="btn ghost">Cancel</a>
</div>
