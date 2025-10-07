@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>غذاهای هفته</h1>
    </div>

    <!-- ناوبری هفته -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <a href="{{ route('admin.foods.edit', ['date' => $previousWeek]) }}" 
                       class="btn btn-outline-primary">
                        ← هفته قبل
                    </a>
                </div>
                
                <div class="col-md-4 text-center">
                    <form method="GET" action="{{ route('admin.foods.edit') }}" class="mb-0">
                        <input type="week" 
                               name="date" 
                               class="form-control text-center" 
                               value="{{ date('Y-\WW', strtotime($currentWeek)) }}"
                               onchange="this.form.submit()">
                    </form>
                    <small class="text-muted">هفته جاری: {{ Carbon\Carbon::parse($currentWeek)->format('d F Y') }}</small>
                </div>
                
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.foods.edit', ['date' => $nextWeek]) }}" 
                       class="btn btn-outline-primary">
                        هفته بعد →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول غذاهای هفته -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="15%">روز</th>
                            <th width="20%">تاریخ</th>
                            <th>غذاها</th>
                            <th width="15%">تعداد غذاها</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weekDays as $day)
                        <tr>
                            <td>
                                <strong>{{ $day['name'] }}</strong>
                            </td>
                            <td>
                                {{ $day['display_date'] }}
                            </td>
                            <td>
                                @if($day['foods']->count() > 0)
                                    <div class="row">
                                        @foreach($day['foods'] as $food)
                                        <div class="col-md-6 mb-2">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-0">{{ $food->name }}</h6>
                                                            <small class="text-muted">{{ number_format($food->price) }} تومان</small>
                                                        </div>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('admin.foods.edit', $food->id) }}" 
                                                               class="btn btn-outline-warning">ویرایش</a>
                                                        </div>
                                                    </div>
                                                    @if($food->description)
                                                    <small class="text-muted mt-1 d-block">{{ $food->description }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">هیچ غذایی برای این روز ثبت نشده است</span>
                                    <br>
                                    <a href="{{ route('admin.foods.create') }}?date={{ $day['date'] }}" 
                                       class="btn btn-sm btn-outline-success mt-2">
                                        افزودن غذا
                                    </a>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $day['foods']->count() > 0 ? 'success' : 'secondary' }}">
                                    {{ $day['foods']->count() }} غذا
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- آمار کلی -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4>{{ $weekDays->sum(function($day) { return $day['foods']->count(); }) }}</h4>
                    <p>کل غذاهای هفته</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4>{{ $weekDays->where('foods.count', '>', 0)->count() }}/5</h4>
                    <p>روزهای دارای غذا</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h4>{{ number_format($weekDays->sum(function($day) { 
                        return $day['foods']->sum('price'); 
                    })) }}</h4>
                    <p>مجموع قیمت‌ها (تومان)</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        text-align: center;
    }
    .card.bg-light {
        border: 1px solid #dee2e6;
    }
</style>
@endsection