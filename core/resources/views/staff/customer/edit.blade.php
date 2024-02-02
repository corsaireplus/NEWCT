@extends('staff.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('staff.customer.update', encrypt($client->id))}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="fname" class="form-control-label font-weight-bold">@lang('Nom & prénom')</label>
                                <input type="text" class="form-control form-control-lg" id="nom" name="nom" value="{{__($client->nom)}}"  maxlength="40" required="">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phone" class="form-control-label font-weight-bold">@lang('Téléphone')</label>
                                <input type="text" class="form-control form-control-lg" id="contact" name="contact" value="{{__($client->contact)}}"  maxlength="40" required="">
                            </div>
                             
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="fname" class="form-control-label font-weight-bold">@lang('Adresse')</label>
                                <input type="text" class="form-control form-control-lg" id="adresse" name="adresse" value="{{__(optional($client->client_adresse)->adresse ?? 'N/A')}}"  maxlength="40" required="">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phone" class="form-control-label font-weight-bold">@lang('Code Postal')</label>
                                <input type="text" class="form-control form-control-lg" id="code" name="code" value="{{__(optional($client->client_adresse)->code_postal ?? 'N/A')}}"  maxlength="40" required="">
                            </div>
                             
                        </div>
                        

                        <div class="row">
                        

                            <div class="form-group col-lg-6">
                                <label for="email" class="form-control-label font-weight-bold">@lang('Email')</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{__($client->email)}}" maxlength="40" >
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i> @lang('Modifier details client')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('staff.customer.list') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Go Back')</a>
@endpush