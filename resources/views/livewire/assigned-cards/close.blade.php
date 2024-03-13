<div>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ ($assigned['status'] == 'open' ? 'Cerrar Contrato' : 'Detalle de Productos') }}</h5>
    </x-slot>

    <form wire:submit.prevent="close" autocomplete="off">
        <div class="row mb-2">
            <div class="col">
                <div class="card card-custom">
                    <div class="card-header py-0 min-h-50px">
                        <h4 class="card-title m-0">Cliente</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-lg-8">
                                <label class="font-weight-bolder text-dark">Nombre</label>
                                <p>{{ $assigned['dealer']['code'] }} - {{ $assigned['dealer']['name'] }}</p>
                            </div>
                            <div class="col-lg-4">
                                <label class="font-weight-bolder text-dark">Documento</label>
                                <p>{{ $assigned['dealer']['document'] }}</p>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-lg-8">
                                <label class="font-weight-bolder text-dark">Dirección</label>
                                <p>
                                    @if (!empty($assigned['dealer']['google_map_url']))
                                        <a href="{{ $assigned['dealer']['google_map_url'] }}" target="_blank">{{ $assigned['dealer']['address'] }}</a>
                                    @else
                                        {{ $assigned['dealer']['address'] }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-lg-4">
                                <label class="font-weight-bolder text-dark">Teléfono</label>
                                <p>
                                    @if (!empty($assigned['dealer']['whatsapp_url']))
                                        <a href="{{ $assigned['dealer']['whatsapp_url'] }}" target="_blank">{{ $assigned['dealer']['phone'] }}</a>
                                    @else
                                        {{ $assigned['dealer']['phone'] }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <div class="card card-custom">
                    <div class="card-header py-0 min-h-50px d-flex align-items-center justify-content-between">
                        <h4 class="card-title m-0">Contrato</h4>

                        <span class="label label-inline label-light-{{ config('cons.status-assigned-class.' . $assigned['status']) }} font-weight-bold">
                            {{ config('cons.status-assigned.' . $assigned['status']) }}
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="form-row mb-4">
                            <div class="col-md-2">
                                <label class="font-weight-bolder text-dark">Número</label>
                                <p class="font-weight-bolder text-dark">{{ $assigned['code'] }}</p>
                            </div>

                            <div class="col-md-2">
                                <label class="font-weight-bolder text-dark">Desde</label>
                                <p>{{ $assigned['date_from_formatted'] }}</p>
                            </div>

                            <div class="col-md-2">
                                <label class="font-weight-bolder text-dark">Hasta</label>
                                <p>{{ $assigned['date_to_formatted'] }}</p>
                            </div>

                            <div class="col-md-6">
                                <label class="font-weight-bolder text-dark">Comentarios</label>
                                <p>{{ $assigned['comments'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <div class="card card-custom">
                    <div class="card-header py-0 min-h-50px">
                        <h4 class="card-title m-0">Resumen de Productos</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group text-center m-0">
                                    <label class="font-weight-bolder text-dark">PRODUCTOS ACTIVADOS</label>
                                    <p class="font-weight-bolder font-size-h4 mt-0 mb-3">{{ $assigned['total_qty'] }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-center m-0">
                                    <label class="font-weight-bolder text-dark">MONTO TOTAL</label>
                                    <p class="font-weight-bolder font-size-h4 mt-0 mb-3">{{ \HP::formatFormDecimal($assigned['total_changed']) }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-center m-0">
                                    <label class="font-weight-bolder text-dark">MONTO COMISION</label>
                                    <p class="font-weight-bolder font-size-h4 mt-0 mb-3">{{ \HP::formatFormDecimal($assigned['total_comission']) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            @foreach ($items as $item)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-header py-5">
                            <h5 class="card-title mt-0 mb-3">{{ $item['name'] }}</h5>

                            <div class="d-flex flex-column w-100 mr-2">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-dark mr-2 font-size-sm font-weight-bold">
                                        {{ $item['changed'] }}
                                    </span>
                                    <span class="text-dark font-size-sm font-weight-bold">
                                        {{ $item['qty'] }}
                                    </span>
                                </div>
                                <div class="progress progress-xs w-100">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($item['changed'] * 100 / $item['qty']) }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @foreach ($item['cards'] as $card)
                                @if ($card['status'] == 'changed')
                                    <a wire:click="$emit('openModal', {{ json_encode($card) }})" href="javascript:">
                                        <span class="label label-inline font-size-h6 w-100px p-1 d-inline-flex align-items-center justify-content-center my-1 h-25px label-light-{{ config('cons.status-assigned-detail-class.' . $card['status']) }} font-weight-bold">
                                            {{ $card['code'] }}
                                        </span>
                                    </a>
                                @else
                                    <span class="label label-inline font-size-h6 w-100px p-1 d-inline-flex align-items-center justify-content-center my-1 h-25px label-light-{{ config('cons.status-assigned-detail-class.' . $card['status']) }} font-weight-bold">
                                        {{ $card['code'] }}
                                    </span>
                                @endif
                            @endforeach
                        </div>

                        <div class="card-footer text-center">
                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group m-0">
                                        <label class="font-weight-bolder text-dark">Precio</label>
                                        <p class="mt-0 mb-3">{{ \HP::formatFormDecimal($item['price']) }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group m-0">
                                        <label class="font-weight-bolder text-dark">Comisión</label>
                                        <p class="mt-0 mb-3">{{ \HP::formatFormDecimal($item['comission']) }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group m-0">
                                        <label class="font-weight-bolder text-dark">Activadas</label>
                                        <p class="mt-0 mb-3">{{ $item['changed'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group m-0">
                                        <label class="font-weight-bolder text-dark">MONTO TOTAL</label>
                                        <p class="font-weight-bolder font-size-h4 mt-0 mb-3">{{ \HP::formatFormDecimal($item['amount_changed']) }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group m-0">
                                        <label class="font-weight-bolder text-dark">MONTO COMISIÓN</label>
                                        <p class="font-weight-bolder font-size-h4 mt-0 mb-3">{{ \HP::formatFormDecimal($item['amount_comission']) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($assigned['status'] == 'open')
            <div class="row">
                <div class="col">
                    <div class="card card-custom">
                        <div class="card-footer d-flex justify-content-center align-items-center">
                            <button id="btn-submit" type="submit" class="btn btn-primary mx-1" wire:loading.attr="disabled" wire:target="close">
                                <i class="far fa-save"></i>
                                Cerrar Contrato
                            </button>
                            <a href="{{ route('assigned-cards.index') }}" class="btn btn-secondary mx-1">
                                <i class="far fa-arrow-alt-circle-left"></i>
                                Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col">
                    <div class="card card-custom">
                        <div class="card-footer d-flex justify-content-center align-items-center">
                            <a href="{{ route('assigned-cards.index') }}" class="btn btn-secondary mx-1">
                                <i class="far fa-arrow-alt-circle-left"></i>
                                Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>

    <div wire:ignore.self class="modal fade" id="modalDetail" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalDetail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel">{{ $modal['code'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-5">
                        <div class="col">
                            @if ($modal['file'])
                                <img src="{{ asset('storage/' . $modal['file']) }}" alt="" class="img-fluid mx-auto">
                            @endif
                        </div>
                    </div>

                    @if ($modal['updated_at'])
                        <div class="row mb-5">
                            <div class="col">
                                <label class="font-weight-bolder text-dark">Fecha</label>
                                <p class="m-0">{{ $modal['updated_at'] }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($modal['comments'])
                        <div class="row">
                            <div class="col">
                                <label class="font-weight-bolder text-dark">Comentarios</label>
                                <p class="m-0">{{ $modal['comments'] }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    @livewire('components.modal-pdf')
</div>

@push('scripts')
    <script>
        Livewire.on('openModal', card => {
            @this.set('modal.code', card.code);
            @this.set('modal.file', card.file);
            @this.set('modal.comment', card.comment);
            @this.set('modal.updated_at', moment(card.updated_at).format('DD/MM/YYYY LT'));
            $('#modalDetail').modal('show');
        });

        $('#modalDetail').on('hidden.bs.modal', function (event) {
            @this.set('modal.code', '');
            @this.set('modal.file', '');
            @this.set('modal.comment', '');
            @this.set('modal.updated_at', '');
        });

        window.addEventListener('cards_closed', event => {
            Swal.fire({
                title: 'Exito!',
                text: event.detail.message,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Imprimir',
                cancelButtonText: 'Continuar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#modalPDF').modal('show');
                    $('#modalPDF').find('.modal-title').html('Cierre de Contrato');
                    $('#modalPDF').find('iframe').attr('src', event.detail.pdf);
                } else {
                    location.href = "{{ route('assigned-cards.index') }}";
                }
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            $('#modalPDF').on('hidden.bs.modal', function (event) {
                location.href = "{{ route('assigned-cards.index') }}";
            });
        });
    </script>
@endpush
