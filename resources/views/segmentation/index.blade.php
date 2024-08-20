@extends('layouts.master')

@section('content')
<!-- Bordered Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <h5>Tabel Segmentasi Alasan Visit</h5>
                <div class="card-header-action">
                    {{-- @can('branch create') --}}
                        <a href="{{ route('segmentation-reason.create') }}" class="btn btn-primary"><box-icon name='plus' ></box-icon> Tambah Data</a>
                    {{-- @endcan --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
    <!--/ Bordered Table -->
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush