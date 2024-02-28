@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4> --}}

    <div class="row">
      <div class="col-md-6">

        <div class="card mb-4">
          <h5 class="card-header">Data Pelanggan</h5>
          <!-- Form -->
          <div class="card-body">
            <form method="POST" action="{{ route('customer.store') }}" enctype="multipart/form-data">
                @csrf
              <div class="row">
                <div class="mb-3 col-md-12">
                  <label for="code" class="form-label">Kode</label>
                  <input class="form-control" type="text" id="code" name="code" value="{{ old('code') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                    <label for="name_customer" class="form-label">Nama Pelanggan</label>
                    <input class="form-control" type="text" id="name_customer" name="name_customer" value="{{ old('name_customer') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="phone_customer" class="form-label">No. Telepon Pelanggan</label>
                  <input class="form-control" type="text" id="phone_customer" name="phone_customer" value="{{ old('phone_customer') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="photo" class="form-label">Foto Pelanggan</label>
                  <input class="form-control" type="file" id="photo" name="photo"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="description" class="form-label">Alamat</label>
                  <textarea name="address" id="address" rows="3" class="form-control">{{ old('address') }}</textarea>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="la" class="form-label">Latitude</label>
                  <input class="form-control" type="text" id="la" name="la" value="{{ old('la') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="lo" class="form-label">Longitude</label>
                  <input class="form-control" type="text" id="lo" name="lo" value="{{ old('lo') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="area" class="form-label">Area</label>
                  <input class="form-control" type="text" id="area" name="area" value="{{ old('area') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="subarea" class="form-label">Sub Area</label>
                  <input class="form-control" type="text" id="subarea" name="subarea" value="{{ old('subarea') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label class="form-label d-block">Status Registrasi/Member</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="regist" id="regist" value="Y" />
                        <label class="form-check-label" for="inlineRadio1">Sudah Registrasi/Member</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="regist" id="regist" value="M" />
                        <label class="form-check-label" for="inlineRadio2">Mixing/Campuran</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="regist" id="regist" value="N" />
                      <label class="form-check-label" for="inlineRadio2">Belum Registrasi/Non-member</label>
                    </div>
                </div>

                <div class="mb-3 col-md-12">
                  <label class="form-label d-block">Tipe</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="type" value="S" />
                        <label class="form-check-label" for="inlineRadio1">Toko</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="type" value="O" />
                        <label class="form-check-label" for="inlineRadio2">Gerai</label>
                    </div>
                </div>

                <div class="mb-3 col-md-12">
                  <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" value="1" id="banner" name="banner"/>
                    <label class="form-check-label" for="defaultCheck1"> Sudah pasang spanduk </label>
                  </div>
                </div>

                <div class="mb-3 col-md-12">
                  <label class="form-label" for="sub-brand">Cabang</label>
                  <select id="branch" class="select2 form-select" name="branch">
                    <option value="0">Pilih Cabang</option>
                    @foreach ($branches as $branch)
                      <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                  </select>
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
                  <label for="name_owner" class="form-label">Nama Pemilik</label>
                  <input class="form-control" type="text" id="name_owner" name="name_owner" value="{{ old('name_owner') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="nik" class="form-label">NIK</label>
                  <input class="form-control" type="text" id="nik" name="nik" value="{{ old('nik') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="phone_owner" class="form-label">No. Telepon Pemilik</label>
                  <input class="form-control" type="text" id="phone_owner" name="phone_owner" value="{{ old('phone_owner') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="address_owner" class="form-label">Alamat Pemilik</label>
                  <textarea name="address_owner" id="address_owner" rows="3" class="form-control">{{ old('address_owner') }}</textarea>
                </div>

              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">Kembali</a>
              </div>
            </form>
          </div>
          <!-- /Form -->
        </div>

      </div>
    </div>
  </div>
@endsection