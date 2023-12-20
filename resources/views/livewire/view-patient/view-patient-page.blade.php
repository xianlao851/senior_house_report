<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-500">
        DAILY REPORT OF THE SENIOR HOUSE OFFICER
    </h2>
</x-slot>
<div class="flex flex-col py-6 mx-auto max-w-7xl">

    @if ($errors->first())
        <div class="mx-auto mb-2 max-w-6xl">
            <div class="shadow-lg alert alert-error">
                <div>
                    <button wire:click="$emit('refresh')"><svg xmlns="http://www.w3.org/2000/svg"
                            class="flex-shrink-0 w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></button>
                    <i class="mr-2 las la-lg la-exclamation-triangle"></i> {{ $errors->first() }}
                </div>
            </div>
        </div>
    @endif
    <div class="w-full p-4 bg-white">
        <div class="mb-4">
            <label for="" class="text-white btn btn-xs btn-neutral"> <a
                    href="{{ route('viewshoreports', ['id' => $get_id]) }}">
                    Back</a></label>
        </div>
        <div class="border-b-2 border-l-2 border-r-2 h-52">

            <table class="table text-sm border table-fixed border-stone-500 table-sm">
                <thead class="text-black bg-gray-200">
                    <th class="border"> NAME OF PATIENT</th>
                    <th class="border">OPERATION DONE</th>
                </thead>
                <tbody>
                    @foreach ($operations as $operation)
                        <tr>
                            <td class="text-xs border">
                                @foreach ($operation->patient as $getinfo)
                                    {{ $getinfo->get_patient_name() }}
                                @endforeach
                            </td>
                            <td class="text-xs border">
                                {{ $operation->operation_done }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex flex-col h-40 my-4 border-x-2 border-y-2">
            <div class="h-6 px-2 text-sm text-black uppercase bg-gray-200">
                <span>
                    <label> INCIDENT</label>
            </div>
            @foreach ($incidents as $incident)
                <div class="ml-6 text-sm">
                    <ul class="list-disc">
                        <li class="">
                            {{ $incident->incident_description }}
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col my-4 border-b-2 border-l-2 border-r-2 h-36">
            <div class="h-6 text-black bg-gray-200">
                <span class="ml-2">SIGNIFICANT EVENTS</span>
            </div>
            <div class="py-2 ">
                <div class="col-md-12">
                    <div class="flex flex-row">
                        @foreach ($significanIncidents as $significanIncident)
                            <div class="ml-2 col-md-4">
                                <div class="text-sm card">
                                    {{ $i++ }}.) {{ $significanIncident->patients->get_patient_name() }}
                                </div>
                                <div class="">
                                    <p class="text-sm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOI &nbsp;
                                        {{ $significanIncident->nature_of_intent }}</p>
                                    <p class="text-sm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOI &nbsp;
                                        {{ $significanIncident->place_of_intent }}</p>
                                    <p class="text-sm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOI &nbsp;
                                        {{ $significanIncident->time_of_intent }}</p>
                                    <p class="text-sm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOI &nbsp;
                                        {{ $significanIncident->date_of_intent }}</p>
                                </div>
                            </div>
                        @endforeach

                    </div>
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
                        <tr class="border">
                            <th>Department</th>
                            <th>Count</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td class="border">{{ $department->department }}</td>
                                <td class="border">
                                    {{ $department->operation($detail->id)->count() }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="border">Total: </td>
                            <td>{{ $getCount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
