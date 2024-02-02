@extends('staff.layouts.app')
@section('panel')
<div class="row mt-50 mb-none-30">
<div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{getAmount($totalValeur)}} {{auth()->user()->branch->currencie}}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total a Payer')</span>
                    </div>

                    <!-- <a href="{{route('staff.cash.income')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a> -->
                </div>
            </div>
        </div>
<div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{getAmount($totalPaye)}} {{ auth()->user()->branch->currencie }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total colis payer')</span>
                    </div>
                    <!-- <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a> -->
                </div>
            </div>
        </div>
        <!-- <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                  
                        <span class="amount"> {{getAmount($totalPartiel)}}{{ auth()->user()->branch->currencie }}</span>
                     

                   
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Colis payé Partiel')</span>
                    </div>

                    <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a>
                </div>
            </div>
        </div> -->
        <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--12 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-money-bill-alt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{getAmount($totalValeur - ( $totalPaye))}} {{ auth()->user()->branch->currencie }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total reste à payer') </span>
                    </div>
                    <!-- <a href="{{route('staff.transaction.depense')}}" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Voir Tout')</a> -->
                </div>
            </div>
        </div>
</div>

 <div class="row mt-30">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div id="impri" class="table-responsive--sm  table-responsive">
                    <table class="table table-bordered " id="colis-table" name="colis-table">
        <!-- <thead>
            <tr>
        
                <th>Date</th>
                <th>Reference</th>
                <th>Nb Colis</th>
                <th>Charge</th>
                <th>client</th>
                <th>contact</th>
                <th>frais</th>
                <th>Action</th>
            </tr>
        </thead> -->
    </table>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                           
                            @forelse($rdv_chauf->sortBy('colis.reference_souche') as $miss)
                            @if($miss->colis)   
                            
                                <tr>
                               
                                    <td data-label="@lang('Date')">
                                        <span class="font-weight-bold">{{date('d-m-Y', strtotime($miss->colis->created_at))}}</span>
                                    </td>

                                    <td data-label="@lang('Reference')">
                                    @if($miss->colis->paymentInfo->status == 0 )
                                        <span class="badge badge--danger">{{$miss->colis->reference_souche}}</span>
                                        @elseif($miss->colis->paymentInfo->status == 1 )
                                        <span class="badge badge--warning">{{$miss->colis->reference_souche}}</span>
                                        @elseif($miss->colis->paymentInfo->status == 2)
                                        <span class="badge badge--success">{{$miss->colis->reference_souche}}</span>
                                        @endif

                                    </td>

                                    <td data-label="@lang('Nb Colis')">
                                        <span>{{$miss->colis->transfertDetail->count()}}</span>
                                    </td>
                                    <td data-label="@lang('Chargé')">
                                        
                                        <span>{{$miss->nb_colis}}</span>
                                        
                                    </td>
                                    <td data-label="@lang('Client')">
                                    {{$miss->colis->sender->nom}}
                                      
                                    </td>

                                    <td data-label="@lang('Contact')">
                                    {{$miss->colis->sender->contact}}
                                    </td>
                                    <td>{{getAmount($miss->colis->paymentInfo->sender_amount)}} {{auth()->user()->branch->currencie}}</td>
                                 
                                    <td data-label="@lang('Status Paiement')"> 
                                    @if($miss->colis->paymentInfo->status == 0 )
                                    <span class="badge badge--danger">@lang('Non Payé')</span>
                                    @elseif($miss->colis->paymentInfo->status == 1 )
                                    <span class="badge badge--warning">@lang('Partiel')</span>
                                    @elseif($miss->colis->paymentInfo->status == 2)
                                    <span class="badge badge--success">@lang('Payé')</span>
                                    @endif
                                  </td>
                                    @if($miss->status <= 2 && auth()->user()->username == 'bagate' )
                                    <td>
                                     <!-- <a href="{{route('staff.mission.validatemission', encrypt($miss->idrdv))}}" title="" class="icon-btn btn--success ml-1 delivery" data-code="{{$miss->idrdv}}"> Valider @lang('Rdv')</a>  -->
                                    <a href="{{route('staff.container.coliscancel',[encrypt($miss->colis->id),encrypt($mission->idcontainer)])}}" title="" class="icon-btn btn--danger ml-1 delivery" data-contenaire="{{encrypt($mission->idcontainer)}}" data-code="{{encrypt($miss->id)}}"> Annuler</a>
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
<!-- <button  class="btn btn-primary m-1"><i class="fa fa-download"></i>@lang('Print')</button>--><form action="{{route('staff.container.search.detailcolis')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Reference Envoi')" value="{{ $search ?? '' }}">
            <input type="hidden" name="id" value="{{encrypt($mission->idcontainer)}}" >
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
</form>
<a href="{{route('staff.container.print.charge',encrypt($mission->idcontainer))}}" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> @lang('Imprimer')</a> 
@if(auth()->user()->branch->country == 'FRA')
<a href="{{route('staff.container.liste')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
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
@push('script')
<script>
    // $('#colis-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     responsive: true,
    //     ajax: "{{ route('staff.container.listecolis',$ct) }}",
    //     columns: [
    //         {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
    //         {data:'colis.reference_souche',name:'reference_souche', orderable: false, searchable: false},
    //         {data:'nb_charge',name:'nb_charge'},
    //         {data:'nb_colis',name:'nb_colis'},
    //         {data: 'colis.sender.nom', name: 'nom', orderable: false, searchable: false},
    //         {data: 'colis.sender.contact', name: 'contact', orderable: false, searchable: false},
    //         {data:'frais',name:'frais'},
    //         {data: 'action', name: 'action', orderable: false, searchable: false}
            
    //     ],
    //     dom: 'lBfrtip',
        
    //     buttons: [
    //         'csv', 'excel', 'print','pdf'
    //     ],
    //     "lengthMenu": [ [10, 50, 100, -1], [10, 50, 100, "All"] ]

    // });
</script>
   


@endpush