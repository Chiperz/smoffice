@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <h5>Summary Per Cabang</h5>
                </div>
                
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

                <div class="row">
                    @foreach ($branches as $branch)
                        <div class="card col-md-3 mb-2 mr-2">
                            <div class="card-header"><h6>{{ $branch->name }}</h6></div>
                            <div class="card-body">
                                Total Toko : <b>{{ $branch->customers()->where('type', 'S')->count() }}</b><br>
                                Total Gerai : <b>{{ $branch->customers()->where('type', 'O')->count() }}</b><br>
                                {{-- Toko Terkunjungi : <b>{{ \App\Models\HeaderVisit::whereHas('customer', function($query) use ($branch){
                                        $query->where('type', 'S')
                                            ->where('branch_id', $branch->id);
                                    })->whereBetween('date', [date('Y-m-01'), date('Y-m-t')])->count() }}</b><br>
                                Gerai Terkunjungi : <b>{{ \App\Models\HeaderVisit::whereHas('customer', function($query) use ($branch){
                                        $query->where('type', 'O')
                                            ->where('branch_id', $branch->id);
                                    })->whereBetween('date', [date('Y-m-01'), date('Y-m-t')])->count() }}</b> --}}
                                    <hr>Menuju Laporan
                                <a class="btn btn-primary" href="{{ route('summary-store', ['id' => $branch->id, 'dateFrom' => date('Y-m-01'), 'dateTo' => date('Y-m-d')]) }}">Toko</a>
                                <button class="btn btn-secondary">Gerai</button>
                            </div>
                        </div>
                    @endforeach
                    
                </div>

            </div>
        </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
@endsection