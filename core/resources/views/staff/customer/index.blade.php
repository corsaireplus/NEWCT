@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two  white-space-wrap" id="customer">
                        <thead>
                            <tr>
                                <th>@lang('Nom Prenom')</th>
                                <th>@lang('Contact')</th>
                                <th>@lang('Email')</th>
                           
                                <th>@lang('Date Creation')</th>
                              
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($clients->sortByDesc('transfert_count') as $client)
                            <tr>
                                <tr>
                                    <td data-label="@lang('Nom Prenom')">
                                    <span>{{__($client->nom)}}</span><br>
                                  
                                </td>

                                <td data-label="@lang('Contact')">
                                    <span>
                                    {{$client->contact}}
                                    </span>
                                </td>

                                <td data-label="@lang('Email')">
                                   
                                    <span> {{$client->email}}</span>
                                </td>

                               
                                <td data-label="@lang('Date Creation')">
                                <span> {{date('d-m-Y', strtotime($client->created_at))}}</span>
                                </td>

                                
                            
                                <td data-label="@lang('Action')">
                                   @if($client->transfert->count() > 0)
                                       <a href="{{route('staff.customer.factures', encrypt($client->id))}}" title="" class="icon-btn bg--10 ml-1"> {{$client->transfert->count()}} @lang('Factures')</a>
                                       @endif
                                   <a href="{{route('staff.customer.edit', encrypt($client->id))}}" title="" class="icon-btn btn--priamry ml-1">@lang('Details')</a>
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
                {{ paginateLinks($clients) }}
             </div>
        </div>
    </div>
</div>

@endsection
  @push('breadcrumb-plugins')
 
    <form action="{{route('staff.client.export_list')}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
<form action="{{route('staff.customer.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Contact Client')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form
@endpush
@push('script-lib')
  <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
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
<script>
    (function($){
        "use strict";
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
  </script>
@endpush
