@extends('staff.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm"><i class="las la-filter"></i> @lang('Filter')</button>
            </div>
            <div class="card responsive-filter-card b-radius--10 mb-3">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('Rechercher')</label>
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Staus')</label>
                                <select name="ship_status" class="form-control">
                                    <option value="">@lang('Tout')</option>
                                    <option value="0">@lang('Entrepot')</option>
                                    <option value="1">@lang('En Conteneur')</option>
                                    <option value="11">@lang('Chargé partiellement')</option>
                                    <option value="2">@lang('Colis à Destination')</option>
                                    <option value="22">@lang('Colis partiel à Destination')</option>
                                     <option value="3">@lang('Livré')</option>
                                    <option value="33">@lang('Livré partiellement')</option>
                                </select>
                                <!-- 0 entrepot 1 chargé en conteneur 11 chargé partiellement 2 colis arrivé 22 colis partiellement arrivé 3 colis livré 33 colis partiellement livré 4 terminé -->
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Paiement Status')</label>
                                <select name="status" class="form-control">
                                    <option value="">@lang('Tout')</option>
                                    <option value="2">@lang('Payé')</option>
                                    <option value="1">@lang('Partiel')</option>
                                    <option value="0">@lang('Non Payé')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Date')</label>
                                <input name="date" type="text" class="date form-control" placeholder="@lang('Start date - End date')" autocomplete="off" value="{{ request()->date }}">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> @lang('Filtrer')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <!-- <th>@lang('Agence - Staff')</th> -->
                                    <th>@lang('Expediteur - Contact')</th>
                                    <th>@lang('Montant - Reference')</th>
                                    <th>@lang('Creations Date')</th>
                                    <th>@lang('Reste à Payer')</th>
                                    <th>@lang('Paiement')</th>
                                    <th>@lang('Status Envoi')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courierLists as $courierInfo)
                                    <tr>
                                        <!-- <td>
                                            <span>{{ __($courierInfo->senderBranch->name) }}</span><br>
                                            {{ __($courierInfo->senderStaff->fullname) }}
                                        </td> -->
                                        <td>
                                            <span>
                                                @if ($courierInfo->sender)
                                                    {{ __($courierInfo->receiver->nom) }}
                                                @else
                                                    @lang('N/A')
                                                @endif
                                            </span>
                                            <br>
                                            @if ($courierInfo->sender)
                                                {{ __($courierInfo->receiver->contact) }}
                                            @else
                                                <span>@lang('N/A')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold d-block">
                                                {{ showAmount(@$courierInfo->paymentInfo->receiver_amount) }}
                                                {{ __('FCFA') }}
                                            </span>
                                            <span class="font-weight-bold"> @if($courierInfo->reftrans)<a href="#" title="" class="icon-btn btn--priamry ml-1">{{$courierInfo->reftrans}} </a>@else {{ $courierInfo->trans_id }} @endif</span>
                                        </td>
                                        <td>{{ showDateTime($courierInfo->created_at, 'd M Y') }}</td>
                                        <td>  <span class="fw-bold d-block">
                                               {{ showAmount(@$courierInfo->paymentInfo->receiver_amount - $courierInfo->payer) }}
                                                {{ __('FCFA') }}
                                                </span>
                                        </td>
                                        <td>
                                            @if (@$courierInfo->status == 2)
                                                <span class="badge badge--success">@lang('Payé')</span>
                                            @elseif(@$courierInfo->status == 1)
                                                <span class="badge badge--warning">@lang('Partiel')</span>    
                                            @elseif(@$courierInfo->status == 0)
                                                <span class="badge badge--danger">@lang('Non Payé')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($courierInfo->reftrans)
                                                @if ($courierInfo->ship_status == 0)
                                                    <span class="badge badge--danger">@lang('En Entrepôt')</span>
                                                @elseif ($courierInfo->ship_status == 1)
                                                  
                                                    <span class="badge badge--success">@lang('Chargé')</span>
                                                                                                    
                                                @elseif ($courierInfo->ship_status ==  11)
                                                    <span class="badge badge--warning">@lang('Chargé partiellement')</span>
                                                @elseif($courierInfo->ship_status ==  2)
                                                    <span class="badge badge--success">@lang('Arrivé a Destination')</span>
                                                @elseif($courierInfo->ship_status ==  22)
                                                    <span class="badge badge--warning">@lang('Arrivé partiellement')</span>
                                                @elseif($courierInfo->ship_status ==  3)
                                                    <span class="badge badge--success">@lang('Livré')</span>
                                                @elseif($courierInfo->ship_status ==  33)
                                                    <span class="badge badge--warning">@lang('Livré partiellement')</span>
                                                @endif
                                             @else
                                             <span class="badge badge--primary">@lang('RDV')</span>

                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('staff.transactions.invoice', encrypt($courierInfo->id)) }}"
                                                title="" class="btn btn-sm btn-outline--info"><i
                                                    class="las la-file-invoice"></i> @lang('Facture')</a>
                                            <a href="{{ route('staff.transactions.details', encrypt($courierInfo->id)) }}"
                                                title="" class="btn btn-sm btn-outline--primary"><i
                                                    class="las la-info-circle"></i> @lang('Details')</a>
                                            @if(auth()->user()->username == 'bagate' || auth()->user()->username == 'mouna') 
                                                @if($courierInfo->ship_status != -1) 
                                              <a href="{{ route('staff.transactions.modifier', encrypt($courierInfo->id)) }}"
                                                class="btn btn-sm btn-outline--primary">
                                                <i class="las la-pen"></i>@lang('Edit')
                                             </a>
                                                @endif
                                            @if($courierInfo->status  == 0 && (auth()->user()->username == 'bagate') && $courierInfo->ship_status != - 1) 
                                              <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 deleteTransaction" data-refpaiement="{{$courierInfo->trans_id}}"><i class="las la-trash"></i></a>
                                    
                                              @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($courierLists->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($courierLists) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('SUPPRIMER ENVOI')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="{{route('staff.transactions.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="refpaiement" id="refpaiement" >
                    <div class="modal-body">
                    <p>@lang('Êtes vous sûr de vouloir Supprimer cet envoi ?')</p>
                </div>

                   
                      <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--danger">@lang('Supprimer')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/viseradmin/css/vendor/datepicker.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/viseradmin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/viseradmin/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
<script>
    "use strict";
    $('.deleteTransaction').on('click', function() {
        var modal = $('#branchModel');
        modal.find('input[name=refpaiement]').val($(this).data('refpaiement'))
        modal.modal('show');
    });
    
</script>
    <script>
        (function($) {
            "use strict";

            $('.date').datepicker({
                maxDate:new Date(),
                range:true,
                multipleDatesSeparator:"-",
                language:'en'
            });

            let url=new URL(window.location).searchParams;
            if(url.get('status') != undefined && url.get('status') != ''){
                $('select[name=status]').find(`option[value=${url.get('status')}]`).attr('selected',true);
            }
            if(url.get('ship_status') != undefined && url.get('ship_status') != ''){
                $('select[name=ship_status]').find(`option[value=${url.get('ship_status')}]`).attr('selected',true);
            }

        })(jQuery)
    </script>
@endpush
