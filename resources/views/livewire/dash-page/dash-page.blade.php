<div class="p-2">
    <div class="mx-auto mt-6 max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col">

            <div class="flex justify-end mb-3 space-x-2 space-y-2">
                {{-- <div class="grid grid-cols-2 gap-4 mt-3">
                    <div><input type="date" class="rounded-lg" wire:model='start'></div>
                    <div><input type="date" class="rounded-lg" wire:model='end'></div>
                </div> --}}
                <div class="join">
                    <select class="select select-bordered join-item focus:border-green-700 focus:ring-green-700"
                        wire:model.lazy="date_filter">
                        <option class="hover:bg-green-700" value="today" {{ $dateFilter == 'today' ? 'selected' : '' }}>
                            Today</option>
                        {{-- <option class="hover:bg-green-700" value="this_year"
                            {{ $dateFilter == 'define' ? 'selected' : '' }}>Define
                        </option> --}}
                        <option class="hover:bg-green-700" value="this_year"
                            {{ $dateFilter == 'this_year' ? 'selected' : '' }}>This Year
                        </option>
                        <option class="hover:bg-green-700" value="yesterday"
                            {{ $dateFilter == 'yesterday' ? 'selected' : '' }}>Yesterday
                        </option>
                        <option class="hover:bg-green-700" value="this_week"
                            {{ $dateFilter == 'this_week' ? 'selected' : '' }}>This Week
                        </option>
                        <option class="hover:bg-green-700" value="last_week"
                            {{ $dateFilter == 'last_week' ? 'selected' : '' }}>Last Week
                        </option>
                        <option class="hover:bg-green-700" value="this_month"
                            {{ $dateFilter == 'this_month' ? 'selected' : '' }}>This
                            Month</option>
                        <option class="hover:bg-green-700" value="last_month"
                            {{ $dateFilter == 'last_month' ? 'selected' : '' }}>Last
                            Month</option>

                        <option class="hover:bg-green-700" value="last_year"
                            {{ $dateFilter == 'last_year' ? 'selected' : '' }}>Last Year
                        </option>
                    </select>
                    <label type="submit" class="text-white bg-green-600 btn join-item" wire:click='clk'>Filter</label>
                </div>
            </div>
        </div>
        <div class="flex flex-col h-full gap-2">
            <div class="flex flex-col bg-white shadow-md md:rounded-lg join join-vertical ">
                <div class="w-full h-6 bg-gray-400 join-item"></div>
                <div class="grid p-1 join-item justify-items-center">
                    <h1 class="text-base font-extrabold text-black">EMERGENCY ROOM CENSUS</h1>
                </div>
                <div class="w-full h-64 p-4 join-item"><livewire:livewire-line-chart
                        key="{{ $lineChartModel->reactiveKey() }}" :line-chart-model="$lineChartModel" />
                </div>
            </div>
            <!--div for the two container--->
            <div class="grid w-full grid-cols-2 gap-2 mx-auto mt-2 h-96">
                <!--first container-->
                <div class="w-full h-full bg-white shadow-md md:rounded-lg">
                    <div class="w-full join join-vertical">
                        <div class="w-full h-6 bg-gray-400 join-item"></div>
                        <div class="grid p-1 join-item justify-items-center">
                            <h1 class="text-base font-extrabold text-black">ER PATIENT TRANSFER</h1>
                        </div>
                        <div class="w-full mt-4 h-80 join-item">
                            <livewire:livewire-pie-chart key="{{ $pieChartModel->reactiveKey() }}" :pie-chart-model="$pieChartModel" />
                        </div>
                        {{-- <div class="mt-4 join-item">
                             @if ($date_filter == 'this_month')
                                <div id="this_month_chart" class="w-full h-full "></div>
                            @else
                                <div id="chart" class="w-full h-full "></div>
                            @endif
                        </div> --}}
                    </div>
                </div><!--first container-->
                <!--second container-->
                <div class="w-full bg-white shadow-md md:rounded-lg">
                    <div class="w-full join join-vertical">
                        <div class="w-full h-6 bg-gray-400 join-item"></div>
                        <div class="grid w-full p-1 join-item justify-items-center">
                            <h1 class="text-base font-extrabold text-black">ER PATIENT CENSUS PER DEPARTMENT</h1>
                        </div>
                        <div class="w-full h-80 join-item">
                            <livewire:livewire-column-chart class="w-full" key="{{ $columnChartModel->reactiveKey() }}"
                                :column-chart-model="$columnChartModel" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            window.onload = function() {
                var getcount = new Array();
                var getname = new Array();
                var catchColors = new Array();

                getcount = {!! json_encode($deptCount) !!};
                getname = {!! json_encode($departments) !!};
                catchColors = {!! json_encode($getColors) !!};

                console.log(getcount);
                console.log(getname);
                console.log(catchColors);

                var options = {
                    series: getcount,
                    chart: {
                        height: 350,
                        //width: 320,
                        type: 'donut',
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        fontSize: 15,
                                        //fontWeight: 'bold',
                                        fontFamily: 'sans',
                                    }
                                }
                            }
                        }
                    },
                    labels: getname,
                    legend: {
                        //color: '#4d4c4a',
                        position: 'bottom',
                        fontSize: '12px',
                        fontWeight: 400,
                        fontFamily: 'sans',
                    },

                    dataLabels: {
                        //enabled: true
                        formatter: (val, {
                            seriesIndex,
                            w
                        }) => w.config.series[seriesIndex]
                    },
                    colors: catchColors,
                    responsive: [{
                        breakpoint: 100,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#this_month_chart"), options);
                chart.render();
            };

            window.addEventListener('loadChart', event => {

                var getcount = event.detail.count;
                var getname = event.detail.deptname;
                var catchColors = event.detail.getcolors;

                console.log(getcount);
                console.log(getname);
                console.log(catchColors);

                var options = {
                    //series: [getcount[0], getcount[1], getcount[2], getcount[3], getcount[4], getcount[5], getcount[
                    //     6], getcount[
                    //     7]],
                    series: getcount,
                    chart: {
                        height: 350,
                        //width: 320,
                        type: 'donut',
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        fontSize: 15,
                                        //fontWeight: 'bold',
                                        fontFamily: 'sans',
                                    }
                                }
                            }
                        }
                    },
                    // labels: [getname[0], getname[1], getname[2], getname[3], getname[4], getname[5], getname[6],
                    //     getname[
                    //         7]
                    // ],
                    labels: getname,
                    legend: {
                        //color: '#4d4c4a',
                        position: 'bottom',
                        fontSize: '12px',
                        fontWeight: 400,
                        fontFamily: 'sans',
                    },

                    dataLabels: {
                        //enabled: true
                        formatter: (val, {
                            seriesIndex,
                            w
                        }) => w.config.series[seriesIndex]
                    },
                    // colors: ["#28756c", "#c42163", "#e3106b", "#2170a3", "#66DA26", "#90cdf4", "#7210e3",
                    //     "#fc8181"
                    // ],
                    colors: catchColors,
                    responsive: [{
                        breakpoint: 100,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            });

            //--
            window.addEventListener('thisloadChart', event => {
                document.location.reload(true)
            });
        </script>
    @endpush

</div>
