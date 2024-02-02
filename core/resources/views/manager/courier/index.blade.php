@extends('manager.layouts.app')
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
                                <label>@lang('Search')</label>
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Staus')</label>
                                <select name="status" class="form-control">
                                    <option value="">@lang('All')</option>
                                    <option value="0">@lang('Queue')</option>
                                    <option value="1">@lang('Dispatch')</option>
                                    <option value="1">@lang('Upcomming')</option>
                                    <option value="2">@lang('Received')</option>
                                    <option value="3">@lang('Delevered')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Payment Status')</label>
                                <select name="payment_status" class="form-control">
                                    <option value="">@lang('All')</option>
                                    <option value="1">@lang('Paid')</option>
                                    <option value="0">@lang('Unpaid')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Date')</label>
                                <input name="date" type="text" class="date form-control" placeholder="@lang('Start date - End date')" autocomplete="off" value="{{ request()->date }}">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> @lang('Filter')</button>
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
                                    <th>@lang('Sender Branch - Staff')</th>
                                    <th>@lang('Receiver Branch - Staff')</th>
                                    <th>@lang('Amount - Order Number')</th>
                                    <th>@lang('Creations Date')</th>
                                    <th>@lang('Payment Status')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courierInfos as $courierInfo)
                                    <tr>
                                        <td>
                                            <span>{{ __($courierInfo->senderBranch->name) }}</span><br>
                                            <a class="text--primary" href="{{ route('manager.staff.edit', encrypt($courierInfo->senderStaff->id)) }}">
                                                <span class="text--primary">@</span>{{ __($courierInfo->senderStaff->username) }}
                                            </a>
                                        </td>
                                        <td>
                                            <span>
                                                @if ($courierInfo->receiver_branch_id)
                                                    {{ __($courierInfo->receiverBranch->name) }}
                                                @else
                                                    @lang('N/A')
                                                @endif
                                            </span>
                                            <br>
                                            @if ($courierInfo->receiver_staff_id)
                                                <span class="text--primary">{{ __($courierInfo->receiverStaff->username) }}</span>
                                            @else
                                                <span>@lang('N/A')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ showAmount(@$courierInfo->paymentInfo->final_amount) }}
                                                {{ __($general->cur_text) }}</span><br>
                                            <span>{{ $courierInfo->code }}</span>
                                        </td>
                                        <td>
                                            {{ showDateTime($courierInfo->created_at, 'd M Y') }}<br>{{ diffForHumans($courierInfo->created_at) }}
                                        </td>
                                        <td>
                                            @if(!$courierInfo->paymentInfo)
                                                <span class="badge badge--danger">@lang('Unpaid')</span>
                                            @else
                                                @if ($courierInfo->paymentInfo->status == Status::PAID)
                                                    <span class="badge badge--success">@lang('Paid')</span>
                                                @elseif($courierInfo->paymentInfo->status == Status::UNPAID)
                                                    <span class="badge badge--danger">@lang('Unpaid')</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($courierInfo->status == Status::COURIER_QUEUE)
                                                <span class="badge badge--danger">@lang('Sent In Queue')</span>
                                            @elseif($courierInfo->status == Status::COURIER_DISPATCH)
                                                @if (auth()->user()->branch_id == $courierInfo->sender_branch_id)
                                                    <span class="badge badge--warning">@lang('Dispatch')</span>
                                                @else
                                                    <span class="badge badge--warning">@lang('Upcoming')</span>
                                                @endif
                                            @elseif($courierInfo->status == Status::COURIER_DELIVERYQUEUE)
                                                <span class="badge badge--primary">@lang('Delivery In Queue')</span>
                                            @elseif($courierInfo->status == Status::COURIER_DELIVERED)
                                                <span class="badge badge--success">@lang('Delivered')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('manager.courier.invoice', encrypt($courierInfo->id)) }}"
                                                title="" class="btn btn-sm btn-outline--info">
                                                <i class="las la-file-invoice"></i> @lang('Invoice')
                                            </a>
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
                @if ($courierInfos->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($courierInfos) }}
                    </div>
                @endif
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
