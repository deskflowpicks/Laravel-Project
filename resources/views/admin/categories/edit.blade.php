@extends('layouts.app')

@section('title', 'Edit Category | Komdigital')

@section('content')

<section class="admin-section">

    <div class="admin-container">

        <div class="admin-page-header">
            <div>
                <h1>Edit Category</h1>
                <p>Update the category information below.</p>
            </div>

            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-secondary">
                Back to Categories
            </a>
        </div>

        <div class="admin-form-wrapper">

            <form action="{{ route('admin.categories.update', $category->id) }}"
                  method="POST">

                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Category Name</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $category->name) }}"
                        required
                    >

                    @error('name')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description (Optional)</label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Briefly describe this category..."
                    >{{ old('description', $category->description) }}</textarea>

                    @error('description')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Update Category
                </button>

            </form>

        </div>

    </div>

</section>

@endsection