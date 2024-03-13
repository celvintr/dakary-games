<div>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Generar Contratos </h5>
    </x-slot>

    <x-slot name="toolbar">
        <div class="d-flex align-items-center">
            <a href="{{ route('assigned-cards.create') }}" class="btn btn-primary font-weight-bolder">
                <i class="fas fa-plus-circle"></i>
                Generar Contratos
            </a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            <span class="text-muted pt-2 font-size-sm d-block">Gestión y control de contratos.</span>
                        </h3>
                    </div>
                </div>

                <div class="card-body">
                    <!--begin: Search Form-->
                    <div class="mb-7">
                        <div class="row align-items-center">
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="">Buscar</label>
                                    <div class="input-icon">
                                        <input wire:model="params.search" type="text" class="form-control" placeholder="Buscar..." />
                                        <span><i class="flaticon2-search-1 text-muted"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label>Estatus</label>
                                    <select wire:model="params.status" class="form-control custom-select">
                                        <option value="">{{ __('Todos') }}</option>
                                        @foreach (config('cons.status-assigned') as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Search Form-->

                    <!--begin: Datatable-->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 125px;">Contrato</th>
                                    <th style="min-width: 250px;">Cliente</th>
                                    <th class="text-center" style="width: 150px;">Vencimiento</th>
                                    <th style="min-width: 250px;">Comentarios</th>
                                    <th class="text-center" style="width: 100px;">Productos</th>
                                    <th class="text-center" style="width: 100px;">Dias</th>
                                    <th class="text-center" style="width: 100px;">Estatus</th>
                                    <th class="text-center" style="width: 100px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td class="font-weight-bolder text-dark align-middle font-size-h5">
                                            {{ $item->code }}
                                        </td>
                                        <td>
                                            <div class="text-dark font-weight-bolder font-size-h5">{{ $item->dealer->code }} - {{ $item->dealer->name }}</div>
                                            <div>
                                                @if (!empty($item->dealer->whatsapp_url))
                                                    <a href="{{ $item->dealer->whatsapp_url }}" class="text-dark text-hover-success" target="_blank">
                                                        <i class="fab fa-whatsapp text-dark"></i>
                                                        {{ $item->dealer->phone }}
                                                    </a>
                                                @else
                                                    {{ $item->dealer->phone }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">{{ $item->date_to_formatted }}</td>
                                        <td class="align-middle">{{ $item->comments }}</td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <span class="label label-inline label-success min-w-30px">{{ $item->details_summary['qty_changed'] }}</span>
                                                <span class="label label-inline label-danger min-w-30px">{{ $item->details_summary['qty_pending'] }}</span>
                                                <span class="label label-inline label-primary min-w-30px">{{ $item->details_summary['qty_total'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if ($item->status == 'open')
                                                @if ($item->days_expiration)
                                                    <span class="label label-inline label-square">{{ $item->days_expiration }}</span>
                                                @else
                                                    <span class="label label-inline label-square label-danger">0</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="label label-inline label-light-{{ config('cons.status-assigned-class.' . $item->status) }} font-weight-bold">
                                                {{ config('cons.status-assigned.' . $item->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="dropdown dropdown-inline">
                                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                    <ul class="navi flex-column navi-hover py-2">
                                                        <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">
                                                            Seleccionar opción:
                                                        </li>
                                                        @if ($item->status == 'open' && !$item->details_summary['qty_changed'])
                                                            <li class="navi-item">
                                                                <a href="{{ route('assigned-cards.edit', $item->id) }}" class="navi-link">
                                                                    <span class="navi-icon"><i class="far fa-edit"></i></span>
                                                                    <span class="navi-text">Editar Contrato</span>
                                                                </a>
                                                            </li>
                                                            <li class="navi-item">
                                                                <a wire:click="$emit('confirmDestroy', {{ $item->id }})" href="javascript:" class="navi-link">
                                                                    <span class="navi-icon"><i class="fas fa-trash-alt text-danger"></i></span>
                                                                    <span class="navi-text text-danger">Eliminar Contrato</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li class="navi-item">
                                                            <a href="{{ route('assigned-cards.detail', $item->id) }}" class="navi-link">
                                                                <span class="navi-icon"><i class="far fa-eye"></i></span>
                                                                <span class="navi-text">Ver Detalle</span>
                                                            </a>
                                                        </li>
                                                        @if ($item->status == 'open')
                                                            <li class="navi-item">
                                                                <a href="{{ route('assigned-cards.close', $item->id) }}" class="navi-link text-hover-danger">
                                                                    <span class="navi-icon"><i class="fas fa-lock"></i></span>
                                                                    <span class="navi-text text-hover-danger">Cerrar Contrato</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li class="navi-item">
                                                            <a wire:click="$emit('printContract', '{{ route('assigned-cards.pdf', $item->id) }}')" href="javascript:" class="navi-link">
                                                                <span class="navi-icon"><i class="fas fa-file-contract"></i></span>
                                                                <span class="navi-text">Ver Contrato</span>
                                                            </a>
                                                        </li>
                                                        @if ($item->status == 'closed')
                                                            <li class="navi-item">
                                                                <a wire:click="$emit('printContractClosed', '{{ route('assigned-cards.pdf-closed', $item->id) }}')" href="javascript:" class="navi-link">
                                                                    <span class="navi-icon"><i class="fas fa-file-contract"></i></span>
                                                                    <span class="navi-text">Ver Cierre</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th colspan="8">
                                            <div class="alert alert-light">
                                                No se encontraron registros
                                            </div>
                                        </th>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!--end: Datatable-->
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>
                        {{ $items->total() }} registros
                    </span>

                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>

    @livewire('components.modal-pdf')
</div>

@push('scripts')
    <script type="text/javascript">
        Livewire.on('printContract', pdf => {
            $('#modalPDF').modal('show');
            $('#modalPDF').find('.modal-title').html('Contrato de Productos Asignados');
            $('#modalPDF').find('iframe').attr('src', pdf);
        });

        Livewire.on('printContractClosed', pdf => {
            $('#modalPDF').modal('show');
            $('#modalPDF').find('.modal-title').html('Cierre de Contrato');
            $('#modalPDF').find('iframe').attr('src', pdf);
        });
    </script>

    @include('parts.js.destroy')
@endpush
