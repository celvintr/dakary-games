<div>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Usuarios | {{ $form['title'] }}</h5>
    </x-slot>

    <form wire:submit.prevent="{{ $form['action'] }}" autocomplete="off">
        <div class="row justify-content-center">
            <div class="col-lg-8">
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
                            <div class="form-group col-md-6">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input wire:model="data.name" type="text" class="form-control font-weight-bold @error('data.name') is-invalid @enderror" maxlength="191" autofocus />
                                @error('data.name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-envelope"></i></span></div>
                                    <input wire:model="data.email" type="email" class="form-control @error('data.email') is-invalid @enderror" maxlength="191" {{ $form['action'] != 'store' ? 'disabled' : '' }} />
                                </div>
                                @error('data.email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            @if ($form['newPassword'])
                                <div class="form-group col-md-6">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                        <input wire:model="data.password" type="password" class="form-control @error('data.password') is-invalid @enderror" maxlength="191" />
                                        @error('data.password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Confirmar <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                                        <input wire:model="data.password_confirmation" type="password" class="form-control @error('data.password_confirmation') is-invalid @enderror" maxlength="191" />
                                    </div>
                                    @error('data.password_confirmation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            @else
                                <div class="form-group col">
                                    <button type="button" class="btn btn-light" wire:click="$set('form.newPassword', true)">
                                        <i class="fas fa-lock"></i>
                                        Cambiar contraseña
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-center align-items-center">
                        <button id="btn-submit" type="submit" class="btn btn-primary mx-1" wire:loading.attr="disabled" wire:target="{{ $form['action'] }}">
                            <i class="far fa-save"></i>
                            {{ $form['label'] }}
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary mx-1">
                            <i class="fas fa-ban"></i>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
