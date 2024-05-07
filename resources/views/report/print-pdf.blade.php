<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('template/assets/js/config.js') }}"></script>

    <style>
        /* table{
            border: 1px solid #000000;
            font-style: normal;
        }
        thead{
            border: 1px solid #000000;
            text-align: center;
            font-weight: bold;
        }
        th{
            border: 1px solid #000000;
            text-align: center;
            font-weight: bold;
        }
        tr{
            border: 1px solid #000000;
            text-align: center;
        }
        td{
            border: 1px solid #000000;
            text-align: center;
        } */
    </style>
    <title>Print PDF</title>
</head>
<body>
    <h1>Lampiran Claim Visit</h1>
    <button onclick="window.print()">Print</button>
    {{-- <div class="card"> --}}
        {{-- <h5 class="card-header">Table Basic</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Tanggal Kunjungan</th>
                <th>Username</th>
                <th>Kunjungan Toko</th>
                <th>Kunjungan Gerai</th>
                <th>Total Kunjungan</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($data as $number => $row)
                    <tr>
                        <td>{{ $number+1 }}</td>
                        <td>{{ date('d M Y',strtotime($row->date)) }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->store_visit }}</td>
                        <td>{{ $row->outlet_visit }}</td>
                        <td>{{ $row->total_visit }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div> --}}

      {{-- </div> --}}
    {{-- <div class="row mb-5">
        @foreach ($data as $row)
            <div class="col-md-3">
                <div class="card mb-3">
                @if ($row->customer->type == 'S')
                    @foreach ($row->foto->where('type', 'V') as $fotos)
                        <img class="card-img-top" src="{{ asset($fotos == NULL ? '' : $fotos->file_name) }}" alt="Card image cap">
                    @endforeach
                @else
                    @foreach ($row->foto->where('type', 'S') as $fotos)
                        <img class="card-img-top" src="{{ asset($fotos == NULL ? '' : $fotos->file_name) }}" alt="Card image cap">
                    @endforeach
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $row->customer->code }} - {{ $row->customer->code }}<h5>
                    <p class="card-text">
                    {{ $row->customer->address }}
                    </p>
                    <p class="card-text">
                    <small class="text-muted">{{ $row->created_at }}</small>
                    </p>
                </div>
                </div>
            </div>
        @endforeach
    </div> --}}

    @foreach ($data as $n => $row)
    <table>
        <thead>
            <tr>
                <td>Tanggal : {{ date('d F Y', strtotime($row->date)) }}</td>
            </tr>
            <tr>
                <td>Nama : {{ $row->user->name }}</td>
            </tr>
        </thead>
        {{-- @foreach ($foto->where('type', 'V') as $row) --}}
        <tbody>
            <tr>
                {{-- @if ($row->customer->type == 'S')
                    @foreach ($foto->where('type', 'V') as $fotos)
                    <td style="margin-right: 5px;margin-bottom: 5px">
                        <img src="{{ asset($fotos->file_name) }}" alt="" style="height: 350px;width: 250px"><br>
                        {{ $row->headerVisit->customer->code }} - {{ $row->headerVisit->customer->name }}
                    </td>
                    @endforeach
                @else
                    @foreach ($foto->where('type', 'S') as $fotos)
                    <td style="margin-right: 5px;margin-bottom: 5px">
                        <img src="{{ asset($fotos->file_name) }}" alt="" style="height: 350px;width: 250px"><br>
                        {{ $row->headerVisit->customer->code }} - {{ $row->headerVisit->customer->name }}
                    </td>
                    @endforeach
                @endif --}}

            @if ($row->headerVisit->customer->type == 'S')
                @foreach ($foto->where('type', 'V') as $fotos)
                    <td style="margin-right: 5px;margin-bottom: 5px">
                        <img src="{{ asset($fotos->file_name) }}" alt="" style="height: 350px;width: 250px"><br>
                        {{ $row->headerVisit->customer->code }} - {{ $row->headerVisit->customer->name }}
                    </td>
                @endforeach
            @else
                @foreach ($foto->where('type', 'S') as $fotos)
                    <td style="margin-right: 5px;margin-bottom: 5px">
                        <img src="{{ asset($fotos->file_name) }}" alt="" style="height: 350px;width: 250px"><br>
                        {{ $row->headerVisit->customer->code }} - {{ $row->headerVisit->customer->name }}
                    </td>
                @endforeach
            @endif
            
            </tr>
        </tbody>
        {{-- @endforeach --}}
    </table>
    @endforeach

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}

    <script src="{{ asset('template/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('template/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('template/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('template/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('template/assets/js/dashboards-analytics.js') }}"></script>
</body>
</html>