@extends('layouts.master')

@section('content')
<!-- Bordered Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-2">
        <div class="card-header">
            <div class="row">
                <h5>Master Jadwal Kunjung</h5>
                <div class="card-header-action">
                    {{-- <a href="{{ route('visit.summary') }}" class="btn btn-primary"><box-icon name='plus' ></box-icon> Kembali</a> --}}
                    {{-- <a href="{{ route('category.trashed') }}" class="btn btn-secondary"><box-icon name='plus' ></box-icon> Data Terhapus</a> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Nama Jadwal Kunjung</label>
                    <input class="form-control" type="text" value="{{ $scheduleMaster->name }}" readonly/>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Nama Staff</label>
                    <input class="form-control" type="text" value="{{ $scheduleMaster->user->name }}" readonly/>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Tanggal Mulai</label>
                    <input class="form-control" type="text" value="{{ $scheduleMaster->date_start }}" readonly/>
                </div>
                
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Tanggal Selesai</label>
                    <input class="form-control" type="text" value="{{ $scheduleMaster->date_end }}" readonly/>
                </div>
            </div>

            {{-- <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Total Toko</label>
                    <input class="form-control" type="text" value="{{ $scheduleMaster->whereHas('detail', function($q){
                        $q->whereHas('customer', function($query){
                            $query->where('type', 'S');
                        });
                    })->count() }}" readonly/>
                </div>
                
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Total Gerai</label>
                    <input class="form-control" type="text" value="" readonly/>
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Total Target Kunjungan</label>
                    <input class="form-control" type="text" value="0" readonly/>
                </div>
                
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Total Kunjungan</label>
                    <input class="form-control" type="text" value="" readonly/>
                </div>
            </div> --}}
            <a href="{{ route('schedule-visit.edit', $scheduleMaster->id) }}" class="btn btn-warning"><box-icon name='plus' ></box-icon> Ubah</a>
            <a href="{{ route('schedule-visit.index') }}" class="btn btn-primary"><box-icon name='plus' ></box-icon> Kembali</a>
            
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <h5>Tabel Jadwal Kunjungan</h5>
                {{-- <div class="card-header-action"> --}}
                    <div class="card">
                        <div class="card-header">
                            Tambah Pelanggan
                        </div>
                            <form action="{{ route('schedule-visit.add-detail', $scheduleMaster->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <label for="customer" class="form-label">Pelanggan</label>
                                    <select name="customer[]" id="customer" multiple></select>
    
                                    &nbsp;&nbsp;&nbsp;<input type="submit" value="Tambah" class="btn btn-success col-md-3 mb-3 mt-3">
                                </div>
                                
                            </form>
                    </div>
                    
                    {{-- <div class="card accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                          <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                            Filter
                          </button>
                        </h2>
        
                        <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body">
                                <label for="customer" class="form-label col-md-12">Pelanggan</label>
                                <select name="customer[]" id="customer" multiple></select>
                            </div>
                        </div>
                    </div> --}}
                {{-- </div> --}}
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
    <!--/ Bordered Table -->
</div>
@endsection

@push('select2')
<script type="text/javascript">
  $(document).ready(function(){
    var customerPath = "{{ route('customer.autocomplete') }}";

    $('#customer').select2({
        placeholder: '-- Pilih Pelanggan --',
        ajax: {
          url: customerPath,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        // text: item.code + ' - '+ item.name + ' - ' + item.address,
                        text: item.code + ' - ' + item.name,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
    });

  });
</script>
@endpush

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
