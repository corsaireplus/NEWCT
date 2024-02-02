@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table white-space-wrap">
                        <thead>
                            <tr>
                                <th>@lang('Date Creation')</th>
                                <th>@lang('Arrivée')</th>
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
                                <td data-label="@lang('Destination')">{{date('d-m-Y', strtotime($mission->date_arrivee))}}</td>
                                <td data-label="@lang('Numero')">{{$mission->numero}}</td>
                                <td data-label="@lang('Armateur')">{{$mission->armateur}}</td>

                                <td data-label="@lang('Status')">
                                    @if($mission->status == 0)
                                    <span class="badge badge--success py-2 px-3">@lang('En Cours Chargement')</span>
                                    @elseif($mission->status == 1)
                                    @if(auth()->user()->username == 'bagate' || auth()->user()->username == 'aminata'|| auth()->user()->username == 'mouna')
                                    <span class="badge badge--warning py-2 px-3"><a href="javascript:void(0)" title="" class="reopen" data-code="{{$mission->idcontainer}}">@lang('En Route')</a></span>
                                    @else
                                    <span class="badge badge--warning py-2 px-3">@lang('En Route')</span>
                                    @endif
                                    @elseif($mission->status == 2)
                                    @if(auth()->user()->username == 'bagate' || auth()->user()->username == 'aminata'|| auth()->user()->username == 'mouna')
                                    <span class="badge badge--warning py-2 px-3"><a href="javascript:void(0)" title="" class="reopen" data-code="{{$mission->idcontainer}}">@lang('Arrivé à Destination')</a></span>
                                    @else
                                    <span class="badge badge--warning py-2 px-3">@lang('Arrivé à Destination')</span>
                                    @endif
                                    @endif
                                </td>
                                <td data-label="@lang('Nb Colis')">{{$mission->envois->count()}}</td>
                             
                                <td data-label="@lang('Action')">

                                    @if($mission->status == 0)
                                    <a href="{{route('staff.container.assigne', encrypt($mission->idcontainer))}}" title="" class="icon-btn btn--info ml-1 delivery" data-code="{{$mission->idcontainer}}">@lang('Ajouter Colis')</a>

                                    @endif
                                    @if($mission->envois->count() > 0)
                                    <a href="{{route('staff.container.detailcontainer', encrypt($mission->idcontainer))}}" title="" class="icon-btn btn--success ml-1 " data-code="{{$mission->idcontainer}}">@lang('Liste Colis')</a>
                                    @endif
                                    @if($mission->status == 0 && $mission->envois->count() > 0)
                                    <a href="javascript:void(0)" title="" class="icon-btn btn--success ml-1 payment" data-code="{{$mission->idcontainer}}">@lang('Chargé')</a>
                                    @endif
                                    @if($mission->status > 0 && $mission->envois->count() > 0)
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
<div class="modal fade" id="ropenBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Rouvrir Conteneur')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.container.reopen')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Etes Vous sûr de rouvrir le conteneur?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirmer')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Chargé Conteneur')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.container.end')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Etes Vous sûr de terminer le chargement du conteneur?')</p>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.container.sms')}}" method="POST">
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
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                    <button type="submit" class="btn btn--success"><i class="fa fa-fw fa-phone"></i>@lang('Envoyer')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<a href="{{route('staff.container.create')}}" class="btn btn-sm btn--primary box--shadow1 text--small addUnit"><i class="fa fa-fw fa-paper-plane"></i>@lang('Ajouter Conteneur')</a>
<!-- <form action="{{route('staff.rdv.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Contact Client')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form> -->
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
    $('.reopen').on('click', function() {
        var modal = $('#ropenBy');
        modal.find('input[name=code]').val($(this).data('code'))
        // modal.modal('show');
        $('#ropenBy').modal('show');
    });
</script>
@endpush