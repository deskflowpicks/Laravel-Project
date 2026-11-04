@extends('layouts.app')

@section('title', 'Manage Categories | Komdigital')

@section('content')

<section class="admin-section">

    <div class="admin-container">

        <div class="admin-page-header">
            <div>
                <h1>Manage Categories</h1>
                <p>View and manage your course categories.</p>
            </div>

            <a href="{{ route('admin.categories.create') }}"
               class="btn btn-primary">
                Add New Category
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="admin-table-wrapper">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Courses</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($categories as $category)

                        <tr>
                            <td>
                                {{ $categories->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>

                            <td>
                                {{ $category->description ?? 'No description' }}
                            </td>

                            <td>
                                {{ $category->courses_count }}
                            </td>

                            <td>
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="btn btn-sm btn-primary">
                                    Edit
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                    method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this category?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>

                                </form>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5">
                                No categories found. Create your first category.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="admin-pagination">
            {{ $categories->links() }}
        </div>

    </div>

</section>

@endsection
