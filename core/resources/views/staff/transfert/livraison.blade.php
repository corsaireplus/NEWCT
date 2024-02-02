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
                                <span class="badge badge--success">@lang('Livré')</span>
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
                                        <a href="javascript:void(0)" title="" class="icon-btn btn--danger ml-1 livraison" data-container_id="{{$courier->container_id}}" data-colis_id="{{$courierInfo->id}}">@lang('Livrer')</a>
</td>
                                        @else
                                        <td data-label="@lang('Livraison')">

                                        <span class="badge badge--success"><a href="javascript:void(0)" title="" class="ml-1 livraison_invoice" data-container_id="{{$courier->container_id}}" data-colis_id="{{$courierInfo->id}}">@lang('Dejà Livré')</a></span>
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
       
       
    </div>
</div>

<div class="modal fade" id="paymentConf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Confirmation de Livraison')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.transfert.livraison_validate')}}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <input type="hidden" name="colis_id">
                    <input type="hidden" name="container_id">

                    <p>@lang('Entrer les Informations de livraison')</p>
                    <div class="form-group">
                        <div class="row">
                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control form-control-lg" name="nom" id="nom" placeholder="Nom & Prenom" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control form-control-lg" name="telephone" id="telephone" placeholder="Telephone" required>
                        </div>
</div>
                      <div class="row">  
                           <div class="form-group col-lg-12">
                            <input type="numeric" class="form-control form-control-lg" name="piece_id"  id="piece_id" placeholder="Nature & Numero piece" required>
                        </div>
                      </div>
                        <div class="row">
                       <div class="form-group col-lg-12">
                            <textarea class="form-control form-control-lg" name="description"  id="description" placeholder="description" required></textarea>
                        </div>
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
    $('.livraison').on('click', function() {
        var modal = $('#paymentConf');
        modal.find('input[name=colis_id]').val($(this).data('colis_id'))
        modal.find('input[name=container_id]').val($(this).data('container_id'))

        modal.modal('show');
    });

   
</script>
@endpush