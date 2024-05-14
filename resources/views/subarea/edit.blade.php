@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4> --}}

    <div class="row">
      <div class="col-md-12">

        <div class="card mb-4">
          <h5 class="card-header">Ubah Sub Area</h5>
          <!-- Form -->
          <div class="card-body">
            <form method="POST" action="{{ route('subarea.update', $subarea->id) }}">
                @csrf
                @method('PUT')
              <div class="row">
                <div class="mb-3 col-md-12">
                  <label for="branch" class="form-label">Cabang</label>
                  <select name="branch" id="branch" class="form-control">
                    <option value="">--Pilih Cabang--</option>
                      @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $subarea->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="mb-3 col-md-12">
                  <label for="area" class="form-label">Area</label>
                  <select name="area" id="area" class="form-control">
                    <option value="">--Pilih Area--</option>
                      @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ $subarea->area_id == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="mb-3 col-md-12">
                    <label for="name" class="form-label">Nama</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{ $subarea->name }}"/>
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="{{ route('subarea.index') }}" class="btn btn-outline-secondary">Kembali</a>
              </div>
            </form>
          </div>
          <!-- /Form -->
        </div>

      </div>
    </div>
  </div>
@endsection