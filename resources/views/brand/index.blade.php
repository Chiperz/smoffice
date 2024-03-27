@extends('layouts.master')

@section('content')
<!-- Bordered Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                    Filter Status
                  </button>
                </h2>

                <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                    <form action="{{ route('visit.summary-search') }}" method="GET">
                        <div class="accordion-body">
                            <select name="status" id="status" class="form-control">
                                <option value="0">Non-active</option>
                                <option value="1">Active</option>
                            </select>
                            <input type="submit" class="btn btn-primary mt-2">
                            <a class="btn btn-secondary mt-2" href="{{ route('visit.summary') }}">Reset Filter</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <h5>Tabel Brand Produk</h5>
                <div class="card-header-action">
                    @can('brand_product create')
                        <a href="{{ route('brand.create') }}" class="btn btn-primary"><box-icon name='plus' ></box-icon> Tambah Data</a>
                    @endcan
                    @hasrole('developer')
                        <a href="{{ route('brand.trashed') }}" class="btn btn-secondary"><box-icon name='plus' ></box-icon> Data Terhapus</a>
                    @endhasrole
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