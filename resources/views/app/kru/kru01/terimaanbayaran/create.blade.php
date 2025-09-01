@extends('layouts.app')


<style>
    .select2-container--open {
        z-index: 2000;
    } 
</style>
@section('content')

    <!-- Page Content -->
    <div id="app-content">
        <!-- Container fluid -->
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <!-- Page header -->
                        <div class="mb-5">
                            <h3 class="mb-0">Terimaan Bayaran</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-right">
                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('kadpendaftarannelayan.terimaanbayaran.index') }}">Permohonan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Terimaan Bayaran</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Card -->
                    <div class="card">
                        <!-- card body -->
                        <div class="card-body">
                            <h6 class="section-title" style="font-weight: bold; color: #1070d5; border-bottom: 2px solid #1070d5; padding-bottom: 5px; margin-bottom: 0%;">Terimaan Bayaran</h6>
                            <form id="form" method="POST" enctype="multipart/form-data" action="{{ route('kadpendaftarannelayan.terimaanbayaran.storeReceipt',$id) }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="paymentReceiptNo">Nombor Resit Bayaran <span style="color: red;">*</span></label>
                                                <input type="text" name="paymentReceiptNo" class="form-control" id="paymentReceiptNo" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="kadPengenalanDoc">Resit Bayaran <span style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="paymentReceipt" name="paymentReceipt" required>
                                                        <label class="custom-file-label" for="paymentReceipt">Pilih Fail</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive">
                                            <div class="form-group">
                                                <label class="col-form-label">Senarai Item:</label>
                                                <button type="button" class="btn btn-secondary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#itemModal">
                                                    <i class="fas fa-plus"></i>
                                                    Tambah Item
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Item Bayaran</th>
                                                    <th>RM</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                                </thead>
                                                <tbody id="listItem">
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-lg-center mt-3">
                                            <a href="{{ route('kadpendaftarannelayan.terimaanbayaran.show',$id) }}" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                                            <button id="btnSubmit" type="submit" name="action" value="submit" class="btn btn-secondary btn-sm" onclick="return confirm($('<span>Simpan Maklumat Bayaran?</span>').text())">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="itemModalLabel">Tambah Item</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="modalForm">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Item Bayaran <span style="color: red;">*</span></label>
                                                            <select class="form-control select2" id="selItemType" name="selItemType" style="width: 100%;" required>
                                                                <option selected="selected" value="">- Sila Pilih -</option>
                                                                @foreach ($paymentItems as $paymentItem)
                                                                    <option value="{{$paymentItem->id}}">{{$paymentItem->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="amount">Bayaran (RM) <span style="color: red;">*</span></label>
                                                            <input type="number" name="amount" class="form-control" id="amount" step=".01" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-info btn-sm" data-bs-dismiss="modal">Kembali</a>
                                                <a class="btn btn-secondary btn-sm" id="btnAddItem" class="btn btn-primary">Tambah</a>
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
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script type="text/javascript">
        bsCustomFileInput.init();  
        $(document).ready(function () {
            var validator = $( "#modalForm" ).validate();
            $("#btnAddItem").click(function() {
                validator.form();

                //get container
                var ItemTypeSel = $('#selItemType option:selected');
                var AmountNum = $('#amount');

                //get input
                var addedItemTypeSel = ItemTypeSel.val();
                var addedItemTypeSelText = ItemTypeSel.text();
                var addedAmountNum = AmountNum.val();

                //clear input
                $('#selItemType').val(null).trigger('change');;
                AmountNum.val('');

                //addrow
                // var rowCount = $('#listItem tr').length;
                // <td>${rowCount+1}</td>
                $('#listItem:last').append(`
                <tr>
                    <td>
                        <input type="hidden" name="item_id[]" value="${addedItemTypeSel}" />${addedItemTypeSelText}
                    </td>
                    <td>
                        <input type="hidden" name="amount[]" value="${addedAmountNum}" />
                        ${addedAmountNum}
                    </td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-tr"><i class="fas fa-trash"></i></button></td>
                </tr>
                `);

                $('#itemModal').modal('hide');
            });

        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }

        //Peranan tidak dipilih
        var msg2 = '{{Session::get('alert2')}}';
        var exist2 = '{{Session::has('alert2')}}';
        if(exist2){
            alert(msg2);
        }

    </script>
@endpush
