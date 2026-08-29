@extends('admin.master_layout')
@section('title')
    <title>{{ __('Course Grade List') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Course Grade List') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Course Grade List') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="mt-4 row">

                    {{-- Search / Filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.course-grade.index') }}" method="GET"
                                    onchange="$(this).trigger('submit')" class="form_padding">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <input type="text" name="keyword" value="{{ request('keyword') }}"
                                                class="form-control" placeholder="{{ __('Search') }}">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <select name="status" class="form-control">
                                                <option value="">{{ __('Select Status') }}</option>
                                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>{{ __('In-Active') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <select name="order_by" class="form-control">
                                                <option value="">{{ __('Order By') }}</option>
                                                <option value="1" {{ request('order_by') == '1' ? 'selected' : '' }}>{{ __('ASC') }}</option>
                                                <option value="0" {{ request('order_by') == '0' ? 'selected' : '' }}>{{ __('DESC') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <select name="par-page" class="form-control">
                                                <option value="">{{ __('Per Page') }}</option>
                                                <option value="10"  {{ request('par-page') == '10'  ? 'selected' : '' }}>10</option>
                                                <option value="50"  {{ request('par-page') == '50'  ? 'selected' : '' }}>50</option>
                                                <option value="100" {{ request('par-page') == '100' ? 'selected' : '' }}>100</option>
                                                <option value="all" {{ request('par-page') == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Course Grade List') }}</h4>
                                <div>
                                    <a href="{{ route('admin.course-grade.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> {{ __('Add New') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" style="min-height:400px;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Images') }}</th>
                                                <th>{{ __('Title') }}</th>
                                                <th>{{ __('Description') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th class="text-center">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($courseGrades as $grade)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        @if($grade->images->count())
                                                            <div class="d-flex flex-wrap gap-1">
                                                                @foreach($grade->images->take(3) as $img)
                                                                    <img src="{{ $img->image_path }}"
                                                                        style="width:40px;height:40px;object-fit:cover;border-radius:4px;border:1px solid #dee2e6;"
                                                                        title="{{ $img->image_name }}">
                                                                @endforeach
                                                                @if($grade->images->count() > 3)
                                                                    <span class="badge bg-secondary d-flex align-items-center">+{{ $grade->images->count() - 3 }}</span>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="text-muted small">—</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $grade->title }}</td>
                                                    <td>{{ \Illuminate\Support\Str::limit($grade->description, 60) }}</td>
                                                    <td>
                                                        <input class="change-status"
                                                            data-url="{{ route('admin.course-grade.status-update', $grade->id) }}"
                                                            type="checkbox"
                                                            {{ $grade->status ? 'checked' : '' }}
                                                            data-toggle="toggle"
                                                            data-on="{{ __('Active') }}"
                                                            data-off="{{ __('Inactive') }}"
                                                            data-onstyle="success"
                                                            data-offstyle="danger">
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.course-grade.edit', $grade->id) }}"
                                                            class="m-1 text-white btn btn-sm btn-warning" title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:;" data-toggle="modal"
                                                            data-target="#deleteModal" class="btn btn-danger btn-sm"
                                                            onclick="deleteData({{ $grade->id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        {{ __('No grades found.') }}
                                                        <a href="{{ route('admin.course-grade.create') }}">{{ __('Add one now') }}</a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $courseGrades->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <x-admin.delete-modal />
@endsection

@push('js')
<script>
    function deleteData(id) {
        $("#deleteForm").attr("action", "{{ url('/admin/course-grade') }}" + "/" + id);
    }
</script>
@endpush
