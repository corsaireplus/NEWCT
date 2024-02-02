@extends('staff.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Staff')</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">{{__($courierInfo->senderStaff->fullname)}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">{{__($courierInfo->senderStaff->email)}}</span>
                        </li>

                       

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
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
                        <h5 class="card-header bg--dark">@lang('Information Client')</h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  @lang('Client')
                                  <span>{{__($courierInfo->client->nom)}}</span>
                                </li>


                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  @lang('Contact')
                                    <span>{{__($courierInfo->client->contact)}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  @lang('Adresse')
                                  <span>{{__($courierInfo->adresse->adresse)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  @lang('Code Postal')
                                  <span>{{__($courierInfo->adresse->code_postal)}}</span>
                                </li>
                                
                               
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Paiement Information')</h5>
                        <div class="card-body">
                            <ul class="list-group">
                               
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  @lang('Chauffeur')
                                  @if($courierInfo->mission)
                                  <span>{{$courierInfo->mission->chauffeur->firstname}}</span>
                                  @else
                                  <span>Aucun Assigné</span>
                                  @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  @lang('Date Paiement')
                                    @if(!empty($courierInfo->paymentInfo->date))
                                        <span>{{showDateTime($courierInfo->paymentInfo->date, 'd M Y')}}</span>
                                    @else
                                        <span>@lang('N/A')</span>
                                    @endif
                                </li>

                                 <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  @lang('Montant à Payer')
                                  <span>{{getAmount($courierInfo->paymentInfo->amount + $courierInfo->paymentInfo->recup_amount)}} {{$general->cur_text}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @if($courierInfo->status == 0)
                                <span class="badge badge-pill bg--success">@lang('En cours')</span>
                            @elseif($courierInfo->status  == 1)
                                <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                            @endif
                        </li>
                                <!-- <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  @lang('Status')
                                    @if($courierInfo->paymentInfo->status == 2)
                                        <span class="badge badge--success">@lang('Payé')</span>
                                    @else
                                        <span class="badge badge--danger">@lang('Non Payé')</span>
                                    @endif
                                </li> -->
                            </ul>
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
                                    @foreach($courierInfo->courierDetail  as $courier)
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

           
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ url()->previous() }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i>@lang('Retour')</a>
@endpush