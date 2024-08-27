@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <h5>Peningkatan Display Cabang {{ $branch->name }}</h5>
                </div>
                <a class="btn btn-primary" href="{{ route('trial-report') }}">Kembali</a>
                
                {{-- <div class="card accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                        Filter
                      </button>
                    </h2>
    
                    <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="date_from" value="{{ date('Y-m-01') }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="date_from" value="{{ date('Y-m-t') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="card-body">
                {!! $summaryStoreBranch->container() !!}
            </div>
        </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
@endsection

@push('chart')
  <script src="{{ $summaryStoreBranch->cdn() }}"></script>

  {{ $summaryStoreBranch->script() }}
@endpush