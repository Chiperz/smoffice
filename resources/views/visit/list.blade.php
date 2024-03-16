@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        
          <div class="row">

            <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
              @foreach ($customers as $customer)
                <div class="col">
                  <div class="card h-100">
                    <img class="card-img-top" src="{{ asset($customer->photo) }}" alt="{{ $customer->code.' - '.$customer->name }}">
                    <div class="card-body">
                      <h5 class="card-title">{{ $customer->code." - ".$customer->name }}</h5>
                      <p class="card-text">
                        {!! empty($customer->address) ? '<span class="badge bg-label-danger">Alamat Belum Diketahui</span>' : Str::words($customer->address, 10, '. . . ')!!}
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

    </div>
    <!-- / Content -->

    

    <div class="content-backdrop fade"></div>
</div>
@endsection