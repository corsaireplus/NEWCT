@extends('staff.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form action="{{route('staff.rdv.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="rdvcode" value="{{$courierInfo->code}}" />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Information Client')</h5>
                                <div class="card-body">
                                    <div class="row">
                                    <div class="form-group col-lg-6">
                                            <label>@lang('Telephone')</label>
                                            <input type="text" class="form-control" id="phone" value="{{$courierInfo->sender->contact}}" name="sender_phone" maxlength="40" required="">
                                            <ul class="search-list" id="suggestions-list"></ul>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>@lang('Nom')</label>
                                            <input type="text" class="form-control" id="sender_name" name="sender_name" value="{{$courierInfo->sender->nom}}" maxlength="40" required="">
                                        </div>

                                      
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6 autocomplete">
                                            <label>@lang('Adresse')</label>
                                            <input type="text" class="form-control" id="sender_address" name="sender_address" value="{{ optional($courierInfo->adresse)->adresse ?? 'N/A' }}" maxlength="255" required="">
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <label>@lang('Code postal')</label>
                                            <input type="text" class="form-control form-control-lg" id="sender_code_postal" name="sender_code_postal" value="{{ optional($courierInfo->adresse)->code_postal ?? 'N/A' }}" maxlength="255" required="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Date')</label>
                                            <input name="date" type="text" data-range="true" data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Date Rdv')" autocomplete="off" value="{{ date('d-m-Y', strtotime($courierInfo->date)) }}">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label >@lang('Observation')</label>
                                            <input name="observation" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="@lang('Observation')" autocomplete="off" value="{{ $courierInfo->observation }}">
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div class="row mb-30">
                                <div class="col-lg-12">
                                    <div class="card border--primary mt-3">
                                        <h5 class="card-header bg--primary  text-white">@lang('Information RDV')
                                        <button type="button" class="btn btn-sm btn-outline-light float-end addUserData"><i
                                            class="la la-fw la-plus"></i>@lang('Ajouter')
                                    </button>
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row addedField">
                                            @foreach($courierInfo->courierDetail as $courier)
                                            <div class="row single-item gy-2 user-data">
                                                        <div class="col-md-2">
                                                            <select class="form-control selected_type" id="rdv_type_{{$courier->id}}" onChange="getType(this.value,{{$courier->id}});" name="rdvName[]">
                                                                <option>@lang('Choisir')</option>
                                                                <option value="1" {{ $courier->rdv_type_id == 1 ?  'selected' : '' }}>RECUP</option>
                                                                <option value="2" {{ $courier->rdv_type_id == 2 ?  'selected' : '' }}>DEPOT</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select class="form-control select3  form-control-lg" id="courier_type_{{$courier->id}}" onchange="currierType({{$courier->id}})" name="courierName[]">

                                                                <option id="opt_{{$courier->type->id}}" value="{{$courier->type->id}}" 'selected' data-unit="{{$courier->type->unit->name}}" data-price={{ getAmount($courier->type->price)}}>{{__($courier->type->name)}}</option>

                                                                @foreach($types as $type)
                                                                <option id="{$type->id}}" value="{{$type->id}}" data-unit="{{$type->unit->name}}" data-price={{ getAmount($type->price)}}>{{__($type->name)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control form-control-lg currier_quantity_{{$courier->id}}" value="{{$courier->qty}}" name="quantity[]" onkeyup="courierQuantity({{$courier->id}})" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                                                <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 ">
                                                            <div class="input-group mb-3">
                                                                <input type="text" id="amount" class="form-control form-control-lg currier_fee_{{$courier->id}}" value="{{getAmount($courier->fee)}}" name="amount[]" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                                                <span class="input-group-text">{{__($general->cur_text)}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                    </div>
                                                </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>




                        </div>
                        <button type="submit" class="btn btn--primary h-45 w-100 Submitbtn"> @lang('Modifier RDV')</button>

                    </div>

                   
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<x-back route="{{route('staff.rdv.list')}}" />
@endpush
@push('script-lib')
<script src="{{asset('assets/viseradmin/js/vendor/datepicker.min.js')}}"></script>
<script src="{{asset('assets/viseradmin/js/vendor/datepicker.en.js')}}"></script>
@endpush
@push('style-lib')
    <link  rel="stylesheet" href="{{asset('assets/viseradmin/css/vendor/datepicker.min.css')}}">
@endpush
@push('script')s
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

        }
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

    function courierQuantity(id) {
        let quantity = $(".currier_quantity_" + id).val();
        let price = $("#courier_type_" + id).find(':selected').data('price');
        let rdv_type = $('#rdv_type_' + id).val();
        $(".currier_fee_" + id).removeAttr("disabled");
        $(".currier_fee_" + id).val(quantity * price);

    }
    $(document).ready(function() {
        let id = 100;
        $(document).on('click', '.removeBtnold', function() {
            $(this).closest('.user-data').remove();
        });
        $('.addUserData').on('click', function() {
            id++;
            let html = `<div class="row single-item gy-2 user-data">
                            
                                <div class="col-md-2">
                                                            <select class="form-control selected_type" id="rdv_type_${id}" onChange="getType(this.value,${id});"  name="rdvName[]">
                                                                <option>@lang('Choisir')</option>
                                                                <option value="1" >RECUP</option>
                                                                <option value="2" >DEPOT</option>
                                                            </select>
                                                        </div>
                                    <div class="col-md-3">
                                        <select class="form-control select_${id}  selected_type" id="courier_type_${id}" onchange="currierType(${id})" name="courierName[]" required="">
                                            <option>@lang('Choisir Type')</option>
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}" data-unit="{{$type->unit->name}}" data-price={{ getAmount($type->price)}}>{{__($type->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-lg currier_quantity_${id}" disabled placeholder="@lang('Qté')" onkeyup="courierQuantity(${id})" name="quantity[]" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                            <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                       <div class="input-group mb-3">
                                            <input type="text" id="amount" class="form-control form-control-lg currier_fee_${id}" disabled placeholder="@lang('Frais')" name="amount[]" aria-label="Frais" aria-describedby="basic-addon2" required="">
                                            <span class="input-group-text">{{__($general->cur_text)}}</span>

                                        </div>
                                    </div>

                                    <div class="col-md-1">
                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                        </div>`;
            $('.addedField').append(html)
        });

        $(document).on('click', '.removeBtn', function() {
            $(this).closest('.user-data').remove();
        });
    });
</script>
<script>
    $(document).ready(function () {
    var $adresseInput = $('#sender_address');
    var $suggestionsList = $('#suggestions-list');
    var $codePostalInput = $('#sender_code_postal');
    var suggestions;
    var base_url = "{{ url('/') }}";
   // var $suggestionsList = $('#suggestions-list');

    // Fonction pour mettre à jour la liste de suggestions
    function updateSuggestions(suggestionsData) {
        $suggestionsList.empty();

        suggestions = suggestionsData; // Mettez à jour la variable suggestions

        if (suggestions.length === 0) {
            $suggestionsList.hide();
            return;
        }

        suggestions.forEach(function (suggestion) {
            var listItem = $('<li>').text(suggestion.adresse);
            $suggestionsList.append(listItem);
        });

        $suggestionsList.show();
    }

    // Écouter les saisies dans le champ d'adresse
    $adresseInput.on('input', function () {
        var search = $(this).val().toLowerCase();
        var clientId = $('input[name="client_id"]').val();
        // Récupérer les suggestions via une requête AJAX
        $.get(base_url + '/staff/get-client-addresses/' + clientId, { query: search }, function (data) {
            // Mettre à jour la liste de suggestions
            updateSuggestions(data);
        });
    });

    // Gérer la sélection d'une suggestion depuis la liste
    $suggestionsList.on('click', 'li', function () {
        var selectedSuggestion = $(this).text();

        // Remplir le champ d'adresse
        $adresseInput.val(selectedSuggestion);

        // Trouver le code postal correspondant à l'adresse sélectionnée
        var selectedAddressWithPostalCode = suggestions.find(function (suggestion) {
            return suggestion.adresse === selectedSuggestion;
        });

        // Remplir le champ de code postal
        if (selectedAddressWithPostalCode) {
            $codePostalInput.val(selectedAddressWithPostalCode.code_postal);
        }

        $suggestionsList.hide();
    });

    // Cacher la liste de suggestions lorsqu'on clique à l'extérieur
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.autocomplete').length) {
            $suggestionsList.hide();
        }
    });
});
</script>
@endpush