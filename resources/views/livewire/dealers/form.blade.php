<div>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Clientes | {{ $form['title'] }}</h5>
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
                            <div class="form-group col-lg-6">
                                <label>Documento</label>
                                <div></div>
                                <input type="file" wire:model.lazy="data.document_image" type="file" id="document_image" accept=".png, .jpg, .jpeg" />
                                @error('data.document_image') <span class="text-danger d-block">{{ $message }}</span> @enderror

                                <div class="d-flex">
                                    @if ($data['document_image'])
                                        <img id="documentPreview" src="{{ $data['document_image']->temporaryUrl() }}" style="max-height: 150px; object-fit: contain;" />
                                    @elseif ($data['document_image_url'])
                                        <img id="documentPreview" src="{{ $data['document_image_url'] }}" style="max-height: 150px; object-fit: contain;" />
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Negocio</label>
                                <div></div>
                                <input type="file" wire:model.lazy="data.business_image" type="file" id="business_image" accept=".png, .jpg, .jpeg" />
                                @error('data.business_image') <span class="text-danger d-block">{{ $message }}</span> @enderror

                                <div class="d-flex">
                                    @if ($data['business_image'])
                                        <img id="businessPreview" src="{{ $data['business_image']->temporaryUrl() }}" style="max-height: 150px; object-fit: contain;" />
                                    @elseif ($data['business_image_url'])
                                        <img id="businessPreview" src="{{ $data['business_image_url'] }}" style="max-height: 150px; object-fit: contain;" />
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label class="font-weight-bolder">Cliente</label>
                                <input wire:model="data.code" type="text" class="form-control font-weight-bolder" disabled />
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Nro. Documento <span class="text-danger">*</span></label>
                                <input wire:model.lazy="data.document" type="text" class="form-control @error('data.document') is-invalid @enderror" maxlength="25" autofocus />
                                @error('data.document') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Teléfono <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                                    <input value="{{ $data['phone'] }}" id="phone" type="text" class="form-control kt-phonemask @error('data.phone') is-invalid @enderror" maxlength="25" />
                                    @error('data.phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <label>Nombre del cliente <span class="text-danger">*</span></label>
                                <input wire:model.lazy="data.name" type="text" class="form-control @error('data.name') is-invalid @enderror" maxlength="191" />
                                @error('data.name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col-12">
                                <label>Nombre del negocio <span class="text-danger">*</span></label>
                                <input wire:model.lazy="data.company" type="text" class="form-control @error('data.company') is-invalid @enderror" maxlength="191" />
                                @error('data.company') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col-12">
                                <label>Dirección <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input wire:model.lazy="data.address" id="address" type="text" class="form-control @error('data.address') is-invalid @enderror" />
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" id="btn-address" type="button">Establecer</button>
                                    </div>
                                </div>
                                @error('data.address') <span class="invalid-feedback">{{ $message }}</span> @enderror

                                @if ($form['errAddr'])
                                    <div class="alert alert-custom alert-notice alert-light-danger fade show my-2" role="alert">
                                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                        <div class="alert-text">{{ $form['errAddr'] }}</div>
                                        <div class="alert-close">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                @error('data.maps')
                                    <div class="alert alert-custom alert-notice alert-light-danger fade show my-2" role="alert">
                                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                        <div class="alert-text">{{ $message }}</div>
                                        <div class="alert-close">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-12" wire:ignore>
                                <div id="map-canvas" class="map-canvas"></div>
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
                        <a href="{{ route('dealers.index') }}" class="btn btn-secondary mx-1">
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
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('cons.google_map_api') }}"></script>

    <script type="text/javascript">
        var myLatlng = new google.maps.LatLng({{ config('cons.google_map_lat') }}, {{ config('cons.google_map_lng') }});
        var myOptions = {
            zoom: 9,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
        var geocoder = new google.maps.Geocoder();
        var markers = [];

        @if ($form['action'] == 'update')
            var arr_maps = @json($data['maps']);
            var latLng = new google.maps.LatLng(arr_maps.geometry.location.lat, arr_maps.geometry.location.lng);
            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: address
            });
            markers.push(marker);
        @endif

        google.maps.event.addListener(map, 'click', function(event) {
            geocoder.geocode({
                'latLng': event.latLng
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        //console.log(results[0].geometry.location.toJSON());
                        /*console.log(JSON.stringify(event.latLng.toJSON(), null, 2));
                        console.log(event.latLng.toJSON().lat);
                        console.log(event.latLng.toJSON().lng);*/

                        //  actualizar direccion
                        var address = results[0].formatted_address;
                        @this.set('data.address', address);
                        @this.set('data.maps', results[0]);
                        @this.set('form.errAddr', null);

                        //  agregar marcador
                        for (let i = 0; i < markers.length; i++) {
                            markers[i].setMap(null);
                        }
                        var latLng = new google.maps.LatLng(event.latLng.toJSON().lat, event.latLng.toJSON().lng);
                        var marker = new google.maps.Marker({
                            position: latLng,
                            map: map,
                            title: address
                        });
                        markers.push(marker);
                    }
                }
            });
        });

        document.getElementById('btn-address').addEventListener("click", () => {
            var address = document.getElementById('address').value;
            geocoder
                .geocode({ address: address })
                .then((result) => {
                    const { results } = result;
                    //console.log(results[0].geometry.location.toJSON());
                    map.setCenter(results[0].geometry.location);

                    for (let i = 0; i < markers.length; i++) {
                        markers[i].setMap(null);
                    }
                    var latLng = new google.maps.LatLng(results[0].geometry.location.toJSON().lat, results[0].geometry.location.toJSON().lng);
                    var marker = new google.maps.Marker({
                        position: latLng,
                        map: map,
                        title: address
                    });
                    markers.push(marker);

                    @this.set('form.errAddr', null);
                    @this.set('data.maps', results[0]);

                    //marker.setPosition(results[0].geometry.location);
                    //marker.setMap(map);

                    //responseDiv.style.display = "block";
                    //response.innerText = JSON.stringify(result, null, 2);
                    return results;
                })
                .catch((e) => {
                    @this.set('form.errAddr', "Geocode no tuvo éxito por la siguiente razón: " + e);
                    @this.set('data.maps', '');
                    for (let i = 0; i < markers.length; i++) {
                        markers[i].setMap(null);
                    }
                    //markeralert("Geocode was not successful for the following reason: " + e);
                });
            //  geocode({ address: inputText.value })
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            initAll();

            $('#phone').on('change', function (e) {
                @this.set('data.phone', $(this).val());
            });
        });
    </script>
@endpush
