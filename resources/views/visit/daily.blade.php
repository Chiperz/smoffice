@extends('layouts.master')

@section('content')
<!-- Bordered Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-2">
        <div class="card-header">
            <div class="row">
                <h5>Summary Kunjungan</h5>
                <div class="card-header-action">
                    {{-- <a href="{{ route('visit.summary') }}" class="btn btn-primary"><box-icon name='plus' ></box-icon> Kembali</a> --}}
                    {{-- <a href="{{ route('category.trashed') }}" class="btn btn-secondary"><box-icon name='plus' ></box-icon> Data Terhapus</a> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="name" class="form-label">Nama Staff</label>
                    <input class="form-control" type="text" value="{{ $headerVisit->user->name }}" readonly/>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <h5>Tabel Kunjungan Harian Karyawan</h5>
                <div class="card-header-action">
                    {{-- <a href="{{ route('visit.summary') }}" class="btn btn-primary"><box-icon name='plus' ></box-icon> Kembali</a> --}}
                    {{-- <a href="{{ route('category.trashed') }}" class="btn btn-secondary"><box-icon name='plus' ></box-icon> Data Terhapus</a> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
    <!--/ Bordered Table -->
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- The Close Button -->
  <span class="close">&times;</span>
  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">
  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>
@endsection

@push('modal_image')
    <script>
        $(document).on('click', '.myImg', function() {
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("img01");
            modal.style.display = "block";
            modalImg.src = this.src;

            var span = document.getElementsByClassName("close")[0];
            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };
        });
    </script>
@endpush

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush