@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <form action="{{ route('visit.search-list', $type) }}" method="GET" class="input-group input-group-merge">
        <input type="hidden" value="{{ $type }}" name="type">
        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
        <input type="text" class="form-control" placeholder="Cari..." aria-label="Cari..." aria-describedby="basic-addon-search31" name="search">
      </form>
      @if ($type == 'S')
        @if($time == 'schedule')
        <div class="row">
          <a href="{{ route('store.create') }}" class="btn btn-success mt-2 col-md-12">Tambah Toko Baru</a>
          <a href="{{ route('visit.list', ['type' => 'O', 'time' => 'schedule']) }}" class="btn btn-info mt-2 col-md-12">Campaign Gerai</a>
          <a href="{{ route('visit.list', ['type' => 'S', 'time' => 'schedule']) }}" class="btn btn-{{ $time == 'all' ? 'outline-' : '' }}primary mt-2 col-md-6">
            <span class="tf-icons bx bx-calendar"></span>&nbsp; Jadwal Kunjungan
          </a>
          <a href="{{ route('visit.list', ['type' => 'S', 'time' => 'all']) }}" class="btn btn-{{ $time == 'schedule' ? 'outline-' : '' }}secondary mt-2 col-md-6">
            <span class="tf-icons bx bx-user"></span>&nbsp; Semua Toko
          </a>
        </div>
        @else
        <div class="row">
          <a href="{{ route('store.create') }}" class="btn btn-success mt-2 col-md-12">Tambah Toko Baru</a>
          <a href="{{ route('visit.list', ['type' => 'O', 'time' => 'schedule']) }}" class="btn btn-info mt-2 col-md-12">Campaign Gerai</a>
          <a href="{{ route('visit.list', ['type' => 'S', 'time' => 'schedule']) }}" class="btn btn-{{ $time == 'all' ? 'outline-' : '' }}primary mt-2 col-md-6">
            <span class="tf-icons bx bx-calendar"></span>&nbsp; Jadwal Kunjungan
          </a>
          <a href="{{ route('visit.list', ['type' => 'S', 'time' => 'all']) }}" class="btn btn-{{ $time == 'schedule' ? 'outline-' : '' }}secondary mt-2 col-md-6">
            <span class="tf-icons bx bx-user"></span>&nbsp; Semua Toko
          </a>
        </div>
        @endif
      
      @else
        @if($time == 'schedule')
        <div class="row">
          <a href="{{ route('outlet.create') }}" class="btn btn-success mt-2 col-md-12">Tambah Gerai Baru</a>
          <a href="{{ route('visit.list', ['type' => 'S', 'time' => 'schedule']) }}" class="btn btn-dark mt-2 col-md-12">Visit Toko</a>
          <a href="{{ route('visit.list', ['type' => 'O', 'time' => 'schedule']) }}" class="btn btn-{{ $time == 'all' ? 'outline-' : '' }}primary mt-2 col-md-6">
            <span class="tf-icons bx bx-calendar"></span>&nbsp; Jadwal Kunjungan
          </a>
          <a href="{{ route('visit.list', ['type' => 'O', 'time' => 'all']) }}" class="btn btn-{{ $time == 'schedule' ? 'outline-' : '' }}secondary mt-2 col-md-6">
            <span class="tf-icons bx bx-user"></span>&nbsp; Semua Gerai
          </a>
        </div>
        @else
        <div class="row">
          <a href="{{ route('outlet.create') }}" class="btn btn-success mt-2 col-md-12">Tambah Gerai Baru</a>
          <a href="{{ route('visit.list', ['type' => 'S', 'time' => 'schedule']) }}" class="btn btn-dark mt-2 col-md-12">Visit Toko</a>
          <a href="{{ route('visit.list', ['type' => 'O', 'time' => 'schedule']) }}" class="btn btn-{{ $time == 'all' ? 'outline-' : '' }}primary mt-2 col-md-6">
            <span class="tf-icons bx bx-calendar"></span>&nbsp; Jadwal Kunjungan
          </a>
          <a href="{{ route('visit.list', ['type' => 'S', 'time' => 'all']) }}" class="btn btn-{{ $time == 'schedule' ? 'outline-' : '' }}secondary mt-2 col-md-6">
            <span class="tf-icons bx bx-user"></span>&nbsp; Semua Gerai
          </a>
        </div>
        @endif
      @endif

          <div class="row">
          @if(empty($customers) && empty($scheduledCustomer))
            <a href="{{ route('dashboard') }}"><img class="responsive" src="{{ asset('custom-icons/Chef-page-not-found.png') }}" alt="" height="1000px"></a>
          @endif
          <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            {{-- {{ dd(!empty($customers)) }} --}}
            @if(!empty($customers))
              @foreach ($customers as $customer)
              <div class="col">
                <div class="card h-100" 
                  @if (collect($cekVisit)->contains('customer_id', $customer->id))
                    style="background-color:lime;"
                  @endif
                >
                  <img class="card-img-top" src="{{ asset($customer->photo) }}" alt="{{ $customer->code.' - '.$customer->name }}">
                  <div class="card-body">
                    <h5 class="card-title">{{ $customer->code." - ".$customer->name }}</h5>
                    <p class="card-text">
                      {!! empty($customer->address) ? '<span class="badge bg-label-danger">Alamat Belum Diketahui</span>' : Str::words($customer->address, 10, '. . . ')!!}<br>
                      {!! empty($customer->deploy_area) ? '' : $customer->deploy_area->name !!} - {!! empty($customer->deploy_sub_area) ? '' : $customer->deploy_sub_area->name !!}
                      <br>
                      
                    </p>
                    @if (!empty($customer->LA) && !empty($customer->LA))
                      <a href="https://maps.google.com/?q={{ $customer->LA.','.$customer->LO }}" class="btn btn-secondary mt-2" target="_blank">Menuju Lokasi</a>
                    @endif
                    <a href="{{ route('visit.create', $customer->id) }}" class="btn btn-primary mt-2">Mulai Kunjungan</a>
                  </div>
                </div>
              </div>
              @endforeach

          </div>

          </div>
          <div class="d-flex">
            {!! $customers->links() !!}
          </div>

          @else
            @if(!empty($scheduledCustomer))
              @foreach ($scheduledCustomer as $customer)
              <div class="col">
                <div class="card h-100" 
                  @if (collect($cekVisit)->contains('customer_id', $customer->customer->id))
                    style="background-color:lime;"
                  @endif
                >
                  <img class="card-img-top" src="{{ asset($customer->customer->photo) }}" alt="{{ $customer->customer->code.' - '.$customer->customer->name }}">
                  <div class="card-body">
                    <h5 class="card-title">{{ $customer->customer->code." - ".$customer->customer->name }}</h5>
                    <p class="card-text">
                      {!! empty($customer->customer->address) ? '<span class="badge bg-label-danger">Alamat Belum Diketahui</span>' : Str::words($customer->customer->address, 10, '. . . ')!!}<br>
                      {!! empty($customer->customer->deploy_area) ? '' : $customer->customer->deploy_area->name !!} - {!! empty($customer->customer->deploy_sub_area) ? '' : $customer->customer->deploy_sub_area->name !!}
                      <br>
                      
                    </p>
                    @if (!empty($customer->customer->LA) && !empty($customer->customer->LA))
                      <a href="https://maps.google.com/?q={{ $customer->customer->LA.','.$customer->customer->LO }}" class="btn btn-secondary mt-2" target="_blank">Menuju Lokasi</a>
                    @endif
                    <a href="{{ route('visit.create', $customer->customer->id) }}" class="btn btn-primary mt-2">Mulai Kunjungan</a>
                  </div>
                </div>
              </div>
              @endforeach
            
          </div>

          </div>
          <div class="d-flex">
            {!! $scheduledCustomer->links() !!}
          </div>
            @else
              {{-- <a href="{{ route('dashboard') }}"><img class="responsive" src="{{ asset('custom-icons/Chef-page-not-found.png') }}" alt="" height="1000px"></a> --}}
            @endif
          @endif

    </div>
    <!-- / Content -->

    

    <div class="content-backdrop fade"></div>
</div>
@endsection