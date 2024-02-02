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
                                <th>@lang('Destinataire')</th>
                                <th>@lang('Description')</th>
                                <th>@lang('Envoye')</th>
                                <th>@lang('Contact')</th>
                                <th>@lang('Agent Livré')</th>
                                <th>@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
                          @forelse($transferts as $rdvliste)
                            <tr>
                                <td data-label="@lang('Date')">{{date('d-m-Y', strtotime($rdvliste->created_at))}}</td>
                                <td data-label="@lang('Reference')">
                                @if($rdvliste->transfert->paymentInfo->status == 0 )
                                    <span class="badge badge--danger"><a href="{{route('staff.transfert.detail', encrypt($rdvliste->transfert->id))}}" title="" >{{$rdvliste->transfert->reference_souche}}</a></span>
                                    @elseif($rdvliste->transfert->paymentInfo->status == 1 )
                                    <span class="badge badge--warning"><a href="{{route('staff.transfert.detail', encrypt($rdvliste->transfert->id))}}" title="" >{{$rdvliste->transfert->reference_souche}}</a></span>

                                    @elseif($rdvliste->transfert->paymentInfo->status == 2)
                                    <span class="badge badge--success"><a href="{{route('staff.transfert.detail', encrypt($rdvliste->transfert->id))}}" title="" >{{$rdvliste->transfert->reference_souche}}</a></span>
                                    @endif
                                </td>
                                <td data-label="@lang('Destinataire')">{{$rdvliste->transfert->receiver->nom}}</td>
                                <td data-label="@lang('Description')">@if($rdvliste->description != NULL){{$rdvliste->description}}@else N/A @endif</td>                               
                                <td data-label="@lang('Envoye')">{{$rdvliste->nom}}</td>

                                <td data-label="@lang('Contact Envoye')">{{$rdvliste->telephone}}</td>

                                <td data-label="@lang('Agent')">{{$rdvliste->livreur->username}}</td>

                                <td data-label="@lang('Action')">
                                     @if(($rdvliste->transfert->container_id != 2 || $rdvliste->transfert->container_id == NULL) && $rdvliste->transfert->paymentInfo->status == 2 )
                                    <a href="{{route('staff.transfert.livraison', encrypt($rdvliste->transfert->id))}}" title="" class="icon-btn btn--priamry ml-1">@lang('Livrer')</a>
                                    @elseif($rdvliste->transfert->container_id == 2  )
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
<form action="{{route('staff.transfert.searchdelivery')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
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

</script>
@endpush