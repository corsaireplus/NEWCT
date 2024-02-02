@extends('staff.layouts.app')
@section('panel')
<div class="row mt-50 mb-none-30">
  

      

        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{getAmount($totalResteAPayer)}} €</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Encours de la page')</span>
                    </div>
                    <!--<a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a> -->
                </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
        <div class="dashboard-w1 bg--pink b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <form action="{{route('staff.encours.paris')}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                
            </div>
        </div>
    </form>
    <div class="desciption">
                        <span>@lang('Export excel')</span>
                    </div>
                </div>
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
                                    <th>Date</th>
                                    <th>Reference</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Montant Payé</th>
                                    <th>Reste à Payer</th>
                                    <th></th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($encours as $trans)
                                <tr>
                                <td data-label="@lang('Date')">
                                    <span>{{showDateTime($trans->date, 'd M Y')}}</span><br>
                                    <span>{{diffForHumans($trans->date) }}</span>
                                </td>
                                    <td data-label="@lang('Reference')">
                                        <a href="{{route('staff.transfert.detail', encrypt($trans->transfert_id))}}" title="">
                                        @if($trans->infopaiement == 0 )
                                        <span class="badge badge--danger">{{$trans->reference}}</span>
                                        @elseif($trans->infopaiement == 1)
                                        <span class="badge badge--warning">{{$trans->reference}}</span>
                                        @elseif($trans->infopaiement == 2)
                                        <span class="badge badge--success">{{$trans->reference}}</span>
                                        @endif
                                        </a>
                                   
                                   
                                </td>

                                <td data-label="@lang('Client')">
                                   
                                    <span>
                                       
                                      {{__($trans->client)}}
                                    </span><br>
                                      {{__($trans->contact)}}
                                      
                                    
                                </td>
                                <td data-label="@lang('Montant')">
                                    <span class="font-weight-bold">{{getAmount($trans->prix)}} €</span>
                                </td>

                                <td class="text-center" data-label="@lang('Montant paye')">
                                     <span class="font-weight-bold">{{getAmount($trans->montant_total_paye)}} €</span>
                                 
                                </td>
                                 <td class="text-center" data-label="@lang('Reste a payer')">
                                     <span class="font-weight-bold">{{getAmount($trans->reste_a_payer)}} €</span>
                                 
                                </td>
                                <td></td>
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
                {{ paginateLinks($encours ) }}
            </div>
            </div>
        </div>
    </div>
    
    @endsection
    @push('breadcrumb-plugins')
    <form action="{{route('staff.bilan.encours.searchparis')}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
    <!--form action="{{route('admin.transaction.abidjan.date.search')}}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="date"   data-language="fr" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Date')" autocomplete="off" value="{{ @$dateSearch }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form-->
    <a href="{{ url()->previous() }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i>@lang('Retour')</a>

@endpush
@push('script-lib')
  <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
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
