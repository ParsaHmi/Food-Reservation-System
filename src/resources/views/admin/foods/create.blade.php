@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Add New Food</h4>
                        <a href="{{ route('admin.foods.edit') }}" class="btn btn-light btn-sm">
                            ← Back to Weekly Foods
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.foods.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Food Name *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required 
                                           placeholder="Enter food name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="date" class="form-label">Date *</label>
                                    <input type="date" 
                                           class="form-control @error('date') is-invalid @enderror" 
                                           id="date" 
                                           name="date" 
                                           value="{{ old('date', request('date', date('Y-m-d'))) }}" 
                                           required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Enter food description (optional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="food_id" class="form-label">Food ID *</label>
                            <input type="number" 
                                   class="form-control @error('food_id') is-invalid @enderror" 
                                   id="food_id" 
                                   name="food_id" 
                                   value="{{ old('food_id') }}" 
                                   required 
                                   placeholder="Enter unique food ID">
                            @error('food_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Save Food
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Quick Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0" style="text-align: left; direction: ltr;">
                        <li>• Food name should be descriptive and clear</li>
                        <li>• Select the correct date for the food</li>
                        <li>• Food ID must be unique for each food item</li>
                        <li>• Description is optional but recommended</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
</style>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        const dateField = document.getElementById('date');
        if (dateField) {
            const today = new Date().toISOString().split('T')[0];
            if (!dateField.value) {
                dateField.value = today;
            }
            dateField.min = today;
        }
    });
</script>
@endsection