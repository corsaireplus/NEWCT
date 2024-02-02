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
                                <th>@lang('Expediteur')</th>
                                <th>@lang('Contact')</th>
                                <th>@lang('Destinataire')</th>
                                <th>@lang('Frais')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
                          @forelse($transferts as $rdvliste)
                            <tr>
                                <td data-label="@lang('Date')">{{date('d-m-Y', strtotime($rdvliste->created_at))}}</td>
                                <td data-label="@lang('Reference')"><span class="font-weight-bold"><a href="{{route('staff.transfert.detail', encrypt($rdvliste->id))}}" title="" class="icon-btn btn--priamry ml-1">{{$rdvliste->reference_souche}}</a></span></td>
                                <td data-label="@lang('Expediteur')">{{$rdvliste->sender->nom}}</td>
                                <td data-label="@lang('Contact')">{{$rdvliste->sender->contact}}</td>
                                <td data-label="@lang('Destinataire')">{{$rdvliste->receiver->nom}}</td>
                                @if($rdvliste->sender_branch_id == $user->branch_id)
                                <td data-label="@lang('Frais')"><span class="font-weight-bold">{{getAmount($rdvliste->paymentInfo->sender_amount)}} {{ $user->branch->currencie}}</span></td>
                                @else
                                <td data-label="@lang('Frais')"><span class="font-weight-bold">{{getAmount($rdvliste->paymentInfo->receiver_amount)}} {{ $user->branch->currencie }}</span></td>
                                @endif
                                <td data-label="@lang('Status')"> @if($rdvliste->paymentInfo->status == 0 )
                                    <span class="badge badge--danger">@lang('Non Payé')</span>
                                    @elseif($rdvliste->paymentInfo->status == 1 )
                                    <span class="badge badge--primary">@lang('Partiel')</span>
                                    @elseif($rdvliste->paymentInfo->status == 2)
                                    <span class="badge badge--success">@lang('Payé')</span>
                                    @endif
                                </td>
                              
                                <td data-label="@lang('Action')">

                                    <!-- <a href="{{route('staff.transfert.detail', encrypt($rdvliste->id))}}" title="" class="icon-btn btn--priamry ml-1">@lang('Details')</a> -->
                                    <a href="{{route('staff.transfert.invoice', encrypt($rdvliste->id))}}" title="" class="icon-btn btn--primary ml-1">@lang('Facture')</a>

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
</div></div></div>
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