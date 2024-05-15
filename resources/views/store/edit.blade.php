@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4> --}}

    <div class="row">
      <div class="col-md-6">

        <div class="card mb-4">
          <h5 class="card-header">Data Toko</h5>
          <!-- Form -->
          <div class="card-body">
            <form method="POST" action="{{ route('store.update', $customer->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
              <div class="row">
                <div class="mb-3 col-md-12">
                  <label for="code" class="form-label">Kode</label>
                  <input class="form-control" type="text" id="code" name="code" value="{{ $customer->code }}" readonly/>
                </div>

                <div class="mb-3 col-md-12">
                    <label for="customer_name" class="form-label">Nama Pelanggan</label>
                    <input class="form-control" type="text" id="customer_name" name="customer_name" value="{{ $customer->name }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="customer_phone" class="form-label">No. Telepon Pelanggan</label>
                  <input class="form-control" type="text" id="customer_phone" name="customer_phone" value="{{ $customer->phone }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <div>
                    <img src="{{ asset($customer->photo) }}" alt="" width="100">
                  </div>
                  <label for="photo" class="form-label">Foto Pelanggan</label>
                  <input class="form-control" type="file" id="photo" name="photo"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="description" class="form-label">Alamat</label>
                  <textarea name="customer_address" id="customer_address" rows="3" class="form-control">{{ $customer->address }}</textarea>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="la" class="form-label">Latitude</label>
                  <input class="form-control" type="number" id="la" name="la" value="{{ $customer->LA }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="lo" class="form-label">Longitude</label>
                  <input class="form-control" type="number" id="lo" name="lo" value="{{ $customer->LO }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label class="form-label" for="sub-brand">Cabang</label>
                  <select id="branch" class="select2 form-select" name="branch">
                    <option value="0">Pilih Cabang</option>
                    @foreach ($branches as $branch)
                      <option value="{{ $branch->id }}" {{ $customer->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="code" class="form-label">Area</label>
                  <select name="area" id="area" class="form-control">
                    @if ($customer->area_id)
                      <option value="{{ $customer->area_id }}" selected>{{ $customer->deploy_area->name }}</option>
                    @endif
                  </select>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="code" class="form-label">Sub Area</label>
                  <select name="subarea" id="subarea" class="form-control">
                    @if ($customer->sub_area_id)
                      <option value="{{ $customer->sub_area_id }}" selected>{{ $customer->deploy_sub_area->name }}</option>
                    @endif
                  </select>
                </div>

                <div class="mb-3 col-md-12">
                  <label class="form-label d-block">Status Registrasi</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="regist" id="regist" value="Y" {{ $customer->status_registration == 'Y' ? 'checked' : '' }}/>
                        <label class="form-check-label" for="inlineRadio1">Sudah Registrasi/RO</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="regist" id="regist" value="N" {{ $customer->status_registration == 'N' ? 'checked' : '' }}/>
                      <label class="form-check-label" for="inlineRadio2">Belum Registrasi/NRO</label>
                    </div>
                </div>

                <div class="mb-3 col-md-12">
                  <label class="form-label d-block">Centang Apabila Toko Sudah Memakai Spanduk</label>
                  <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" value="1" id="banner" name="banner" {{ $customer->status_registration == 1 ? 'checked' : '' }}/>
                    <label class="form-check-label" for="defaultCheck1"> Sudah pasang spanduk </label>
                  </div>
                </div>

                

              </div>
              {{-- <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">Kembali</a>
              </div> --}}
            {{-- </form> --}}
          </div>
          <!-- /Form -->
        </div>

      </div>

      <div class="col-md-6">

        <div class="card mb-4">
          <h5 class="card-header">Data Pemilik</h5>
          <!-- Form -->
          <div class="card-body">
            {{-- <form method="POST" action="{{ route('customer.store') }}" enctype="multipart/form-data"> --}}
                @csrf
              <div class="row">
                <div class="mb-3 col-md-12">
                  <label for="owner_name" class="form-label">Nama Pemilik</label>
                  <input class="form-control" type="text" id="owner_name" name="owner_name" value="{{ !empty($owner->name) ? $owner->name : '' }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="nik" class="form-label">NIK</label>
                  <input class="form-control" type="text" id="nik" name="nik" value="{{ !empty($owner->nik) ? $owner->nik : '' }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="owner_phone" class="form-label">No. Telepon Pemilik</label>
                  <input class="form-control" type="text" id="owner_phone" name="owner_phone" value="{{ !empty($owner->phone) ? $owner->phone : '' }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="owner_address" class="form-label">Alamat Pemilik</label>
                  <textarea name="owner_address" id="owner_address" rows="3" class="form-control">{{ !empty($owner->address) ? $owner->address : '' }}</textarea>
                </div>

              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="{{ route('store.index') }}" class="btn btn-outline-secondary">Kembali</a>
              </div>
            </form>
          </div>
          <!-- /Form -->
        </div>

      </div>
    </div>
  </div>
@endsection

@push('select2')
<script type="text/javascript">
  $(document).ready(function(){
    var areaPath = "{{ route('area.autocomplete') }}";
    var subAreaPath = "{{ route('subarea.autocomplete') }}";

    $('#area').select2({
        placeholder: 'Pilih Area',
        ajax: {
          url: areaPath,
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

    $('#subarea').select2({
        placeholder: 'Pilih Sub Area',
        ajax: {
          url: subAreaPath,
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
  });
</script>
@endpush