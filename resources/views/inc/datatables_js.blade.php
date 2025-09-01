<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
            alert(message);
        };
        $.extend($.fn.dataTable.defaults, {
            processing: true,
            autoWidth: false,
            language: {
                url: '{{ asset("assets/json/datatables/lang/".app()->currentLocale().".json") }}'
            },
            stateSave: true,
            stateSaveCallback: function(settings, data) {
                localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
            },
            stateLoadCallback: function(settings) {
                return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
            },
            columnDefs: [
                {
                    targets: 'dt-body-amount',
                    className: 'text-right',
                    render: function (data, type, row, meta) {
                        if (data != '' && data != null) {
                            return parseFloat(data).toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                        return '0.00';
                    }
                },
                {
                    targets: 'dt-body-center',
                    className: 'text-center'
                },
                {
                    targets: 'dt-body-right',
                    className: 'text-right'
                },
                {
                    targets: 'dt-body-left',
                    className: 'text-left'
                },
                {
                    targets: 'dt-body-nowrap',
                    className: 'text-nowrap'
                },
                {
                    targets: 'dt-body-ellipsis',
                    className: 'text-ellipsis'
                }
            ]
        });
    });
</script>
