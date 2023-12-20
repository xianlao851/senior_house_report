<x-slot name="header">
    <h2 class="text-xl font-bold leading-tight text-black"> </h2>
    <div class="p-2 px-4 text-black indicator">
        <h3>DAILY REPORT OF THE SENIOR HOUSE OFFICER</h3>
    </div>
</x-slot>
<div class="p-1">
    {{-- <div class="relative max-w-5xl p-4 mx-auto">
        <div class="absolute top-0 right-0">
            <div class="join">
                <div>
                    <div>
                        <input class="input input-bordered join-item" wire:model='get_emp_id' placeholder="Search" />
                    </div>
                </div>
                 <select class="select select-bordered join-item">
                    <option disabled selected>Filter</option>
                    <option>Sci-fi</option>
                    <option>Drama</option>
                    <option>Action</option>
                </select>
                <div class="indicator">
                    <span class="indicator-item badge badge-secondary">new</span>
                    <button class="btn join-item" wire:click='clickMe'>Search</button>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="max-w-6xl p-4 mx-auto mt-4">
        @if ($errors->first())
            <div class="max-w-6xl mx-auto mb-2">
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
        <div class="w-full p-3 bg-white rounded-md">
            <div class="relative py-2 font-medium uppercase">
                <span>
                    <label class="text-black"> OPERATIONS ( EMERGENCY )</label>
                </span>
                @if ($cur_time >= 17 or $cur_time < 12)
                    @if ($getDiffHours <= 23)
                        <div class="absolute top-0 right-0">
                            <div class="join">
                                <label class="text-white bg-green-600 btn btn-sm join-item hover:bg-gray-400"
                                    @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59) for="my_modal_7"
                                    @else onclick="permission()" @endif>ADD
                                    OPERATION
                            </div>

                            <div class="join">
                                <div class="">
                                    <label
                                        @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59) for="my_modal_5" @else onclick="permission()" @endif
                                        class="text-white bg-green-600 btn join-item btn-sm hover:bg-gray-400">ADD
                                        SIGNIFICANT EVENT</label>
                                </div>
                            </div>
                            <div class="join">
                                <div class="">
                                    <label
                                        @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59) for="my_modal_6"
                                    @else
                                    onclick="permission()" @endif
                                        class="text-white bg-green-600 btn join-item btn-sm hover:bg-gray-400">ADD
                                        INCIDENT</label>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="mt-2">
                <div class="border-b-2 border-l-2 border-r-2 h-52 ">
                    <table class="table text-sm border table-fixed border-stone-500 table-sm">
                        <thead class="text-black bg-gray-200">
                            <th class="border"> NAME OF PATIENT</th>
                            <th class="border">OPERATION DONE</th>
                            <th class="border w-28">Action</th>
                        </thead>
                        <tbody>
                            @if ($operations)
                                @foreach ($operations as $operation)
                                    <tr class="hover:bg-slate-100">
                                        <td class="text-xs border">
                                            <label>
                                                {{ $operation->patient_id }}
                                                {{ $operation->patient->get_patient_name() }}&nbsp;
                                                /&nbsp;{{ $var = (int) $operation->getAge->patage }}
                                                / {{ $operation->patient->patsex }}
                                            </label>
                                            {{-- <div wire:loading
                                                wire:target="get_patient_id({{ $operation->patient_id }})">
                                                Loading data ......
                                            </div> --}}
                                        </td>
                                        <td class="text-xs border ">
                                            <label>
                                                {{ $operation->operation_done }}
                                            </label>
                                        </td>
                                        <td class="text-xs border">
                                            <label class=" btn btn-secondary btn-xs"
                                                @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                                wire:click="editOperation('{{ $operation->id }}','{{ $operation->operation_done }}','{{ $operation->patient_id }}','{{ $operation->deparment_id }}','{{ $operation->sho_id }}')" for="editOperation"
                                                @else onclick="permission()" @endif
                                                @endif><i class="las la-edit la-lg"></i></label>
                                            <label class="btn btn-warning btn-xs"
                                                @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                                onclick="deleteOperation({{ $operation->id }})"
                                                @else onclick="permission()" @endif
                                                @endif>
                                                <i class="las la-trash la-lg"></i>
                                            </label>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    @if ($operations)
                        {{ $operations->links() }}
                    @endif

                </div>

                <div class="flex flex-col h-40 my-4 border-x-2 border-y-2">
                    <div class="h-6 px-2 text-sm text-black uppercase bg-gray-200">
                        <span>
                            <label> INCIDENT</label>
                    </div>
                    <div class="grid grid-rows-4  grid-cols-2 grid-flow-col gap-[2px]">
                        @if ($incidents)
                            @foreach ($incidents as $incident)
                                <div class="grid grid-cols-2 mt-1">
                                    <div>&nbsp; -&nbsp; {{ $incident->incident_description }}</div>
                                    <div>
                                        <label class="btn btn-xs btn-secondary"
                                            @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                            wire:click="editIncident('{{ $incident->id }}','{{ $incident->incident_description }}')" for="editIncidentReport"
                                            @else onclick="permission()" @endif
                                            @endif><i class="las la-edit la-lg"></i></label>
                                        <label class="btn btn-xs btn-warning"
                                            @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                            onclick="deletetIncident({{ $incident->id }})"
                                            @else onclick="permission()" @endif
                                            @endif><i class="las la-trash la-lg"></i></label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="flex flex-col h-40 my-4 border-b-2 border-l-2 border-r-2">
                    <div class="h-6 text-sm text-black bg-gray-200">
                        <span class="ml-2">SIGNIFICANT EVENTS</span>
                    </div>
                    <div class="py-2 ">
                        <div class="">
                            <div class="grid grid-cols-4 gap-4">
                                @if ($significanIncidents)
                                    @foreach ($significanIncidents as $significanincident)
                                        <div class="">
                                            <div class="text-sm card">
                                                &nbsp;
                                                {{ $significanincident->patient->get_patient_name() }}
                                            </div>
                                            <div class="">
                                                <p class="text-sm">&nbsp;&nbsp;&nbsp;NOI &nbsp;
                                                    {{ $significanincident->nature_of_incident }}</p>
                                                <p class="text-sm">&nbsp;&nbsp;&nbsp;POI &nbsp;
                                                    {{ $significanincident->place_of_incident }}</p>
                                                <p class="text-sm">&nbsp;&nbsp;&nbsp;TOI &nbsp;
                                                    {{ $significanincident->time_of_incident }}</p>
                                                <p class="text-sm">&nbsp;&nbsp;&nbsp;DOI &nbsp;
                                                    {{ $significanincident->date_of_incident }}</p>
                                            </div>
                                            <div class="ml-2">
                                                <label class="btn btn-xs btn-secondary"
                                                    @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                                    wire:click="editSignificantIncident('{{ $significanincident->id }}','{{ $significanincident->nature_of_incident }}','{{ $significanincident->place_of_incident }}','{{ $significanincident->time_of_incident }}','{{ $significanincident->date_of_incident }}','{{ $significanincident->patient_id }}')"
                                                    for="editSignificant"
                                                    @else onclick="permission()" @endif
                                                    @endif><i
                                                        class="las la-edit la-lg"></i></label>
                                                <label class="btn btn-xs btn-warning"
                                                    @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                                    onclick="deleteSignificant({{ $significanincident->id }})"
                                                    @else onclick="permission()" @endif
                                                    @endif><i
                                                        class="las la-trash la-lg"></i></label>

                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    @if ($significanIncidents)
                        {{ $significanIncidents->links() }}
                    @endif
                </div>
                <!-- For displayinfg census -->
                <div class="flex flex-col my-4">
                    <div class="bg-gray-200">
                        <span>
                            <p class="ml-2">CENSUS</p>
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-xs">
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Count</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($getdepartments)
                                    @foreach ($getdepartments as $department)
                                        <tr>
                                            <td>
                                                @if ($department->tsdesc == 'Diagnostics')
                                                    Anesthesiology Department
                                                @else
                                                    {{ $department->tsdesc }}
                                                @endif
                                            </td>
                                            <td>{{ $department->getlogs($get_sho_detail->report_date)->count() }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="font-semibold">
                                        <td>Total: </td>
                                        <td>{{ $getCount }}</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end tag for second div bg white, main div-->

            <!--modal section-->
            <!-- Modal for adding incident -->
            <input type="checkbox" id="my_modal_6" class="modal-toggle" />
            <div class="modal">
                <div class="modal-box">
                    <h3 class="text-lg font-bold ">Incident</h3>
                    <div class="py-2">
                        <label for="incident"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                        <textarea type="text" wire:model="incident_description" id="reason "
                            class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                            placeholder="INCIDENT" required> </textarea>
                    </div>
                    <div class="modal-action">
                        <label for="my_modal_6" class="btn btn-sm">Close!</label>
                        <label wire:click="save_incident" class="btn btn-success btn-sm">Save</label>
                    </div>
                </div>
            </div>

            <!-- Modal for adding patient in the operation -->
            <input type="checkbox" id="my_modal_7" class="modal-toggle" />
            <div class="modal">
                <div class="flex flex-col max-w-xl modal-box">
                    <div class="w-full p-2"> <!-- For searching patient info, for adding transfer from-->
                        <div class="w-full join">
                            <div class="">
                                <input
                                    class="input input-bordered join-item w-[450px] focus:border-green-700 focus:ring-green-700"
                                    type="text" wire:model.lazy="search_patient" placeholder="Search" />
                            </div>
                            {{-- <select class="select select-bordered join-item" wire:model='get_option'>
                                <option>Filter</option>
                                <option value="dbo.hperson.hpercode">Hospital No.</option>
                                <option value="dbo.hperson.patlast">Last name</option>
                                <option value="dbo.hperson.patfirst">First name</option>
                            </select> --}}
                            <div class="indicator">
                                <button class="w-20 text-white bg-green-700 btn join-item">Search </button>
                                {{-- wire:click='searchpatient'>Search</button> --}}
                            </div>
                        </div>
                        <div wire:loading wire:target="search_patient" class="mt-3 mx-44">
                            <span class="text-green-400 loading loading-md loading-spinner "></span>
                        </div>
                        <div class="mt-2 text-black font-extralight" wire:loading.remove>
                            <ul class="">
                                {{-- wire:click="get_patientIdFrom({{ $patient->hpercode }})" --}}
                                @if ($getPatients)
                                    @forelse ($getPatients as $pat)
                                        <li class="w-full mt-2 rounded-sm shadow-lg cursor-pointer hover:bg-gray-300 bg-slate-200"
                                            wire:click="selectPatient({{ $pat->hpercode }})">
                                            {{ $pat->patlast }}, {{ $pat->patfirst }}
                                        </li>
                                    @empty
                                        <div class="mx-1">No records!</div>
                                    @endforelse
                                @else
                            </ul>
                            @endif
                        </div>
                    </div>
                    <div wire:loading wire:target="selectPatient" class="mt-2 mx-44">
                        <span class="text-green-400 loading loading-md loading-spinner "></span>
                    </div>
                    @if ($selected_patient)
                        <div class="mt-6">
                            <h3 class="font-bold text-black text-md join">
                                Patient Name: &nbsp;
                                <p class="text-green-600 underline join-item">
                                    {{ $selected_patient->patient->get_patient_name() }}
                                </p>
                            </h3>
                            <div class="">
                                <label for="operation"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                                <textarea type="text" wire:model="operation_done" id="operation "
                                    class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    placeholder="OPERATION" required> </textarea>
                            </div>
                        </div>

                        <div class="modal-action">
                            <label wire:click="save_operation" class="btn btn-sm btn-success ">Save</label>
                            <label for="my_modal_7" wire:click='reset_page'
                                class="btn btn-sm btn-danger ">Close!</label>
                        </div>
                    @endif
                    @if (is_null($selected_patient))
                        <div class="modal-action">
                            <label for="my_modal_7" wire:click="reset_page"
                                class="btn btn-sm btn-danger ">Closed!</label>
                        </div>
                    @endif

                </div>
            </div>

            <!-- for adding significant event-->
            <input type="checkbox" id="my_modal_5" class="modal-toggle" />
            <div class="modal">
                <div class="flex flex-col max-w-xl modal-box">
                    <div class="w-full p-2"> <!-- For searching patient info, for adding transfer from-->
                        <div class="w-full join">
                            <div class="">
                                <input
                                    class="w-[450px] input input-bordered join-item focus:border-green-700 focus:ring-green-700"
                                    type="text" wire:model.lazy="search_patient" placeholder="Search" />
                            </div>
                            {{-- <select class="select select-bordered join-item" wire:model='get_option'>
                                <option>Filter</option>
                                <option value="dbo.hperson.hpercode">Hospital No.</option>
                                <option value="dbo.hperson.patlast">Last name</option>
                                <option value="dbo.hperson.patfirst">First name</option>
                            </select> --}}
                            <div class="indicator">
                                <button class="w-20 text-white bg-green-700 btn join-item">Search</button>
                                {{-- wire:click='searchpatient'>Search</button> --}}
                            </div>
                        </div>
                        <div wire:loading wire:target="search_patient" class="mt-3 mx-44">
                            <span class="text-green-400 loading loading-md loading-spinner "></span>
                        </div>
                        <div class="mt-2 text-black font-extralight" wire:loading.remove>
                            <ul class="">
                                {{-- wire:click="get_patientIdFrom({{ $patient->hpercode }})" --}}
                                @if ($getPatients)
                                    @forelse ($getPatients as $pat)
                                        <li class="w-full mt-2 rounded-sm shadow-lg cursor-pointer hover:bg-gray-300 bg-slate-200"
                                            wire:click="selectPatient({{ $pat->hpercode }})">
                                            {{ $pat->patlast }}, {{ $pat->patfirst }}
                                        </li>
                                    @empty
                                        <div class="mx-1">No records!</div>
                                    @endforelse
                                @else
                            </ul>
                            @endif
                        </div>
                    </div>
                    <div wire:loading wire:target="selectPatient" class="mt-2 mx-44">
                        <span class="text-green-400 loading loading-md loading-spinner "></span>
                    </div>
                    @if ($selected_patient)
                        <div class="mt-2 join">
                            <h4 class="font-bold text-black join-item"> Patient Name:&nbsp;
                            </h4>
                            <p class="text-green-600 underline join-item">
                                {{ $selected_patient->patient->get_patient_name() }}</p>
                        </div>

                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div class="">
                                <label for="noi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nature of
                                    Incident</label>
                                <input wire:model="nature_of_incident" type="text" id="noi"
                                    class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    placeholder="NOI" required>
                            </div>
                            <div class="">
                                <label for="poi"
                                    class="mb-2 text-sm font-medium text-gray-900 blo ck dark:text-white">Place of
                                    Incident</label>
                                <input wire:model="place_of_incident" type="text" id="poi"
                                    class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    placeholder="POI" required>
                            </div>
                            <div class="">
                                <label for="toi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Time of
                                    Incident</label>
                                <input wire:model="time_of_incident" type="time" id="toi"
                                    class="w-full text-sm text-gray-900 border rounded-md iblock bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    placeholder="NOI" required>
                            </div>
                            <div class="">
                                <label for="doi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white focus:border-green-700 focus:ring-green-700">Date
                                    of
                                    Incident</label>
                                <input wire:model="date_of_incident" type="date" id="doi"
                                    class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    placeholder="NOI" required>
                            </div>
                        </div>
                        <div class="modal-action">
                            <label class="btn btn- btn-sm" wire:click="reset_page" for="my_modal_5">Close!</label>
                            <label wire:click="save_significant" class="btn btn-success btn-sm">Save</label>
                        </div>
                    @else
                        <div class="modal-action">
                            <label class="btn btn-sm" wire:click="reset_page" for="my_modal_5">Close!</label>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Significant events -->


            <!-- Edit operation -->
            <input type="checkbox" id="editOperation" class="modal-toggle" />
            <div class="modal">
                <div class="modal-box">
                    <div wire:loading wire:target="editOperation" class="mt-3 mx-44">
                        <span class="text-green-400 loading loading-lg loading-spinner "></span>
                    </div>
                    @if ($selected_patient)
                        <h3 class="font-bold text-black text-md join">
                            Patient Name: &nbsp;
                            <p class="text-green-600 underline join-item">
                                {{ $selected_patient->patient->get_patient_name() }}
                            </p>
                        </h3>
                        <div class="">
                            <label for="operation"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                            <textarea type="text" wire:model="get_operation" id="operation "
                                class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                placeholder="OPERATION" required> </textarea>
                        </div>
                        <div class="modal-action">
                            <label for="editOperation" wire:click='reset_page' class="btn btn-sm">Close!</label>
                            <label for="editOperation" class="btn btn-sm btn-success"
                                wire:click='upadateOperation'>Update</label>
                        </div>
                    @endif
                    @if (is_null($selected_patient))
                        <div class="modal-action">
                            <label for="editOperation" wire:click='reset_page' class="btn btn-sm">Close!</label>
                        </div>
                    @endif

                </div>
            </div> {{-- Edit Operation --}}


            <!-- Edit significant incident -->
            <input type="checkbox" id="editSignificant" class="modal-toggle" />
            <div class="modal">
                <div class="modal-box">
                    <div wire:loading wire:target="editSignificantIncident" class="mt-3 mx-44">
                        <span class="text-green-400 loading loading-lg loading-spinner "></span>
                    </div>
                    @if ($selected_patient)
                        <div class="mt-2 join">
                            <h4 class="font-bold text-black join-item"> Patient Name:&nbsp;
                            </h4>
                            <p class="text-green-600 underline join-item">
                                {{ $selected_patient->patient->get_patient_name() }}</p>
                        </div>

                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div class="">
                                <label for="noi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nature of
                                    Incident</label>
                                <input wire:model="getNatureOfIncident" type="text" id="noi"
                                    class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    placeholder="NOI" required>
                            </div>
                            <div class="">
                                <label for="poi"
                                    class="mb-2 text-sm font-medium text-gray-900 blo ck dark:text-white">Place of
                                    Incident</label>
                                <input wire:model="getPlaceOfIncident" type="text" id="poi"
                                    class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    placeholder="POI" required>
                            </div>
                            <div class="">
                                <label for="toi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Time of
                                    Incident</label>
                                <input wire:model="getTimeOfIncident" type="time" id="toi"
                                    class="w-full text-sm text-gray-900 border rounded-md iblock bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    placeholder="NOI" required>
                            </div>
                            <div class="">
                                <label for="doi"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white focus:border-green-700 focus:ring-green-700">Date
                                    of
                                    Incident</label>
                                <input wire:model="getDateOfIncident" type="date" id="doi"
                                    class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    placeholder="NOI" required>
                            </div>
                        </div>
                        <div class="modal-action">
                            <label class="btn btn- btn-sm" wire:click="reset_page"
                                for="editSignificant">Close!</label>
                            <label wire:click="updateSignificantEvent" for="editSignificant"
                                class="btn btn-success btn-sm">Update</label>
                        </div>
                    @else
                        <div class="modal-action">
                            <label class="btn btn-sm" wire:click="reset_page" for="editSignificant">Close!</label>
                        </div>
                    @endif
                </div>
            </div>
            {{-- Edit incident --}}
            <input type="checkbox" id="editIncidentReport" class="modal-toggle" />
            <div class="modal">
                <div class="modal-box">
                    <div wire:loading wire:target="editIncident" class="mt-3 mx-44">
                        <span class="text-green-400 loading loading-lg loading-spinner "></span>
                    </div>
                    @if ($getIncidentDescription)
                        <div wire:loading.remove>
                            <h3 class="text-lg font-bold ">Edit Incident</h3>
                            <div class="py-2">
                                <label for="incident"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                                <textarea type="text" wire:model="getIncidentDescription" id="reason "
                                    class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                    required> </textarea>
                            </div>
                            <div class="modal-action">
                                <label for="editIncidentReport" class="btn btn-sm"
                                    wire:click="reset_page">Close!</label>
                                <label wire:click="updateIncident" for="editIncidentReport"
                                    class="btn btn-success btn-sm">Update</label>
                            </div>
                        </div>
                    @else
                        <div class="modal-action">
                            <label for="editIncidentReport" class="btn btn-sm" wire:click="reset_page">Close!</label>
                        </div>
                    @endif

                </div>
            </div> {{-- Edit incident --}}
        </div>
        <script>
            function deleteOperation(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#0f7d34",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteComfirmedOperation', id);
                    }
                });
            }

            function deleteSignificant(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#0f7d34",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteComfirmedSignificant', id);
                    }
                });
            }

            function deletetIncident(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#0f7d34",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteComfirmedIncident', id);
                    }
                });
            }
            window.addEventListener('try', function() {
                Swal.fire("Added");
            });

            window.addEventListener('pos', function(c) {
                Swal.fire({
                    html: `
                <div class="flex flex-col px-2 mb-6 space-y-4">
                    <input type="text" id="catMyId" wire:model='getMyId' placeholder="Enter Item Name" class="bg-gray-100 rounded-md">

                </div>`,
                    showCancelButton: true,
                    confirmButtonText: `Save`,
                    didOpen: () => {
                        const catMyId = Swal.getHtmlContainer().queyrSelector('#catMyId');

                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.set('catMyId', catMyId.value);
                        Livewire.emit('fetchData');
                    }
                });
            });

            function permission() {
                Swal.fire({
                    title: "You dont have permission",
                    text: "Only doctors have the permission to this fucntion!",
                    icon: "warning",
                    confirmButtonColor: "#0f7d34",
                });
            }
            window.addEventListener('neg', function() {
                Swal.fire("Added");
            });
        </script>
    </div>
