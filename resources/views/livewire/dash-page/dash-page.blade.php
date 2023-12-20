<div class="">
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
                    <h1 class="text-base font-extrabold text-black">Patient Count</h1>
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
                            <h1 class="text-base font-extrabold text-black">Patient Transfers</h1>
                        </div>
                        <div class="w-full mt-4 h-80 join-item">
                            <livewire:livewire-pie-chart key="{{ $pieChartModel->reactiveKey() }}" :pie-chart-model="$pieChartModel" />
                        </div>
                    </div>
                </div><!--first container-->
                <!--second container-->
                <div class="w-full bg-white shadow-md md:rounded-lg">
                    <div class="w-full join join-vertical">
                        <div class="w-full h-6 bg-gray-400 join-item"></div>
                        <div class="grid w-full p-1 join-item justify-items-center">
                            <h1 class="text-base font-extrabold text-black">Patient Count Per Department</h1>
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
