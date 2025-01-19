@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ isset($pet) ? __('Edit pet ID'.$pet->id. ' - ' . $pet->name) : __('Add new pet') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="" method="post">
                        @csrf
                        @if(isset($pet))
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', isset($pet) ? $pet->name : '') }}">
                            @if (isset($validate['name']))
                                <div id="nameHelp" class="form-text text-danger">{{ $validate['name'][0] }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                @foreach($categories as $category)
                                    <option name="{{ $category->id }}" value="{{ $category->id }}"{{ isset($pet) && $pet->category->id == $category->id ? ' selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if (isset($validate['category_id']))
                                <div id="category_idHelp" class="form-text text-danger">{{ $validate['category_id'][0] }}</div>
                            @endif
                        </div>
                        <fieldset class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Tags</legend>
                            <div class="col-sm-10">
                                @foreach($tags as $tag)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}"{{ isset($pet) && $pet->hasTag($tag->id) ? ' checked' : '' }}>
                                    <label class="form-check-label" for="gridRadios1">
                                        {{ $tag->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </fieldset>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select">
                                @foreach($statuses as $status)
                                    <option name="{{ $status }}"{{ isset($pet) && $pet->status->value == $status ? ' selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="photo_urls" class="form-label">Photos</label>
                            <div class="row-cols-4">
                                @if (isset($pet) && !empty($pet->photoUrls))
                                    @foreach($pet->photoUrls as $url)
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="photo_urls[]" value="{{ $url }}">
                                            <button class="btn btn-primary remove-photo-button" type="button">remove</button>
                                        </div>
                                    @endforeach
                                @else
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="photo_urls[]">
                                    <button class="btn btn-primary remove-photo-button" type="button">remove</button>
                                </div>
                                @endif
                                <button type="button" class="btn btn-primary btn-sm float-end" id="moreButton">more</button>
                            </div>
                            @if (isset($validate['photo']))
                                <div id="photo_urlsHelp" class="form-text text-danger">{{ $validate['photo'][0] }}</div>
                            @endif
                        </div>
                        <div class="row-4 mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('home') }}" class="btn btn-primary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('moreButton').addEventListener('click', function () {
                let button = this;
                let cloned = button.previousElementSibling.cloneNode(true);
                button.parentNode.insertBefore(cloned, button);
                cloned.querySelector('input').value = '';
                cloned.querySelector('button').addEventListener('click', function () {
                    removePhotoInput(this);
                })
            });
            let buttons = document.getElementsByClassName('remove-photo-button');
            [...buttons].forEach(btn => {
                btn.addEventListener('click', function () {
                    removePhotoInput(this);
                })
            });
        });
        let removePhotoInput = function (element) {
            let buttons = document.getElementsByClassName('remove-photo-button');
            if (buttons.length > 1) {
                element.parentNode.remove();
            }
        }
    </script>
@endsection
