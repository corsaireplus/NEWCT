@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Staff')</th>
                                <th>@lang('Client')</th>
                                <th>@lang('Montant')</th>
                                <th>@lang('Reference')</th>
                                <th>@lang('Creations Date')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($courierLists as $courierInfo)
                            <tr>
                                <tr>
                                    <td data-label="@lang('Agent')">
                                    <span>{{__($courierInfo->senderStaff->fullname)}}</span><br>
                                   
                                </td>

                                <td data-label="@lang('Client')">
                                    <span>
                                     
                                            {{__($courierInfo->client->nom)}}
                                        
                                    </span>
                                    <br>
                                   
                                </td>

                                <td data-label="@lang('Montant')">
                                    <span class="font-weight-bold">{{getAmount($courierInfo->montant)}} {{ $general->cur_text }}</span><br>
                                  
                                </td>
                                <td data-label="@lang('Reference')">
                                <span>{{__($courierInfo->reference) }}</span>
                                </td>
                                 <td data-label="@lang('Creations Date')">
                                    {{showDateTime($courierInfo->created_at, 'd M Y')}}
                                </td>
    
                                <td data-label="@lang('Action')">
                                   <!-- <a href="{{route('staff.courier.invoice', encrypt($courierInfo->id))}}" title="" class="icon-btn bg--10 ml-1">@lang('Invoice')</a>
                                   <a href="{{route('staff.courier.details', encrypt($courierInfo->id))}}" title="" class="icon-btn btn--priamry ml-1">@lang('Details')</a> -->
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
                {{ paginateLinks($courierLists) }}
            </div>
        </div>
    </div>
</div>
@endsection


@push('breadcrumb-plugins')
    <form action="{{route('staff.courier.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Order Number')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
    <a href="{{route('staff.vente.create')}}" class="btn btn-sm btn--danger box--shadow1 text--small addUnit"><i class="fa fa-fw fa-paper-plane"></i>@lang('Ajouter Vente')</a>

    <!-- <form action="{{route('staff.courier.date.search')}}" method="GET" class="form-inline float-sm-right bg--white">
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

@push('script')
  <script>
    (function($){
        "use strict";
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
  </script>
@endpush