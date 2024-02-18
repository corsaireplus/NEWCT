@extends('staff.layouts.app')
@section('panel')
 <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <form action="{{ route('staff.transactions.livraison_validate') }}" method="POST">
                  <input type="hidden" name="colis_id" value="{{$courierInfo->id}}">
                    <input type="hidden" name="container_id" value="{{$ct}}">
                    <div class="card-body">
                        @csrf
                       
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border--primary mt-3">
                                    <h5 class="card-header bg--primary  text-white">@lang('Livraison Information')</h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label>@lang('Nom')</label>
                                                <input type="text" class="form-control" name="nom"
                                                    value="{{ old('nom') }}" id="nom" required>
                                            </div>
                                            <div class=" form-group col-lg-6">
                                                <label>@lang('Telephone')</label>
                                                <input type="text" class="form-control" name="telephone"
                                                    value="{{ old('telephone') }}" id="telephone" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label>@lang('Nature & Numero piece')</label>
                                                <input type="text" class="form-control" name="piece_id"
                                                    value="{{ old('piece_id') }}" required>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>@lang('Description')</label>
                                                <input type="text" class="form-control" name="description"
                                                    value="{{ old('description') }}" required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>

                        </div>
                        <button type="submit" class="btn btn--primary h-45 w-100 Submitbtn"> @lang('Valider Livraison')</button>

                </form>
            </div>
    </div>
</div>



@endsection

@push('breadcrumb-plugins')
 <x-back route="{{ url()->previous()  }}" />
 @endpush
