@extends('staff.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('staff.vente.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border--primary mt-3">
                                    <h5 class="card-header bg--primary  text-white">@lang('Client')</h5>
                                    <div class="card-body">
                                        <div class="row">
                                        <div class="form-group col-lg-6">
                                                <label for="sender_phone" class="form-control-label font-weight-bold">@lang('Contact')*</label>
                                                <input type="text" class="form-control form-control-lg" id="phone" value="{{old('sender_phone')}}" name="sender_phone" placeholder="@lang("Entrer Contact")"  maxlength="40" required="">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="sender_name" class="form-control-label font-weight-bold">@lang('Nom')*</label>
                                                <input type="text" class="form-control form-control-lg" id="sender_name" name="sender_name" value="{{old('sender_name')}}" placeholder="@lang("Client")"  maxlength="40" required="">
                                            </div>

                                            
                                        </div>

                                        
                                       
                                    </div> 
                                </div>
                             </div>


                             
                         </div>
                    
                         <div class="row mb-30">
                            <div class="col-lg-12">
                                <div class="card border--primary mt-3">
                                    <h5 class="card-header bg--primary  text-white">@lang('Informations Vente')
                                        <button type="button" class="btn btn-sm btn-outline-light float-right addUserData"><i class="la la-fw la-plus"></i>@lang('Ajouter Ligne')
                                        </button>
                                    </h5>

                                    <div class="card-body">
                                        <div class="row addedField">
                                            <div class="col-md-12 user-data">
                                                <div class="form-group">
                                                    <div class="input-group mb-md-0 mb-4">
                                                        <div class="col-md-4">
                                                            <select class="form-control select2-basic form-control-lg" id="courier_type_0" onchange="currierType(0)" name="courierName[]">
                                                                <option>@lang('Choisir')</option>
                                                                @foreach($types as $type)
                                                                    <option value="{{$type->id}}" data-unit="{{$type->unit->name}}" data-price={{ getAmount($type->price)}}>{{__($type->name)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control form-control-lg currier_quantity_0" placeholder="@lang('Qté')" disabled="" name="quantity[]" onkeyup="courierQuantity(0)" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="unit_0"><i class="las la-balance-scale"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                           <div class="input-group mb-3">
                                                                <input type="text" id="amount" class="form-control form-control-lg currier_fee_0 montant" placeholder="@lang('Frais')" disabled="" name="amount[]" onkeyup="changeMontant(0)" aria-label="Recipient's username" aria-describedby="basic-addon2" required="" >
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                         </div> 
                         <div class="row mb-30">
                         <div class="col-lg-12">
                         <div class="card border--primary mt-3">
                         <h5 class="card-header bg--primary  text-white">@lang('Information Paiement')
                         
                         </h5>
                         
                         <div class="card-body">
                         <div class="row">
                         <div class="form-group col-lg-4">
                         <label for="sender_phone" class="form-control-label font-weight-bold">@lang('TOTAL A PAYER')</label>
                         <input type="text" style="background-color :red; color :#ffffff" class="form-control form-control-lg" id="total_paye" value="{{old('total_paye')}}" name="total_payer" placeholder="@lang(" Total a Payer")" maxlength="40" required="">
                         </div>
                         <div class="form-group col-lg-4">
                         <label for="sender_name" class="form-control-label font-weight-bold">@lang('MONTANT PAYER')</label>
                         <input type="text" style="background-color : green; color :#ffffff" class="form-control form-control-lg" id="montant_payer" name="montant_payer" value="{{old('montant_payer')}}" placeholder="@lang(" Montant Payer ")" maxlength="40" required="">
                         </div>
                         <div class="form-group col-lg-4">
                         <label for="sender_name" class="form-control-label font-weight-bold">@lang('MODE PAIEMENT')</label>
                         <select class="form-control form-control-lg" id="mode" name="mode" required>
                         
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
                         <div class="form-group">
                         <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i> @lang('Enregistrer Vente')</button>
                         </div>
                         </div>
                         </div>
                         </div>
                         </div>
                         <!-- <div class="form-group">
                         <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i> @lang('Enregistrer Transfert')</button>
                         </div> -->
                         </form>
                         </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('staff.dashboard')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
@endpush

@push('script')
<script>
    "use strict";
$(document).ready(function(){
    var sum = 0;
        // or $( 'input[name^="ingredient"]' )
        $('.montant').each(function(i, e) {
            var v = parseInt($(e).val());
            if (!isNaN(v))
                sum += v;
            console.log('total ' + sum);
        });
        $("#total_paye").val(sum);
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

        $('.select2-basic').select2({});

        
$('#phone').keyup(function(){ 
       var query = $(this).val();

       if(query != '' && query.length == 10)
       {
        var _token = $('input[name="_token"]').val();
        $.ajax({
         url:"{{ route('staff.rdv.fetch') }}",
         method:"POST",
         data:{query:query, _token:_token},
         success:function(response){
             console.log(response);
             if(response){
                $("#sender_name").val(response.nom);
               // $("#sender_address").val(response.adresse);
                //$("#sender_code").val(response.code_postal);
             }
         
         }
        });
       }
   });
   $('#receiver_phone').keyup(function(){ 
       var queryreciever = $(this).val();

       if(queryreciever != '' && queryreciever.length == 10)
       {
        var _token = $('input[name="_token"]').val();
        $.ajax({
         url:"{{ route('staff.rdv.fetchreceiver') }}",
         method:"POST",
         data:{queryreciever:queryreciever, _token:_token},
         success:function(response){
             console.log(response);
             if(response){
                $("#receiver_name").val(response.nom);
                $("#receiver_address").val(response.adresse);
              //  $("#receiver_code").val(response.code_postal);
             }
         
         }
        });
       }
   });
</script>
<script>
    "use strict";
    function currierType(id) {
        let unit = $("#courier_type_" + id).find(':selected').data('unit');
        let price = $("#courier_type_" + id).find(':selected').data('price');
        $("#unit_" + id).html(unit);

        if ($('#courier_type_' + id).val()) {
            $(".currier_quantity_" + id).removeAttr("disabled");
        }
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
    function courierQuantity(id)
    {
        let quantity = $(".currier_quantity_" + id).val();
        let price = $("#courier_type_" + id).find(':selected').data('price');
        $(".currier_fee_" + id).val(quantity * price);
        $(".currier_fee_" + id).removeAttr("disabled");

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
 
    $(document).ready(function () {
        let id = 0;
        $('.addUserData').on('click', function () {
            id++;
            let html = `<div class="col-md-12 user-data">
                            <div class="form-group">
                                <div class="input-group mb-md-0 mb-4">
                                    <div class="col-md-4">
                                        <select class="form-control select2-basic_${id} form-control-lg" id="courier_type_${id}" onchange="currierType(${id})" name="courierName[]" required="">
                                            <option>@lang('Choisir')</option>
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}" data-unit="{{$type->unit->name}}" data-price={{ getAmount($type->price)}}>{{__($type->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-lg currier_quantity_${id}" placeholder="@lang('Qté')" disabled="" onkeyup="courierQuantity(${id})" name="quantity[]" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="unit_${id}"><i class="las la-balance-scale"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-md-0 mt-2">
                                       <div class="input-group mb-3">
                                            <input type="text" id="amount" class="form-control form-control-lg currier_fee_${id} montant" placeholder="@lang('Frais')" onkeyup="changeMontant(${id})" name="amount[]" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">{{$general->cur_text}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 mt-md-0 mt-2 text-right">
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
            $('.select2-basic_'+id).select2({});
        });

        $(document).on('click', '.removeBtn', function () {
            $(this).closest('.user-data').remove();
        });
    });
</script>
@endpush
