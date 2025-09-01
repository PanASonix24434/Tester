@extends('layouts.landing')
@include('layouts.page_title')

@push('top_script')
    <link rel="stylesheet" href="{{ asset('template/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

@section('content')
    <form id="form-create" method="POST" action="{{ route('landing.ticket.store') }}" autocomplete="off" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" data-card-widget="collapse">
                        <h3 class="card-title">{{ __('app.incident_details') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('app.summary') }}</label>
                                    <input id="summary" type="text" class="form-control @error('summary') is-invalid @enderror" name="summary" placeholder="{{ __('app.summary') }}" value="{{ old('summary') }}" required>
                                    @error('summary')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('app.details') }}</label>
                                    <textarea id="details" class="form-control summernote @error('details') is-invalid @enderror" name="details" placeholder="{{ __('app.details') }}">{{ old('details') }}</textarea>
                                    @error('details')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('app.attachment') }}</label>
                                    <div class="custom-file">
                                        <input id="attachment" type="file" class="custom-file-input" name="attachment[]" multiple="multiple">
                                        <label for="attachment" class="custom-file-label">{{ __('app.select_item', ['item' => __('app.attachment')]) }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" data-card-widget="collapse">
                        <h3 class="card-title">{{ __('app.reported_by') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('app.name') }}</label>
                                    <input type="text" class="form-control input-capitalize @error('requested_by_name') is-invalid @enderror" name="requested_by_name" placeholder="{{ __('app.name') }}" value="{{ old('requested_by_name') }}" required>
                                    @error('requested_by_name')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('app.email') }}</label>
                                    <input type="email" class="form-control @error('requested_by_email') is-invalid @enderror" name="requested_by_email" placeholder="{{ __('app.email') }}" value="{{ old('requested_by_email') }}" required>
                                    @error('requested_by_email')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('app.date') }}</label>
                                    <input id="requested_date" type="datetime-local" class="form-control" name="requested_date" placeholder="{{ __('app.date') }}" value="{{ old('requested_date') }}">
                                    @error('requested_date')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-3">
                <a href="javascript:void(0);" class="btn btn-primary btn-lg" onclick="formSubmit(this, 'form-create', '{{ __('app.submitting') }}...');"><i class="fas fa-share"></i> {{ __('app.submit') }}</a>
            </div>
        </div>
    </form>
@endsection

@push('bottom_script')
    @include('inc.form_action')
    <script src="{{ asset('template/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('form').find('.card').addClass('card-secondary');

            $('.summernote').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    // ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    // ['height', ['height']],
                    ['view', ['undo', 'redo']]
                ]
            });

            bsCustomFileInput.init();
        });
    </script>
@endpush
