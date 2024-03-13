<x-app-layout>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Reporte de ventas por cliente </h5>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form action="{{ route('reports.sales.dealers.export') }}" method="POST">
                @csrf

                <div class="card card-custom">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Desde</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                    <input name="date_from" id="date_from" value="{{ $date_from }}" type="text" class="form-control kt-datepicker" maxlength="10" />
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Hasta</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                    <input name="date_to" id="date_to" value="{{ $date_to }}" type="text" class="form-control kt-datepicker" maxlength="10" />
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>Cliente</label>
                                <select class="form-control select2 kt-select-dealers" id="dealer_id" name="dealer_id">
                                    <option label="Label"></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Estatus Producto</label>
                                <select name="status_detail" id="status_detail" class="custom-select form-control">
                                    <option value="">::. Seleccionar .::</option>
                                    <option value="pending">Pendiente</option>
                                    <option value="changed">Cambiado</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Estatus Contrato</label>
                                <select name="status_parent" id="status_parent" class="custom-select form-control">
                                    <option value="">::. Seleccionar .::</option>
                                    <option value="open">Abierto</option>
                                    <option value="closed">Cerrado</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <div class="radio-inline">
                                    <label class="radio">
                                        <input type="radio" name="export" id="export" value="pdf" checked />
                                        <span></span>
                                        PDF
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="export" id="export" value="xls" />
                                        <span></span>
                                        Excel
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-file-export"></i>
                            <span>Exportar</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                initAll();

                $(".kt-select-dealers").select2({
                    placeholder: "Seleccionar cliente",
                    allowClear: true,
                    ajax: {
                        url: "{{ route('api.dealers') }}",   //"https://api.github.com/search/repositories",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term,
                                page: params.page
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                    minimumInputLength: 1,
                    templateResult: formatRepo,
                    templateSelection: formatRepoSelection,
                    language: {
                        errorLoading: function () {
                            return 'No se pudieron cargar los resultados';
                        },
                        inputTooLong: function (args) {
                            var remainingChars = args.input.length - args.maximum;

                            var message = 'Por favor, elimine ' + remainingChars + ' car';

                            if (remainingChars == 1) {
                                message += 'ácter';
                            } else {
                                message += 'acteres';
                            }

                            return message;
                        },
                        inputTooShort: function (args) {
                            var remainingChars = args.minimum - args.input.length;

                            var message = 'Por favor, introduzca ' + remainingChars + ' car';

                            if (remainingChars == 1) {
                                message += 'ácter';
                            } else {
                                message += 'acteres';
                            }

                            return message;
                        },
                        loadingMore: function () {
                            return 'Cargando más resultados…';
                        },
                        maximumSelected: function (args) {
                            var message = 'Sólo puede seleccionar ' + args.maximum + ' elemento';

                            if (args.maximum != 1) {
                                message += 's';
                            }

                            return message;
                        },
                        noResults: function () {
                            return 'No se encontraron resultados';
                        },
                        searching: function () {
                            return 'Buscando…';
                        },
                        removeAllItems: function () {
                            return 'Eliminar todos los elementos';
                        }
                    }
                });

                function formatRepo(repo) {
                    if (repo.loading) return repo.text;

                    var markup = `
                        <div class="select2-result-dealers clearfix">
                            <div class="select2-result-dealers__meta font-size-h4">
                                ${repo.name}
                            </div>
                            <div class="select2-result-dealers__info">
                                <div class="select2-result-dealers__info d-flex align-items-center justify-content-between">
                                    <div class="w-100"><small class="text-muted d-block">Codigo: </small> <b>${repo.code}</b></b> </div>
                                    <div class="w-100"><small class="text-muted d-block">Telefono: </small> ${repo.phone}</div>
                                </div>
                            </div>
                        </div>
                    `;
                    return markup;
                }

                function formatRepoSelection(repo) {
                    return repo.name || repo.text;
                }
            });
        </script>
    @endpush

</x-app-layout>
