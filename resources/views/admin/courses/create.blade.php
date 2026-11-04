@extends('layouts.app')

@section('title', 'Add New Course | Komdigital')

@section('content')

<section class="admin-section">

    <div class="admin-container">

        <div class="admin-page-header">
            <div>
                <h1>Add New Course</h1>
                <p>Enter the details of the new Komdigital course.</p>
            </div>

            <a href="{{ route('admin.courses.index') }}"
               class="btn btn-primary">
                Back to Courses
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-form-card">

            <form method="POST"
                  action="{{ route('admin.courses.store') }}"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label for="title">Course Title</label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Enter course title"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="category_id">Course Category</label>

                    <select name="category_id" id="category_id" required>
                        <option value="">Select a category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description-editor">Course Description</label>

                    <div id="description-editor" style="min-height: 200px; background: #fff;">
                        {!! old('description') !!}
                    </div>

                    <input
                        type="hidden"
                        name="description"
                        id="description-input"
                        value="{{ old('description') }}"
                    >

                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="short_description">
                        Short Description
                    </label>

                    <textarea
                        name="short_description"
                        id="short_description"
                        rows="3"
                        maxlength="160"
                        placeholder="Write a short summary of this course (maximum 160 characters)..."
                    >{{ old('short_description') }}</textarea>

                    <small class="form-help">
                        Maximum 160 characters. This summary will appear on the public course catalogue.
                    </small>

                    @error('short_description')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-row">

                    <div class="form-group">
                        <label for="fee">Course Fee (GHS)</label>

                        <input
                            type="number"
                            id="fee"
                            name="fee"
                            value="{{ old('fee') }}"
                            min="0"
                            step="0.01"
                            placeholder="e.g. 1500"
                        >
                    </div>

                    <div class="form-group">
                        <label for="duration">Course Duration</label>

                        <input
                            type="text"
                            id="duration"
                            name="duration"
                            value="{{ old('duration') }}"
                            placeholder="e.g. 6 weeks"
                        >
                    </div>

                </div>

                <div class="form-group">
                    <label for="image">Course Image</label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <small>
                        Accepted formats: JPG, PNG and WEBP.
                        Maximum size: 2 MB.
                    </small>
                </div>

                <div class="form-group">
                    <label for="status">Course Status</label>

                    <select id="status" name="status" required>
                        <option value="draft"
                            {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="published"
                            {{ old('status') === 'published' ? 'selected' : '' }}>
                            Published
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Course
                </button>

            </form>

        </div>

    </div>

</section>


@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editorElement = document.getElementById('description-editor');
            const descriptionInput = document.getElementById('description-input');

            if (!editorElement || !descriptionInput) {
                return;
            }

            const quill = new Quill(editorElement, {
                theme: 'snow',
                placeholder: 'Write the full course description...',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            quill.root.innerHTML = descriptionInput.value;

            const form = editorElement.closest('form');

            form.addEventListener('submit', function () {
                descriptionInput.value = quill.root.innerHTML;
            });
        });
    </script>
@endpush

@endsection
