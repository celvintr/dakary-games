<x-app-layout>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Reporte de ventas por tipo de producto </h5>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form action="{{ route('reports.sales.cards.export') }}" method="POST">
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
                                <label>Productos</label>
                                <select name="card_id" id="card_id" class="custom-select form-control">
                                    <option value="">::. Producto .::</option>
                                    @foreach ($cards as $card)
                                        <option value="{{ $card->id }}">{{ $card->name }}</option>
                                    @endforeach
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
            });
        </script>
    @endpush

</x-app-layout>
