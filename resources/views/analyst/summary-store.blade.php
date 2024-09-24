@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-2">
            <div class="card-header">
                <h5>Pengaturan dan Summary Laporan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="form-group col-md-4 mb-2">
                        <label><b>Jumlah Total Toko</b></label>
                        <input type="text" class="form-control" value="{{ $totalStore }}" readonly>
                        <a href="{{ route('store.index') }}">Lihat Lebih Lengkap</a>
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label><b>Jumlah Toko yang Sudah Pasang Display</b></label>
                        <input type="text" class="form-control" value="{{ $storeHasDisplay }}" readonly>
                        <a href="{{ route('store-has-display', $branch->id) }}">Lihat Lebih Lengkap</a>
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label><b>Coverage (%)</b></label>
                        <input type="text" class="form-control" value="{{ number_format($coverage, 2) }}%" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="form-group col-md-4 mb-2">
                        <label><b>Toko Terkunjungi</b></label>
                        <input type="text" class="form-control" value="{{ $visitedStore }}" readonly>
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label><b>Toko Belum Terkunjungi</b></label>
                        <input type="text" class="form-control" value="{{ $notVisitedStore }}" readonly>
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label><b>Terkunjungi (%)</b></label>
                        <input type="text" class="form-control" value="{{ number_format($visited, 2) }}%" readonly>
                    </div>
                </div>
                <div class="card accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                        Filter 
                      </button>
                    </h2>
    
                    <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <form action="{{ route('summary-store-search')}}" method="POST">
                                @csrf
                                <select name="branch" class="form-control mb-2">
                                    <option>-- Pilih Cabang --</option>
                                    @foreach ($branches as $row)
                                        <option {{ $row->id == $branch->id ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="date_from" value="{{ date('Y-m-d',strtotime(request()->dateFrom)) }}">
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="date_to" value="{{ date('Y-m-d', strtotime(request()->dateTo)) }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Konfirmasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-header">
                <div class="row">
                    <h5>Peningkatan Display Cabang {{ $branch->name }}</h5>
                </div>
                {{-- <a class="btn btn-primary" href="{{ route('trial-report') }}">Kembali</a> --}}
            </div>
            <div class="card-body">
                {!! $summaryStoreBranch->container() !!}
            </div>
        </div>

        {{-- <div class="card mb-2">
            <div class="card-header">
                <div class="row">
                    <h5>Tabel Analisa Data</h5>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-stripped table-responsive">
                    <tr>
                        <th>Area</th>
                        @foreach ($months as $row)
                            <th>{{ $row->month_name }}</th>
                        @endforeach
                    </tr>
                    @foreach ($areas as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                                @php
                                    $branchId = $branch->id;
                                    $areaId = $row->id;
                                    $display = \App\Models\DetailStoreVisit::selectRaw('
                                        areas.name as area_name,
                                        month(detail_store_visits.created_at) as no,
                                        monthname(detail_store_visits.created_at) as month,
                                        COUNT(detail_store_visits.display_product_id) as count_diplay
                                    ')
                                    ->join('header_visits', 'header_visits.id', 'detail_store_visits.header_visit_id')
                                    ->join('customers', 'customers.id', 'header_visits.customer_id')
                                    ->join('branches', 'branches.id', 'customers.branch_id')
                                    ->join('areas', 'areas.id', 'customers.area_id')
                                    ->whereHas('header_visit', function($query) use ($branchId, $areaId){
                                        $query->whereHas('customer', function($q) use ($branchId, $areaId){
                                            $q->where('branch_id', $branchId)
                                                ->where('area_id', $areaId);
                                        });
                                    })
                                    ->groupBy('area_name', 'no', 'month')
                                    ->get();
                                    // echo $branchId;
                                @endphp
                            @foreach ($display as $rowData)
                                <td>{{ $rowData->count_display }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        </div> --}}

    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
@endsection

@push('chart')
  <script src="{{ $summaryStoreBranch->cdn() }}"></script>

  {{ $summaryStoreBranch->script() }}
  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush