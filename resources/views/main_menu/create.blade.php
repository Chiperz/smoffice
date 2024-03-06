@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4> --}}

    <div class="row">
      <div class="col-md-12">

        <div class="card mb-4">
          <h5 class="card-header">Tambah Main Menu</h5>
          <!-- Form -->
          <div class="card-body">
            <form method="POST" action="{{ route('main_menu.store') }}">
                @csrf
              <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="title" class="form-label">Judul</label>
                    <input class="form-control" type="text" id="title" name="title" value="{{ old('title') }}"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="icon" class="form-label">Icon</label>
                  <textarea name="icon" id="icon" rows="3" class="form-control">{{ old('icon') }}</textarea>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="url" class="form-label">Link</label>
                  <textarea name="url" id="url" rows="3" class="form-control">{{ old('url') }}</textarea>
                </div>

                <div class="mb-3 col-md-12">
                  <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" value="1" name="parent">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Parent</label>
                  </div>
                </div>

                <div class="mb-3 col-md-12">
                  <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" value="1" name="show">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Terlihat</label>
                  </div>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="serial" class="form-label">Urutan</label>
                  <input class="form-control" type="number" id="serial" name="serial" value="{{ old('serial') }}"/>
              </div>

              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="{{ route('category.index') }}" class="btn btn-outline-secondary">Kembali</a>
              </div>
            </form>
          </div>
          <!-- /Form -->
        </div>

      </div>
    </div>
  </div>
@endsection