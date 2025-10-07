@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>افزودن غذای جدید</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.foods.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">نام غذا</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">قیمت</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">توضیحات</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">ذخیره غذا</button>
            <a href="{{ route('admin.foods.index') }}" class="btn btn-secondary">بازگشت</a>
        </form>
    </div>
</div>
@endsection