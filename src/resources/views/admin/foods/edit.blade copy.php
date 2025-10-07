@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>ویرایش غذا</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.foods.update', $food->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">نام غذا</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $food->name }}" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">قیمت</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $food->price }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">توضیحات</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $food->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">بروزرسانی غذا</button>
            <a href="{{ route('admin.foods.index') }}" class="btn btn-secondary">بازگشت</a>
        </form>
    </div>
</div>
@endsection