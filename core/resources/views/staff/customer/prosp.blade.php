@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two  white-space-wrap" id="customer">
                        <thead>
                            <tr>
                                <th>@lang('Date Creation')</th>
                                <th>@lang('Nom Prenom')</th>
                                <th>@lang('Contact')</th>
                                
                                <th>@lang('Objet')</th>
                                <th>@lang('Action')</th>
                              
                                <th>@lang('')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($clients as $client)
                            <tr>
                            <td data-label="@lang('Date Creation')">
                                <span> {{date('d-m-Y', strtotime($client->created_at))}}</span>
                                </td>
                                    <td data-label="@lang('Nom Prenom')">
                                    <span>{{__($client->client->nom)}}</span><br>
                                  
                                </td>

                                <td data-label="@lang('Contact')">
                                    <span>
                                    {{$client->client->contact}}
                                    </span>
                                </td>
                                 <td data-label="@lang('Observation')">
                                 <span>{{$client->observation}}</span>
                                </td>
                                <td data-label="@lang('Action')">
                                 <span>{{$client->action}}</span>
                                </td>
                                <td data-label="@lang('Option')">
                                  
                                   <a href="{{route('staff.prospect.editprospect', encrypt($client->id))}}" title="" class="icon-btn btn--priamry ml-1">@lang('Details')</a>
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
                {{ paginateLinks($clients) }}
            </div>
        </div>
    </div>
</div>

@endsection


@push('breadcrumb-plugins')
<a href="{{route('staff.prospect.create')}}" class="btn btn-sm btn--primary box--shadow1 text--small addUnit"><i class="fa fa-fw fa-paper-plane"></i>@lang('Ajouter Prospect')</a>

<form action="{{route('staff.customer.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Contact Client')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
@push('script')

@endpush