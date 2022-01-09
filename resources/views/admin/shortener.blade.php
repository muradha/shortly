@section('site_title', formatTitle([__('Shortener'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Shortener')],
]])

<h2 class="mb-3 d-inline-block">{{ __('Shortener') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header"><div class="font-weight-medium py-1">{{ __('Shortener') }}</div></div>
    <div class="card-body">

        <ul class="nav nav-pills d-flex flex-fill flex-column flex-md-row mb-3" id="pills-tab" role="tablist">
            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link active" id="pills-shortener-tab" data-toggle="pill" href="#pills-shortener" role="tab" aria-controls="pills-smtp" aria-selected="true">{{ __('Shortener') }}</a>
            </li>
            <li class="nav-item flex-grow-1 text-center">
                <a class="nav-link" id="pills-gsb-tab" data-toggle="pill" href="#pills-gsb" role="tab" aria-controls="pills-contact" aria-selected="false">{{ __('Google Safe Browsing') }}</a>
            </li>
        </ul>

        @include('shared.message')

        <form action="{{ route('admin.shortener') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-shortener" role="tabpanel" aria-labelledby="pills-shortener-tab">
                    <div class="form-group">
                        <label for="i-short-guest">{{ __('Guest shortening') }}</label>
                        <select name="short_guest" id="i-short-guest" class="custom-select{{ $errors->has('short_guest') ? ' is-invalid' : '' }}">
                            @foreach([0 => __('Disabled'), 1 => __('Enabled')] as $key => $value)
                                <option value="{{ $key }}" @if ((old('short_guest') !== null && old('short_guest') == $key) || (config('settings.short_guest') == $key && old('short_guest') == null)) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('short_guest'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('short_guest') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-short-protocol" class="d-flex align-items-center"><span>{{ __('Domains protocol') }}</span> <span data-enable="tooltip" title="{{ __('Use HTTPS only if you are able to generate SSL certificates for the additional domains.') }}" class="d-flex align-items-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}">@include('icons.info', ['class' => 'fill-current text-muted width-4 height-4'])</span></label>
                        <select name="short_protocol" id="i-short-protocol" class="custom-select{{ $errors->has('short_protocol') ? ' is-invalid' : '' }}">
                            @foreach(['http' => 'HTTP', 'https' => 'HTTPS'] as $key => $value)
                                <option value="{{ $key }}" @if ((old('short_protocol') !== null && old('short_protocol') == $key) || (config('settings.short_protocol') == $key && old('short_protocol') == null)) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('short_protocol'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('short_protocol') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-short-bad-words">{{ __('Bad words') }}</label>
                        <textarea name="short_bad_words" id="i-short-bad-words" class="form-control{{ $errors->has('short_bad_words') ? ' is-invalid' : '' }}" rows="3" placeholder="One per line.">{{ config('settings.short_bad_words') }}</textarea>
                        @if ($errors->has('short_bad_words'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('short_bad_words') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-short-domain" class="d-flex align-items-center">{{ __('Domain') }} ({{ __('Default') }})</label>
                        <select name="short_domain" id="i-short-domain" class="custom-select">
                            @foreach($domains as $domain)
                                <option value="{{ $domain->id }}" @if (config('settings.short_domain') == $domain->id) selected @endif>{{ str_replace(['http://', 'https://'], '', $domain->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-gsb" role="tabpanel" aria-labelledby="pills-gsb-tab">
                    <div class="form-group">
                        <label for="i-short-gsb">{{ __('Enabled') }}</label>
                        <select name="short_gsb" id="i-short-gsb" class="custom-select{{ $errors->has('short_gsb') ? ' is-invalid' : '' }}">
                            @foreach([0 => __('No'), 1 => __('Yes')] as $key => $value)
                                <option value="{{ $key }}" @if ((old('short_gsb') !== null && old('short_gsb') == $key) || (config('settings.short_gsb') == $key && old('short_gsb') == null)) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('short_gsb'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('short_gsb') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="i-short-gsb-key">{{ __('API key') }}</label>
                        <input type="password" name="short_gsb_key" id="i-short-gsb-key" class="form-control{{ $errors->has('short_gsb_key') ? ' is-invalid' : '' }}" value="{{ old('short_gsb_key') ?? config('settings.short_gsb_key') }}">
                        @if ($errors->has('short_gsb_key'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('short_gsb_key') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>

    </div>
</div>