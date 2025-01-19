@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pets') }}</div>

                <div class="card-body">
                    @if ($errors->count())
                        <div class="alert alert-success" role="alert">
                            {{ $errors }}
                        </div>
                    @endif
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Photos</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tags</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pets as $pet)
                                <tr>
                                    <th scope="row">{{ $pet->id}}</th>
                                    <td>{{ $pet->name }}</td>
                                    <td>{{ $pet->category->name }}</td>
                                    <td>{{ $pet->photoUrls === null ? 0 : count($pet->photoUrls) }}</td>
                                    <td>{{ $pet->status }}</td>
                                    <td>
                                        @foreach($pet->tags as $tag)
                                            <button type="button" class="badge text-bg-light">
                                                {{ $tag->name }}
                                            </button>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('edit', ['id' => $pet->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a
                                                href="{{ route('remove', ['id' => $pet->id]) }}"
                                                class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#removeModal"
                                            >Remove</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('add') }}" class="btn btn-primary btn-sm">Add new</a>
                </div>
                <div class="modal fade" id="removeModal" tabindex="-1" aria-labelledby="removeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="removeModalLabel">Remove confirmation</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <button type="button" class="btn btn-primary" id="removeModalLink">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const confirmRemoveButton = document.getElementById('removeModalLink');

        document.querySelectorAll('[data-bs-target="#removeModal"]').forEach(button => {
            button.addEventListener('click', function () {
                let test = button.getAttribute('href');
                confirmRemoveButton.addEventListener('click', function () {
                    window.location.href = test;
                });
            })
        });
    });
</script>
@endsection
