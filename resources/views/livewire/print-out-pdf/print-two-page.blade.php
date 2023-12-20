<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-black">
        SHO REPORT
    </h2>

</x-slot>
<div class="p-12">
    <div class="w-full h-full p-8 mt-4 bg-white">
        <div class="relative flex flex-col p-4 mx-auto">
            <div class="absolute right-0 top-4">
                <button class="text-white bg-green-700 btn btn-sm hover:bg-blue-500"
                    onClick="printReport()">Print</button>
            </div>
        </div>
        <div id="reportPrinting" class="p-12">
            <div class="">
                <h4>
                    <span style="font-size: 14px;">Senior House Officer:
                        <span
                            style="text-decoration: underline; font-size: 14px;">{{ $detail->employee->fullname() }}</span>
                    </span>
                    <span style="margin-left: 30px; font-size: 14px; font-size: 14px;">Report Date:
                        <span
                            style="text-decoration: underline; font-size: 14px;">{{ \Carbon\Carbon::parse($detail->report_date)->format('M-j-Y') }}</span>
                    </span>
                </h4>
            </div>

            <div class="">
                <table style="width:100%;border:1px solid black; border-collapse: collapse">
                    <thead>
                        <tr>
                            <th style="border:1px solid black; border-collapse: collapse;background-color:#D6DBDF">
                                Department
                            </th>
                            <th style="border:1px solid black; border-collapse: collapse; background-color:#D6DBDF">
                                Medical
                                Officer III</th>
                            <th style="border:1px solid black; border-collapse: collapse; background-color:#D6DBDF">
                                Medical
                                Specialist</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td style="border:1px solid black; border-collapse: collapse">
                                    {{ $department->department }}</td>
                                <td style="border:1px solid black; border-collapse: collapse; font-size: 12px;">

                                    @foreach ($department->checked_in_mo($detail->id)->get() as $checkin_mo)
                                        {{ 'Dr.' . $checkin_mo->employee->name() }}
                                        @if (!$loop->last)
                                            /
                                        @endif
                                    @endforeach


                                </td>
                                <td style="border:1px solid black; border-collapse: collapse; font-size: 12px;">

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
            <div style="margin-top: 6px;">
                <div style=""> TRANSFER FROM OTHER FACILITIES</div>
                <div style="margin-top: 6px;">
                    <table style="width:100%;border:1px solid black; border-collapse: collapse">
                        <thead>
                            <tr>
                                <th
                                    style="border:1px solid black; border-collapse: collapse;background-color:#D6DBDF; font-size: 12px;">
                                    NAME / AGE / ADDRESS
                                </th>
                                <th
                                    style="border:1px solid black; border-collapse: collapse; background-color:#D6DBDF; font-size: 12px;">
                                    DIAGNOSIS
                                </th>
                                <th
                                    style="border:1px solid black; border-collapse: collapse; background-color:#D6DBDF; font-size: 12px;">
                                    TRANSFERING FACILITY</th>
                                <th
                                    style="border:1px solid black; border-collapse: collapse; background-color:#D6DBDF; font-size: 12px;">
                                    REASON
                                    FOR TRANSFER</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($transfers)
                                @foreach ($transfers as $transfer)
                                    <tr>
                                        <td style="border:1px solid black; border-collapse: collapse">
                                            {{ $transfer->getpatient->get_patient_name() }} /
                                            {{ $var = (int) $transfer->getAge->patage }} /
                                            {{ $transfer->getpatient->getAddress->first()->province->provinceName() }},
                                            {{ $transfer->getpatient->getAddress->first()->city->cityName() }},
                                            Brgy.
                                            {{ $transfer->getpatient->getAddress->first()->barangay->barangayName() }}
                                            {{ $transfer->getpatient->fataddr }}
                                        </td>
                                        <td style="border:1px solid black; border-collapse: collapse">
                                            {{ $transfer->diagnosis }}</td>
                                        <td style="border:1px solid black; border-collapse: collapse">
                                            {{ $transfer->hospital->hospital_name }}</td>
                                        <td style="border:1px solid black; border-collapse: collapse">
                                            {{ $transfer->reason }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            @if (is_null($transfers))
                                <tr>
                                    <td>NO DATA</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="margin-top: 6px;">
                <div style=""> TRANSFER TO OTHER FACILITIES</div>
                <div style="margin-top: 6px;">
                    <table style="width:100%;border:1px solid black; border-collapse: collapse">
                        <thead>
                            <tr>
                                <th
                                    style="border:1px solid black; border-collapse: collapse;background-color:#D6DBDF; font-size: 12px;">
                                    NAME / AGE / ADDRESS
                                </th>
                                <th
                                    style="border:1px solid black; border-collapse: collapse; background-color:#D6DBDF; font-size: 12px;">
                                    DIAGNOSIS
                                </th>
                                <th
                                    style="border:1px solid black; border-collapse: collapse; background-color:#D6DBDF; font-size: 12px;">
                                    TRANSFERING FACILITY</th>
                                <th
                                    style="border:1px solid black; border-collapse: collapse; background-color:#D6DBDF; font-size: 12px;">
                                    REASON
                                    FOR TRANSFER</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trasnsferTos as $to)
                                <tr>
                                    <td style="border:1px solid black; border-collapse: collapse">
                                        {{ $to->getpatient->get_patient_name() }} /
                                        {{ $var = (int) $to->getAge->patage }} /
                                        {{ $to->getpatient->getAddress->first()->province->provinceName() }},
                                        {{ $to->getpatient->getAddress->first()->city->cityName() }},
                                        Brgy.
                                        {{ $to->getpatient->getAddress->first()->barangay->barangayName() }}

                                        {{ $to->getpatient->fataddr }}
                                    </td>
                                    <td style="border:1px solid black; border-collapse: collapse">{{ $to->diagnosis }}
                                    </td>
                                    <td style="border:1px solid black; border-collapse: collapse">
                                        {{ $to->hospital->hospital_name }}</td>
                                    <td style="border:1px solid black; border-collapse: collapse">{{ $to->reason }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="page-break-after: always;"></div>
                <div class="mt-8">
                    <div>
                        <h3 style="font-size: 15px; font-weight: bold;">OPERATIONS ( EMERGENCY )</h3>
                    </div>
                    <div>
                        <table style="width:100%;border:1px solid black; border-collapse: collapse">
                            <thead>
                                <tr>
                                    <th
                                        style="font-size: 15px; border:1px solid black; border-collapse: collapse;background-color:#D6DBDF">
                                        NAME OF
                                        PATIENT</th>
                                    <th
                                        style="font-size: 15px; border:1px solid black; border-collapse: collapse;background-color:#D6DBDF">
                                        OPERATION
                                        DONE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($operations as $operation)
                                    <tr>
                                        <td style="border:1px solid black; border-collapse: collapse">
                                            {{ $operation->patient_id }}
                                            {{ $operation->patient->get_patient_name() }}&nbsp;
                                            /&nbsp;{{ $var = (int) $operation->getAge->patage }}
                                            / {{ $operation->patient->patsex }}</td>
                                        <td style="border:1px solid black; border-collapse: collapse">
                                            {{ $operation->operation_done }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 30px">
                        <table style="width:100%;border:1px solid black; border-collapse: collapse">
                            <thead>
                                <tr>
                                    <th
                                        style="font-size: 15px; border:1px solid black; border-collapse: collapse;background-color:#D6DBDF">
                                        Incidents</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($incidents as $incident)
                                    <tr>
                                        <td style="border:1px solid black; border-collapse: collapse">
                                            &nbsp; Incident:&nbsp; {{ $incident->incident_description }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> {{-- for incident --}}
                    <div style="margin-top: 20px; background:white; position:relative">
                        <div>
                            <h4 style="font-size: 15px; font-weight: bold;">
                                SIGNIFICANT EVENTS</h4>
                        </div>
                        <div
                            style=" display: grid;
                        grid-template-columns: repeat(5, auto);
                        max-width: 100%; border:1px solid black; border-collapse: collapse;">
                            @foreach ($significanIncidents as $sigevent)
                                <div
                                    style="
                                border-radius: 5px; font-size: 12px; padding: 10px; margin-bottom: 2px;">
                                    <div class="text-sm">&nbsp;&nbsp;&nbsp;NOI &nbsp;
                                        {{ $sigevent->nature_of_intent }}</div>
                                    <div class="text-sm">&nbsp;&nbsp;&nbsp;POI &nbsp;
                                        {{ $sigevent->place_of_intent }}</div>
                                    <div class="text-sm">&nbsp;&nbsp;&nbsp;TOI &nbsp;
                                        {{ $sigevent->time_of_intent }}</div>
                                    <div class="text-sm">&nbsp;&nbsp;&nbsp;NOI &nbsp;
                                        {{ $sigevent->date_of_intent }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div> {{-- significant event --}}
                <div style="margin-top: 30px; ">
                    <table style="width:100%;border:1px solid black; border-collapse: collapse">
                        <thead>
                            <tr>
                                <th
                                    style="font-size: 15px; border:1px solid black; border-collapse: collapse;background-color:#D6DBDF">
                                    Department</th>
                                <th
                                    style="font-size: 15px; border:1px solid black; border-collapse: collapse;background-color:#D6DBDF">
                                    Count</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td style="border:1px solid black; border-collapse: collapse">
                                        {{ $department->department }}
                                    </td>
                                    <td style="border:1px solid black; border-collapse: collapse; text-align: center;">
                                        {{ $department->operation($getid)->count() }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td style="border:1px solid black; border-collapse: collapse">Total: </td>
                                <td style="border:1px solid black; border-collapse: collapse; text-align: center;">
                                    {{ $getCount }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>{{-- significant events --}}
            </div> {{-- for second page --}}
            <div style="page-break-after: always;"></div>
            <div style="margin-top: 20px"> {{-- staer third page --}}
                <div style="">
                    <p style="display: flex;
                    justify-content: center;">MARIANO MARCOS MEMORIAL
                        HOSPITAL & MEDICAL CENTER</p>
                    <p style="display: flex;
                        justify-content: center;">City of Batac, Ilocos
                        Norte
                    </p>
                    <p style="display: flex;
                    justify-content: center;">DAILY CENSUS SUMMARY</p>
                    <P
                        style="display: flex;
                    justify-content: center; text-decoration: underline; font-weight: bold;">
                        {{ \Carbon\Carbon::parse($detail->report_date)->format('M-j-Y') }}</P>
                    <P
                        style="display: flex;
                    justify-content: center; text-decoration: underline; font-weight: bold;">
                        DATE</P>
                </div>
            </div> {{-- third page --}}
        </div>
    </div>
</div>
<script type="text/javascript">
    function printReport() {
        var prtContent = document.getElementById("reportPrinting");
        var WinPrint = window.open();
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    }
</script>

</div>
