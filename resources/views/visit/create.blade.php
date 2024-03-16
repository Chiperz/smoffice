@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4> --}}

    <div class="row">
      <div class="col-md-6">

        <div class="card mb-4">
          <h5 class="card-header">Data Kunjungan Umum</h5>
          <!-- Form -->
          <div class="card-body">
            <form method="POST" action="{{ route('visit.store', $customer->id) }}">
                @csrf
              <div class="row">
                <div class="mb-3 col-md-12">
                  <label for="code" class="form-label">Kode {{ $customer->type == 'S' ? 'Toko' : 'Gerai' }}</label>
                  <input class="form-control" type="text" id="code" name="code" value="{{ $customer->code }}" readonly/>
                </div>

                <div class="mb-3 col-md-12">
                    <label for="name" class="form-label">Nama</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{ $customer->name }}" readonly/>
                </div>
                <input class="form-control" type="hidden" id="lat" name="lat" value="{{ old('lat') }}" readonly/>
                <input class="form-control" type="hidden" id="lon" name="lon" value="{{ old('lon') }}" readonly/>

                <div class="mb-3 col-md-12">
                  <label for="name" class="form-label">Foto Kunjungan</label>
                  <input class="form-control" type="file" id="photo" name="photo"/>
                </div>

                <div class="col-md-12 mb-2">
                  <label class="text-light fw-semibold d-block">Spanduk</label>
                  <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="radio" id="banner" value="1" name="banner">
                    <label class="form-check-label" for="inlineRadio1">Terpasang</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="banner" value="0" name="banner">
                    <label class="form-check-label" for="inlineRadio2">Tidak ada</label>
                  </div>
                </div>

                @if ($customer->type == 'O')
                  <div class="col-md-12 mb-2">
                    <label class="text-light fw-semibold d-block">Sudah Pakai Produk Hnasel?</label>
                    <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="radio" id="type" value="Y" name="type">
                      <label class="form-check-label" for="inlineRadio1">Sudah</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="type" value="M" name="type">
                      <label class="form-check-label" for="inlineRadio2">Sudah, Tetapi Pakai Produk Lain Juga</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="type" value="N" name="type">
                      <label class="form-check-label" for="inlineRadio2">Belum Sama Sekali</label>
                    </div>
                  </div>
                @endif

                <div class="col-md-12 mb-2">
                  <label class="text-light fw-semibold d-block">Aktifitas</label>
                  <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="radio" id="activity" value="Visit" name="activity">
                    <label class="form-check-label" for="inlineRadio1">Kunjungan</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="activity" value="Maintenance" name="activity">
                    <label class="form-check-label" for="inlineRadio2">Maintenance Display</label>
                  </div>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="note" class="form-label">Catatan Kunjungan</label>
                  <textarea name="note" rows="2" class="form-control">{{ old('note') }}</textarea>
                </div>
                
              </div>
              {{-- <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="{{ route('unproductive-reason.index') }}" class="btn btn-outline-secondary">Kembali</a>
              </div>
            </form> --}}
          </div>
          <!-- /Form -->
        </div>

      </div>


      <div class="col-md-6">

        <div class="card mb-4">
          <h5 class="card-header">Data Display Toko</h5>
          <!-- Form -->
          <div class="card-body">
              <div class="row">
                <div class="mb-3 col-md-12">
                  <label for="code" class="form-label">Display Produk</label>
                  <select name="display[]" id="display" class="form-control" multiple="multiple"></select>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="code" class="form-label">Kategori Produk</label>
                  <select name="category[]" id="category" class="form-control" multiple="multiple"></select>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="code" class="form-label">Produk yang tersedia</label>
                  <select name="brand[]" id="brand" class="form-control" multiple="multiple"></select>
                </div>

                {{-- @if ($customer->type == 'O')
                  <div class="col-md-12 mb-2">
                    <label class="text-light fw-semibold d-block">Sudah Pakai Produk Hnasel?</label>
                    <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="radio" id="type" value="Y" name="type">
                      <label class="form-check-label" for="inlineRadio1">Sudah</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="type" value="M" name="type">
                      <label class="form-check-label" for="inlineRadio2">Sudah, Tetapi Pakai Produk Lain Juga</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="type" value="N" name="type">
                      <label class="form-check-label" for="inlineRadio2">Belum Sama Sekali</label>
                    </div>
                  </div>
                @endif --}}

                <div class="col-md-12 mb-2">
                  <label class="text-light fw-semibold d-block">Alasan tidak pasang display</label>
                  @foreach ($reasons as $reason)
                    <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="checkbox" id="reason[]" value="{{ $reason->id }}" name="reason[]">
                      <label class="form-check-label" for="inlineCheckbox1">{{ ucfirst($reason->name) }}</label>
                    </div>
                  @endforeach
                  <div class="input-group mt-2">
                    <div class="input-group-text">
                      <input class="form-check-input mt-0" type="checkbox" value="1" aria-label="Checkbox for following text input" name="other_reason" id="other_reason">
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox" placeholder="Alasan lainnya" name="name_other_reason">
                  </div>
                </div>
                
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="{{ route('unproductive-reason.index') }}" class="btn btn-outline-secondary">Kembali</a>
              </div>
            </form>
          </div>
          <!-- /Form -->
        </div>

      </div>
    </div>
  </div>
@endsection

@push('geolocation')
  <script>
    getLocation();
    function showPosition(position) {
        document.getElementById('lat').value = position.coords.latitude;
        document.getElementById('lon').value = position.coords.longitude;
      }
  </script>
@endpush

@push('select2')
  <script>
    var displayPath = "{{ route('display.autocomplete') }}";
    var categoryPath = "{{ route('category.autocomplete') }}";
    var brandPath = "{{ route('brand.autocomplete') }}";
  
    $('#display').select2({
        placeholder: 'Pilih display produk',
        ajax: {
          url: displayPath,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });

      $('#category').select2({
        placeholder: 'Pilih kategori produk',
        ajax: {
          url: categoryPath,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });

      $('#brand').select2({
        placeholder: 'Pilih brand produk yang tersedia di toko',
        ajax: {
          url: brandPath,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });
  </script>
@endpush
