<div>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Generar Contratos | {{ $form['title'] }}</h5>
    </x-slot>

    <form wire:submit.prevent="{{ $form['action'] }}" autocomplete="off">
        @if ($form['action'] == 'store')
            <div class="row justify-content-center mb-3">
                <div class="col-lg-6 col-md-9">
                    @livewire('components.select-dealer', ['module' => 'assigned-cards.form', 'listener' => 'selectDealer'])
                </div>
            </div>
        @else
            <div class="row justify-content-center mb-3">
                <div class="col-lg-6 col-md-9">
                    <div class="card card-custom">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col m-0">
                                    <label class="font-size-h4 font-weight-bold">Cliente</label>
                                    <p><b>{{ $dealer['name'] }}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($data['dealer_id'])
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-9">
                    <div class="card card-custom">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">
                                    Datos Generales
                                </h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-3 col-6">
                                    <label>Código</label>
                                    <p class="font-weight-bolder text-dark">{{ $dealer['code'] }}</p>
                                </div>
                                <div class="form-group col-md-3 col-6">
                                    <label>Teléfono</label>
                                    <p>{{ $dealer['phone'] }}</p>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Dirección</label>
                                    <p>{{ $dealer['address'] }}</p>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Desde <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                        <input value="{{ $data['date_from'] }}" id="date_from" type="text" class="form-control kt-datepicker @error('data.date_from') is-invalid @enderror" maxlength="10" />
                                        @error('data.date_from') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Hasta <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                                        <input value="{{ $data['date_to'] }}" id="date_to" type="text" class="form-control kt-datepicker @error('data.date_to') is-invalid @enderror" maxlength="10" />
                                        @error('data.date_to') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>Comentarios</label>
                                    <textarea wire:model.lazy="data.comments" class="form-control" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5>Nuevos Productos</h5>

                                        <div class="wrapper-btn">
                                            <button wire:click="addItem" type="button" class="btn btn-light">
                                                <i class="fas fa-plus"></i>
                                                Agregar Producto
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive max-h-300px">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th style="width: 150px;">Cantidad</th>
                                                    <th style="width: 50px;"></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($items as $key => $item)
                                                    <tr>
                                                        <td class="text-center align-middle">
                                                            <select wire:model="items.{{ $key }}.card_id" class="custom-select form-control">
                                                                <option value="">::. Producto .::</option>
                                                                @foreach ($cards as $card)
                                                                    <option value="{{ $card['id'] }}">{{ $card['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('items.'.$key.'.card_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <input wire:model="items.{{ $key }}.qty" class="form-control" type="number" value="0" />
                                                            @error('items.'.$key.'.qty') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                                        </td>
                                                        <td class="text-right align-middle">
                                                            <a wire:click="removeItem({{ $key }})" href="javascript:" class="text-muted text-hover-danger">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @if (count($pending_cards))
                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5>Productos Pendientes</h5>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="checkbox-list">
                                            @foreach ($pending_cards as $key => $item)
                                                <label class="checkbox">
                                                    <input type="checkbox" wire:model="reassigned_cards.{{ $key }}" value="{{ $item['code'] }}" />
                                                    <span></span>
                                                    {{ $item['code'] }} | {{ $item['card_name'] }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer d-flex justify-content-center align-items-center">
                            <button id="btn-submit" type="submit" class="btn btn-primary mx-1" wire:loading.attr="disabled" wire:target="{{ $form['action'] }}">
                                <i class="far fa-save"></i>
                                {{ $form['label'] }}
                            </button>
                            <a href="{{ route('assigned-cards.index') }}" class="btn btn-secondary mx-1">
                                <i class="fas fa-ban"></i>
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>

    @livewire('components.modal-pdf')
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initAll();
            init();
        });

        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.processed', (message, component) => {
                initAll();
                init();
            });

            $('#modalPDF').on('hidden.bs.modal', function (event) {
                location.href = "{{ route('assigned-cards.index') }}";
            });
        });

        window.addEventListener('cards_assigned', event => {
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
                    $('#modalPDF').find('.modal-title').html('Contrato');
                    $('#modalPDF').find('iframe').attr('src', event.detail.pdf);
                } else {
                    location.href = "{{ route('assigned-cards.index') }}";
                }
            });
        });

        function init() {
            $('#date_from').on('change', function (e) {
                @this.set('data.date_from', $(this).val());
            });
            $('#date_from').datepicker().on('changeDate', function(e) {
                @this.set('data.date_from', $(this).val());
            });

            $('#date_to').on('change', function (e) {
                @this.set('data.date_to', $(this).val());
            });
            $('#date_to').datepicker().on('changeDate', function(e) {
                @this.set('data.date_to', $(this).val());
            });
        }
    </script>
@endpush
