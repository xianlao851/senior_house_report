<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-black">
        SHO REPORT
    </h2>

</x-slot>
<div class="w-full max-w-6xl p-8 mx-auto">
    <div class="relative flex flex-col p-4 mx-auto">
        <div class="absolute top-0 right-2">
            <button class="text-white bg-amber-700 btn btn-sm hover:bg-blue-500"> <a onclick="window.history.back()"><i
                        class="las la-arrow-circle-left la-2x"></i></a></button>
            <button class="text-white bg-green-700 btn btn-sm hover:bg-blue-500" onClick="printReport()"><i
                    class="las la-print la-2x"></i> </button>
        </div>
    </div>
    <div class="bg-white ">

        <div id="reportPrinting" class="p-2 mt-2">
            <div class="flex flex-col p-3 mx-auto bg-white rounded-md">
                <div>
                    <h4>
                        @if ($detail)
                            <div class="join">
                                <span class="font-bold join-item">Senior House Officer: </span>
                                <span
                                    class="px-2 font-bold text-green-600 underline join-item">{{ $detail->employee->fullname() }}</span>
                            </div>

                            <div class="px-12 join">
                                <span class="font-bold join-item">Report Date: </span>
                                {{-- <span class="px-2 font-bold text-green-600 underline join-item">{{ $detail->report_date }}
                                </span> --}}
                                <span
                                    class="px-2 font-bold text-green-600 underline join-item">{{ \Carbon\Carbon::parse($detail->report_date)->format('M-j-Y') }}
                                </span>
                            </div>
                        @endif
                    </h4>
                </div>
                <div class="py-2 mt-2">
                    <table class="table border table-fixed table-xs">
                        <thead>
                            <tr class="text-center text-black uppercase bg-gray-200 ">
                                <th class="border">Department</th>
                                <th class="border">Medical Officer III</th>
                                <th class="border">Medical Specialist</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr class="uppercase">
                                    <td class="text-black border">{{ $department->department }}</td>
                                    <td class="text-black border">
                                        @foreach ($department->checked_in_mo($detail->id)->get() as $checkin_mo)
                                            {{ 'Dr.' . $checkin_mo->employee->name() }}
                                            @if (!$loop->last)
                                                /
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-black border">
                                        @foreach ($department->checked_in_ms($detail->id)->get() as $checkin_ms)
                                            {{ 'Dr.' . $checkin_ms->employee->name() }}
                                            @if (!$loop->last)
                                                /
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col py-3">
                    <div class="">
                        <span class="label">
                            <Label class="font-bold text-black uppercase label-text">TRANSFER FROM OTHER
                                FACILITIES</Label>
                        </span>
                        <div>
                        </div>
                    </div>

                    <div class="flex flex-col border-x-2 border-y-2">
                        <table class="table border table-fixed table-xs">
                            <thead class="text-black bg-gray-200"">
                                <tr class="">
                                    <th class="border">NAME / AGE / ADDRESS</th>
                                    <th class="border">DIAGNOSIS</th>
                                    <th class="border">TRANSFERING FACILITY</th>
                                    <th class="border">REASON FOR TRANSFER</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transfers as $transfer)
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
                                @empty
                                    <tr>
                                        <td>No records</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- end for the transfer from other facilities --}}
                    {{-- begin for transfer to other hospital --}}
                    <div class="flex flex-col py-3">
                        <div class="">
                            <span class="label">
                                <Label class="font-bold text-black uppercase label-text">TRANSFER TO OTHER
                                    FACILITIES</Label>
                            </span>
                            <div>
                            </div>
                        </div>
                        <div class="flex flex-col border-x-2 border-y-2">
                            <table class="table border table-fixed table-xs">
                                <thead class="text-black bg-gray-200"">
                                    <tr class="">
                                        <th class="border">NAME / AGE / ADDRESS</th>
                                        <th class="border">DIAGNOSIS</th>
                                        <th class="border">TRANSFERING FACILITY</th>
                                        <th class="border">REASON FOR TRANSFER</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($trasnsferTos as $to)
                                        <tr>
                                            <td class="border"> {{ $to->getpatient->get_patient_name() }} /
                                                {{ $var = (int) $to->getAge->patage }} /
                                                {{ $to->getpatient->getAddress->first()->province->provinceName() }},
                                                {{ $to->getpatient->getAddress->first()->city->cityName() }},
                                                Brgy.
                                                {{ $to->getpatient->getAddress->first()->barangay->barangayName() }}
                                                {{-- {{ $to->getpatient->fataddr }} --}}
                                            </td>
                                            <td class="border">{{ $to->diagnosis }}</td>
                                            <td class="border">{{ $to->facility }}</td>
                                            <td class="border">{{ $to->reason }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>No records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div style="page-break-after: always;"></div>
            <div class="w-full p-3 bg-white rounded-md">
                <div class="border-b-2 border-l-2 border-r-2 ">
                    <table class="table text-sm border table-fixed border-stone-500 table-sm">
                        <thead class="text-black bg-gray-200">
                            <th class="border"> NAME OF PATIENT</th>
                            <th class="border">OPERATION DONE</th>
                        </thead>
                        <tbody>
                            @forelse ($operations as $operation)
                                <tr>
                                    <td class="text-xs border">
                                        <label for="my_modal_5"
                                            wire:click="get_patient_id({{ $operation->patient_id }})"
                                            class="cursor-pointer">
                                            {{ $operation->patient_id }}
                                            {{ $operation->patient->get_patient_name() }}&nbsp;
                                            /&nbsp;{{ $var = (int) $operation->getAge->patage }}
                                            / {{ $operation->patient->patsex }}
                                        </label>
                                    </td>
                                    <td class="text-xs border">
                                        <label for="my_modal_5"
                                            wire:click="get_patient_id({{ $operation->patient_id }})"
                                            class="cursor-pointer">
                                            {{ $operation->operation_done }}
                                        </label>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td>No records</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col my-4 border-x-2 border-y-2">
                    <div class="h-6 px-2 text-sm text-black uppercase bg-gray-200">
                        <span>
                            <label> INCIDENT</label>
                    </div>
                    <div class="">
                        @forelse ($incidents as $incident)
                            @foreach ($incidents as $incident)
                                <div class="grid mt-1 ml-2">
                                    @if ($incident->incident_case_reported != null)
                                        <div>{{ $incident->incident_case_reported }} &nbsp; INCIDENT CASE
                                            REPORTED</div>
                                    @else
                                        <div>NO INCIDENT CASE REPORTED</div>
                                    @endif
                                    @if ($incident->absconding_patient_case_reported != null)
                                        <div>{{ $incident->absconding_patient_case_reported }} &nbsp; ABSCONDING
                                            PATIENT CASE REPORTED</div>
                                    @else
                                        <div>NO ABSCONDING PATIENT CASE REPORTED</div>
                                    @endif
                                    @if ($incident->doa_patient_case_reported != null)
                                        <div> {{ $incident->doa_patient_case_reported }} &nbsp; DOA PATIENT CASE
                                            REPORTED</div>
                                    @else
                                        <div>NO DOA PATIENT CASE REPORTED</div>
                                    @endif
                                    @if ($incident->other_security_function != null)
                                        <div>{{ $incident->other_security_function }}&nbsp; OTHER SECURITY
                                            FUNCTION</div>
                                    @else
                                        <div>NO OTHER SECURITY FUNCTION</div>
                                    @endif
                                    @if ($incident->trauma_patient_case_reported != null)
                                        <div>{{ $incident->trauma_patient_case_reported }}&nbsp; TRAUMA PATIENT
                                            CASE REPORTED</div>
                                    @else
                                        <div>NO TRAUMA PATIENT CASE REPORTED</div>
                                    @endif
                                </div>
                            @endforeach
                        @empty
                            <div class="ml-2 text-sm">No records</div>
                        @endforelse
                    </div>
                </div>

                <div class="flex flex-col my-4 border-b-2 border-l-2 border-r-2 ">
                    <div class="h-6 text-black bg-gray-200">
                        <span class="ml-2">SIGNIFICANT EVENTS</span>
                    </div>
                    <div class="py-2 ">
                        <div class="grid grid-cols-3 gap-2">
                            @forelse ($significanIncidents as $significanIncident)
                                <div class="">
                                    <div class="text-sm card">
                                        &nbsp;
                                        {{ $significanIncident->patient->get_patient_name() }}
                                    </div>
                                    <div class="">
                                        <p class="text-sm">&nbsp;&nbsp;&nbsp;NOI &nbsp;
                                            {{ $significanIncident->nature_of_incident }}</p>
                                        <p class="text-sm">&nbsp;&nbsp;&nbsp;POI &nbsp;
                                            {{ $significanIncident->place_of_incident }}</p>
                                        <p class="text-sm">&nbsp;&nbsp;&nbsp;TOI &nbsp;
                                            {{ $significanIncident->time_of_incident }}</p>
                                        <p class="text-sm">&nbsp;&nbsp;&nbsp;DOI &nbsp;
                                            {{ $significanIncident->date_of_incident }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="ml-2 text-sm">No records</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="flex flex-col my-4 border-b-2 border-l-2 border-r-2">
                    <div class="bg-gray-200">
                        <span class="">
                            <p class="ml-2">CENSUS</p>
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-xs">
                            <thead>
                                <tr class="">
                                    <th>Department</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getdepartments as $department)
                                    <tr>
                                        <td>
                                            @if ($department->tsdesc == 'Diagnostics')
                                                Anesthesiology Department
                                            @else
                                                {{ $department->tsdesc }}
                                            @endif
                                        </td>
                                        <td>{{ $department->getlogs($detail->report_date)->count() }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="">Total: </td>
                                    <td>{{ $getCount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>{{-- Second page --}}
            {{-- for second page --}}
            <div style="page-break-after: always;"></div>
            <div class="mt-1">
                <div class="flex flex-col p-2 mx-auto text-black bg-white rounded-md">
                    <div class="flex flex-col items-center justify-center">
                        <h2>MARIANO MARCOS MEMORIAL HOSPITAL & MEDICAL CENTER</h2>
                        <p class="items">City of Batac, Ilocos Norte</p>
                        <p class="mt-2 text-sm font-semibold">DAILY CENSUS SUMMARY</p>
                        <P class="text-sm font-semibold underline">
                            {{ \Carbon\Carbon::parse($get_date)->format('M-j-Y') }}</P>
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
                        <div class="grid col-span-5 text-sm font-normal border-b-2">Admission Reportable Cases
                        </div>

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
                                            <th class="font-semibold text-black border-b-2">Name / Age / Address
                                            </th>
                                            <th class="font-semibold text-black border-b-2">Diagnosis</th>
                                            <th class="font-semibold text-black border-b-2">Refering and other
                                                Heath
                                                Facility
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
                            </div>
                        </div>

                    </div>
                </div>
            </div> {{-- third page --}}
        </div>
    </div>
</div>
<script type="text/javascript">
    function printReport() {
        var printContents = document.getElementById('reportPrinting').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

</div>
