@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4> --}}
        <div class="card mb-4">
          <h5 class="card-header">Tambah Master Jadwal Kunjung</h5>
          <!-- Form -->
          <div class="card-body">
            <form method="POST" action="{{ route('schedule-visit.store') }}">
                @csrf
              <div class="row">
                <div class="mb-3 col-md-12">
                  <label for="name" class="form-label">Nama</label>
                  <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}"/>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                      <label for="date_start" class="form-label">Tanggal Mulai</label>
                      <input class="form-control" type="date" id="date_start" name="date_start"/>
                  </div>

                  <div class="mb-3 col-md-6">
                    <label for="date_end" class="form-label">Tanggal Selesai</label>
                    <input class="form-control" type="date" id="date_end" name="date_end"/>
                  </div>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="looping" class="form-label">Perulangan Kunjungan</label>
                  <input class="form-control" type="number" id="looping" name="looping"/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="looping_type" class="form-label">Pengulangan Setiap</label><br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="looping_type" id="looping_type" value="O"/>
                    <label class="form-check-label" for="inlineRadio1">Hanya Sekali</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="looping_type" id="looping_type" value="D"/>
                    <label class="form-check-label" for="inlineRadio1">Hari</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="looping_type" id="looping_type" value="W"/>
                    <label class="form-check-label" for="inlineRadio1">Minggu</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="looping_type" id="looping_type" value="M"/>
                    <label class="form-check-label" for="inlineRadio1">Bulan</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="looping_type" id="looping_type" value="Y"/>
                    <label class="form-check-label" for="inlineRadio1">Tahun</label>
                  </div>
                </div>

                <div class="mb-3 col-md-12">
                  <label class="form-label" for="sub-brand">Staff</label>
                  <select id="user" class="select2 form-select" name="user">
                    <option value="0">Pilih Staff</option>
                    @foreach ($users as $user)
                      <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                  </select>
                </div>

              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <a href="{{ route('schedule-visit.index') }}" class="btn btn-outline-secondary">Kembali</a>
              </div>
            </form>
          </div>
          <!-- /Form -->
        </div>
  </div>
@endsection
