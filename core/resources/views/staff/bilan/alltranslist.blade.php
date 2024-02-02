@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
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
                                    <!-- <th>@lang('Action')</th> -->
                                   
                                   
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
                                     @else
                                     <span>
                                     {{__($trans->rdv->sender->nom)}}
                                        </span><br>
                                        {{__($trans->rdv->sender->contact)}}
                                    @endif
                                    
                                </td>
                                <td data-label="@lang('Type')">
                                    @if($trans->transfert)
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

                                    <!-- <td data-label="@lang('Status Paiement')">
                                       
                                            <span class="badge badge--success">@lang('Facture')</span>
                                        
                                    </td> -->
                                    
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
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
<!-- <form action="{{route('staff.rdv.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
    <div class="input-group has_append  ">
        <input type="text" name="search" class="form-control" placeholder="@lang('Contact Client')" value="{{ $search ?? '' }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form> -->
@endpush
@push('script')


@endpush