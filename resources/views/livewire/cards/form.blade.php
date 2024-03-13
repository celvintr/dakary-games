<div>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Tarjetas | {{ $form['title'] }}</h5>
    </x-slot>

    <form wire:submit.prevent="{{ $form['action'] }}" autocomplete="off">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                Datos del registro
                            </h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input wire:model.lazy="data.name" type="text" class="form-control @error('data.name') is-invalid @enderror" maxlength="191" />
                                @error('data.name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Precio <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign"></i></span></div>
                                    <input id="price" type="text" value="{{ $data['price'] }}" class="form-control kt-decimal text-right @error('data.price') is-invalid @enderror" readonly />
                                    @error('data.price') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Comisión <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign"></i></span></div>
                                    <input id="comission" type="text" value="{{ $data['comission'] }}" class="form-control kt-decimal text-right @error('data.comission') is-invalid @enderror" readonly />
                                    @error('data.comission') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            @if ($form['action'] == 'update')
                                <div class="form-group col-12">
                                    <label>Estatus:</label>
                                    <div class="radio-inline">
                                        <label class="radio radio-solid">
                                            <input wire:model="data.status" type="radio" name="active" value="active"/>
                                            <span></span>
                                            Activo
                                        </label>
                                        <label class="radio radio-solid">
                                            <input wire:model="data.status" type="radio" name="active" value="inactive"/>
                                            <span></span>
                                            Inactivo
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-center align-items-center">
                        <button id="btn-submit" type="submit" class="btn btn-primary mx-1" wire:loading.attr="disabled" wire:target="{{ $form['action'] }}">
                            <i class="far fa-save"></i>
                            {{ $form['label'] }}
                        </button>
                        <a href="{{ route('cards.index') }}" class="btn btn-secondary mx-1">
                            <i class="fas fa-ban"></i>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initAll();

            $('#code').on('change', function (e) {
                @this.set('data.code', $(this).val());
            });

            $('#price').on('change', function (e) {
                @this.set('data.price', $(this).val());
            });
            $('#comission').on('change', function (e) {
                @this.set('data.comission', $(this).val());
            });
        });
    </script>
@endpush
