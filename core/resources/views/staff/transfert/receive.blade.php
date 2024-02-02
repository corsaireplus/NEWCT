@extends('staff.layouts.app')
@section('panel')
<div class="row">
<div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
    <table class="table table--light style--two custom-data-table white-space-wrap">
        <thead>
            <tr>
            
                                
                                <th>@lang('Date')</th>
                                <th>Reference</th>
                                <th>@lang('Frais')</th>
                                <th>@lang('Reste')</th>
                                <th>@lang('Destinataire')</th>
                                <th>@lang('Contact')</th>
                                <th>@lang('Status Paiement')</th>
                                <th>@lang('Expediteur')</th>
                                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
                          @forelse($transferts as $rdvliste)
                            <tr>
                                <td data-label="@lang('Date')">{{date('d-m-Y', strtotime($rdvliste->created_at))}}</td>
                                <td data-label="@lang('Reference')">
                                @if($rdvliste->paymentInfo->status == 0 )
                                    <span class="badge badge--danger"><a href="{{route('staff.transfert.detail', encrypt($rdvliste->id))}}" title="" >{{$rdvliste->reference_souche}}</a></span>
                                    @elseif($rdvliste->paymentInfo->status == 1 )
                                    <span class="badge badge--warning"><a href="{{route('staff.transfert.detail', encrypt($rdvliste->id))}}" title="" >{{$rdvliste->reference_souche}}</a></span>

                                    @elseif($rdvliste->paymentInfo->status == 2)
                                    <span class="badge badge--success"><a href="{{route('staff.transfert.detail', encrypt($rdvliste->id))}}" title="" >{{$rdvliste->reference_souche}}</a></span>
                                    @endif
                                </td>
                                @if($rdvliste->sender_branch_id == $user->branch_id)
                                <td data-label="@lang('Frais')"><span class="font-weight-bold">{{getAmount($rdvliste->paymentInfo->sender_amount)}} {{ $user->branch->currencie}}</span></td>
                                @else
                                <td data-label="@lang('Frais')"><span class="font-weight-bold">{{getAmount($rdvliste->paymentInfo->receiver_amount)}} {{ $user->branch->currencie}}</span></td>

                                @endif
                                <td data-label="@lang('Reste')">{{getAmount($rdvliste->paymentInfo->receiver_amount - $rdvliste->payer)}}</td>
                                <td data-label="@lang('Expediteur')">{{$rdvliste->receiver->nom}}</td>
                                <td data-label="@lang('Contact')">{{$rdvliste->receiver->contact}}</td>
                                <td data-label="@lang('Status Paiement')"> @if($rdvliste->paymentInfo->status == 0 )
                                    <span class="badge badge--danger">@lang('Non Payé')</span>
                                    @elseif($rdvliste->paymentInfo->status == 1 )
                                    <span class="badge badge--warning">@lang('Partiel')</span>
                                    @elseif($rdvliste->paymentInfo->status == 2)
                                    <span class="badge badge--success">@lang('Payé')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Destinataire')">{{$rdvliste->sender->nom}}</td>
                               
                                <td data-label="@lang('Action')">
                                     @if(($rdvliste->container_id != 2 || $rdvliste->container_id == NULL) && $rdvliste->paymentInfo->status == 2 )
                                    <a href="{{route('staff.transfert.livraison', encrypt($rdvliste->id))}}" title="" class="icon-btn btn--priamry ml-1">@lang('Livrer')</a>
                                    @elseif($rdvliste->container_id == 2  )
                                    <span class="badge badge--success">@lang('Dejà Livré')</span>

                                    @endif
                                    <!-- <a href="{{route('staff.transfert.edit', encrypt($rdvliste->id))}}" title="" class="icon-btn btn--success ml-1">@lang('Editer')</a> -->

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
                {{ paginateLinks($transferts) }}
            </div>
</div></div></div>
@endsection
@push('breadcrumb-plugins')

@push('breadcrumb-plugins')
<form action="{{route('staff.transfert.searchreceive')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Rechercher')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <!-- <form action="{{route('staff.transfert.date.search')}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form> -->
@endpush
@push('script-lib')
  <script src="{{ asset('assets/staff/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/staff/js/vendor/datepicker.en.js') }}"></script>
@endpush
@endpush
@push('script')


<script type="text/javascript">
//   $(function () {
    
//     var table = $('.transfertable').DataTable({
//         processing: true,
//         serverSide: true,
//         ajax: "{{ route('staff.transfert.list') }}",
//         columns: [
//             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
//             {data: 'created_at', name: 'date'},
//             {data: 'sender.nom', name: 'expediteur'},
//             {data: 'sender.contact', name: 'contact'},
//             {data: 'receiver.nom', name: 'destinataire'},
//             {data: 'transferts.paymentInfo.status', name: 'paymentInfo.status'},
//             {data: 'status', name: 'status'},
           
//             {
//                 data: 'action', 
//                 name: 'action', 
//                 orderable: true, 
//                 searchable: true
//             },
//         ]
//     });
    
//   });
</script>
@endpush