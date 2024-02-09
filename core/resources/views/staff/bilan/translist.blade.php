@extends('staff.layouts.app')
@section('panel')
    <div class="row mt-50 mb-none-30">
    @if(auth()->user()->branch->country == 'FRA')
        

        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"> {{$rdvbranchSum}} {{ auth()->user()->branch->currencie }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total RDV Objet')</span>
                    </div>
                    <!-- <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a> -->
                </div>
            </div>
        </div>
    @endif
    @if(auth()->user()->branch->country != 'FRA')
        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
    @else
    <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
    @endif

            <div class="dashboard-w1 bg--12 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-money-bill-alt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$transfertbranchCount}}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Transactions')</span>
                    </div>
                    <!-- <a href="{{route('staff.transaction.all_list')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a> -->
                </div>
            </div>
        </div>
        
        @if(auth()->user()->branch->country == 'FRA')
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                  
                        <span class="amount">{{$Senderpaiment}} {{ auth()->user()->branch->currencie }}</span>
                     

                   
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Colis Chauffeur Payé')</span>
                    </div>

                    <!-- <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a> -->
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->branch->country != 'FRA')
        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
    @else
    <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
    @endif
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                  
                        <span class="amount">{{$Receiverpaiment}} {{ auth()->user()->branch->currencie }}</span>
                   
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Colis Bureau Payé')</span>
                    </div>

                    <!-- <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-30">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table white-space-wrap">
                            <thead>
                                <tr>
                                    <th>@lang('Agence - Staff')</th>
                                    <th>@lang('Client')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Montant Payé - Reference')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Action')</th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($branch_transactions as $trans)
                                <tr>
                                    <td data-label="@lang('Agence - Staff')">
                                    <span>{{__($trans->branch->name)}}</span><br>
                                    {{__($trans->agent->fullname)}}
                                </td>

                                <td data-label="@lang('Client')">
                                
                                    @if($trans->transfert)
                                    <span>
                                    {{__($trans->transfert->sender->nom)}}
                                   
                                    </span><br>
                                    {{__($trans->transfert->sender->contact)}}
                                     @elseif($trans->rdv)
                                     <span>
                                     {{__($trans->rdv->sender->nom)}}
                                        </span><br>
                                        {{__($trans->rdv->sender->contact)}}
                                      @else
                                        {{__($trans->transaction->sender->nom)}}
                                    </span><br>
                                    {{__($trans->transaction->sender->contact)}}
                                    @endif
                                    
                                </td>
                                <td data-label="@lang('Type')">
                                   @if($trans->transaction)
                                    <span>
                                    TRANSACTION
                                   </span><br>
                                    {{$trans->transaction->trans_id}}
                                    </span>
                                    @elseif($trans->transfert)
                                    <span>
                                    TRANSFERT
                                    </span><br>
                                    {{$trans->transfert->reference_souche}}
                                    </span>
                                     @else
                                    <span>RDV DEPOT</span><br>
                                    {{$trans->rdv->code}}
                                    @endif
                                    
                                </td>

                                <td data-label="@lang('Montant paye - Reference')">
                                 @if($trans->transfert )
                                    @if(auth()->user()->branch_id == $trans->transfert->sender_branch_id)
                                    <span class="font-weight-bold"> {{getAmount($trans->sender_payer)}} {{ auth()->user()->branch->currencie  }}</span><br>
                                        @else
                                        <span class="font-weight-bold">{{getAmount($trans->receiver_payer)}} {{ auth()->user()->branch->currencie }}</span><br>
                                        @endif
                                    @else
                                    <span class="font-weight-bold"> {{getAmount($trans->sender_payer)}} {{ auth()->user()->branch->currencie  }}</span><br>
@endif
                                    <span>{{$trans->refpaiement}}</span>
                                </td>

                                 <td data-label="@lang('Date')">
                                    <span>{{showDateTime($trans->created_at, 'd M Y')}}</span><br>
                                    <span>{{diffForHumans($trans->created_at) }}</span>
                                </td>

                                    <td data-label="@lang('Status Paiement')">
                                    @if($trans->transfert)
                                             <a href="{{route('staff.transaction.recu', encrypt($trans->refpaiement))}}" class="icon-btn btn--warning ml-1"><i class="las la-print"></i></a>
                                            <a href="{{route('staff.transaction.edit', encrypt($trans->refpaiement))}}"><span class="badge badge--primary">@lang('modifier')</span></a>
                                            @if(auth()->user()->username == 'bagate' || auth()->user()->username == 'mouna') <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 deletePaiement" data-refpaiement="{{$trans->refpaiement}}"><i class="las la-trash"></i></a>@endif 
                                         @else
                                    <span class="badge badge--success">@lang('payé')</span>
                                    @endif
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                {{ paginateLinks($branch_transactions) }}
            </div>
            </div>
        </div>
    </div>
    <div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('SUPPRIMER PAIEMENT')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="{{route('staff.transaction.delete_paiement')}}" method="POST">
                    @csrf
                    <input type="hidden" name="refpaiement"id="refpaiement" >
                    <div class="modal-body">
                    <p>@lang('Êtes vous sûr de vouloir Supprimer ce paiement ?')</p>
                </div>

                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--danger"><i class="fa fa-fw fa-trash"></i>@lang('Supprimer')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
    @push('breadcrumb-plugins')
 

    <form action="{{route('staff.transaction.date.search')}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="date"   data-language="fr" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Date')" autocomplete="off" value="{{ @$dateSearch }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

@endpush

@push('script')
<script>
    "use strict";
    $('.deletePaiement').on('click', function() {
        var modal = $('#branchModel');
        modal.find('input[name=refpaiement]').val($(this).data('refpaiement'))
        modal.modal('show');
    });
</script>
@endpush