@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4> --}}

    <div class="row">
      <div class="col-md-6">

        <div class="card mb-4">
          <h5 class="card-header">Data Kunjungan Umum</h5>
          <!-- Form -->
          <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" value="{{ $headerVisit->customer->id }}" name="id_customer">
              <div class="row">
                <div class="mb-3 col-md-12">
                  <label for="code" class="form-label">Kode {{ $headerVisit->customer->type == 'S' ? 'Toko' : 'Gerai' }}</label>
                  <input class="form-control" type="text" id="code" name="code" value="{{ $headerVisit->customer->code }}" readonly/>
                </div>

                <div class="mb-3 col-md-12">
                    <label for="name" class="form-label">Nama</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{ $headerVisit->customer->name }}" readonly/>
                </div>

                <div class="mb-3 col-md-12">
                  <label for="name" class="form-label">Foto Kunjungan</label><br>
                  @if (empty($fotoVisit))
                    <b>Tidak ada foto</b>
                  @else
                    <img src="{{ asset($fotoVisit->file_name) }}" alt="" height="200" width="200"><br>
                  @endif
                </div>

                @if ($headerVisit->customer->type == 'S')
                <div class="col-md-12 mb-2">
                  <label class="text-light fw-semibold d-block">Spanduk</label>
                  <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="radio" id="banner" value="1" name="banner" required {{ $headerVisit->banner == 1 ? 'checked' : 'disabled'}}>
                    <label class="form-check-label" for="inlineRadio1">Terpasang</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="banner" value="0" name="banner" required {{ $headerVisit->banner == 0 ? 'checked' : 'disabled'}}>
                    <label class="form-check-label" for="inlineRadio2">Tidak ada</label>
                  </div>
                </div>
                
                <div class="col-md-12 mb-2">
                  <label class="text-light fw-semibold d-block">Aktifitas</label>
                  <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="radio" id="activity" value="Visit" name="activity" required {{ $headerVisit->activity == 'Visit' ? 'checked' : 'disabled'}}>
                    <label class="form-check-label" for="inlineRadio1">Kunjungan</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="activity" value="Maintenance" name="activity" required {{ $headerVisit->activity == 'Maintenance' ? 'checked' : 'disabled'}}>
                    <label class="form-check-label" for="inlineRadio2">Maintenance Display</label>
                  </div>
                </div>
                @else
                  <input type="hidden" value="0" name="banner">
                  <input type="hidden" value="Visit" name="activity">
                @endif

                <div class="mb-3 col-md-12">
                  <label for="note" class="form-label">Catatan Kunjungan</label>
                  <textarea name="note" rows="2" class="form-control" readonly>{{ $headerVisit->note }}</textarea>
                </div>
                
              </div>
          </div>
          <!-- /Form -->
        </div>

      </div>


      @if ($headerVisit->customer->type == 'S')
        <div class="col-md-6">

          <div class="card mb-4">
            <h5 class="card-header">Data Display Toko</h5>
            <!-- Form -->
            <div class="card-body">
                <div class="row">
                  <div class="mb-3 col-md-12">
                    <label for="code" class="form-label">Display Produk</label>
                    <select name="display[]" id="display" class="form-control" multiple="multiple" readonly>
                      @if (empty($displays))
                        <option>Tidak pasang display</option>
                      @else
                        @foreach ($displays as $display)
                          <option value="{{ $display->display_product_id }}">{{ $display->display->name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>

                  <div class="mb-3 col-md-12">
                    <label for="code" class="form-label">Kategori Produk</label>
                    <select name="category[]" id="category" class="form-control" multiple="multiple" readonly>
                      @if (empty($categories))
                        <option>Tidak ada kategori produk</option>
                      @else
                        @foreach ($categories as $category)
                          <option value="{{ $category->category_product_id }}">{{ $category->category->name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>

                  <div class="mb-3 col-md-12">
                    <label for="brand" class="form-label">Produk yang tersedia</label>
                    <select name="brand[]" id="brand" class="form-control" multiple="multiple" readonly>
                      @foreach ($products as $product)
                        <option value="{{ $product->brand_product_id }}">{{ $product->brand->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="mb-3 col-md-12">
                    <label for="name" class="form-label">Foto Display</label><br>
                    @if (empty($fotoDisplay))
                      <b>Tidak ada foto</b>
                    @else
                      <img src="{{ asset($fotoDisplay->file_name) }}" alt="" height="200" width="200"><br>
                    @endif
                  </div>

                  <div class="col-md-12 mb-2">
                    <label class="text-light fw-semibold d-block">Alasan tidak pasang display</label>
                    <select name="reason" class="form-control" multiple readonly>
                      @if (empty($reasonStore))
                        <option>Tidak ada alasan</option>
                      @else
                        @foreach ($reasonStore as $reason)
                          <option value="{{ $reason->unproductive_reason_id }}">{{ $reason->unproductive_reason->name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  
                </div>
                <div class="mt-2">
                  <a href="{{ route('visit.detail-daily', ['date' => $headerVisit->date, 'user' => $headerVisit->user_id ]) }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
              </form>
            </div>
            <!-- /Form -->
          </div>

        </div>
      @else
        <div class="col-md-6">

          <div class="card mb-4">
            <h5 class="card-header">Data Gerai</h5>
            <!-- Form -->
            <div class="card-body">
                <div class="row">
                  <div class="col-md-12 mb-2">
                    <label class="text-light fw-semibold d-block">Sudah Pakai Produk Hansel?</label>
                    <div class="form-check form-check-inline mt-3">
                      <input class="form-check-input" type="radio" id="status" value="Y" name="status" {{ $headerVisit->status_registration == 'Y' ? 'checked' : 'disabled' }}>
                      <label class="form-check-label" for="inlineRadio1">Sudah</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="status" value="M" name="status" {{ $headerVisit->status_registration == 'M' ? 'checked' : 'disabled' }}>
                      <label class="form-check-label" for="inlineRadio2">Sudah, Tetapi Pakai Produk Lain Juga</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="status" value="N" name="status" {{ $headerVisit->status_registration == 'N' ? 'checked' : 'disabled' }}>
                      <label class="form-check-label" for="inlineRadio2">Belum Sama Sekali</label>
                    </div>
                  </div>
                  <hr>

                  <label for="" class="form-label">Produk yang Dipakai Gerai</label>
                  <div id="TextBoxesGroup">
                    <div id="TextBoxDiv1">
                      <div class="mb-3 col-md-12">
                        <label for="usedProduct" class="form-label">Nama/Kode Produk</label>
                        <select class="form-control" name="usedProduct[]" id="product1" multiple readonly>
                        @if (empty($productUsed))
                          <option>Tidak ada produk</option>
                        @else
                          @foreach ($productUsed as $product)
                            <option value="{{ $product->product_id }}">{{$product->product->name.' - Rp. '.$product->purchase_price }}</option>
                          @endforeach
                        @endif
                        </select>
                      </div>
    
                    </div>
                  </div>
                
                  <hr>

                  <div class="mb-3 col-md-12">
                    <label for="store" class="form-label">Toko Beli yang Sudah Register</label>
                    <input type="text" class="form-control" value="{{ $storeBuy->customer->code.' - '.$storeBuy->customer->name }}" readonly>
                  </div>

                  <div class="mb-3 col-md-12">
                    <label for="store_name" class="form-label">Nama Toko Beli</label>
                    <input class="form-control" type="text" id="store_name" name="store_name" value="{{ $storeBuy->store_name }}" readonly/>
                  </div>

                  <div class="mb-3 col-md-12">
                    <label for="market_name" class="form-label">Pasar Beli</label>
                    <input class="form-control" type="text" id="market_name" name="market_name" value="{{ $storeBuy->market_name }}" readonly/>
                  </div>

                  <div class="mb-3 col-md-12">
                    <label for="mark" class="form-label">Patokan Toko Beli</label>
                    <textarea name="mark" id="mark" rows="3" class="form-control" readonly>{{ $storeBuy->mark }}</textarea>
                  </div>

                  <div class="col-md-12 mb-2">
                    <label class="fw-semibold d-block">Alasan Pakai Produk/Belum Pakai Produk</label>
                    <select name="reason" class="form-control" readonly multiple>
                      @if (empty($reasonOutlet))
                        <option>Tidak ada alasan</option>
                      @else
                        @foreach ($reasonOutlet as $reason)
                          <option value="{{ $reason->unproductive_reason_id }}">{{ $reason->unproductive_reason->name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>

                  <div class="mb-3 col-md-12">
                    <label for="sales_amount" class="form-label">Qty Penjualan Perhari</label>
                    <input class="form-control" type="number" id="sales_amount" name="sales_amount" value="{{ $storeBuy->sales_amount }}" multiple readonly/>
                  </div>

                  <label for="" class="form-label">Sampel Produk yang Diberikan ke Gerai</label>
                      <div class="mb-3 col-md-12">
                        <label for="usedProduct" class="form-label">Nama/Kode Produk</label>
                        <select class="form-control" name="sample[]" id="sample" multiple readonly>
                          @if (empty($sample))
                            <option>Tidak ada produk yang diberikan</option>
                          @else
                            @foreach ($sample as $gift)
                              <option value="{{ $gift->product_id }}">{{ $gift->product->name.' - '.$gift->qty.' pcs' }}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>

                      <div class="mb-3 col-md-12">
                        <label for="name" class="form-label">Foto Penyerahan Sampel</label><br>
                        @if (empty($fotoCampaign))
                          <b>Tidak ada foto</b>
                        @else
                          <img src="{{ asset($fotoCampaign->file_name) }}" alt="" height="200" width="200"><br>
                        @endif
                      </div>
                    <br>
                  
                </div>
                <div class="mt-2">
                  <a href="{{ route('visit.detail-daily', ['date' => $headerVisit->date, 'user' => $headerVisit->user_id ]) }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
              </form>
            </div>
            <!-- /Form -->
          </div>

        </div>
      @endif
      
    </div>
  </div>
@endsection

@push('geolocation')
  <script>
    getLocation();
    function showPosition(position) {
        document.getElementById('lat').value = position.coords.latitude;
        document.getElementById('lon').value = position.coords.longitude;
      }
  </script>
@endpush

@push('select2')
  {{-- <script type="text/javascript">
    $(document).ready(function(){
      var displayPath = "{{ route('display.autocomplete') }}";
      var categoryPath = "{{ route('category.autocomplete') }}";
      var brandPath = "{{ route('brand.autocomplete') }}";
      var storePath = "{{ route('store.autocomplete') }}";
      var productPath = "{{ route('product.autocomplete') }}";
      var counter = 2;
    
      $('#display').select2({
          placeholder: 'Pilih display produk',
          ajax: {
            url: displayPath,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
              return {
                results:  $.map(data, function (item) {
                      return {
                          text: item.name,
                          id: item.id
                      }
                  })
              };
            },
            cache: true
          }
      });

      $('#category').select2({
          placeholder: '--Pilih kategori produk--',
          ajax: {
            url: categoryPath,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
              return {
                results:  $.map(data, function (item) {
                      return {
                          text: item.name,
                          id: item.id
                      }
                  })
              };
            },
            cache: true
          }
      });

      $('#brand').select2({
          placeholder: '--Pilih brand produk yang tersedia di toko--',
          ajax: {
            url: brandPath,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
              return {
                results:  $.map(data, function (item) {
                      return {
                          text: item.name,
                          id: item.id
                      }
                  })
              };
            },
            cache: true
          }
      });

      $('#store').select2({
          placeholder: '--Pilih toko yang sudah register--',
          theme: 'form-control',
          ajax: {
            url: storePath,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
              return {
                results:  $.map(data, function (item) {
                      return {
                          text: item.name + ' - ' + item.address,
                          id: item.id
                      }
                  })
              };
            },
            cache: true
          }
      });

      $('#product1').select2({
          placeholder: '--Pilih produk--',
          ajax: {
          url: productPath,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                return {
                  text: item.name,
                  id: item.id
                }
              })
            };
          },
          cache: true
          }
      });

      $('#sample').select2({
          placeholder: '--Pilih produk--',
          ajax: {
          url: productPath,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                return {
                  text: item.code+' - '+item.name,
                  id: item.id
                }
              })
            };
          },
          cache: true
          }
      });

      $("#addButton").click(function () {
                      
        var newTextBoxDiv = $(document.createElement('div'))
          .attr("id", 'TextBoxDiv' + counter);
                                  
        newTextBoxDiv.after().html(
            '<div class="mb-3 col-md-12">'+
              '<label for="product" class="form-label">Nama/Kode Produk</label>'+
              '<select class="form-control" name="usedProduct[]" id="product'+counter+'"></select>'+
            '</div>'+
      
            '<div class="mb-3 col-md-12">'+
              '<label for="purchaseAmount" class="form-label">Harga Beli</label>'+
              '<input type="number" class="form-control" name="purchaseAmount[]" id="purchaseAmount'+counter+'">'+
            '</div><br>'
          )
                              
                              
        newTextBoxDiv.appendTo("#TextBoxesGroup");

        $('#product'+counter).select2({
          placeholder: 'Pilih produk',
          ajax: {
          url: productPath,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                return {
                  text: item.code+' - '+item.name,
                  id: item.id
                }
              })
            };
          },
          cache: true
          }
        });
        counter++;
      });

      $("#removeButton").click(function () {
        if(counter==1){
          alert("Tidak ada textfield lagi");
            return false;
        }   
                      
        counter--;
                          
        $("#TextBoxDiv" + counter).remove();
                          
        });
                      
        $("#getButtonValue").click(function () {
          var msg = '';
          for(i=1; i<counter; i++){
            msg += "\n Textbox #product" + i + " : " + $('#product' + i).val();
            msg += "\n Textbox #purchaseAmount" + i + " : " + $('#purchaseAmount' + i).val();
            // msg += "\n Textbox name usedProduct : "+$("input[name='usedProduct[]']").val();
            // msg += "\n Textbox name purchaseAmount : "+$("input[name='purchaseAmount[]']").val();
          }
          alert(msg);
      });
    });
  </script> --}}
@endpush
