@extends('layouts.app')

@push('styles')
    <style type="text/css">
    </style>
@endpush

@section('content')

    <!-- Page Content -->
    <div id="app-content">

        <!-- Container fluid -->
        <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- Page header -->
                    <div class="mb-5">
                        <h3 class="mb-0">Senarai Nama ESHND Hq</h3>
                    </div>
                </div>
                <div class="col-md-6">
                   
                </div>
            </div>
            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">
                            <div class="card-header">
                            <!-- <h6><i class="fas fa-list"></i> Janaan Senarai Nama ESHND Hq:</h6> -->
                            
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered table-hover">

                                        <thead class="table-light">
                                            <tr> 
                                                <th><b>Nama</b></th>
                                                <th><b>No Kad Pengenalan</b></th>
                                                <th><b>Pendaratan ({{$month}}/{{$year}})</b></th>
                                                <th><b>Pejabat</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$lists->isEmpty())
                                                @foreach ($lists as $a)
                                                    @php
                                                        $user = App\Models\User::find($a->user_id);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $user != null ? $user->name : '' }}</td>
                                                        <td>{{ $user != null ? $user->username : '' }}</td>
                                                        <td>
                                                            @if ($a->has_landing)
                                                                <span class="badge bg-success">Ada Pendaratan</span>
                                                            @else
                                                                <span class="badge bg-danger">Tiada Pendaratan</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $user != null ? App\Models\Entity::find($a->entity_id)->entity_name : '' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="text-center">
                                                    <td colspan="4">{{ __('app.no_record_found') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    
                                    </table>
                                </div>
                            </div>
                            <div
                                class="card-footer d-md-flex justify-content-between align-items-center">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        {!! $lists->appends(Request::except('page'))->render() !!}
                                    </div>
                                </div>
                                @if (!$lists->isEmpty())
                                    <div class="col-md-4">
                                        <span class="float-md-right">
                                            {{ __('app.table_info', [ 'first' => $lists->firstItem(), 'last' => $lists->lastItem(), 'total' => $lists->total() ]) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <form action="{{ route('subsistenceallowancepayment.generatenamehq.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="entity_id" value="{{$entity_id}}">
                                    <input type="hidden" name="selMonth" value="{{$month}}">
                                    <input type="hidden" name="selYear" value="{{$year}}">
                                    <div class="row">
                                        <br />
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0" style="margin-top:-10px;">
                                            <a href="{{ route('subsistenceallowancepayment.generatenamehq.index') }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            <button type="submit" class="btn btn-primary btn-sm">Simpan Janaan Senarai Nama Hq</button> 
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">

        $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

        function resetForm() {
                // Reset all input fields
                document.querySelector('input[name="txtNoAccount"]').value = '';
                document.querySelector('input[name="txtName"]').value = '';
                document.querySelector('input[name="txtNoFail"]').value = '';
                document.querySelector('input[name="txtNoKP"]').value = '';

                

                // Submit the form to retrieve all list data
                document.getElementById('search-form').submit();
            }

</script>   
@endpush
