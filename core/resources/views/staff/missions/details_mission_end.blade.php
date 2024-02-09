@extends('staff.layouts.app')
@section('panel')
 <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div id="impri" class="table-responsive--sm custom-data-table table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Code Postal')</th>
                                    <th>@lang('Adresse')</th>
                                    <th>@lang('Client')</th>
                                    <th>@lang('Contact')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($rdv_chauf as $rdv)
                             
                                <tr>
                               
                                    <td data-label="@lang('Date')">
                                        <span class="font-weight-bold">{{date('d-m-Y', strtotime($rdv->date))}}</span>
                                    </td>

                                    <td data-label="@lang('Code Postal')">
                                        @if($rdv->adresse->code_postal)
                                        <span>{{$rdv->adresse->code_postal}}</span>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Adresse')">
                                        <span>{{$rdv->adresse->adresse}}</span>
                                    </td>

                                    <td data-label="@lang('Client')">
                                    {{$rdv->client->nom}}
                                      
                                    </td>

                                    <td data-label="@lang('Contact')">
                                    {{$rdv->client->contact}}
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if($rdv->transfert)
                                        @if($rdv->transfert->paymentInfo->status == 0 )
                                        <a href="{{route('staff.transfert.detail', encrypt($rdv->transfert->id))}}" title="" > <span class="badge badge--danger">{{$rdv->transfert->reference_souche}}</span></a>
                                    @elseif($rdv->transfert->paymentInfo->status == 1 )
                                    <a href="{{route('staff.transfert.detail', encrypt($rdv->transfert->id))}}" title="" > <span class="badge badge--warning">{{$rdv->transfert->reference_souche}}</span></a>
                                    @elseif($rdv->transfert->paymentInfo->status == 2)
                                    <a href="{{route('staff.transfert.detail', encrypt($rdv->transfert->id))}}" title="" > <span class="badge badge--success">{{$rdv->transfert->reference_souche}}</span></a>
                                    @endif
                                        @endif
                                         @if($rdv->transaction)
                                        @if($rdv->transaction->status == 0 )
                                        <a href="{{route('staff.transactions.details', encrypt($rdv->transaction->id))}}" title="" > <span class="badge badge--danger">{{ isset($rdv->transaction->reftrans) ? $rdv->transaction->reftrans : $rdv->transaction->trans_id }}</span></a>
                                    @elseif($rdv->transaction->status == 1 )
                                    <a href="{{route('staff.transactions.details', encrypt($rdv->transaction->id))}}" title="" > <span class="badge badge--warning">{{ isset($rdv->transaction->reftrans) ? $rdv->transaction->reftrans : $rdv->transaction->trans_id }}</span></a>
                                    @elseif($rdv->transaction->status == 2)
                                    <a href="{{route('staff.transactions.details', encrypt($rdv->transaction->id))}}" title="" > <span class="badge badge--success">{{ isset($rdv->transaction->reftrans) ? $rdv->transaction->reftrans : $rdv->transaction->trans_id }}</span></a>
                                    @endif
                                    @endif
                                        @if($rdv->depot)
                                        <span class="badge badge--primary"> Depot {{$rdv->depot->refpaiement}}</span>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Action')">
                                       
                                    <a href="{{route('staff.rdv.detail', encrypt($rdv->idrdv))}}" title="" class="icon-btn btn--info ml-1 delivery" data-code="{{$rdv->idrdv}}"> Detail</a>
                                    <span class="badge badge-pill bg--success">@lang('Terminé')</span> 
                                   
                                    
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
 <a href="{{route('staff.mission.index')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
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