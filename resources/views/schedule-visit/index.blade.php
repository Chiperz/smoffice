@extends('layouts.master')

@section('content')
<!-- Bordered Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                    Filter
                  </button>
                </h2>

                <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <select name="branch" id="branch" class="form-control mt-2">
                            <option value="">--Pilih Pengguna--</option>
                                @foreach ($users as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <h5>Tabel Schedule Visit</h5>
                <div class="card-header-action">
                    @can('schedule-visit create')
                        <a href="{{ route('schedule-visit.create') }}" class="btn btn-primary"><box-icon name='plus' ></box-icon> Tambah Data</a>
                    @endcan
                    @can('schedule-visit export')
                        <a href="{{ route('schedule-visit.export') }}" class="btn btn-success">Export ke excel</a>
                    @endcan
                    @can('schedule-visit import')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Import dari Excel
                        </button>

                        <!-- Modal Import -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <form action="{{ route('schedule-visit.import') }}" enctype="multipart/form-data" method="POST">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @csrf
                                    <label for="import" class="form-label">Unggah File</label>
                                    <input type="file" name="import" class="form-control mb-2">
                                    <a href="{{ route('store.file-import', 'Format Impor Toko - SMOffice.xlsx') }}" class="mt-2">Unduh Contoh File Disini</a>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                            </div>
                            </form>
                        </div>
                    @endcan
                    
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

    <script>
        $('#status').change(function(){
            $('.table').DataTable().draw();
        });

        $('#branch').change(function(){
            $('.table').DataTable().draw();
        });
    </script>
@endpush
