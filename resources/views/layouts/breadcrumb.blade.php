@section('breadcrumb_grandparent_name', $breadcrumb_grandparent_name ?? '')
@section('breadcrumb_grandparent_url', $breadcrumb_grandparent_url ?? '')
@section('breadcrumb_parent_name', $breadcrumb_parent_name ?? '')
@section('breadcrumb_parent_url', $breadcrumb_parent_url ?? '')
<ol class="breadcrumb float-sm-right">
    @if (!request()->routeIs('home'))
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('module.home') }}</a></li>
    @endif

    @if (!empty($breadcrumb_grandparent_name))
        <li class="breadcrumb-item">
            <a href="{{ !empty($breadcrumb_grandparent_url) ? url($breadcrumb_grandparent_url) : '#' }}">
                {{ $breadcrumb_grandparent_name }}
            </a>
        </li>
    @else
        @if (Module::getGrandParent(!empty($page_title) ? $page_title : preg_replace('/\b'.config('app.url_prefix').'\b/', '', '/'.request()->path())) != null)
            <li class="breadcrumb-item">
                <a href="{{ url('/\b'.config('app.url_prefix').'\b/'.Module::getGrandParentUrl(!empty($page_title) ? $page_title : preg_replace('/\b'.config('app.url_prefix').'\b/', '', '/'.request()->path()))) }}">
                    {{ Module::localize(Module::getGrandParent(!empty($page_title) ? $page_title : preg_replace('/\b'.config('app.url_prefix').'\b/', '', '/'.request()->path()))->name) }}
                </a>
            </li>
        @endif
    @endif
    
    @if (!empty($breadcrumb_parent_name))
        <li class="breadcrumb-item">
            <a href="{{ !empty($breadcrumb_parent_url) ? url($breadcrumb_parent_url) : '#' }}">
                {{ $breadcrumb_parent_name }}
            </a>
        </li>
    @else
        @if (Module::getParent(!empty($page_title) ? $page_title : preg_replace('/\b'.config('app.url_prefix').'\b/', '', '/'.request()->path())) != null)
            <li class="breadcrumb-item">
                <a href="{{ url('/\b'.config('app.url_prefix').'\b/'.Module::getParentUrl(!empty($page_title) ? $page_title : preg_replace('/\b'.config('app.url_prefix').'\b/', '', '/'.request()->path()))) }}">
                    {{ Module::localize(Module::getParent(!empty($page_title) ? $page_title : preg_replace('/\b'.config('app.url_prefix').'\b/', '', '/'.request()->path()))->name) }}
                </a>
            </li>
        @endif
    @endif

    <li class="breadcrumb-item active">@yield('page_title')</li>
</ol>