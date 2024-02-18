@extends('staff.layouts.app')
@section('panel')
<div class="row mt-50 mb-none-30">

        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                  
                        <span class="amount"> {{getAmount($totalPartiel)}}   {{ auth()->user()->branch->currencie }}</span>
                     

                   
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Colis payé Abidjan')</span>
                    </div>

                    <a href="{{route('staff.container.listecolispayer', encrypt($mission->idcontainer))}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--12 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-money-bill-alt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{getAmount($totalValeur - ($totalPaye))}} {{ auth()->user()->branch->currencie }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total restant à payer ') </span>
                    </div>
                    <a href="{{route('staff.container.listecolisrestapayer', encrypt($mission->idcontainer))}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a>
                </div>
            </div>
        </div>
</div>

 <div class="row mt-30">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div id="impri" class="table-responsive--sm custom-data-table table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Reference')</th>
                                    <th>@lang('Nb Colis')</th>
                                    <th>@lang('Chargé')</th>
                                    <th>@lang('Client')</th>
                                    <th>@lang('Contact')</th>
                                    <th>@lang('Frais')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($rdv_chauf as $rdv)
                             
                           
                                <tr>
                               
                                    <td data-label="@lang('Date')">
                                        <span class="font-weight-bold">{{date('d-m-Y', strtotime($rdv->colis->created_at))}}</span>
                                    </td>

                                    <td data-label="@lang('Reference')">
                                    @if($rdv->colis->paymentInfo->status == 0 )
                                        <span class="badge badge--danger"><a href="{{route('staff.transfert.detail', encrypt($rdv->colis->id))}}" title="" >{{$rdv->colis->reference_souche}}</a></span>
                                        @elseif($rdv->colis->paymentInfo->status == 1 )
                                        <span class="badge badge--warning"><a href="{{route('staff.transfert.detail', encrypt($rdv->colis->id))}}" title="" >{{$rdv->colis->reference_souche}}</a></span>
                                        @elseif($rdv->colis->paymentInfo->status == 2)
                                        <span class="badge badge--success"><a href="{{route('staff.transfert.detail', encrypt($rdv->colis->id))}}" title="" >{{$rdv->colis->reference_souche}}</a></span>
                                        @endif

                                    </td>

                                    <td data-label="@lang('Nb Colis')">
                                        <span>{{$rdv->colis->transfertDetail->count()}}</span>
                                    </td>
                                    <td data-label="@lang('Chargé')">
                                        
                                        <span>{{$rdv->nb_colis}}</span>
                                        
                                    </td>
                                    <td data-label="@lang('Client')">
                                    {{$rdv->colis->sender->nom}}
                                      
                                    </td>

                                    <td data-label="@lang('Contact')">
                                    {{$rdv->colis->sender->contact}}
                                    </td>
                                    <td>{{getAmount($rdv->colis->paymentInfo->receiver_amount)}} {{auth()->user()->branch->currencie}}</td>
                                 
                                    <td data-label="@lang('Status Livraison')"> 
                                    @if($rdv->colis->container_id == NULL || empty($rdv->colis->container_id)  )
                                    <span class="badge badge--danger">@lang('Non Livré')</span>
                                    @elseif($rdv->colis->container_id == 1 )
                                    <span class="badge badge--warning">@lang('Livraison Partiel')</span>
                                    <!-- @elseif($rdv->colis->paymentInfo->status == 2)
                                    <span class="badge badge--success">@lang('Payé')</span> -->
                                    @endif
                                </td>
                                    @if($rdv->status <= 2 )
                                    <!-- <a href="{{route('staff.mission.validatemission', encrypt($rdv->idrdv))}}" title="" class="icon-btn btn--success ml-1 delivery" data-code="{{$rdv->idrdv}}"> Valider @lang('Rdv')</a> -->
                                    <!-- <a href="{{route('staff.container.coliscancel',[encrypt($rdv->colis->id),encrypt($mission->idcontainer)])}}" title="" class="icon-btn btn--danger ml-1 delivery" data-contenaire="{{encrypt($mission->idcontainer)}}" data-code="{{encrypt($rdv->id)}}"> Annuler</a> -->
                                    @else 
                                    
                                    <a href="{{route('staff.rdv.details', encrypt($rdv->idrdv))}}" title="" class="icon-btn btn--info ml-1 delivery" data-code="{{$rdv->idrdv}}"> Detail</a>
                                    <span class="badge badge-pill bg--success">@lang('Terminé')</span> 
                                    @endif
                                    
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
                {{ paginateLinks($rdv_chauf) }}
                </div>
            </div>
        </div>
     </div>
</div>
    @endsection
@push('breadcrumb-plugins')
<!-- <button  class="btn btn-primary m-1"><i class="fa fa-download"></i>@lang('Print')</button>-->
@if(auth()->user()->branch->country == 'FRA')
<a href="{{route('staff.container.print.charge',encrypt($mission->idcontainer))}}" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> @lang('Imprimer')</a> 
<a href="{{route('staff.container.liste')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
@else
<a href="{{route('staff.container.print.decharge',encrypt($mission->idcontainer))}}" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> @lang('Imprimer')</a> 
<a href="{{route('staff.container.liste_decharge')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>

@endif
@endpush
@push('script')
<script>
    "use strict";
    $('.printInvoice').click(function () { 
        var divContents = document.getElementById("impri").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
            
    });

    $('.payment').on('click', function () {
        var modal = $('#paymentBy');
        modal.find('input[name=code]').val($(this).data('code'))
        modal.modal('show');
    });
</script>
<script type="text/javascript" language="javascript">
    function printDiv() {
            var divContents = document.getElementById("impri").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
</script>
@endpush