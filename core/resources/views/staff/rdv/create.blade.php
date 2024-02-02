@extends('staff.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form action="{{route('staff.rdv.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Information Client')</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="sender_phone" class="form-control-label font-weight-bold">@lang('Telephone')</label>
                                            <input type="text" class="form-control form-control-lg" id="phone" value="{{old('sender_phone')}}" name="sender_phone" placeholder="@lang(" Telephone")" maxlength="40" required="">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="sender_name" class="form-control-label font-weight-bold">@lang('Nom')</label>
                                            <input type="text" class="form-control form-control-lg" id="sender_name" name="sender_name" value="{{old('sender_name')}}" placeholder="@lang(" Nom & Prenom")" maxlength="40" required="">
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6 autocomplete">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Adresse')</label>
                                            <input type="text" class="form-control form-control-lg" id="sender_address" name="sender_address" value="{{old('sender_address')}}" placeholder="@lang(" Adresse")" maxlength="255" required="">
                                            <ul id="suggestions-list"></ul>

                                        </div>
                                        <input type="hidden" id="client_id" name="client_id">
                                        <!-- <select class="form-control form-control-lg" id="clientAddresses" style="display: none;"></select> -->


                                        <div class="form-group col-lg-6">
                                            <label for="sender_code_postal" class="form-control-label font-weight-bold">@lang('Code postal')</label>
                                            <input type="text" class="form-control form-control-lg" id="sender_code_postal" name="sender_code_postal" value="{{old('sender_address')}}" placeholder="@lang(" Code Postal")" maxlength="255" required="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Date')</label>
                                            <input name="date" type="text" data-range="true" data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Date Rdv')" autocomplete="off" value="{{ @$dateSearch }}">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Observation')</label>
                                            <input name="observation" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="@lang('Observation')" autocomplete="off" value="{{ @$observation }}">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Information RDV')
                                    <button type="button" class="btn btn-sm btn-outline-light float-right addUserData"><i class="la la-fw la-plus"></i>@lang('Ajouter')
                                    </button>
                                </h5>
                                <div class="card-body">
                                    <div class="row addedField">
                                        <div class="form-group">
                                            <div class="input-group mb-md-0 mb-4">
                                                <div class="col-md-3">
                                                    <select class="form-control rdvtype form-control-lg" id="rdv_type_0" name="rdvName[]" onChange="getType(this.value,0);">
                                                        <option>@lang('Choisir Type')</option>
                                                        <option value="1">RECUP</option>
                                                        <option value="2">DEPOT</option>


                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control select3 form-control-lg" id="courier_type_0"   onchange="currierType(0)" name="courierName[]">
                                                        <option>Choisir Objet</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mt-md-0 mt-2">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control form-control-lg currier_quantity_0" placeholder="@lang('Qté')"  name="quantity[]" onkeyup="courierQuantity(0)" aria-label="objet" aria-describedby="basic-addon2" required="">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="unit_0"><i class="las la-balance-scale"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-md-0 mt-2">
                                                    <div class="input-group mb-3">
                                                        <input type="text" id="amount" class="form-control form-control-lg currier_fee_0" placeholder="@lang('Prix')"  name="amount[]" aria-label="Prix Objet" aria-describedby="basic-addon2" required="">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 user-data">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i> @lang('Enregistrer RDV')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('breadcrumb-plugins')
<a href="{{route('staff.new_dashboard')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
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
                                <div class="col-md-2">
                                                            <select class="form-control rdvtype form-control-lg" id="rdv_type_${id}"  name="rdvName[]" onChange="getType(this.value,${id});">
                                                                <option>@lang('Choisir Type')</option>
                                                                <option value="1" >RECUP</option>
                                                                <option value="2" >DEPOT</option>
                                                            </select>
                                                        </div>
                                    <div class="col-md-3">
                                        <select class="form-control select_${id} form-control-lg" id="courier_type_${id}" onchange="currierType(${id})" name="courierName[]" required="">
                                            <option>@lang('Choisir Objet')</option>    
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-lg currier_quantity_${id}" placeholder="@lang('Qté')"  onkeyup="courierQuantity(${id})" name="quantity[]" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="unit_${id}"><i class="las la-balance-scale"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-md-0 mt-2">
                                       <div class="input-group mb-3">
                                            <input type="text" id="amount" class="form-control form-control-lg currier_fee_${id}" placeholder="@lang('Prix')" name="amount[]" aria-label="Frais" aria-describedby="basic-addon2" required="" >
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

   


//     $(document).ready(function () {
//     var $adresseInput = $('#sender_address');
//     var base_url = "{{ url('/') }}";

//     $adresseInput.select2({
//         ajax: {
//             url: base_url + '/staff/get-client-addresses/3' ,
//             dataType: 'json',
//             delay: 250,
//             processResults: function (data) {
//                 return {
//                     results: $.map(data, function (value) {
//                         return { text: value, id: value };
//                     })
//                 };
//             },
//             cache: true
//         },
//         placeholder: 'Saisissez une adresse',
//         minimumInputLength: 1,
//         createTag: function (params) {
//             // L'utilisateur a appuyé sur Entrée pour ajouter une nouvelle adresse
//             return {
//                 id: params.term,
//                 text: params.term,
//                 newTag: true // Marquez le tag comme nouveau
//             };
//         }
//     });

//     // Événement lorsqu'une option est sélectionnée
//     $adresseInput.on('select2:select', function (e) {
//         var selectedOption = e.params.data;

//         if (selectedOption.newTag) {
//             // L'utilisateur a sélectionné une nouvelle adresse
//             var newAddress = selectedOption.text;
//             // Ajoutez ici la logique pour créer une nouvelle adresse
//             console.log('Nouvelle adresse à créer:', newAddress);
//         }
//     });
        

// });

// $(document).ready(function () {
//         /* récupérez l'ID du client ici */;
//        /// var clientId =client_Id.value;
//         var $adresseInput = $('#sender_address');
//         var $clientAddressesSelect = $('#clientAddresses');
//         var base_url = "{{ url('/') }}";

       

//         $adresseInput.on('input', function () {
//             var query = $adresseInput.val();
//             var clientId = $('input[name="client_id"]').val();
//             console.log('client ' +clientId);
//             // Utilisation d'AJAX pour récupérer les adresses du client
//             $.get(base_url + '/staff/get-client-addresses/' + clientId, { query: query }, function (data) {
//                 // Mettre à jour la liste déroulante avec les adresses du client
//                 $clientAddressesSelect.empty();
//                 if (data.length > 0) {
//                 $clientAddressesSelect.append('<option value="" disabled selected>Sélectionnez une adresse</option>');
//                 $.each(data, function (index, value) {
//                     $clientAddressesSelect.append('<option value="' + value + '">' + value + '</option>');
//                 });
//                 $clientAddressesSelect.show();
//             } else {
//                 $clientAddressesSelect.hide();
//             }
//                 // $.each(data, function (index, value) {
//                 //     $clientAddressesSelect.append('<option  value="' + value + '">' + value + '</option>');
//                 // });

//                 // // Afficher la liste déroulante si des adresses sont disponibles
//                 // if (data.length > 0) {
//                 //     $clientAddressesSelect.show();
//                 // } else {
//                 //     $clientAddressesSelect.hide();
//                 // }
//             });
//         });

//         $clientAddressesSelect.on('click', 'option', function () {
//             var selectedAddress = $clientAddressesSelect.val();
//             $adresseInput.val(selectedAddress);
//             $clientAddressesSelect.hide();
//         });




//      // Écoutez l'événement d'input pour le champ d'adresse
//      $adresseInput.on('input', function () {
//         // Récupérez la nouvelle valeur du champ d'adresse
//         var newClientId = $('input[name="client_id"]').val(); /* récupérez l'ID du client ici */;
//         console.log('new client id '+newClientId);
//         // Utilisez la nouvelle valeur pour effectuer une action, par exemple, mettre à jour la liste déroulante
//         updateClientAddresses(newClientId);
//     });

//     function updateClientAddresses(clientId) {
//         // Utilisation d'AJAX pour récupérer les adresses du client
//         $.get(base_url + '/staff/get-client-addresses/' + clientId, { query: $adresseInput.val() }, function (data) {
//             // Mettre à jour le dropdown avec les adresses du client
//             $clientAddressesSelect.empty();
//             if (data.length > 0) {
//                 $clientAddressesSelect.append('<option value="" disabled selected>Sélectionnez une adresse</option>');
//                 $.each(data, function (index, value) {
//                     $clientAddressesSelect.append('<option value="' + value + '">' + value + '</option>');
//                 });
//                 $clientAddressesSelect.show();
//             } else {
//                 $clientAddressesSelect.hide();
//             }
//         });
//     }

//     // Gestionnaire d'événements pour le changement dans le dropdown
//     $clientAddressesSelect.on('change', function () {
//         // Mettre à jour le champ "adresse" avec la valeur sélectionnée dans le dropdown
//         var selectedAddress = $clientAddressesSelect.val();
//         $adresseInput.val(selectedAddress);

//         // Cacher le dropdown après la sélection
//         $clientAddressesSelect.hide();
//     });
// });
</script>



@endpush
