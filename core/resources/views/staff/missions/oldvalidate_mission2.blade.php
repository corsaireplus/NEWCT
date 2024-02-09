@extends('staff.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
        <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
            <div class="card-body">
                <h5 class="mb-20 text-muted">@lang('Chauffeur')</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <span class="font-weight-bold">{{__($courierInfo->mission->chauffeur->firstname)}}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <span class="font-weight-bold">{{__($courierInfo->mission->chauffeur->mobile)}}</span>
                    </li>

                </ul>
            </div>
        </div>

    </div>

    <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12 mt-10">
        <form action="{{route('staff.transactions.store')}}" method="POST">
            @csrf
            <div class="row mb-30">
                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Expediteur')</h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">

                                    <span>{{__($courierInfo->client->nom)}}</span>
                                    <input type="hidden" name="sender_id" id="sender_id" value="{{$courierInfo->client->id}}">
                                    </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">

                                    <span>{{__($courierInfo->client->contact)}}</span>
                                </li>
                                @if($courierInfo->adresse->adresse)
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                    <span>{{__($courierInfo->adresse->adresse)}}</span>
                                </li>
                                @endif
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                    @if($courierInfo->adresse->code_postal)
                                    <span>{{__($courierInfo->adresse->code_postal)}}</span>
                                    @else
                                    <span>Aucun Code Postal </span>
                                    @endif
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                    <span>RDV Ref : {{__($courierInfo->code)}}</span>
                                    <input type="hidden" name="refrdv" id="refrdv" value="{{$courierInfo->code}}">

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Destinataire')</h5>
                        <div class="card-body">
                                      <div class="row">
                                            <div class="form-group col-lg-12">
                                               
                                                <input type="text" class="form-control" name="reference" id="reference" placeholder="@lang(" Reference Souche")"
                                                 value="{{old('reference')}}"   style="background-color : green; color: #ffffff"
                                                    >
                                            </div>
                                            <div class="form-group col-lg-12">
                                                
                                                <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" placeholder="@lang(" Téléphone")" 
                                                    value="{{ old('receiver_customer_phone') }}" id="receiver_phone"
                                                    >
                                            </div>
                                            <div class="form-group col-lg-12">
                                                
                                                <input type="text" class="form-control"
                                                id="receiver_name" name="receiver_name" value="{{old('receiver_name')}}" placeholder="@lang(" Nom Destinataire")" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="form-group col-lg-6">
                                                <input type="text" class="form-control"d="receiver_adresse" name="receiver_adrresse" value="{{old('receiver_adresse')}}" placeholder="@lang(" Adresse")" >
                                             </div>

                                                <div class="form-group col-lg-6">
                                                    <select class="form-control" name="branch" id="branch" required="">
                                                        @foreach($branchs as $branch)
                                                        <option value="{{$branch->id}}">{{__($branch->name)}}</option>
                                                        @endforeach
                                                    </select>  
                                                </div>
                                            </div>
                                  
                            
                        </div>
                    </div>
                </div>

            </div>
    </div>

<div class="row mb-none-30">
    <div class="col-lg-12">
        <div class="card border--dark">
            <h5 class="card-header bg--dark">@lang('Information Envoi') 
            <button type="button"
                                            class="btn btn-sm btn-outline-light float-end addUserData"><i
                                                class="la la-fw la-plus"></i>@lang('Ajouter')
                                        </button>
            </h5>

            <div class="card-body">
            <div class="row" id="addedField">
                                        @foreach ($courierInfo->courierDetail as $item)
                                            <div class="row single-item gy-2">
                                            <div class="col-md-2">
                                                    <select class="form-control " id="rdv_type_{{$item->id}}" name="items[{{ $loop->index}}][rdvName]"  onChange="getType(this.value,{{$item->id}});">
                                                        <option>@lang('Choisir')</option>
                                                        <option value="1" {{ $item->rdv_type_id == 1 ?  'selected' : '' }}>ENVOI</option>
                                                        <option value="2" {{ $item->rdv_type_id == 2 ?  'selected' : '' }}>DEPOT</option>
                                                        <option value="0" {{ $item->rdv_type_id == 0 ?  'selected' : '' }}>FRAIS</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control select select2 selected_type" name="items[{{ $loop->index}}][type]" required>
                                                        <option disabled selected value="">@lang('Select Courier/Parcel Type')</option>
                                                        @foreach($types as $type)
                                                            <option value="{{$type->id}}" @selected($item->type->id==$type->id)
                                                                data-unit="{{$type->unit->name}}" data-price="{{ getAmount($type->price)}}"  >
                                                                {{__($type->name)}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                               
                                                <div class="col-md-3">
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control quantity" value="{{ $item->qty }}"  name="items[{{ $loop->index }}][quantity]"  required>
                                                        <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input type="text"  class="form-control single-item-amount" value="{{getAmount($item->fee)}}"  name="items[{{ $loop->index }}][amount]" required readonly>
                                                        <span class="input-group-text">{{__($general->cur_text)}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
 						                @endforeach
                                    </div>
                <!-- <div class="row addedField">
                
                 @foreach($courierInfo->courierDetail as $courier)
                    <div class="row single-item gy-2 user-data">
                          
                                <div class="col-md-2">
                                    <select class="form-control " id="rdv_type_{{$courier->id}}" name="rdvName[]" onChange="getType(this.value,{{$courier->id}});">
                                        <option>@lang('Choisir')</option>
                                        <option value="1" {{ $courier->rdv_type_id == 1 ?  'selected' : '' }}>ENVOI</option>
                                        <option value="2" {{ $courier->rdv_type_id == 2 ?  'selected' : '' }}>DEPOT</option>
                                        <option value="0" {{ $courier->rdv_type_id == 0 ?  'selected' : '' }}>FRAIS</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control select2" id="courier_type_{{$courier->id}}" onchange="currierType({{$courier->id}})" name="courierName[]">
                                    <option id="opt_{{$courier->type->id}}" value="{{$courier->type->id}}" 'selected'  data-unit="{{$courier->type->unit->name}}" data-price={{ getAmount($courier->type->price)}}>{{__($courier->type->name)}}</option>
                                      @foreach($types as $type)
                                        <option id="{$type->id}}" value="{{$type->id}}"  data-unit="{{$type->unit->name}}" data-price={{ getAmount($type->price)}}>{{__($type->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg quantity currier_quantity_{{$courier->id}}" value="{{$courier->qty}}" name="quantity[]" onkeyup="courierQuantity({{$courier->id}})" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                        <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <input type="text" id="amount" class="form-control form-control-lg currier_fee_{{$courier->id}} montant" value="{{getAmount($courier->fee)}}" name="amount[]" aria-label="Frais" aria-describedby="basic-addon2" required="">
                                        <span class="input-group-text">{{ __($general->cur_text) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                        <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button"><i class="fa fa-times"></i></button>
                                </div>

                          </div>
                    @endforeach
                </div> -->
            </div>

         </div>

            </div>
            <div class="clearfix"></div>
            <div class="col-lg-12">
                <div class="card border--primary mt-3">
            <h5 class="card-header bg--primary  text-white">@lang('Information Paiement')

            </h5>

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>@lang('TOTAL A PAYER')</label>
                        <input type="text" style="background-color :red; color :#ffffff" class="form-control" id="total_paye" value="{{old('total_paye')}}" name="total_payer" placeholder="@lang(" Total a Payer")" maxlength="40" required="">
                    </div>
                    <div class="form-group col-lg-4">
                        <label>@lang('MONTANT PAYER')</label>
                        <input type="text" style="background-color : green; color :#ffffff" class="form-control" id="montant_payer" name="montant_payer" value="{{old('montant_payer')}}" placeholder="@lang(" Montant Payer ")" maxlength="40" required="">
                    </div>
                    <div class="form-group col-lg-4">
                        <label>@lang('MODE PAIEMENT')</label>
                        <select class="form-control" id="mode" name="mode" required>
                            <option value="1">ESPECE</option>
                            <option value="2">CHEQUE</option>
                            <option value="3">CARTE BANCAIRE</option>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="inputMessage">@lang('Note')</label>
                        <textarea name="message" id="observation" rows="6" class="form-control form-control-lg" placeholder="@lang('Observation ou Note')">{{old('message')}}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn--primary h-45 w-100 Submitbtn"> @lang('Submit')</button>
            </div>
        </form>
        </div>
    </div>
</div>
</div>
</div>

@endsection

@push('breadcrumb-plugins')
<a href="{{ route('staff.mission.detailmission', encrypt($courierInfo->mission_id)) }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i>@lang('Retour')</a>
@endpush
@push('script')
<script>
    "use strict";
    $(document).ready(function() {
        var sum = 0;
        // or $( 'input[name^="ingredient"]' )
        $('.montant').each(function(i, e) {
            var v = parseInt($(e).val());
            if (!isNaN(v))
                sum += v;
            console.log('total ' + sum);
        });
        $("#total_paye").val(sum);
        $(document).on('click', '.removeBtnold', function() {
            $(this).closest('.user-data').remove();
        });
    });
    
    $('.montant').keyup(function() {
        var sum = 0;
        $('.montant').each(function(i, e) {
            var v = parseInt($(e).val());
            if (!isNaN(v))
                sum += v;
            console.log('montant modifie  ' + sum);
        });
        $("#total_paye").val(sum);
    });
    $('#receiver_phone').keyup(function() {
        var queryreciever = $(this).val();

        if (queryreciever != '' && queryreciever.length == 10) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('staff.rdv.fetchreceiver') }}",
                method: "POST",
                data: {
                    queryreciever: queryreciever,
                    _token: _token
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        $("#receiver_name").val(response.nom);
                        $("#receiver_adresse").val(response.adresse);
                        // $("#sender_code_postal").val(response.code_postal);
                    }

                }
            });
        }
    });
</script>
<script>
   function currierType(id) {
        let unit = $("#courier_type_" + id).find(':selected').data('unit');
        let price = $("#courier_type_" + id).find(':selected').data('price');
        $("#unit_" + id).html(unit);

        if ($('#courier_type_' + id).val()) {
            $(".currier_quantity_" + id).removeAttr("disabled");
        }
    }

    function courierQuantity(id) {
        let quantity = $(".currier_quantity_" + id).val();
        let price = $("#courier_type_" + id).find(':selected').data('price');
        $(".currier_pu_" + id).val(price);
        $(".currier_fee_" + id).val(quantity * price);

        var sum = 0;
        // or $( 'input[name^="ingredient"]' )
        $('.montant').each(function(i, e) {
            var v = parseInt($(e).val());
            if (!isNaN(v))
                sum += v;
            console.log('total apres ' + sum);
        });
        $("#total_paye").val(sum);
    }

    function getType(val, id) {
        var base_url = "{{ url('/') }}";
        $.ajax({

            type: 'POST',
            url: base_url + '/staff/mission/get_type',
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

    function changeMontant(id) {
        var sum = 0;
        // or $( 'input[name^="ingredient"]' )
        $('.montant').each(function(i, e) {
            var v = parseInt($(e).val());
            if (!isNaN(v))
                sum += v;
            console.log('total changeMontant ' + sum);
        });
        $("#total_paye").val(sum);
    }
    $(document).ready(function() {
        let id = 100;
        $('.addUserData').on('click', function() {
            id++;
            let html = `<div class="col-md-12 user-data">
                            <div class="form-group">
                             <div class="input-group mb-md-0 mb-4">
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <select class="form-control form-control-lg" id="rdv_type_${id}"  name="rdvName[]"  onChange="getType(this.value,${id});" required="">
                                            <option>@lang('Choisir')</option>
                                               <option value="1" >ENVOI</option>
                                               <option value="0" >FRAIS</option>
                                                <option value="2" >DEPOT</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <select class="form-control select_${id} form-control-lg" id="courier_type_${id}" onchange="currierType(${id})" name="courierName[]" required="">
                                            <option>@lang('Choisir')</option>
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control form-control-lg quantity currier_quantity_${id}" placeholder="@lang('Qté')" disabled="" onkeyup="courierQuantity(${id})" name="quantity[]" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="unit_${id}"><i class="las la-balance-scale"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 mt-md-0 mt-2">
                                       <div class="input-group mb-2">
                                            <input type="text" id="amount" class="form-control form-control-lg currier_fee_${id}  montant" placeholder="@lang('Frais')" onkeyup="changeMontant(${id})" name="amount[]" aria-label="Frais" aria-describedby="basic-addon2" required="" >
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                            </div>
                                        </div>
                                    </div>

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