@extends('staff.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form action="{{route('staff.suivi.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Information Suivi')</h5>
                                <div class="card-body">
                                    <div class="row">
                                       
                                    <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Date')</label>
                                            <input name="date_charge" type="text"  data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Date')" autocomplete="off" value="{{ @$date_charge}}">
                                        </div>
                                       
                                        <div class="form-group col-lg-6">
                                            <label for="sender_name" class="form-control-label font-weight-bold">@lang('compagnie / bateau')</label>
                                            <input type="text" class="form-control form-control-lg" id="comp_bateau" name="comp_bateau" value="{{old('comp_bateau')}}" placeholder="@lang("compagnie / bateau")" maxlength="40" >
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('ETD')</label>
                                            <input type="text" class="form-control form-control-lg" id="etd" name="etd" value="{{old('etd')}}" placeholder="@lang(" ETD")" maxlength="255" >
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <label for="sender_code_postal" class="form-control-label font-weight-bold">@lang('Status Draft')</label>
                                            <input type="text" class="form-control form-control-lg" id="draft_status" name="draft_status" value="{{old('draft_status')}}" placeholder="@lang(" Status Draft")" maxlength="255" >
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-lg-6">
                                            <label for="sender_phone" class="form-control-label font-weight-bold">@lang('ETA')</label>
                                            <input type="text" class="form-control form-control-lg" id="eta" value="{{old('eta')}}" name="eta" placeholder="@lang(" ETA")" maxlength="40" >
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Status relache')</label>
                                            <input name="relache_status" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="@lang('Status relache')" autocomplete="off" value="{{ @$relache_status }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Numero Conteneur')</label>
                                            <input name="conteneur_num" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="@lang('Numero Conteneur')" autocomplete="off" value="{{ @$conteneur_num }}">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Numero Dossier')</label>
                                            <input name="dossier_num" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="@lang('Numero Dossier')" autocomplete="off" value="{{ @$dossier_num }}">
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Palette')</label>
                                            <input name="palette" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="@lang('Palette')" autocomplete="off" value="{{ @$palette }}">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Livrer')</label>
                                            <input name="livrer" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="@lang('Livrer')" autocomplete="off" value="{{ @$livrer }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Montant')</label>
                                            <input name="montant" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="@lang('Montant')" autocomplete="off" value="{{ @$montant }}">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Regle')</label>
                                            <input name="regle" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="@lang('Regle')" autocomplete="off" value="{{ @$regle }}">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12 user-data">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i> @lang('Enregistrer')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
@push('breadcrumb-plugins')
<a href="{{route('staff.suivi.liste')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
@endpush



@push('script-lib')
<script src="{{ asset('assets/staff/js/vendor/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/staff/js/vendor/datepicker.en.js') }}"></script>
@endpush