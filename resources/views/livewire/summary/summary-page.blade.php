    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            SUMMARY
            {{ \Carbon\Carbon::parse($get_sho_detail->report_date)->format('M-j-Y') }}
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="flex flex-col max-w-6xl p-4 mx-auto mt-4 text-black bg-white rounded-md">
            <div class="flex flex-col items-center justify-center">
                <h2>MARIANO MARCOS MEMORIAL HOSPITAL & MEDICAL CENTER</h2>
                <p class="items">City of Batac, Ilocos Norte</p>
                <p class="mt-2 text-sm font-semibold">DAILY CENSUS SUMMARY</p>
                <P class="text-sm font-semibold underline">
                    {{ \Carbon\Carbon::parse($get_sho_detail->report_date)->format('M-j-Y') }}</P>
                <P>DATE</P>
            </div>
            <div class="grid grid-cols-5 mt-2 text-sm border-b-4">
                <div class="h-fit">DEPARTMENT</div>
                {{-- <div class="h-fit">WARD/FLOOR</div> --}}
                <div class="h-fit">TOTAL</div>
                <div class="h-fit">DEPARTMENT</div>
                {{-- <div class="h-fit">WARD/FLOOR</div> --}}
                <div class="h-fit">TOTAL</div>
                {{-- <div class="h-fit">OBS</div> --}}
                <div class="h-fit">OTHER MATTERS</div>
            </div>
            <div class="grid grid-cols-5 text-sm font-semibold">
                <div class="text-xs grids grid-row-6">
                    <div class="border-b-2 h-fit">MEDICINE</div>
                    <div class="border-b-2 h-fit">SURGERY</div>
                    <div class="border-b-2 h-fit">ENT</div>
                    <div class="border-b-2 h-fit">OB</div>
                    <div class="border-b-2 h-fit">PEDIA</div>
                    <div class="border-b-2 h-fit">NICU</div>
                </div>
                {{-- <div class="grid text-xs grid-row-6">
                    <div class="border-b-2 h-fit">{{ $text }}</div>
                    <div class="border-b-2 h-fit">{{ $text }}</div>
                    <div class="border-b-2 h-fit">{{ $text }}</div>
                    <div class="border-b-2 h-fit">{{ $text }}</div>
                    <div class="border-b-2 h-fit">{{ $text }}</div>
                    <div class="border-b-2 h-fit">{{ $text }}</div>
                </div> --}}

                <div class="grid text-xs grid-row-6">
                    <div class="border-b-2 h-fit">{{ $countmed }}</div>
                    <div class="border-b-2 h-fit">{{ $countsurgery }}</div>
                    <div class="border-b-2 h-fit">{{ $ent }}</div>
                    <div class="border-b-2 h-fit">{{ $ob }}</div>
                    <div class="border-b-2 h-fit">{{ $pedia }}</div>
                    <div class="border-b-2 h-fit">{{ $text }}</div>
                </div>

                <div class="grid text-xs grid-row-6">
                    <div class="border-b-2">ORTHO</div>
                    <div class="border-b-2">GYNE</div>
                    <div class="border-b-2">OPTHA</div>
                    <div class="border-b-2">TOTAL</div>
                    <div class="border-b-2">NEWBORN</div>
                    <div class="border-b-2">GRAND TOTAL</div>
                </div>
                {{-- <div class="grid text-xs grid-row-6"> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- </div> --}}
                <div class="grid text-xs grid-row-6">
                    <div class="border-b-2">{{ $ortho }}</div>
                    <div class="border-b-2">{{ $ob }}</div>
                    <div class="border-b-2">{{ $optha }}</div>
                    <div class="border-b-2">{{ $getCount }}</div>
                    <div class="border-b-2">{{ $text }}</div>
                    <div class="border-b-2">{{ $text }}</div>
                </div>
                {{-- <div class="grid text-xs grid-row-5"> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- <div class="border-b-2">{{ $text }}</div> --}}
                {{-- </div> --}}
                <div class="grid text-xs grid-row-6">
                    <div class="border-b-2">FAM MED</div>
                    <div class="text-transparent border-b-2"> s</div>
                    <div class="text-transparent border-b-2">s </div>
                    <div class="text-transparent border-b-2">s</div>
                    <div class="text-transparent border-b-2">s</div>
                    <div class="text-transparent border-b-2">s</div>
                </div>

                <div class="grid col-span-5 text-transparent border-b-2">s </div>
                <div class="grid col-span-5 text-sm font-normal border-b-2">Admission Reportable Cases</div>

                <div class="flex justify-around col-span-5 text-xs font-normal border-b-2">
                    <p>NAME</p>
                    <p>DIAGNOSIS</p>
                </div>
                <div class="flex justify-around col-span-5 text-xs border-b-2">
                    <div class="text-transparent">s</div>
                    <div class="text-transparent">s</div>
                </div>
                <div class="flex justify-between col-span-5 text-xs font-normal border-b-2">
                    <p>Transfer of service</p>
                    <p>From &nbsp; &nbsp; &nbsp;To</p>
                    <p class="text-transparent"> s</p>
                </div>
                <div class="col-span-5">
                    <div class="row-span-8">
                        <div class="flex justify-between col-span-5 text-xs border-b-2">
                            <div>NAME</div>
                            <div class="col-span-3">DIAGNOSIS</div>
                            <div>FLOOR/WARD</div>
                            <div>FlOOR/WARD</div>
                            <div class="col-span-2">REASON FOR TRANSFER</div>
                        </div>
                        <div class="col-span-5">
                            <div class="col-span-5 text-xs text-transparent border-b-2"> s</div>
                        </div>
                        <div class="text-xs font-normal border-b-2">
                            <p>Deaths</p>
                        </div>
                        <div class="flex justify-between text-xs font-normal border-b-2 ">
                            <div class="col-span-3">
                                <p>NAME</p>
                            </div>
                            <div class="col-span-4">
                                <p>Departmernt/Ward</p>
                            </div>
                            <div class="">
                                <p>Diagnosis</p>
                            </div>
                        </div>
                        <div class="text-xs text-transparent border-b-2"> s</div>
                        <div class="text-xs text-transparent border-b-2">s</div>
                        <div class="font-semibold border-b-2">
                            <p>Trasnfer from other hospital</p>
                        </div>
                        <div class="h-96">
                            <table class="table table-xs">
                                <thead class="">
                                    <th class="font-semibold text-black border-b-2">Name / Age / Address</th>
                                    <th class="font-semibold text-black border-b-2">Diagnosis</th>
                                    <th class="font-semibold text-black border-b-2">Refering and other Heath Facility
                                    </th>
                                    <th class="font-semibold text-black border-b-2">Reason for Referal</th>
                                </thead>
                                <tbody>
                                    @foreach ($transfers as $transfer)
                                        <tr>
                                            <td class="font-normal border">
                                                {{ $transfer->getpatient->get_patient_name() }} /
                                                {{ $var = (int) $transfer->getAge->patage }} /
                                                {{ $transfer->getpatient->getAddress->first()->province->provinceName() }},
                                                {{ $transfer->getpatient->getAddress->first()->city->cityName() }},
                                                Brgy.
                                                {{ $transfer->getpatient->getAddress->first()->barangay->barangayName() }}
                                                {{-- {{ $transfer->getpatient->fataddr }} --}}
                                            </td>
                                            <td class="font-normal border">{{ $transfer->diagnosis }}</td>
                                            <td class="font-normal border">{{ $transfer->facility }}
                                            </td>
                                            <td class="font-normal border">{{ $transfer->reason }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2">
                            @if ($transfers)
                                {{ $transfers->links() }}
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
