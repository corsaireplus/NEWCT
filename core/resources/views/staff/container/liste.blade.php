@extends('staff.layouts.app')
@section('panel')
<div class="row mt-50 mb-none-30">
 <div class="row gy-4">
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--purple has-link box--shadow2">
                <a href="#" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-money-bill-wave f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Total Conteneur')</span>
                            <h2 class="text-white">{{ showAmount($totalValeurColis) }} {{ $general->cur_sym }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="col-xxl-4 col-sm-6">
            <div class="card bg--orange has-link box--shadow2">
                <a href="#" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-check-double f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Total Payé')</span>
                            <h2 class="text-white">{{ showAmount($totalPaiements) }} {{ $general->cur_sym }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-xxl-4 col-sm-6">
            <div class="card bg--pink has-link box--shadow2">
                <a href="{{route('staff.conteneurs.listenonpaye', encrypt($container_id))}}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                           <i class="las la-hourglass-start f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang(' Reste à Payer')</span>
                            <h2 class="text-white">{{ showAmount($totalValeurColis - $totalPaiements) }} {{ $general->cur_sym }}</h2>
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
                    <div id="impri" class="table-responsive--sm  table-responsive">
                    
                         <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Reference')</th>
                                    <th>@lang('Nb colis')</th>
                                    <th>@lang('Chargé')</th>
                                    <th>@lang('Client')</th>
                                    <th>@lang('Contact')</th>
                                    <th>@lang('Frais')</th>
                                    <th>@lang('Status')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                           
                            @forelse($rdv_chauf->sortBy('transaction.reftrans') as $miss)
                            @if($miss->transaction)   
                            
                                <tr>
                               
                                    <td data-label="@lang('Date')">
                                        <span class="font-weight-bold">{{date('d-m-Y', strtotime($miss->transaction->created_at))}}</span>
                                    </td>

                                    <td data-label="@lang('Reference')">
                                    @if($miss->transaction->status == 0 )
                                        <span class="badge badge--danger">{{$miss->transaction->reftrans}}</span>
                                        @elseif($miss->transaction->status == 1 )
                                        <span class="badge badge--warning">{{$miss->transaction->reftrans}}</span>
                                        @elseif($miss->transaction->status == 2)
                                        <span class="badge badge--success">{{$miss->transaction->reftrans}}</span>
                                        @endif

                                    </td>

                                    <td data-label="@lang('Nb transaction')">
                                        <span>{{$miss->transaction->transfertDetail->count()}}</span>
                                    </td>
                                    <td data-label="@lang('Chargé')">
                                        
                                        <span>{{$miss->nb_colis}}</span>
                                        
                                    </td>
                                    <td data-label="@lang('Client')">
                                    {{$miss->transaction->sender->nom}}
                                      
                                    </td>

                                    <td data-label="@lang('Contact')">
                                    {{$miss->transaction->sender->contact}}
                                    </td>
                                    <td>{{getAmount($miss->transaction->paymentInfo->sender_amount)}} {{auth()->user()->branch->currencie}}</td>
                                 
                                    <td data-label="@lang('Status Paiement')"> 
                                    @if($miss->transaction->status == 0 )
                                    <span class="badge badge--danger">@lang('Non Payé')</span>
                                    @elseif($miss->transaction->status == 1 )
                                    <span class="badge badge--warning">@lang('Partiel')</span>
                                    @elseif($miss->transaction->status == 2)
                                    <span class="badge badge--success">@lang('Payé')</span>
                                    @endif
                                  </td>
                                    @if($miss->status <= 2 && auth()->user()->username == 'bagate' )
                                    <td>
                                    <a href="{{route('staff.conteneurs.coliscancel',[encrypt($miss->transaction->id),encrypt($mission->idcontainer)])}}" title="" class="icon-btn btn--danger ml-1 delivery" data-contenaire="{{encrypt($mission->idcontainer)}}" data-code="{{encrypt($miss->id)}}"> Annuler</a>
                                    @else 
                                    
                                    <a href="{{route('staff.rdv.details', encrypt($miss->idrdv))}}" title="" class="icon-btn btn--info ml-1 delivery" data-code="{{$miss->idrdv}}"> Detail</a>
                                    <span class="badge badge-pill bg--success">@lang('Terminé')</span> 
                                    <td>
                                    @endif
                                    
                                    </td>
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
                {{ paginateLinks($rdv_chauf) }}
                 </div>
            </div>
<!-- new table-->



        </div>
     </div>
</div>
    @endsection
@push('breadcrumb-plugins')

<a href="{{route('staff.conteneurs.printcharge',encrypt($mission->idcontainer))}}"><button class="btn btn-outline--primary m-1">
                            <i class="las la-download"></i>@lang('Imprimer')
                        </button></a> 
@if(auth()->user()->branch->country == 'FRA')
 <x-back route="{{route('staff.conteneurs.index')}}" />
@else
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

@push('script-lib')
        
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
@endpush
