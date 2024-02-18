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
                                <select name="status" class="form-control">
                                    <option value="">@lang('Tout')</option>
                                    <option value="0">@lang('En Cours de chargement')</option>
                                    <option value="1">@lang('Chargé')</option>
                                    <option value="2">@lang('Arrivé à destination')</option>
                                 
                                </select>
                            </div>
                            
                            <div class="flex-grow-1">
                                <label>@lang('Date')</label>
                                <input name="date" type="text" class="date form-control" placeholder="@lang('Debut date - Fin date')" autocomplete="off" value="{{ request()->date }}">
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
                    <table class="table table--light style--two custom-data-table white-space-wrap">
                        <thead>
                            <tr>
                                <th>@lang('Date Creation')</th>
                                <th>@lang('Destination')</th>
                                <th>@lang('Numero')</th>
                                <th>@lang('Armarteur')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Nb Colis')</th>
                            
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($missions as $key => $mission)
                            <tr>
                                <td data-label="@lang('Date')">{{date('d-m-Y', strtotime($mission->date))}}</td>
                                <td data-label="@lang('Destination')">{{$mission->destination->name}}</td>
                                <td data-label="@lang('Numero')">{{$mission->numero}}</td>
                                <td data-label="@lang('Armateur')">{{$mission->armateur}}</td>

                                <td data-label="@lang('Status')">
                                    @if($mission->status == 0)
                                    <span class="badge badge--success py-2 px-3">@lang('En Cours Chargement')</span>
                                    @elseif($mission->status == 1)
                                    <span class="badge badge--warning py-2 px-3">@lang('En Route')</span>
                                    @elseif($mission->status == 2)
                                    <span class="badge badge--warning py-2 px-3">@lang('Arrivé à Destination')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Nb Colis')">{{$mission->envois->count()}}</td>
                             
                                <td data-label="@lang('Action')">

                                   
                                    @if($mission->envois->count() > 0)
                                    <a href="{{route('staff.conteneurs.listereceive', encrypt($mission->idcontainer))}}" title="" class="icon-btn btn--success ml-1 " data-code="{{$mission->idmission}}">@lang('Liste Colis')</a>
                                    @endif
                                    @if($mission->status == 1)
                                    <a href="javascript:void(0)" title="" class="icon-btn btn--success ml-1 payment" data-code="{{$mission->idcontainer}}">@lang('Dechargé')</a>
                            @endif
                            @if($mission->status == 2 && $mission->envois->count() > 0)
                                    <a href="javascript:void(0)" class="btn btn-sm btn--secondary box--shadow1 text--small sendSms"  data-container_id="{{encrypt($mission->idcontainer)}}"><i class="las la-phone"></i>@lang('Sms')</a>

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
                {{ paginateLinks($missions) }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Decharger Conteneur')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.conteneurs.decharger')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Etes Vous sûr de terminer le dechargement?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirmer')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="smsModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('ENVOYER SMS AUX CLIENTS DU CONTENEUR')</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                        <i class="las la-times"></i> </button>
            </div>

            <form action="{{route('staff.conteneurs.conteneursms')}}" method="POST">
                @csrf
                <input type="hidden" name="container_id" id="container_id">
                <input type="hidden" name="contact" id="contact">
                <div class="modal-body">
                      <div class="form-group">
                        
                            <label for="inputMessage">@lang('Entrer Message')</label>
                            <textarea name="message" id="message" rows="4" class="form-control form-control-lg" placeholder="@lang('Entrer Message')">{{old('message')}}</textarea>
                        
                        </div>

               
                    <p>@lang('Êtes vous sûr de vouloir envoyer les sms?')</p>
                </div>


                <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--primary">@lang('Envoyer SMS')</button>
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

    $('.payment').on('click', function() {
        var modal = $('#paymentBy');
        modal.find('input[name=code]').val($(this).data('code'))
        // modal.modal('show');
        $('#paymentBy').modal('show');
    });
    $('.sendSms').on('click', function() {
        var modal = $('#smsModel');
        modal.find('input[name=container_id]').val($(this).data('container_id'))
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
            if(url.get('payment_status') != undefined && url.get('payment_status') != ''){
                $('select[name=payment_status]').find(`option[value=${url.get('payment_status')}]`).attr('selected',true);
            }

        })(jQuery)
    </script>
@endpush