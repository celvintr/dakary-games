<x-app-layout>
    <x-slot name="header">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard </h5>
    </x-slot>

    {{--  INFO CARDS  --}}
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card card-custom gutter-b" style="height: 150px">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <span class="svg-icon svg-icon-3x svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
                            </g>
                        </svg>
                    </span>
                    <div class="text-dark font-weight-bolder font-size-h1 mt-3">{{ \number_format($cards['dealers'], 0, ',', '.') }}</div>
                    <a href="{{ route('dealers.index') }}" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">Clientes Registrados</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card card-custom gutter-b" style="height: 150px">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <span class="svg-icon svg-icon-3x svg-icon-success">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                            </g>
                        </svg>
                    </span>
                    <div class="text-dark font-weight-bolder font-size-h1 mt-3">{{ \number_format($cards['assigned_card_details'], 0, ',', '.') }}</div>
                    <a href="{{ route('assigned-card-details.index') }}" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">Productos Entregados</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card card-custom gutter-b" style="height: 150px">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <span class="svg-icon svg-icon-3x svg-icon-success">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
                                <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
                            </g>
                        </svg>
                    </span>
                    <div class="text-dark font-weight-bolder font-size-h1 mt-3">{{ \number_format($cards['assigned_cards'], 0, ',', '.') }}</div>
                    <a href="{{ route('assigned-cards.index') }}" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">Contratos Abiertos</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card card-custom gutter-b" style="height: 150px">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <span class="svg-icon svg-icon-3x svg-icon-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
                                <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
                            </g>
                        </svg>
                    </span>
                    <div class="text-dark font-weight-bolder font-size-h1 mt-3">{{ \number_format($cards['assigned_card_expired'], 0, ',', '.') }}</div>
                    <a href="{{ route('assigned-cards.index') }}" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">Contratos Vencidos</a>
                </div>
            </div>
        </div>
    </div>

    {{--  INFO TABLES  --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-custom card-stretch gutter-b">
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Clientes</span>
                        <span class="text-muted mt-3 font-weight-bold font-size-sm">Ventas por clientes</span>
                    </h3>
                </div>

                <div class="card-body pt-0 pb-3">
                    <div class="tab-content">
                        <div class="table-responsive">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                <thead>
                                    <tr class="text-left text-uppercase">
                                        <th style="min-width: 250px" class="pl-7"><span class="text-dark-75">cliente</span></th>
                                        <th style="min-width: 100px" class="text-right">monto</th>
                                        <th style="min-width: 100px" class="text-right">comisión</th>
                                        <th style="min-width: 100px" class="text-center">productos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tables['dealers_sales'] as $dealer)
                                        <tr>
                                            <td class="font-weight-bolder text-dark">
                                                {{ $dealer->dealer_code }} - {{ $dealer->dealer_name }}
                                            </td>
                                            <td class="text-right">
                                                {{ \HP::formatFormDecimal($dealer->amount) }}
                                            </td>
                                            <td class="text-right">
                                                {{ \HP::formatFormDecimal($dealer->comission) }}
                                            </td>
                                            <td class="text-center">
                                                {{ $dealer->qty }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-custom card-stretch gutter-b">
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Productos</span>
                        <span class="text-muted mt-3 font-weight-bold font-size-sm">Ventas por productos</span>
                    </h3>
                </div>

                <div class="card-body pt-0 pb-3">
                    <div class="tab-content">
                        <div class="table-responsive">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                <thead>
                                    <tr class="text-left text-uppercase">
                                        <th style="min-width: 250px" class="pl-7"><span class="text-dark-75">producto</span></th>
                                        <th style="min-width: 100px">monto</th>
                                        <th style="min-width: 100px">comisión</th>
                                        <th style="min-width: 100px">clientes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tables['cards_sales'] as $card)
                                        <tr>
                                            <td class="font-weight-bolder text-dark">
                                                {{ $card->card_name }}
                                            </td>
                                            <td class="text-right">
                                                {{ \HP::formatFormDecimal($card->amount) }}
                                            </td>
                                            <td class="text-right">
                                                {{ \HP::formatFormDecimal($card->comission) }}
                                            </td>
                                            <td class="text-center">
                                                {{ $card->qty }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  CHARTS  --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-custom gutter-b">
                <div class="card-header h-auto">
                    <div class="card-title py-5">
                        <h3 class="card-label">
                            Ventas por periodo
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart_sales"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-custom gutter-b">
                <div class="card-header h-auto">
                    <div class="card-title py-5">
                        <h3 class="card-label">
                            Comisiones por periodo
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart_comissions"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            "use strict";

            // Shared Colors Definition
            const primary = '#6993FF';
            const success = '#1BC5BD';
            const info    = '#8950FC';
            const warning = '#FFA800';
            const danger  = '#F64E60';

            const chart_sales_data = @json($chart_sales);

            var KTApexCharts = function () {
                var _chart_sales = function () {
                    const apexChart = "#chart_sales";
                    var options = {
                        series: [{
                            name: "Ventas",
                            data: chart_sales_data.amount //[10, 41, 35, 51, 49, 62, 69, 91, 148]
                        }],
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'straight'
                        },
                        grid: {
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                opacity: 0.5
                            },
                        },
                        xaxis: {
                            categories: chart_sales_data.categories, //['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                        },
                        colors: [primary]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();
                }

                var _chart_comissions = function () {
                    const apexChart = "#chart_comissions";
                    var options = {
                        series: [{
                            name: "Comisiones",
                            data: chart_sales_data.comission //[10, 41, 35, 51, 49, 62, 69, 91, 148]
                        }],
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'straight'
                        },
                        grid: {
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                opacity: 0.5
                            },
                        },
                        xaxis: {
                            categories: chart_sales_data.categories, //['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                        },
                        colors: [success]
                    };

                    var chart = new ApexCharts(document.querySelector(apexChart), options);
                    chart.render();
                }

                return {
                    // public functions
                    init: function () {
                        _chart_sales();
                        _chart_comissions();
                    }
                };
            }();

            $(document).ready(function () {
                KTApexCharts.init();
            });
        </script>
    @endpush


</x-app-layout>
