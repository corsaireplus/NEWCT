@extends('staff.layouts.app')
@section('panel')
<div class="row mb-none-30">
   <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12 mt-10">
        <div class="card">
            <div class="card-body">
                <form action="{{route('staff.rdv.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Information Client')</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="sender_name" class="form-control-label font-weight-bold">@lang('Nom')</label>
                                            <input type="text" class="form-control form-control-lg" id="sender_name" name="sender_name" value="{{$courierInfo->sender->nom}}" maxlength="40" required="">
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="sender_phone" class="form-control-label font-weight-bold">@lang('Telephone')</label>
                                            <input type="text" class="form-control form-control-lg" id="phone" value="{{$courierInfo->sender->contact}}" name="sender_phone" maxlength="40" required="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Adresse')</label>
                                            <input type="text" class="form-control form-control-lg" id="sender_address" name="sender_address" value="{{$courierInfo->sender->adresse}}" maxlength="255" required="">
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <label for="sender_code_postal" class="form-control-label font-weight-bold">@lang('Code postal')</label>
                                            <input type="text" class="form-control form-control-lg" id="sender_code_postal" name="sender_code_postal" value="{{$courierInfo->sender->code_postal}}" maxlength="255" required="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold">@lang('Date') Rdv</label>
                                            <input name="date" type="text" data-range="true" data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Date Rdv')" autocomplete="off" value="{{ date('d-m-Y', strtotime($courierInfo->date)) }}">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="sender_email" class="form-control-label font-weight-bold">@lang('Email')</label>
                                            <input type="email" class="form-control form-control-lg" id="sender_email" name="sender_email" value="{{$courierInfo->sender->email}}" maxlength="40" required="">
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Destinataire Information')</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="=branch" class="form-control-label font-weight-bold">@lang('Select Branch')</label>
                                            <select class="form-control form-control-lg" name="branch" id="branch" required="">
                                                <option value="">@lang('Select One')</option>

                                                <option value="1">abidjan</option>

                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="receiver_name" class="form-control-label font-weight-bold">@lang('Name')</label>
                                            <input type="text" class="form-control form-control-lg" id="receiver_name" name="receiver_name" value="{{old('receiver_name')}}" placeholder="@lang(" Enter Receiver Name")" maxlength="40" required="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="receiver_phone" class="form-control-label font-weight-bold">@lang('Phone')</label>
                                            <input type="text" class="form-control form-control-lg" id="receiver_phone" name="receiver_phone" placeholder="@lang(" Enter Receiver Phone")" value="{{old('receiver_phone')}}" required="">
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <label for="receiver_email" class="form-control-label font-weight-bold">@lang('Email')</label>
                                            <input type="email" class="form-control form-control-lg" id="receiver_email" name="receiver_email" value="{{old('receiver_email')}}" placeholder="@lang(" Enter Receiver Email")" required="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="receiver_address" class="form-control-label font-weight-bold">@lang('Address')</label>
                                            <input type="text" class="form-control form-control-lg" id="receiver_address" name="receiver_address" placeholder="@lang(" Enter Receiver Address")" value="{{old('receiver_address')}}" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!--fin col lg 6-->
                        <div class="row mb-30">
                            <div class="col-lg-12">
                                <div class="card border--dark">
                                    <h5 class="card-header bg--dark">@lang('Details Rdv')</h5>
                                    <div class="card-body">
                                        <div class="table-responsive--md  table-responsive">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--fin row-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection

@push('breadcrumb-plugins')
<a href="{{route('staff.rdv.list')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Go Back')</a>
@endpush
@push('script-lib')
<script src="{{ asset('assets/staff/js/vendor/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/staff/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')s
<script>
    (function($) {
        "use strict";
        if (!$('.datepicker-here').val()) {
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
    "use strict";

    function rdvType(id) {

    }

    function currierType(id) {
        let unit = $("#courier_type_" + id).find(':selected').data('unit');
        let price = $("#courier_type_" + id).find(':selected').data('price');

        $("#unit_" + id).html(unit);

        if ($('#courier_type_' + id).val()) {

            $(".currier_quantity_" + id).removeAttr("disabled");

        }
    }

    function courierQuantity(id) {
        let quantity = $(".currier_quantity_" + id).val();
        let price = $("#courier_type_" + id).find(':selected').data('price');
        let rdv_type = $('#rdv_type_' + id).val();
        if (rdv_type == 2) {
            $(".currier_fee_" + id).val(quantity * price);
        }
    }

    $(document).on('click', '.removeBtn', function() {
    $(this).closest('.user-data').remove();
    });
    
</script>
@endpush