@extends('staff.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                 <form action="{{route('staff.transactions.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="mission_id" id="mission_id" value="{{$mission_id}}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Expediteur')</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Contact')</label>
                                            <input type="text" class="form-control" id="phone" value="{{old('sender_phone')}}" name="sender_phone" maxlength="40" required="">
                                           

                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Nom')</label>
                                            <input type="text" class="form-control" id="sender_name" name="sender_name" value="{{old('sender_name')}}" placeholder="@lang(" Expediteur")" maxlength="40" required="">
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Adresse')</label>
                                            <input type="text" class="form-control" id="sender_address" value="{{old('sender_address')}}" name="sender_address" maxlength="40" required="">
                                            <ul  id="suggestions-list"></ul>


                                        </div>
                                        <input type="hidden" id="client_id" name="client_id">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Code Postal')</label>
                                            <input type="text" class="form-control" id="sender_code_postal" name="sender_code_postal" value="{{old('sender_code_postal')}}" placeholder="@lang(" Code Postal")" maxlength="40" required="">
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Reference')</label>
                                            <input type="text" style="background-color : green; color: #ffffff" class="form-control form-control-lg" id="reference" name="reference" value="{{old('reference')}}" maxlength="40">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Type Envoi')</label>
                                            <select class="form-control" name="envoi" id="envoi" required="">
                                                <option value="1">Maritime</option>
                                                <option value="2">Aerien</option>

                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Destinataire')</h5>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-lg-12">
                                            <label>@lang('Contact')</label>
                                            <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" value="{{old('receiver_phone')}}">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>Nom</label>
                                            <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="{{old('receiver_name')}}" maxlength="40">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Adresse')</label>
                                            <input type="text" class="form-control" id="receiver_address" name="receiver_address"  value="{{old('receiver_address')}}" >
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Destination')</label>
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

                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Information Colis')
                                <button type="button" class="btn btn-sm btn-outline-light float-end addUserData"><i class="la la-fw la-plus"></i>@lang('Ajouter')</button>
                                </h5>

                                <div class="card-body">
                                            <div class="row addedField" id="addedField">
                                                
                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary text-white">@lang('Information Paiement')</h5>
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
                                            <option value="3">VIREMENT</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="inputMessage">@lang('Note')</label>
                                            <textarea name="message" id="observation" rows="6" class="form-control form-control-lg" placeholder="@lang('Observation ou Note')">{{old('message')}}</textarea>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                    <button type="submit" class="btn btn--primary h-45 w-100 Submitbtn"> @lang('Submit')</button>

                             
                </div>
                   
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')

    <x-back route="{{ url()->previous()  }}" />

@endpush
@push('script-lib')
    <script src="{{asset('assets/viseradmin/js/vendor/datepicker.min.js')}}"></script>
    <script src="{{asset('assets/viseradmin/js/vendor/datepicker.en.js')}}"></script>
@endpush

@push('style-lib')
    <link  rel="stylesheet" href="{{asset('assets/viseradmin/css/vendor/datepicker.min.css')}}">
@endpush
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
                    url: "{{ route('staff.rdv.fetch') }}",
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
                            $("#client_id").val(response.client_id);
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


</script>

<script>
    "use strict";
    (function ($) {

        $('.addUserData').on('click', function () {
            let length=$("#addedField").find('.single-item').length;
            let html = `
            <div class="row single-item gy-2">
            <div class="col-md-2">
            <select class="form-control" id="rdv_type_${length}"  name="items[${length}][rdvName]"  onChange="getType(this.value,${length});" required="">
                                            <option>@lang('Choisir')</option>
                                               <option value="1" >ENVOI</option>
                                               <option value="0" >FRAIS</option>
                                                <option value="2" >DEPOT</option>
                                        </select>
            </div>
                <div class="col-md-3">
                    <select class="form-control select_${length} select2 selected_type" id="courier_type_${length}" onchange="currierType(${length})" name="items[${length}][courierName]" required>
                        <option disabled selected value="">@lang('Choisir')</option>
                           
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control quantity currier_quantity_${length}" placeholder="@lang('Quantité')" onkeyup="courierQuantity(${length})" disabled name="items[${length}][quantity]"  required>
                        <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" id="amount"  class="form-control single-item-amount currier_fee_${length}  montant"  onkeyup="changeMontant(${length})" placeholder="@lang('Prix')"  name="items[${length}][amount]" required>
                        <span class="input-group-text">{{__($general->cur_text)}}</span>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>`;
            $('#addedField').append(html)

             $(".select_"+length).select2({
            allowClear:true,
            tags:true,
            placeholder:""});

        });

        $('#addedField').on('change', '.selected_type', function (e) {
            let unit = $(this).find('option:selected').data('unit');
            let parent = $(this).closest('.single-item');
            $(parent).find('.quantity').attr('disabled', false);
            $(parent).find('.unit').html(`${unit || '<i class="las la-balance-scale"></i>'}`);
            calculation();
        });

        $('#addedField').on('click', '.removeBtn', function (e) {
            let length=$("#addedField").find('.single-item').length;
            if(length <= 1){
                notify('warning',"@lang('At least one item required')");
            }else{
                $(this).closest('.single-item').remove();
            }
            $('.discount').trigger('change');
            calculation();
        });

        let discount=0;

        $('.discount').on('input change',function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');
             discount=parseFloat($(this).val() || 0);
             if(discount >=100){
                discount=100;
                notify('warning',"@lang('Discount can not bigger than 100 %')");
                $(this).val(discount);
             }
            calculation();
        });

        $('#addedField').on('input', '.quantity', function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');

            let quantity = $(this).val();
            if (quantity <= 0) {
                quantity = 0;
            }
            quantity=parseFloat(quantity);

            let parent   = $(this).closest('.single-item');
            let price    = parseFloat($(parent).find('.selected_type option:selected').data('price') || 0);
            let subTotal = price*quantity;

            $(parent).find('.single-item-amount').val(subTotal.toFixed(2));


            var sum = 0;
                // or $( 'input[name^="ingredient"]' )
                $('.montant').each(function(i, e) {
                    var v = parseInt($(e).val());
                    if (!isNaN(v))
                        sum += v;
                    console.log('total apres ' + sum);
                });
                $("#total_paye").val(sum);
        });

        function calculation ( ) {
            let items    = $('#addedField').find('.single-item');
            let subTotal = 0;

            $.each(items, function (i, item) {
                let price = parseFloat($(item).find('.selected_type option:selected').data('price') || 0);
                let quantity = parseFloat($(item).find('.quantity').val() || 0);
                subTotal+=price*quantity;
            });

            subTotal=parseFloat(subTotal);

            let discountAmount = (subTotal/100)*discount;
            let total          = subTotal-discountAmount;

            $('.subtotal').text(subTotal.toFixed(2));
            $('.total').text(total.toFixed(2));
        };

        $('.date').datepicker({
            language  : 'en',
            dateFormat: 'yyyy-mm-dd',
            minDate   : new Date()
        });

    })(jQuery);
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
@push('style')
    <style>
        .border-line-area {
            position: relative;
            text-align: center;
            z-index: 1;
        }
        .border-line-area::before {
            position: absolute;
            content: '';
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #e5e5e5;
            z-index: -1;
        }
        .border-line-title {
            display: inline-block;
            padding: 3px 10px;
            background-color: #fff;
        }
    </style>
@endpush