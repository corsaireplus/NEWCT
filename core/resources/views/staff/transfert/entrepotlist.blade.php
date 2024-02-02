@extends('staff.layouts.app')
@section('panel')
<div class="row">
<div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
    <table class="table table--light style--two  white-space-wrap">
        <thead>
            <tr>
            
                                <!--th>@lang('Action')</th-->
                                <th>@lang('Date')</th>
                                <th>Reference</th>
                                <th>@lang('Expediteur')</th>
                                <th>@lang('Contact')</th>
                                <th>@lang('Paiement')</th>
                                <th>@lang('Frais')</th>
                                <th>@lang('Destinataire')</th>
                                
                                
                                <!-- <th>@lang('Action')</th> -->
            </tr>
        </thead>
        <tbody>
                          @forelse($transferts as $rdvliste)
                          @if($rdvliste->paymentInfo->sender_amount != 0 && $rdvliste->paymentInfo->sender_amount>0)
                            <tr>
                            <!--td data-label="@lang('Action')"> 
                                @if(auth()->user()->username == 'bagate' || auth()->user()->username == 'mouna') 
                                <a href="{{route('staff.transfert.edit', encrypt($rdvliste->id))}}"  class="icon-btn btn--primary "><i class="las la-edit"></i></a>
                                @endif
                                @if($rdvliste->paymentInfo->status == 0 && (auth()->user()->username == 'bagate')) 
                                <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 deletePaiement" data-refpaiement="{{$rdvliste->id}}"><i class="las la-trash"></i></a>                                    @else
                                @endif
                               </td-->
                                <td data-label="@lang('Date')">{{date('d-m-Y', strtotime($rdvliste->created_at))}}</td>
                                <td data-label="@lang('Reference')"><span class="font-weight-bold"><a href="{{route('staff.transfert.detail', encrypt($rdvliste->id))}}" title="" class="icon-btn btn--priamry ml-1">{{$rdvliste->reference_souche}}</a></span></td>
                                <td data-label="@lang('Expediteur')">{{$rdvliste->sender->nom}}</td>
                                <td data-label="@lang('Contact')">{{$rdvliste->sender->contact}}</td>
                                <td data-label="@lang('Status Paiement')"> 
                                    @if($rdvliste->paymentInfo->status == 0 )
                                    <span class="badge badge--danger">@lang('Non Payé')</span>
                                    @elseif($rdvliste->paymentInfo->status == 1 )
                                    <span class="badge badge--warning">@lang('Partiel')</span>
                                    @elseif($rdvliste->paymentInfo->status == 2)
                                    <span class="badge badge--success">@lang('Payé')</span>
                                    @endif
                                </td>
                                @if($rdvliste->sender_branch_id == $user->branch_id)
                                <td data-label="@lang('Frais')"><span class="font-weight-bold">{{getAmount($rdvliste->paymentInfo->sender_amount)}} {{ $user->branch->currencie}}</span></td>
                                @else
                                <td data-label="@lang('Frais')"><span class="font-weight-bold">{{getAmount($rdvliste->paymentInfo->receiver_amount)}} {{ $user->branch->currencie }}</span></td>
                                @endif
                                
                                <td data-label="@lang('Destinataire')">{{$rdvliste->receiver->nom}}</td>
                               
                                
                                <!-- <td data-label="@lang('Action')">

                                    <a href="{{route('staff.transfert.detail', encrypt($rdvliste->id))}}" title="" class="icon-btn btn--priamry ml-1">@lang('Details')</a> 
                                    <a href="{{route('staff.transfert.invoice', encrypt($rdvliste->id))}}" title="" class="icon-btn btn--primary ml-1">@lang('Facture')</a>

                                </td> -->
                                

                            </tr>
                            @endif
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
                {{ paginateLinks($transferts) }}
            </div>
</div></div></div>
<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('SUPPRIMER ENVOI')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="{{route('staff.transfert.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="refpaiement"id="refpaiement" >
                    <div class="modal-body">
                    <p>@lang('Êtes vous sûr de vouloir Supprimer cet envoi ?')</p>
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
<!--form action="{{route('staff.transfert.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Rechercher')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <form action="{{route('staff.transfert.date.search')}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form-->
 
  

@endpush
@push('script-lib')
  <script src="{{ asset('assets/staff/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/staff/js/vendor/datepicker.en.js') }}"></script>
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

<script type="text/javascript">

  $(function () {
    
    var table = $('.transfertable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('staff.transfert.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'created_at', name: 'date'},
            {data: 'sender.nom', name: 'expediteur'},
            {data: 'sender.contact', name: 'contact'},
            {data: 'receiver.nom', name: 'destinataire'},
            {data: 'transferts.paymentInfo.status', name: 'paymentInfo.status'},
            {data: 'status', name: 'status'},
           
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>
<script>
    (function($){
        "use strict";
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
  </script>
@endpush