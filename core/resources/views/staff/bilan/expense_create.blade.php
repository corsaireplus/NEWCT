@extends('staff.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('staff.transaction.store_depense')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="branch" class="form-control-label font-weight-bold">@lang('Categorie')</label>
                                <select class="form-control form-control-lg" id="cat_id" name="cat_id">
                                    <option value="">@lang('Select One')</option>
                                    @foreach($categorie as $cat)
                                        <option value="{{ $cat->id }}">{{__($cat->nom)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <span class="btn addUnit chauffeur btn--primary btn-block"> Ajouter Categorie</span>
                        </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="fname" class="form-control-label font-weight-bold">@lang('Date')</label>
                                <input type="date" class="form-control form-control-lg" id="date" name="date" placeholder="@lang("Entrer Date")"  maxlength="40" required="" value="{{ old('date') }}">
                            </div>

                             <div class="form-group col-lg-6">
                                <label for="lname" class="form-control-label font-weight-bold">@lang('Montant')</label>
                                <input type="numeric" class="form-control form-control-lg" id="montant" name="montant" placeholder="@lang("Entrer Montant")"  maxlength="40" value="{{ old('montant') }}" required="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="username" class="form-control-label font-weight-bold">@lang('Description')</label>
                                <textarea name="description" id="description" rows="6" class="form-control form-control-lg" placeholder="@lang('Observation ou Note')">{{old('message')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i> @lang('Ajouter Depense')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="unitModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Ajouter Categorie')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('staff.transaction.store_categorie')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fname" class="form-control-label font-weight-bold">@lang('Name')</label>
                            <input type="text" class="form-control form-control-lg" name="nom" placeholder="@lang("Nom")"  maxlength="40" required="">
                        </div>
                        <div class="form-group">
                            <label for="fname" class="form-control-label font-weight-bold">@lang('Description')</label>
                            <input type="text" class="form-control form-control-lg" name="description" placeholder="@lang("Description")"  maxlength="40" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary"><i class="fa fa-fw fa-paper-plane"></i>@lang('Ajouter')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('staff.transaction.depense') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
@endpush
@push('script')
<script>
    "use strict";
    $('.addUnit').on('click', function() {
        $('#unitModel').modal('show');
            });
        if (!$('.datepicker-here').val()) {
            $('.datepicker-here').datepicker();
        }
</script>
@endpush