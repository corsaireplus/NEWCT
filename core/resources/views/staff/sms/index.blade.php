@extends('staff.layouts.app')
@section('panel')
<div class="row mt-50 mb-none-30">

<div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-sms"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$smsrdv[0]->smsrdv}}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Sms RDV ce mois-ci ')</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-wallet"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$smscont[0]->smscont}}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Sms Conteneur ce mois-ci ')</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--12 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$smscontAbj[0]->smsabj}}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Sms Abidjan ce mois-ci ')</span>
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
                                <th>@lang('Date')</th>
                                <th>@lang('Conteneur / RDV')</th>
                                <th>@lang('Agent')</th>
                                <th>@lang('Details')</th>
                                <th>@lang('Message')</th>                                
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($sms as $smsbip)
                            <tr>
                            
                                <td data-label="@lang('Date')">{{date('d-m-Y', strtotime($smsbip->date))}}</td>
                                @if(str_starts_with($smsbip->rdv_cont, 'R'))
                                <td data-label="@lang('Rdv')">Rendez-vous</td>
                                @else
                                <td data-label="@lang('Conteneur')">Conteneur</td>
                                @endif
                                <td data-label="@lang('Agent')">{{$smsbip->user->fullname}}</td>
                                @if($smsbip->details)
                                <td>{{$smsbip->details->count()}}</td>
                                @else
                                <td></td>
                                @endif
                                @if($smsbip->message !== NULL)
                                <td data-label="@lang('Message')">{{$smsbip->message}}</td>
                                @else <td data-label="@lang('Message')">N/A</td> @endif
                               

                               
                              
                               
                              
                                
                                
                                

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
                {{ paginateLinks($sms) }}
            </div>
        </div>
    </div>
    </div>

@endsection
@push('breadcrumb-plugins')

@endpush