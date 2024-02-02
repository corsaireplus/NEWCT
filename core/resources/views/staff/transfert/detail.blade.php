@extends('staff.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
        <div class="card b-radius--10 overflow-hidden box--shadow1">
            <div class="card-body">
                <h5 class="mb-20 text-muted">@lang('Agent')</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <span class="font-weight-bold">{{__($courierInfo->senderStaff->fullname)}}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <span class="font-weight-bold">{{__($courierInfo->senderStaff->email)}}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <span class="font-weight-bold">{{__($courierInfo->senderBranch->name)}}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        @if($courierInfo->senderStaff->status == 1)
                        <span class="badge badge-pill bg--success">@lang('Active')</span>
                        @elseif($courierInfo->senderStaff->status == 0)
                        <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        @if($courierInfo->receiver_staff_id)
        <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
            <div class="card-body">
                <h5 class="mb-20 text-muted">@lang('Receiver Staff')</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Fullname')
                        <span class="font-weight-bold">{{__($courierInfo->receiverStaff->fullname)}}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Email')
                        <span class="font-weight-bold">{{__($courierInfo->receiverStaff->email)}}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Branch')
                        <span class="font-weight-bold">{{__($courierInfo->receiverBranch->name)}}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Status')
                        @if($courierInfo->receiverStaff->status == 1)
                        <span class="badge badge-pill bg--success">@lang('Active')</span>
                        @elseif($courierInfo->receiverStaff->status == 0)
                        <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        @endif
    </div>

    <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12 mt-10">
        <div class="row mb-30">
            <div class="col-lg-6 mt-2">
                <div class="card border--dark">
                    <h5 class="card-header bg--dark">@lang('Expediteur')</h5>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Nom')
                                <span>{{__($courierInfo->sender->nom)}}</span>
                            </li>



                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Tel')
                                <span>{{__($courierInfo->sender->contact)}}</span>
                            </li>
                            <!-- @if($courierInfo->sender_adresse)
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Adresse')
                                <span>{{__($courierInfo->sender_adresse->adresse)}}</span>
                            </li>
                            @endif -->
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Reference Colis')
                                <span class="badge badge--success font-weight-bold">{{__($courierInfo->reference_souche)}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mt-2">
                <div class="card border--dark">
                    <h5 class="card-header bg--dark">@lang('Destinataire')</h5>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Nom')
                                <span>{{__($courierInfo->receiver->nom)}}</span>
                            </li>



                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Tel')
                                <span>{{__($courierInfo->receiver->contact)}}</span>
                            </li>
                            <!-- @if($courierInfo->receiver_adresse)
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Adresse')

                                <span>{{__($courierInfo->receiver_adresse->adresse)}}</span>
                            </li>
                            @endif -->
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Status')
                                @if($courierInfo->status == 0)
                                <span class="badge badge--primary">@lang('En Cours')</span>
                                @elseif($courierInfo->status == 1)
                                <span class="badge badge--success">@lang('Conteneur')</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-30">
            <div class="col-lg-12">
                <div class="card border--dark">
                    <h5 class="card-header bg--dark">@lang('Details Enlevement')</h5>
                    <div class="card-body">
                        <div class="table-responsive--md  table-responsive">
                            
                        <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Date Enregistrement RDV')
                                @if(!empty($programme))
                                <span>{{date('d-m-Y', strtotime($programme->created_at))}}</span>
                                @else
                                <span>@lang('N/A')</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Date RDV')
                                @if(!empty($programme))
                                <span>{{date('d-m-Y', strtotime($programme->date))}}</span>
                                @else
                                <span>@lang('N/A')</span>
                                @endif
                            </li>
                             <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Agent Enregistrement RDV')
                                @if(!empty($programme))
                                <span>{{$programme->senderStaff->username}}</span>
                                @else
                                <span>@lang('N/A')</span>
                                @endif
                               
                             </li>
                             <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Date Programme Enlevement')
                                @if(!empty($programme->mission))
                                <span>{{date('d-m-Y', strtotime($programme->mission->date))}}</span>
                                @else
                                <span>@lang('N/A')</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Camion du Programme')
                                @if(!empty($programme->mission))
                                <span>{{__($programme->mission->camion)}}</span>
                                @else
                                <span>@lang('N/A')</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Chauffeur du Programme')
                                @if(!empty($programme->mission))
                                <span>{{__($programme->mission->chauffeur->lastname)}}</span>
                                @else
                                <span>@lang('N/A')</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Agent enregistrement Programme')
                                @if(!empty($programme->mission))
                                <span>{{__($programme->mission->staff->lastname)}}</span>
                                @else
                                <span>@lang('N/A')</span>
                                @endif
                            </li>
                            </div>
                                   
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-30">
                <div class="col-lg-12">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Details Rdv')</h5>
                        <div class="card-body">
                            <div class="table-responsive--md  table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th scope="col">@lang('Type')</th>
                                            <th scope="col">@lang('Produit')</th>
                                            <th scope="col">@lang('Qté')</th>
                                            <th scope="col">@lang('PU')</th>
                                            <th scope="col">@lang('Total')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rdv_detail->courierDetail  as $courier)
                                        <tr>
                                        
                                            @if($courier->rdv_type_id == 1)
                                            <td data-label="@lang('Type')">
                                           RECUP
                                           </td>
                                           @elseif($courier->rdv_type_id == 2)
                                           <td data-label="@lang('Type')">
                                           DEPOT
                                            </td>
                                            @elseif($courier->rdv_type_id == 0)
                                            <td data-label="@lang('Type')">
                                           FRAIS
                                            </td>
                                            @endif
                                        
                                            <td data-label="@lang('Description')">
                                                {{$courier->type->name}}
                                            </td>
                                            <td data-label="@lang('Qté')">{{$courier->qty}}</td>
                                            <td data-label="@lang('Frais')">{{getAmount($courier->fee/$courier->qty)}}</td>
                                            <td data-label="@lang('Frais')">{{getAmount($courier->fee)}} {{$general->cur_text}}</td>
                                           
                                            
                                           
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!-- @if($courierInfo->paymentInfo->status != 0 )
                        <div class="table-responsive--md  table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Date')</th>
                                        <th scope="col">@lang('Agent')</th>
                                        <th scope="col">@lang('Montant Payé')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total = 0;
                                    @endphp
                                    @foreach($courierInfo->paiement as $payment)
                                    <tr>
                                        <td data-label="@lang('Date Paiement')">
                                            {{$payment->date_paiement}}
                                        </td>
                                        <td data-label="@lang('Agent')">{{$payment->agent->firstname}}</td>
                                        <td data-label="@lang('Montant Payé')">{{getAmount($payment->sender_payer)}} {{auth()->user()->branch->currencie}}</td>

                                    </tr>
                                    @php
                                    $total += $payment->sender_payer;
                                    @endphp
                                    @endforeach
                                    <td></td>
                                    <td>Total Payé</td>
                                    <td data-label="@lang('Total Payé')">{{getAmount($total)}} {{auth()->user()->branch->currencie}}</td>
                                </tbody>
                            </table>
                        </div>
                        @endif -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row mb-30">
            <div class="col-lg-12">
                <div class="card border--dark">
                    <h5 class="card-header bg--dark">@lang('Details Envoi')</h5>
                    <div class="card-body">
                        <div class="table-responsive--md  table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Description')</th>
                                        <th scope="col">@lang('Quantité')</th>
                                        <th scope="col">@lang('Frais')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($courierInfo->courierDetail as $courier)
                                    <tr>
                                        <td data-label="@lang('Desciprtion')">
                                            {{$courier->type->name}}
                                        </td>
                                        <td data-label="@lang('Qté')">{{$courier->qty}}</td>

                                        <td data-label="@lang('Frais')">{{getAmount($courier->fee)}} {{$general->cur_text}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($conteneur->count() > 0)
        <div class="row mb-30">
            <div class="col-lg-12">
                <div class="card border--dark">
                    <h5 class="card-header bg--dark">@lang('Details Conteneur')</h5>
                    <div class="card-body">
                        <div class="table-responsive--md  table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Date')</th>
                                        <th scope="col">@lang('Numero Conteneur')</th>
                                        <th scope="col">@lang('Nb Chargé')</th>
                                        <th scope="col">@lang('Livraison')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($conteneur as $courier)
                                    <tr>
                                        <td data-label="@lang('Date')">
                                            {{date('d-m-Y', strtotime($courier->conteneur->date))}}
                                        </td>
                                        <td data-label="@lang('Numero')">{{$courier->conteneur->numero}}</td>

                                        <td data-label="@lang('Nb Chargé')">{{$courier->nb_colis}}</td>
                                        @if($courier->date_livraison ==  NULL)
                                        <td data-label="@lang('Livraison')">
                                        <span class="badge badge--danger">@lang('Non Livré')</span>
</td>
                                        @else
                                        <td data-label="@lang('Livraison')">

                                        <span class="badge badge--success"><a href="{{route('staff.transfert.livraison_invoice',[encrypt($courierInfo->id),encrypt($courier->container_id)])}}" title="" class="ml-1 livraison_invoice" data-container_id="{{$courier->container_id}}" data-colis_id="{{$courierInfo->id}}">@lang('Dejà Livré')</a></span>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif
        <div class="row mb-30">
            <div class="col-lg-12 mt-2">
                <div class="card border--dark">
                    <h5 class="card-header bg--dark">@lang('Information Paiement')</h5>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Destinataire')
                                @if(!empty($courierInfo->paymentInfo->receiver_id))
                                <span>{{__($courierInfo->paymentInfo->receiver->username)}}</span>
                                @else
                                <span>@lang('N/A')</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Agence Destination')
                                @if(!empty($courierInfo->receiver_branch_id))
                                <span>{{__($courierInfo->receiverBranch->name)}}</span>
                                @else
                                <span>@lang('N/A')</span>
                                @endif
                            </li>
                            <!-- <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  @lang('Date Paiement')
                                    @if(!empty($courierInfo->paymentInfo->date))
                                        <span>{{showDateTime($courierInfo->paymentInfo->date, 'd M Y')}}</span>
                                    @else
                                        <span>@lang('N/A')</span>
                                    @endif
                                </li> -->

                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Montant à Payer')
                                @if($userInfo->branch_id == $courierInfo->sender_branch_id )
                                <span class="badge badge--primary">{{getAmount($courierInfo->paymentInfo->sender_amount)}} {{$userInfo->branch->currencie}}</span>
                                @else
                                <span class="badge badge--primary">{{getAmount($courierInfo->paymentInfo->receiver_amount)}} {{$userInfo->branch->currencie}}</span>
                                @endif
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Reste à Payer')
                                @if($userInfo->branch_id == $courierInfo->sender_branch_id )
                                <span class="badge badge--danger">{{getAmount($courierInfo->paymentInfo->sender_amount - $deja_payer_sender )}} {{$userInfo->branch->currencie}}</span>
                                @else
                                <span class="badge badge--danger">{{ getAmount($courierInfo->paymentInfo->receiver_amount - $deja_payer_receiver) }} {{$userInfo->branch->currencie}}</span>
                                @endif
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                @lang('Status Paiement')
                                @if($courierInfo->paymentInfo->status == 2)
                                <span class="badge badge--success">@lang('Payé')</span>
                                @elseif($courierInfo->paymentInfo->status == 1)
                                <span class="badge badge--primary">@lang('Partiel')</span>
                                @else
                                <span class="badge badge--danger">@lang('Non Payé')</span>
                                @endif
                            </li>
                            <li>@if($courierInfo->paymentInfo->status < 2)<button type="button" class="btn btn-success m-1 payment" data-rdv="{{$courierInfo->mission_id}}" data-code="{{$courierInfo->code}}"><i class="fa fa-credit-card"></i>@lang('Ajouter Paiement')</button>@endif</li>
                        </ul>
                        @if($courierInfo->paymentInfo->status != 0 )
                        <div class="table-responsive--md  table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Date')</th>
                                        <th scope="col">@lang('Agent')</th>
                                        <th scope="col">@lang('Montant Payé')</th>
                                        <th scope="col">@lang('Mode')</th>
                                         <th scope="col">@lang('Action')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total = 0;
                                    @endphp
                                    @foreach($courierInfo->paiement as $payment)
                                    <tr>
                                        <td data-label="@lang('Date Paiement')">
                                            {{date('d-m-Y', strtotime($payment->date_paiement))}}
                                        </td>
                                        <td data-label="@lang('Agent')">{{$payment->agent->firstname}}</td>
                                        @if($userInfo->branch_id == $courierInfo->sender_branch_id )
                                        <td data-label="@lang('Montant Payé')">{{getAmount($payment->sender_payer)}} {{auth()->user()->branch->currencie}}</td>
                                        @else
                                        <td data-label="@lang('Montant Payé')">{{getAmount($payment->receiver_payer)}} {{auth()->user()->branch->currencie}}</td>

                                        @endif
                                        @if($payment->modepayer)
                                        <td>{{$payment->modepayer->nom}}</td>
                                        @else
                                        <td>N/A</td>
                                        @endif
                                        <td>                                            <a href="{{route('staff.transaction.recu', encrypt($payment->refpaiement))}}"><span class="badge badge--primary">@lang('reçu')</span></a>

                                    </tr>

                                    @if($userInfo->branch_id == $courierInfo->sender_branch_id)
                                    @php
                                    $total += $payment->sender_payer;
                                    @endphp
                                    @else
                                    @php
                                    $total += $payment->receiver_payer;
                                    @endphp
                                    @endif

                                    @endforeach
                                    <tfooter>
                                    <td></td>
                                    <td>Total Payé</td>
                                    <td data-label="@lang('Total Payé')" class="font-weight-bold"> <span>{{getAmount($total)}} {{auth()->user()->branch->currencie}} </span></td>
                                    <td></td>
                                    </tfooter>
                                    
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if($courierInfo->paymentInfo->status != 0 )
        <!-- <div class="row mb-30">
                <div class="col-lg-12 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Liste Paiements')</h5>
                        <div class="card-body">
                            <div class="table-responsive--md  table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th scope="col">@lang('Date')</th>
                                            <th scope="col">@lang('Agent')</th>
                                            <th scope="col">@lang('Montant Payé')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($courierInfo->paiement  as $payment)
                                        <tr>
                                            <td data-label="@lang('Courier Type')">
                                                {{$payment->date_paiement}}
                                            </td>
                                            <td data-label="@lang('Quantity')">{{$payment->agent->firstname}}</td>
                                            <td data-label="@lang('Fee')">{{getAmount($payment->montant_paye)}} {{$general->cur_text}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        @endif
    </div>
</div>

<div class="modal fade" id="paymentConf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Payment Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.transfert.payment')}}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <input type="hidden" name="code">
                    <p>@lang('Entrer les Informations de paiement')</p>
                    <div class="form-group">
                        <div class="form-group col-lg-6">
                            <select class="form-control form-control-lg" id="mode" name="mode">
                                <option>@lang('Choisir Mode')</option>
                                <option value="1">ESPECE</option>
                                <option value="2">CHEQUE</option>
                                <option value="3">CARTE BANCAIRE</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control form-control-lg" name="montant_payer" id="montant_payer" placeholder="Montant Payer">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--success">@lang('Enregistrer')</button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<a href="{{ url()->previous() }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i>@lang('Retour')</a>
@endpush
@push('script')
<script>
    "use strict";
    $('.payment').on('click', function() {
        var modal = $('#paymentConf');
        modal.find('input[name=code]').val($(this).data('code'))
        modal.modal('show');
    });
</script>
@endpush