        </div>
    </main>

    <!-- Footer -->
    <footer class="lg:pl-64 py-4 bg-white border-t border-slate-200">
        <div class="container mx-auto px-4 lg:px-6">
            <p class="text-center text-slate-500 text-sm">
                &copy; <?php echo date("Y"); ?> YDI Admin Panel. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons for Glyphicon replacement -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables with Tailwind styling
            if ($('#dyntable').length) {
                $('#dyntable').DataTable({
                    "pageLength": 25,
                    "ordering": true,
                    "searching": true,
                    "language": {
                        "search": "",
                        "searchPlaceholder": "Search...",
                        "lengthMenu": "Show _MENU_ entries",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries"
                    },
                    "dom": '<"flex flex-wrap items-center justify-between gap-4 mb-4"<"flex items-center gap-2"l><"flex items-center gap-2"f>>rt<"flex flex-wrap items-center justify-between gap-4 mt-4"<"text-slate-600 text-sm"i><"flex gap-1"p>>',
                    "drawCallback": function() {
                        // Style pagination buttons
                        $('.paginate_button').addClass('px-3 py-1 rounded-lg text-sm');
                        $('.paginate_button.current').addClass('bg-primary-500 text-white');
                        $('.paginate_button:not(.current):not(.disabled)').addClass('bg-slate-100 text-slate-700 hover:bg-slate-200');
                    }
                });

                // Style the search input
                $('input[type="search"]').addClass('px-4 py-2 border border-slate-200 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-colors');

                // Style the length select
                $('select[name="dyntable_length"]').addClass('px-4 py-2 border border-slate-200 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-colors');
            }

            // Form validation
            if (typeof $.fn.validationEngine !== 'undefined') {
                $("#vfrm").validationEngine();
            }
        });

        function onSelectChange() {
            document.getElementById('frm').submit();
        }
    </script>

    <style>
        /* DataTables custom styling */
        .dataTables_wrapper .dataTables_filter input {
            @apply px-4 py-2 border border-slate-200 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-colors;
        }

        .dataTables_wrapper .dataTables_length select {
            @apply px-4 py-2 border border-slate-200 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-colors;
        }

        table.dataTable thead th {
            @apply bg-slate-50 text-slate-700 font-semibold text-left px-4 py-3 border-b border-slate-200;
        }

        table.dataTable tbody td {
            @apply px-4 py-3 border-b border-slate-100;
        }

        table.dataTable tbody tr:hover {
            @apply bg-slate-50;
        }

        /* Admin utility classes */
        .admin-card {
            @apply bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden;
        }

        .admin-card-header {
            @apply px-6 py-4 bg-gradient-to-r from-primary-500 to-secondary-400 text-white font-semibold;
        }

        .admin-card-body {
            @apply p-6;
        }

        .admin-btn {
            @apply inline-flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition-all duration-200;
        }

        .admin-btn-primary {
            @apply bg-primary-500 text-white hover:bg-primary-600 shadow-sm hover:shadow;
        }

        .admin-btn-secondary {
            @apply bg-slate-100 text-slate-700 hover:bg-slate-200;
        }

        .admin-btn-danger {
            @apply bg-red-500 text-white hover:bg-red-600 shadow-sm hover:shadow;
        }

        .admin-btn-success {
            @apply bg-green-500 text-white hover:bg-green-600 shadow-sm hover:shadow;
        }

        .admin-input {
            @apply w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 outline-none transition-colors;
        }

        .admin-label {
            @apply block text-sm font-medium text-slate-700 mb-2;
        }

        .admin-alert {
            @apply p-4 rounded-xl mb-4;
        }

        .admin-alert-success {
            @apply bg-green-50 text-green-700 border border-green-200;
        }

        .admin-alert-error {
            @apply bg-red-50 text-red-700 border border-red-200;
        }

        .admin-alert-warning {
            @apply bg-yellow-50 text-yellow-700 border border-yellow-200;
        }

        /* Legacy Bootstrap compatibility */
        .panel { @apply admin-card; }
        .panel-primary { @apply admin-card; }
        .panel-heading { @apply admin-card-header; }
        .panel-title { @apply font-semibold; }
        .panel-body { @apply admin-card-body; }

        .btn { @apply admin-btn; }
        .btn-primary { @apply admin-btn-primary; }
        .btn-danger { @apply admin-btn-danger; }
        .btn-success { @apply admin-btn-success; }
        .btn-default { @apply admin-btn-secondary; }

        .form-control { @apply admin-input; }
        .form-group { @apply mb-4; }

        .table { @apply w-full; }
        .table > thead > tr > th { @apply bg-slate-50 text-slate-700 font-semibold text-left px-4 py-3 border-b border-slate-200; }
        .table > tbody > tr > td { @apply px-4 py-3 border-b border-slate-100; }
        .table > tbody > tr:hover { @apply bg-slate-50; }
        .table-striped > tbody > tr:nth-of-type(odd) { @apply bg-slate-25; }

        .alert { @apply admin-alert; }
        .alert-success { @apply admin-alert-success; }
        .alert-danger { @apply admin-alert-error; }
        .alert-warning { @apply admin-alert-warning; }

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }

        .img-responsive { @apply max-w-full h-auto; }
        .img-thumbnail { @apply rounded-lg border border-slate-200; }

        .row { @apply flex flex-wrap -mx-4; }
        .col-md-3 { @apply w-full md:w-1/4 px-4; }
        .col-md-4 { @apply w-full md:w-1/3 px-4; }
        .col-md-6 { @apply w-full md:w-1/2 px-4; }
        .col-md-8 { @apply w-full md:w-2/3 px-4; }
        .col-md-9 { @apply w-full md:w-3/4 px-4; }
        .col-md-12 { @apply w-full px-4; }

        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 1rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }

        /* Additional Bootstrap grid */
        .col-xs-3 { @apply w-1/4 px-2; }
        .col-xs-4 { @apply w-1/3 px-2; }
        .col-xs-6 { @apply w-1/2 px-2; }
        .col-xs-12 { @apply w-full px-2; }
        .col-sm-6 { @apply sm:w-1/2 px-2; }
        .col-sm-12 { @apply sm:w-full px-2; }

        /* Bootstrap utilities */
        .pull-right { @apply float-right; }
        .pull-left { @apply float-left; }
        .clearfix::after { content: ""; display: table; clear: both; }
        .btn-group { @apply inline-flex gap-1; }
        .btn-sm { @apply px-3 py-1.5 text-sm; }
        .img-rounded { @apply rounded-lg; }
        .control-label { @apply block text-sm font-medium text-slate-700 mb-1; }
        .responsive { @apply w-full; }
        .table-bordered { @apply border border-slate-200; }

        /* Labels/Badges */
        .label { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium; }
        .label-success { @apply bg-green-100 text-green-800; }
        .label-danger { @apply bg-red-100 text-red-800; }
        .label-warning { @apply bg-yellow-100 text-yellow-800; }
        .label-primary { @apply bg-primary-100 text-primary-800; }
        .label-large { @apply px-3 py-1 text-sm; }

        /* Glyphicon to Bootstrap Icons mapping */
        .glyphicon { font-family: 'bootstrap-icons' !important; font-style: normal; font-weight: normal !important; }
        .glyphicon::before { font-family: 'bootstrap-icons' !important; }
        .glyphicon-eye-open::before { content: "\F341"; }
        .glyphicon-edit::before { content: "\F4CA"; }
        .glyphicon-trash::before { content: "\F5DE"; }
        .glyphicon-plus::before { content: "\F4FE"; }
        .glyphicon-pencil::before { content: "\F4CA"; }
        .glyphicon-remove::before { content: "\F62A"; }
        .glyphicon-ok::before { content: "\F26B"; }
        .glyphicon-search::before { content: "\F52A"; }
        .glyphicon-home::before { content: "\F3DC"; }
        .glyphicon-user::before { content: "\F4DA"; }
        .glyphicon-cog::before { content: "\F3E5"; }
        .glyphicon-picture::before { content: "\F3F8"; }
        .glyphicon-film::before { content: "\F32C"; }
        .glyphicon-th-list::before { content: "\F473"; }
        .glyphicon-menu-hamburger::before { content: "\F479"; }
        .glyphicon-log-out::before { content: "\F1C3"; }
        .glyphicon-dashboard::before { content: "\F3F1"; }
        .glyphicon-list::before { content: "\F479"; }
        .glyphicon-folder-open::before { content: "\F3D5"; }
        .glyphicon-file::before { content: "\F3E9"; }
        .glyphicon-envelope::before { content: "\F32F"; }
        .glyphicon-star::before { content: "\F586"; }
        .glyphicon-info-sign::before { content: "\F431"; }
        .glyphicon-question-sign::before { content: "\F504"; }
        .glyphicon-exclamation-sign::before { content: "\F33B"; }
        .glyphicon-chevron-left::before { content: "\F284"; }
        .glyphicon-chevron-right::before { content: "\F285"; }
        .glyphicon-arrow-left::before { content: "\F12F"; }
        .glyphicon-arrow-right::before { content: "\F138"; }

        /* Textarea styling */
        textarea.form-control { @apply min-h-32 resize-y; }

        /* Panel title with flex */
        .panel-title { @apply flex items-center justify-between flex-wrap gap-2; }
    </style>

</body>
</html>
