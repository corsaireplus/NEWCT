@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Branch')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Income')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($branchIncomes as $branchIncome)
                                    <tr>
                                        <td>
                                            <span>{{ __(@$branchIncome->branch->name) }}</span>
                                        </td>
                                        <td>
                                            <span>{{ showDateTime($branchIncome->date, 'd M Y') }}</span>
                                        </td>
                                        <td>
                                            <span>{{ getAmount($branchIncome->totalAmount) }}
                                                {{ __($general->cur_text) }}</span>
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
                @if ($branchIncomes->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($branchIncomes) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form action="" method="GET" class="d-flex gap-2">
        <div class="input-group">
            <select class="form-control" name="branch_id">
                <option value="">@lang('Select Branch')</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" @selected(request()->branch_id == $branch->id)>
                        {{ __($branch->name) }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
        <x-date-filter placeholder="Start date - End date" />
    </form>
@endpush
