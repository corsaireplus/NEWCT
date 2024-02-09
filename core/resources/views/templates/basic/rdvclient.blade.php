@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')

    <div class="rdvclient-section pt-120 pb-120">
    
        <div class="container">
        <form class="rdvclient-form" action="" method="POST">
                        @csrf
            <div class="row align-items-center justify-content-between">
               <div class="section__header">
                        <span class="section__cate">{{__(@$contact->data_values->title)}}</span>
                        <h3 class="section__title">{{__(@$contact->data_values->heading)}}</h3>
                        <p>
                            {{__(@$contact->data_values->sub_heading)}}
                        </p>
                    </div>
                
                <div class="col-lg-6">
                    <!-- <img src="{{getImage('assets/images/frontend/contact_us/'. @$contact->data_values->rdv_image, '653x612')}}" alt="@lang('contact')"> -->
                    <div class="form-group mb-3">
                            <label for="name" class="form--label">@lang('Telephone')</label>
                            <input type="text" class="form-control form--control" id="phone" name="sender_phone" value="{{old('sender_phone')}}" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form--label">@lang('Nom & Prenom')</label>
                            <input type="text" class="form-control form--control" id="sender_name" name="sender_name" value="{{old('sender_name')}}" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form--label">@lang('Code Postal')</label>
                            <input type="text" class="form-control form--control" id="sender_code_postal" name="sender_code_postal" value="{{old('sender_code_postal')}}" required="">
                        </div>
                        
                        
                </div>
                <div class="col-lg-6">
                   
                   
                        <div class="form-group mb-3">
                            <label for="name" class="form--label">@lang('Adresse')</label>
                            <input type="text" class="form-control form--control" id="sender_address" name="sender_address" value="{{old('sender_address')}}" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form--label">@lang('Date Souhaitée')</label>
                            <input type="date" class="form-control form--control" id="date" name="date" value="{{old('date')}}" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form--label">@lang('Remarque')</label>
                            <input type="text" class="form-control form--control" id="observation" name="observation" value="{{old('observation')}}">
                        </div>
                       
                        
                    
                </div>

                <div class="col-lg-12">
                            <div class="card border-danger mt-3">
                                <h5 class="card-header bg-danger  text-white">@lang('Information RDV')
                                    <button type="button" class="btn btn-sm btn-outline-light float-right addUserData"><i class="la la-fw la-plus"></i>@lang('Ajouter plusieurs Lignes')
                                    </button>
                                </h5>
                                <div class="card-body">
                                <div class="row addedField">
                                            <div class="col-md-12 user-data">
                                                <div class="form-group">
                                                    <div class="input-group mb-md-0 mb-4">
                                                        <div class="col-md-4">
                                                            <select class="form-control form-control-lg rdvtype" id="rdv_type_0" name="rdvName[]" onChange="getType(this.value,0);">
                                                                <option>@lang('Choisir Type')</option>
                                                                <option value="1">ENLEVEMENT COLIS</option>
                                                                <option value="2">DEPOT CARTON/BARRIQUE</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">

                                                            <select class="form-control form-control-lg select3" id="courier_type_0" onchange="currierType(0)" name="courierName[]">
                                                                <option>@lang('Choisir Objet')</option>
                                                                <option></option>
                                                        
                                                            </select>
                                                        
                                                        </div>
                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control form-control-lg currier_quantity_0" placeholder="@lang('Quantité')" disabled="" name="quantity[]" onkeyup="courierQuantity(0)" aria-label="Recipient's username" aria-describedby="basic-addon2" >
                                                                
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="form-control form-control-lg currier_fee_0" name="amount[]" id="amount">
                                                        <!-- <div class="col-md-3 mt-md-0 mt-2">
                                                           <div class="input-group mb-3">
                                                                <input type="text" id="amount" class="form-control form-control-lg currier_fee_0" placeholder="@lang('Enter Price')" name="amount[]" aria-label="Recipient's username" aria-describedby="basic-addon2"  readonly="">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    <!-- <div class="row addedField">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <select class="form-control form--control rdvtype" id="rdv_type_0" name="rdvName[]" onChange="getType(this.value,0);">
                                                        <option>@lang('Choisir Type')</option>
                                                        <option value="1">RECUP</option>
                                                        <option value="2">DEPOT</option>


                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <select class="form-control form--control select3" id="courier_type_0"   onchange="currierType(0)" name="courierName[]">
                                                        <option>Choisir Objet</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">

                                                <div class="form-group mb-3">
                                                        <input type="text" class="form-control form--control currier_quantity_0" placeholder="@lang('Qté')"  name="quantity[]" onkeyup="courierQuantity(0)" aria-label="objet" aria-describedby="basic-addon2" >
                                                        
                                                </div>

                                                    <div class="form-group mb-3">
                                                        <input type="text" id="amount" class="form-control form--control currier_fee_0" placeholder="@lang('Prix')"  name="amount[]" aria-label="Prix Objet" aria-describedby="basic-addon2" >
                                                        
                                                    </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    
                                </div>


                            </div>

                            <div class="col-lg-6">
                            <div class="form-group mb-3">
                <label for="capatcha">Captcha</label>
                <div class="captcha">
                  <span>{!! app('captcha')->display($attributes = [], $options = ['lang'=> 'fr']) !!}</span>
                  <!-- <button type="button" class="btn btn-success refresh-cpatcha"><i class="fa fa-refresh"></i></button> -->
                </div>
               
                @error('g-recaptcha-response')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
                            </div>
                            <div class="form-group">
                            <button class="cmn--btn btn--lg rounded" type="submit">@lang('Envoyer Demande')</button>
                         </div>
                        
            
            </div>
        </form>
        </div>

    </div>
@endsection

@push('script')

<script>
    
    $(document).ready(function() {

        $(".select3").select2({
            allowClear:true,
            tags:true,
            placeholder:""});
        
    
    $('#phone').keyup(function() {
            var query = $(this).val();

            if (query != '' && query.length == 10) {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('rdvclient.fetch') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            $("#sender_name").val(response.nom);
                            $("#sender_address").val(response.adresse);
                            $("#sender_code_postal").val(response.code_postal);
                        }

                    }
                });
            }
        });

        $(document).on('click', 'li', function() {
            $('#country_name').val($(this).text());
            $('#countryList').fadeOut();
        });

        $('.select2-basic').select2({
            dropdownParent: $('.card-body'),
            tags:true,
            allowClear:true
        });
    });
</script>
<script>
    (function($) {
        "use strict";
        if (!$('.datepicker-here').val()) {
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
    "use strict";

    function rdvType(id) {

    }

    function currierType(id) {
        let unit = $("#courier_type_" + id).find(':selected').data('unit');
        let price = $("#courier_type_" + id).find(':selected').data('price');

        $("#unit_" + id).html(unit);

        if ($('#courier_type_' + id).val()) {

            $(".currier_quantity_" + id).removeAttr("disabled");
            $(".ccurrier_fee_" + id).removeAttr("disabled");

        }
    }

    function getType(val, id) {
        var base_url = "{{ url('/') }}";
        $.ajax({

            type: 'POST',
            url: base_url + '/rdvclient/get_type',
            data: {
                _token: "{{ csrf_token() }}",
                id: val,
            },

            success: function(data) {
                //$("#opt_"+id).hide();
                $("#courier_type_" + id).html(data);
            }
        }); 
    }

    function courierQuantity(id) {
        let quantity = $(".currier_quantity_" + id).val();
        let price = $("#courier_type_" + id).find(':selected').data('price');
        console.log(price);
        if(price != undefined){
            $(".currier_fee_" + id).val(quantity * price);
        }else{
            $(".currier_fee_" + id).val(quantity);
        }
        let rdv_type = $('#rdv_type_' + id).val();
       
       // $(".currier_fee_" + id).val(quantity * price);
       
    }


    $(document).ready(function() {
        let id = 0;
        $('.addUserData').on('click', function() {
            id++;
            let html = `<div class="col-md-12 user-data">
                            <div class="form-group">
                                <div class="input-group mb-md-0 mb-4">
                                <div class="col-md-4">
                                                            <select class="form-control rdvtype form-control-lg" id="rdv_type_${id}"  name="rdvName[]" onChange="getType(this.value,${id});">
                                                                <option>@lang('Choisir Type')</option>
                                                                <option value="1" >RECUP</option>
                                                                <option value="2" >DEPOT</option>
                                                            </select>
                                                        </div>
                                    <div class="col-md-4">
                                        <select class="form-control select_${id} form-control-lg" id="courier_type_${id}" onchange="currierType(${id})" name="courierName[]" >
                                            <option>@lang('Choisir Objet')</option>    
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-lg currier_quantity_${id}" placeholder="@lang('Quantité')"  onkeyup="courierQuantity(${id})" name="quantity[]" aria-label="Qté" aria-describedby="basic-addon2" >
                                           
                                        </div>
                                    </div>
                                    <input type="hidden"  class="form-control form-control-lg currier_fee_${id}" name="amount[]">
                                    

                                    <div class="col-md-1 mt-md-0 mt-2 text-right">
                                        <span class="input-group-btn">
                                            <button class="btn btn--danger btn-lg removeBtn w-100" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>`;
            $('.addedField').append(html)
            $(".select_"+id).select2({
            allowClear:true,
            tags:true,
            placeholder:""});
        });

        $(document).on('click', '.removeBtn', function() {
            $(this).closest('.user-data').remove();
        });
    });
</script>
@endpush