<div>
    <div class="card card-custom">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col m-0">
                    <label class="font-size-h4 font-weight-bold">Cliente</label>
                    <select class="form-control select2 kt-select-dealers" id="dealer_id">
                        <option label="Label"></option>
                    </select>
                </div>
            </div>
        </div>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#dealer_id').on('select2:select', function (e) {
                var data = e.params.data;
                Livewire.emitTo(@this.module, @this.listener, data.id);
            });
        });
    </script>
@endpush
