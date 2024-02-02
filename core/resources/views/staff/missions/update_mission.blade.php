@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body">
                <form action="{{route('staff.mission.update_mission')}}" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                    @csrf
                    <div class="row">
                       
                    <input type="hidden" name="idmission" id="idmission" value="{{$mission->idmission}}">

                        <div class="form-group col-md-6">
                            <label for="website">@lang('Date Programme')</label>
                            <input type="text" name="date" value="{{date('d-m-Y', strtotime($mission->date))}}" data-language="en" class="form-control datepicker-here  form-control-lg" placeholder="@lang('Date Programme')" required="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="priority">@lang('Chauffeur')</label>
                            <select name="id_chauffeur" class="form-control form-control-lg select3">
                                @foreach($chauffeur as $type)
                                <option value="{{$type->id}}"  @if ($type->id == $mission->chauffeur_idchauffeur) {{'selected="selected"'}} @endif >{{ $type->firstname}} {{$type->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label> </label>
                            <span class="btn addUnit chauffeur btn--primary btn-block">Ajouter chauffeur</span>
                        </div>
                       
                    </div>
                    <div class="row">
                       

                        <div class="form-group col-md-6">
                            <label for="website">@lang('Camion')</label>
                            <input type="text" name="camion" value="{{$mission->camion}}" data-language="en" class="form-control form-control-lg" placeholder="@lang('Camion')" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="priority">@lang('Chargeur')</label>
                            <select name="id_chargeur" class="form-control form-control-lg select3">
                                @foreach($chargeur as $type)
                                <option value="{{$type->id}}" @if ($type->id == $mission->chargeur_idchargeur) {{'selected="selected"'}} @endif>{{ $type->firstname}} {{$type->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                       
                    </div>
                    
                    <div class="row">
                    <div class="form-group col-md-6">
                            <label for="website">@lang('Contact Chargeur')</label>
                            <input type="text" name="contact" value="{{$mission->contact}}" data-language="en" class="form-control form-control-lg" required="">
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="row form-group">
                        <div class="form-group col-lg-12">
                            <label for="inputMessage">@lang('Observation')</label>
                            <textarea name="message" id="inputMessage" rows="6" class="form-control form-control-lg" placeholder="@lang('Observation ou Note')">{{$mission->missioncol}}</textarea>
                        </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn--primary btn-block" id="recaptcha"><i class="fa fa-fw fa-paper-plane"></i> @lang('Modifier')</button>
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
                    <h5 class="modal-title">@lang('Ajouter Chauffeur')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('staff.mission.store_chauffeur')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fname" class="form-control-label font-weight-bold">@lang('Name')</label>
                            <input type="text" class="form-control form-control-lg" name="fname" placeholder="@lang("Nom")"  maxlength="40" required="">
                        </div>

                        <div class="form-group">
                            <label for="lname" class="form-control-label font-weight-bold">@lang('Name')</label>
                            <input type="text" class="form-control form-control-lg" name="lname" placeholder="@lang("Prenom")"  maxlength="40" required="">
                        </div>

                        <div class="form-group">
                            <label for="price" class="form-control-label font-weight-bold">@lang('Contact')</label>
                            <div class="input-group mb-3">
                                  <input type="text" id="mobile" class="form-control form-control-lg" placeholder="@lang('Contact')" name="mobile" aria-label="" aria-describedby="basic-addon2" required="">
                                  
                            </div>
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
@push('script-lib')
<script src="{{ asset('assets/staff/js/vendor/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/staff/js/vendor/datepicker.en.js') }}"></script>
@endpush