<div>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Activar / Canjear Productos </h5>
    </x-slot>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            @if (!$assigned_card_detail)
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="form-row justify-content-center">
                            <div class="form-group col">
                                <label>Código del Producto</label>
                                <div class="input-group">
                                    <input wire:model="card_code" type="text" class="form-control" placeholder="Ingresar el código del producto" />
                                    <div class="input-group-append">
                                        <button wire:click="search" class="btn btn-secondary" type="button">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($error)
                            <div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">{{ $error }}</div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card card-custom mb-3">
                    <div class="card-body">
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-3">
                                <label>Tarjeta</label>
                                <p class="font-weight-bolder text-dark m-0">{{ $assigned_card_detail['code'] }}</p>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Nombre</label>
                                <p class="m-0">{{ $assigned_card_detail['card']['name'] }}</p>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Precio</label>
                                <p class="m-0">{{ $assigned_card_detail['card']['price_formatted'] }}</p>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Estatus</label>
                                <p class="m-0">
                                    <span class="label label-inline label-light-{{ config('cons.status-assigned-detail-class.'.$assigned_card_detail['status']) }} font-weight-bold">
                                        {{ config('cons.status-assigned-detail.'.$assigned_card_detail['status']) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-3">
                                <label>Cliente</label>
                                <p class="font-weight-bolder text-dark m-0">{{ $assigned_card_detail['assigned']['dealer']['code'] }}</p>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nombre</label>
                                <p class="m-0">{{ $assigned_card_detail['assigned']['dealer']['name'] }}</p>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Documento</label>
                                <p class="m-0">{{ $assigned_card_detail['assigned']['dealer']['document'] }}</p>
                            </div>

                            <div class="form-group col-md-9">
                                <label>Negocio</label>
                                <p class="m-0">{{ $assigned_card_detail['assigned']['dealer']['company'] }}</p>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Teléfono</label>
                                <p class="m-0">{{ $assigned_card_detail['assigned']['dealer']['phone'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($assigned_card_detail['status'] == 'pending')
                    <form wire:submit.prevent="change" autocomplete="off">
                        <div class="card card-custom mb-3">
                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                <div class="card-title">
                                    <h3 class="card-label">Cambiar Tarjeta</h3>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>Soporte</label>
                                        <div></div>
                                        <input type="file" wire:model.lazy="assigned_card_detail.file" type="file" id="file" accept=".png, .jpg, .jpeg" />
                                        @error('assigned_card_detail.file') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        @if ($assigned_card_detail['file'])
                                            <img id="filePreview" src="{{ $assigned_card_detail['file']->temporaryUrl() }}" style="max-height: 150px; object-fit: contain;" />
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>Comentarios</label>
                                        <textarea wire:model.lazy="assigned_card_detail.comments" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-center align-items-center">
                                <button id="btn-submit" type="submit" class="btn btn-primary mx-1" wire:loading.attr="disabled" wire:target="change">
                                    <i class="far fa-save"></i>
                                    Procesar
                                </button>
                                <a href="{{ route('assigned-card-details.index') }}" class="btn btn-secondary mx-1">
                                    <i class="fas fa-ban"></i>
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="card card-custom mb-3">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">Soporte</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col">
                                    <div class="text-center">
                                        <img src="{{ $assigned_card_detail['file_url'] }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>Comentarios</label>
                                    <p>{{ $assigned_card_detail['comments'] }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>Fecha de actualización</label>
                                    <p class="font-weight-bolder text-dark">{{ $assigned_card_detail['updated_at'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-center align-items-center">
                            <a href="{{ route('assigned-card-details.index') }}" class="btn btn-secondary mx-1">
                                <i class="fas fa-check"></i>
                                Aceptar
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
