@section('site_title', formatTitle([__('Pixels'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Pixels')],
]])

<div class="d-flex">
    <div class="flex-grow-1">
        <h2 class="mb-3 d-inline-block">{{ __('Pixels') }}</h2>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col-12 col-md"><div class="font-weight-medium py-1">{{ __('Pixels') }}</div></div>
            <div class="col-12 col-md-auto">
                <form method="GET" action="{{ route('admin.pixels') }}" class="d-md-flex">
                    @include('shared.filter-tags')
                    <div class="input-group input-group-sm">
                        <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn {{ request()->input('search') || request()->input('type') || request()->input('sort') ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                            <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64" id="search-filters">
                                <div class="dropdown-header py-1">
                                    <div class="row">
                                        <div class="col"><div class="font-weight-medium m-0 text-dark text-truncate">{{ __('Filters') }}</div></div>
                                        <div class="col-auto">
                                            @if(request()->input('search') || request()->input('type') || request()->input('sort'))
                                                <a href="{{ route('admin.pixels') }}" class="text-secondary">{{ __('Reset') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <div class="form-group px-4">
                                    <label for="i-type" class="small">{{ __('Type') }}</label>
                                    <select name="type" id="i-type" class="custom-select custom-select-sm">
                                        <option value="">{{ __('All') }}</option>
                                        @foreach(config('pixels') as $key => $value)
                                            <option value="{{ $key }}" @if(request()->input('type') == $key && request()->input('type') !== null) selected @endif>{{ $value['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group px-4">
                                    <label for="i-sort" class="small">{{ __('Sort') }}</label>
                                    <select name="sort" id="i-sort" class="custom-select custom-select-sm">
                                        @foreach(['desc' => __('Descending'), 'asc' => __('Ascending')] as $key => $value)
                                            <option value="{{ $key }}" @if(request()->input('sort') == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group px-4 mb-2">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">{{ __('Search') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        @if(count($pixels) == 0)
            {{ __('No results found.') }}
        @else
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0 text-muted">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-5 d-flex">
                                    {{ __('Name') }}
                                </div>

                                <div class="col-12 col-lg-5 d-flex">
                                    {{ __('User') }}
                                </div>

                                <div class="col-12 col-lg-2 d-flex">
                                    {{ __('Links') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-row">
                                <div class="col">
                                    <div class="invisible btn d-flex align-items-center btn-sm text-primary">@include('icons.horizontal-menu', ['class' => 'fill-current width-4 height-4'])&#8203;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($pixels as $pixel)
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col text-truncate">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg-5 d-flex">
                                        <div class="text-truncate">
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center text-truncate">
                                                    <img src="{{ asset('/images/icons/pixels/' . md5(strtolower($pixel->type))) }}.svg" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                                    <div class="text-truncate"><a href="{{ route('pixels.edit', $pixel->id) }}">{{ $pixel->name }}</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-5 d-flex align-items-center">
                                        <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                            <img src="{{ gravatar($pixel->user->email, 48) }}" class="rounded-circle width-6 height-6">
                                        </div>
                                        <a href="{{ route('admin.users.edit', $pixel->user->id) }}">{{ $pixel->user->name }}</a>
                                    </div>

                                    <div class="col-12 col-lg-2 d-flex">
                                        <a href="{{ route('admin.links', ['pixel' => $pixel->id]) }}" class="text-dark">{{ $pixel->totalLinks }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-row">
                                    <div class="col">
                                        @include('pixels.partials.menu')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3 align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $pixels->firstItem(), 'to' => $pixels->lastItem(), 'total' => $pixels->total()]) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            {{ $pixels->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>