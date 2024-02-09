@extends('staff.layouts.app')
@section('panel')
    <div class="card">
        <div class="card-body">
            <div id="printInvoice">
                <div class="content-header">
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">
                        <address class="m-t-5 m-b-5">
                            <strong class="text-inverse">BILAN PROGRAMME</strong><br>
                        </address>
                           
                        </div>
                        
                    </div>
                </div>

                <div class="invoice">
                    <div class="d-flex justify-content-between mt-3">
                       
                        
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('Client')</th>
                                        <th>@lang('Montant Prevu')</th>
                                        <th>@lang('Montant Encaissé')</th>
                                        <th>@lang('Methode Paiement')</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                  @forelse($rdv_chauf as $rdv)
                                    <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$rdv->client->nom}}</td>
                                    <td>{{showAmount($rdv->montant)}}</td>
                                    <td>{{showAmount($rdv->encaisse)}}</td>
                                    @php
                                    if($rdv->transaction){

                                    
                                    $premierPaiement='';
                                    $mode ='N/A';
                                     if ($rdv->transaction->paiement) {
                                      $premierPaiement = $rdv->transaction->paiement->first();
                                       if ($premierPaiement) {
                                        $mode=$premierPaiement->mode_paiement;
                                       }
                                     }
                                    }else{
                                    $premierPaiement='';
                                    $mode ='N/A';
                                     if ($rdv->transfert->paiement) {
                                      $premierPaiement = $rdv->transfert->paiement->first();
                                       if ($premierPaiement) {
                                        $mode=$premierPaiement->mode_paiement;
                                       }
                                     }
                                     }
                                    @endphp
                                   @if($mode ==1)
                                    <td>ESPECES</td>
                                   @elseif($mode == 2)
                                    <td>CHEQUE</td>
                                   @elseif($mode ==3 )
                                    <td>CARTE BANCAIRE</td>
                                   @elseif($mode == 4)
                                    <td>VIREMENT</td>
                                   @else
                                    <td>{{$mode}}</td>
                                   @endif
                                   
                                    

                                    </tr>

                                @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                          
                            @endforelse
                            <tr><td>#</td><td>Total</td><td>{{$rdv_chauf->sum('montant') ?? 0 }}</td><td>{{ $rdv_chauf->sum('encaisse') ?? 0}}</td><td></td></tr>
    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-30 mb-none-30">
                        <div class="col-lg-12 mb-30">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>@lang('Total Prevu'):</th>
                                            <td>{{$rdv_chauf->sum('montant') }}{{ $general->cur_sym }}
                                            </td>
                                        </tr>
                                  
                                        <tr>
                                            <th>@lang('Total Encaissé'):</th>
                                            <td>{{$rdv_chauf->sum('encaisse') }}{{ $general->cur_sym }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            <div class="border-line-area">
                                        <h6 class="border-line-title">@lang('Depenses')</h6>
                                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('Satff')</th>
                                        <th>@lang('Categorie')</th>
                                        <th>@lang('Montant')</th>
                                        <th>@lang('Description')</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($depenses as $dep)
                                <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$dep->staff->username}}</td>
                                <td>{{$dep->categorie->nom}}</td>
                                <td>{{$dep->montant}}</td>
                                <td>{{$dep->description}}</td>
                                </tr>
                               
                               @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                          
                            @endforelse
                             <tr><td>#</td><td></td><td>Total</td><td>{{ $depenses->sum('montant') ?? 0}}</td><td></td></tr>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-30 mb-none-30">
                        <div class="col-lg-12 mb-30">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>@lang('Total Depense'):</th>
                                            <td> {{$depenses->sum('montant')}}{{ $general->cur_sym }}
                                            </td>
                                        </tr>
                                  
                                        <tr>
                                            <th>@lang('Total Versé'):</th>
                                            <td>{{$rdv_chauf->sum('encaisse') - $depenses->sum('montant') }}{{ $general->cur_sym }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                   
                </div>
            </div>

            <div class="row no-print">
                <div class="col-sm-12">
                    <div class="float-sm-end">
                        
                        <button class="btn btn-outline--primary m-1 printInvoice">
                            <i class="las la-download"></i>@lang('Imprimer')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" a>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Payment Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal">
                        <i class="las la-times"></i> </button>
                </div>

                <form action="{{ route('staff.courier.payment') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to collect this amount?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
 <x-back route="{{ url()->previous()  }}" /> 
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.printInvoice').click(function() {
                $("#printInvoice").printThis();
            });
            $('.payment').on('click', function() {
                var modal = $('#paymentBy');
                modal.find('input[name=code]').val($(this).data('code'))
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
@push('style')
    <style>
        .border-line-area {
            position: relative;
            text-align: center;
            z-index: 1;
        }
        .border-line-area::before {
            position: absolute;
            content: '';
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #e5e5e5;
            z-index: -1;
        }
        .border-line-title {
            display: inline-block;
            padding: 3px 10px;
            background-color: #fff;
        }
    </style>
@endpush