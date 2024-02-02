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
                                <th>ID</th>
                                <th>@lang('Description')</th>
                               <th>@lang('Qté')</th>
                                <th>@lang('Montant')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($courierInfo as $branchIncome)
                            <tr>
                                <td data-label="@lang('ID')">
                                    <span class="font-weight-bold">{{$loop->iteration}}</span>
                                </td>
                                <td data-label="@lang('Description')">
                                    <span class="font-weight-bold">{{$branchIncome->name}}</span>
                                </td>
                                <td data-label="@lang('Qté')">
                                    @if($branchIncome->qty != null)
                                    <span class="font-weight-bold">{{$branchIncome->qty}}</span>
                                    @else
                                    <span class="font-weight-bold">N/A</span>
                                    @endif
                                </td>
                               
                                 <td data-label="@lang('Montant')">
                                    <span class="font-weight-bold">{{getAmount($branchIncome->qty * $branchIncome->price)}} {{$general->cur_text}}</span>
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
                {{ paginateLinks($courierInfo) }}
            </div>
        </div>
    </div>
</div>
@endsection
@push('script-lib')
<script src="{{ asset('assets/staff/js/vendor/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/staff/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('breadcrumb-plugins')
 

 <!-- <form action="{{route('staff.transaction.date.search')}}" method="GET" class="form-inline float-sm-right bg--white">
     <div class="input-group has_append ">
         <input name="date" type="date"   data-language="fr" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Date')" autocomplete="off" value="{{ @$dateSearch }}">
         <div class="input-group-append">
             <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
         </div>
     </div>
 </form> -->

 <form action="{{route('staff.customer.search_depot_bilan')}}" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append ">
        <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form> 

@endpush