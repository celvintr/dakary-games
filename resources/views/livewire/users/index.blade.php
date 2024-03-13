<div>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Usuarios </h5>
    </x-slot>

    <x-slot name="toolbar">
        <div class="d-flex align-items-center">
            <a href="{{ route('users.create') }}" class="btn btn-primary font-weight-bolder">
                <i class="fas fa-plus-circle"></i>
                Nuevo registro
            </a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">
                            <span class="text-muted pt-2 font-size-sm d-block">Maestro para actualizar los usuarios del sistema.</span>
                        </h3>
                    </div>
                </div>

                <div class="card-body">
                    <!--begin: Search Form-->
                    <div class="mb-7">
                        <div class="row align-items-center">
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <label for="">Buscar</label>
                                <div class="input-icon">
                                    <input wire:model="params.search" type="text" class="form-control" placeholder="Buscar..." />
                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Search Form-->

                    <!--begin: Datatable-->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th class="text-center" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
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
                                                    <li class="navi-item">
                                                        <a href="{{ route('users.edit', $item->id) }}" class="navi-link">
                                                            <span class="navi-icon"><i class="far fa-edit"></i></span>
                                                            <span class="navi-text">Editar</span>
                                                        </a>
                                                    </li>
                                                    @if ($item->id != 1)
                                                        <li class="navi-item">
                                                            <a wire:click="$emit('confirmDestroy', {{ $item->id }})" href="javascript:" class="navi-link">
                                                                <span class="navi-icon"><i class="fas fa-trash-alt text-danger"></i></span>
                                                                <span class="navi-text text-danger">Eliminar</span>
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
                                    <th colspan="3">
                                        <div class="alert alert-light">
                                            No se encontraron registros
                                        </div>
                                    </th>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
</div>

@push('scripts')
    @include('parts.js.destroy')
@endpush

