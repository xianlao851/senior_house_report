<x-slot name="header">
    <h3 class="text-lg font-normal leading-tight text-gray-800">
        DAILY REPORT OF THE SENIOR HOUSE OFFICER
        {{-- {{ date('F j, Y') }} --}}
    </h3>
</x-slot>
<div class="p-4 mt-4">
    {{-- @if ($errors->first())
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
    @endif --}}
    <div class="relative flex flex-col max-w-6xl p-3 mx-auto bg-white rounded">
        <div class="absolute right-0 top-8">
            <div class="grid grid-cols-2 join">
                @if ($cur_time >= 17 or $cur_time < 8)
                    @if ($getDiffHours >= 24)
                        {{-- @if ($cur_time >= 20 and $cur_time < 8) --}}
                        <div class="mt-1 ml-0 join-item">
                            <div class="join">
                                <span class="font-semibold join-item">New Record Date: &nbsp;</span>
                                <span
                                    class="font-semibold text-green-700 underline join-item">{{ \Carbon\Carbon::parse($currentDate)->format('M-j-Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="join-item">
                            <button class="ml-2 text-white bg-green-600 btn btn-sm hover:bg-gray-400"
                                wire:click="check_in_sho">Create Record</button>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div class="flex flex-col mt-2 justify-betweenfont-bold">

            <div class="join"><span class="font-bold uppercase join-item">Senior House Officer:</span>
                <span
                    class="px-2 font-semibold text-green-600 underline uppercase join-item">{{ $current_detail->employee->fullname() }}</span>
            </div>
            <div class="join"><span class="font-bold uppercase join-item">Report Date:</span>
                <span
                    class="px-2 font-semibold text-green-600 underline join-item">{{ \Carbon\Carbon::parse($current_detail->report_date)->format('M-j-Y') }}</span>
            </div>

        </div>

        @if ($cur_time >= 17 or $cur_time < 12)
            @if ($getDiffHours < 24)
                <div class="absolute top-0 flex gap-6 mt-2 right-3">
                    {{-- @if ($cur_time >= 20 and $cur_time <= 8) --}}
                    {{-- <div class="flex mb-3 space-x-3">
                        <div class="w-full max-w-xs form-control">
                            <label class="label">
                                <span class="ml-6 text-black label-text"> Medical Officer III /
                                    Specialist</span>
                            </label>
                            <div class="ml-[100px] indicator">
                                <label
                                    @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59) for="searchDoctor" @else onclick="permission()" @endif
                                    class="text-white bg-green-600 btn join-item btn-sm hover:bg-gray-400">Add
                                    Doctor</label>
                            </div>
                        </div>
                    </div> --}}
                    <div class="flex mb-3 space-x-3">
                        <div class="w-full max-w-xs form-control">
                            <label class="label">
                                <span class="text-black label-text">Transfer From </span>
                            </label>
                            <div class="indicator">
                                <label
                                    @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59) for="my_modal_6"
                                    @else onclick="permission()" @endif
                                    class="text-white bg-green-600 btn join-item btn-sm hover:bg-gray-400">ADD
                                    FROM</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex mb-3 space-x-3">
                        <div class="w-full max-w-xs form-control">
                            <label class="label">
                                <span class="text-black label-text">Transfer To </span>
                            </label>
                            <div class="indicator ">
                                <label
                                    @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59) for="my_modal_7" @else onclick="permission()" @endif
                                    class="text-white bg-green-600 btn join-item btn-sm hover:bg-gray-400">ADD
                                    TO</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <div class="flex flex-col">
            <span class="font-bold uppercase">Physician on Duty</span>
            <table class="table border table-fixed table-xs">
                <thead class="text-black bg-gray-200">
                    <tr class="text-center uppercase ">
                        <th class="border">Department</th>
                        <th class="border">Medical Officer III</th>
                        <th class="border">Medical Specialist</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr class="uppercase">
                            <td class="text-black border text-bold">{{ $department->department }}</td>
                            <td class="border">
                                @foreach ($department->checked_in_mo($current_detail->id)->get() as $checkin_mo)
                                    @if ($getDiffHours > 18)
                                        <label for=""
                                            class="">{{ 'Dr.' . $checkin_mo->employee->name() }}</label>
                                    @endif
                                    @if ($getDiffHours <= 18)
                                        <label for="" class="cursor-pointer hover:underline" title="Delete?"
                                            @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59) onclick='deleteCheckMo(`{{ $checkin_mo->id }}`)' @endif>{{ 'Dr.' . $checkin_mo->employee->name() }}</label>
                                    @endif
                                    @if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                                @if ($getDiffHours <= 18)
                                    @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                        <label wire:click="getDepartmenttId('{{ $department->department_id }}')"
                                            for="searchDoctorMo"><i
                                                class="bg-green-200 las la-plus la-lg btn btn-xs"></i></label>
                                    @endif
                                @endif
                            </td>

                            <td class="border">
                                @foreach ($department->checked_in_ms($current_detail->id)->get() as $checkin_ms)
                                    @if ($getDiffHours > 18)
                                        <label for="" class="">
                                            {{ 'Dr.' . $checkin_ms->employee->name() }}
                                        </label>
                                    @endif
                                    @if ($getDiffHours <= 18)
                                        <label for="" class="cursor-pointer hover:underline" title="Delete?"
                                            @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59) onclick='deleteCheckMs(`{{ $checkin_ms->id }}`)' @endif>
                                            {{ 'Dr.' . $checkin_ms->employee->name() }}
                                        </label>
                                    @endif
                                    @if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                                @if ($getDiffHours <= 18)
                                    @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                        <label wire:click="getDepartmenttId('{{ $department->department_id }}')"
                                            for="searchDoctorMs"><i
                                                class="bg-green-200 las la-plus la-lg btn btn-xs"></i></label>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <!-- end of doctors div -->

        <div class="flex flex-col py-3">
            <div class="">
                <span class="label">
                    <Label class="font-bold text-black uppercase label-text">TRANSFER FROM OTHER
                        FACILITIES</Label>
                </span>
                <div>
                </div>
            </div>

            <div class="flex flex-col border-x-2 @if ($transfers == null or $transfers == '') h-52 @else @endif border-y-2">
                <table class="table border table-fixed table-xs">
                    <thead class="text-black bg-gray-200">
                        <tr class="">
                            <th class="border">NAME / AGE / ADDRESS</th>
                            <th class="border">DIAGNOSIS</th>
                            <th class="border">TRANSFERING FACILITY</th>
                            <th class="border">REASON FOR TRANSFER</th>
                            <th class="w-[105px]">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($transfers)
                            @forelse ($transfers as $transfer)
                                <tr>
                                    <td class="border"> {{ $transfer->getpatient->get_patient_name() }} /
                                        {{ $var = (int) $transfer->getAge->patage }} /
                                        {{ $transfer->getpatient->getAddress->first()->province->provinceName() }},
                                        {{ $transfer->getpatient->getAddress->first()->city->cityName() }},
                                        Brgy.
                                        {{ $transfer->getpatient->getAddress->first()->barangay->barangayName() }}
                                        {{-- {{ $transfer->getpatient->fataddr }} --}}
                                    </td>
                                    <td class="border">{{ $transfer->diagnosis }}</td>
                                    <td class="border">{{ $transfer->facility }}</td>
                                    <td class="border">{{ $transfer->reason }}</td>
                                    <td class="border">
                                        <label class="btn btn-xs btn-secondary"
                                            @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                            title="Edit?"  wire:click="editTransferFrom('{{ $transfer->id }}','{{ $transfer->diagnosis }}','{{ $transfer->facility }}','{{ $transfer->reason }}','{{ $transfer->patient_id }}','{{ $transfer->sho_id }}')"
                                            for="editTransferFrom"
                                            @else
                                            onclick="permission()" @endif
                                            @endif><i class="las la-edit la-lg"></i></label>
                                        <label for="" class="btn btn-xs btn-warning"
                                            @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                            title="Delete?" onclick="deleteTransferFrom({{ $transfer->id }})"
                                            @else
                                            onclick="permission()" @endif
                                            @endif><i class="las la-trash la-lg"></i></label>

                                    </td>

                                </tr>
                                @empty
                                    <tr>
                                        <td class="h-52"></td>
                                    </tr>
                                @endforelse
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    @if ($transfers)
                        {{ $transfers->links() }}
                    @endif

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
                            <thead class="text-black bg-gray-200">
                                <tr class="">
                                    <th class="border">NAME / AGE /
                                        ADDRESS</th>
                                    <th class="border">DIAGNOSIS</th>
                                    <th class="border">TRANSFERING FACILITY</th>
                                    <th class="border">REASON FOR TRANSFER</th>
                                    <th class="w-[105px]">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($trasnsferTos)
                                    @forelse ($trasnsferTos as $to)
                                        <tr>
                                            <td class="border"> {{ $to->getpatient->get_patient_name() }} /
                                                {{ $var = (int) $to->getAge->patage }} /
                                                {{ $to->getpatient->getAddress->first()->province->provinceName() }},
                                                {{ $to->getpatient->getAddress->first()->city->cityName() }},
                                                Brgy.
                                                {{ $to->getpatient->getAddress->first()->barangay->barangayName() }}

                                                {{ $to->getpatient->fataddr }}
                                            </td>
                                            <td class="border">{{ $to->diagnosis }}</td>
                                            <td class="border">{{ $to->facility }}</td>
                                            <td class="border">{{ $to->reason }}</td>
                                            <td class="border">
                                                <label class="btn btn-xs btn-secondary"
                                                    @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                                for="editTransferTo" wire:click="editTransferTo('{{ $to->id }}','{{ $to->diagnosis }}','{{ $to->facility }}','{{ $to->reason }}','{{ $to->patient_id }}','{{ $to->sho_id }}')"
                                                @else
                                                onclick="permission()" @endif
                                                    @endif><i class="las la-edit la-lg"></i></label>
                                                <label for="" class="btn btn-xs btn-warning"
                                                    @if ($getDiffHours <= 18) @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59)
                                                onclick="deleteTransferTo({{ $to->id }})"
                                                @else onclick="permission()" @endif
                                                    @endif><i class="las la-trash la-lg"></i></label>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td class="h-52"></td>
                                            </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div>
                    @if ($trasnsferTos)
                        {{ $trasnsferTos->links() }}
                    @endif
                </div> <!-- end of transfer from and to -->
                <!-- For modals start-->

                <input type="checkbox" id="my_modal_6" class="modal-toggle" /> <!-- for transfer from-->
                <div class="modal">
                    <div class="flex flex-col max-w-xl modal-box ">
                        <div class="">
                            <div class="w-full p-2"> <!-- For searching patient info, for adding transfer from-->
                                <div class="w-full join">
                                    <div class="">
                                        <input
                                            class="input input-bordered join-item w-[450px] focus:border-green-700 focus:ring-green-700"
                                            type="text" wire:model.lazy="search_patient" placeholder="Search" />
                                    </div>
                                    <div class="indicator">
                                        <button class="w-20 text-white bg-green-700 btn join-item">Search</button>
                                        {{-- wire:click='searchpatient'>Search</button> --}}
                                    </div>
                                </div>
                                <div wire:loading wire:target="search_patient" class="mt-3 mx-44">
                                    <span class="text-green-400 loading loading-md loading-spinner "></span>
                                </div>
                                <!-- Displays list of the searched patients-->
                                <div class="mt-2 text-black font-extralight" wire:loading.remove>
                                    <ul class="">
                                        {{-- wire:click="get_patientIdFrom({{ $patient->hpercode }})" --}}
                                        @if ($getPatients)
                                            @forelse ($getPatients as $pat)
                                                <li class="w-full mt-2 rounded-sm shadow-lg cursor-pointer hover:bg-gray-300 bg-slate-200"
                                                    wire:click="get_patientIdFrom({{ $pat->hpercode }})">
                                                    {{ $pat->patlast }}, {{ $pat->patfirst }}
                                                    @if ($pat->patmiddle != null or $pat->patmiddle == '')
                                                        {{ $pat->patmiddle }},
                                                    @endif
                                                    {{-- {{ $pat->erdate }} --}}
                                                </li>
                                            @empty
                                                <div class="mx-1">No records!</div>
                                            @endforelse
                                        @else
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="get_patientIdFrom" class="mt-2 mx-44">
                            <span class="text-green-400 loading loading-md loading-spinner "></span>
                        </div>
                        <div class="mt-2 ">
                            @if ($selected_patient)
                                <div class="join">
                                    <h3 class="font-bold text-black text-md join-item">
                                        Patient Name: &nbsp;
                                    </h3>
                                    <p class="text-green-600 underline join-item">
                                        {{ $selected_patient->patient->get_patient_name() }}</p>
                                </div>
                                <div class="py-2">

                                    <label for="diagnosis"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnosis</label>
                                    <textarea type="text" wire:model="diagnosis" id="diagnosis "
                                        class="block w-full text-sm text-gray-900 border rounded-md focus:border-green-700 focus:ring-green-700 bg-gray-50"
                                        required> </textarea>
                                </div>
                                <div class="py-2">
                                    <label for="reason"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason
                                        @error('reason')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </label>

                                    <textarea type="text" wire:model="reason" id="reason "
                                        class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                        placeholder="Reason" required> </textarea>
                                </div>
                                <div class="py-2">
                                    <label for="facility"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transfering
                                        Facility @error('facility')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </label>

                                    <input wire:model="facility" id="facility" required
                                        class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                        placeholder="Transfering Facility">
                                    </input>
                                </div>
                                <div class="modal-action">
                                    <label class="btn btn-sm btn-success" wire:click="saveShoTransferFrom">
                                        SAVE</label>
                                    <label for="my_modal_6" wire:click="reset_patient_from_to_id"
                                        class="btn btn-sm btn-danger">Close!</label>
                                </div>
                            @else
                                <div class="">
                                    <div class="modal-action">
                                        <label for="my_modal_6" wire:click="reset_patient_from_to_id"
                                            class="btn btn-sm btn-danger">Close!</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div> <!-- for transfer from end-->


                <input type="checkbox" id="my_modal_7" class="modal-toggle" /> <!-- adding transfer to -->
                <div class="modal">
                    <div class="flex flex-col max-w-xl modal-box">
                        <div class="">
                            <div class="w-full p-2"> <!-- For searching patient info, for adding transfer from-->
                                <div class="w-full join">
                                    <div class="">
                                        <input
                                            class="input input-bordered join-item w-[450px] focus:border-green-700 focus:ring-green-700"
                                            type="text" wire:model.lazy="search_patient" placeholder="Search" />
                                    </div>
                                    <div class="indicator">
                                        <button class="w-20 text-white bg-green-700 btn join-item">Search </button>
                                        {{-- wire:click='searchpatient'>Search</button> --}}
                                    </div>
                                </div>
                                <div wire:loading wire:target="search_patient" class="mt-3 mx-44">
                                    <span class="text-green-400 loading loading-md loading-spinner "></span>
                                </div>
                                <!-- Displays list of the searched patients-->
                                <div class="mt-2 text-black font-extralight" wire:loading.remove>
                                    <ul class="">
                                        {{-- wire:click="get_patientIdFrom({{ $patient->hpercode }})" --}}
                                        @if ($getPatients)
                                            @forelse ($getPatients as $pat)
                                                <li class="w-full mt-2 rounded-sm shadow-lg cursor-pointer hover:bg-gray-300 bg-slate-200"
                                                    wire:click="get_patientIdTo({{ $pat->hpercode }})">
                                                    {{ $pat->patlast }}, {{ $pat->patfirst }}
                                                    @if ($pat->patmiddle != null or $pat->patmiddle == '')
                                                        {{ $pat->patmiddle }}
                                                    @endif
                                                </li>
                                            @empty
                                                <div class="mx-1">No records!</div>
                                            @endforelse
                                        @else
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div wire:loading wire:target="get_patientIdTo" class="mt-2 mx-44">
                            <span class="text-green-400 loading loading-md loading-spinner "></span>
                        </div>
                        <div class="mt-2">
                            @if ($selected_patient)
                                <div class="join">
                                    <h3 class="font-bold text-black text-md join-item">
                                        Patient Name: &nbsp;

                                    </h3>
                                    <p class="text-green-600 underline join-item">
                                        {{ $selected_patient->patient->get_patient_name() }}</p>
                                </div>

                                <div class="py-2">
                                    <label for="diagnosis"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnosis</label>
                                    <textarea type="text" wire:model="diagnosis" id="diagnosis "
                                        class="block w-full text-sm text-gray-900 border rounded-md focus:border-green-700 focus:ring-green-700 bg-gray-50"
                                        placeholder="Diagnosis" required> </textarea>
                                </div>
                                <div class="py-2">
                                    <label for="reason"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason
                                        @error('reason')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <textarea type="text" wire:model="reason" id="reason "
                                        class="block w-full text-sm text-gray-900 border rounded-md focus:border-green-700 focus:ring-green-700 bg-gray-50"
                                        placeholder="Reason" required> </textarea>
                                </div>
                                <div class="py-2">
                                    <label for="facility"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transfering
                                        Facility @error('facility')
                                            <span class="text-red-500 error">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input wire:model="facility" id="facility" required
                                        class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700">
                                    </input>
                                </div>
                                <div class="modal-action">
                                    <label class="btn btn-sm btn-success" wire:click="saveShoTransferTo"> ADD</label>
                                    <label for="my_modal_7" wire:click="reset_patient_from_to_id"
                                        class="btn btn-sm btn-danger">Close!</label>
                                </div>
                            @else
                                <div class="">
                                    <div class="modal-action">
                                        <label for="my_modal_7" wire:click="reset_patient_from_to_id"
                                            class="btn btn-sm btn-danger">Close!</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div> <!-- adding transfer to end-->

                <input type="checkbox" id="searchDoctorMo" class="modal-toggle" /> <!-- search doctor MO-->
                <div class="modal ">
                    <div class="max-w-xl modal-box">
                        <h3 class="text-lg font-bold"></h3>
                        <p class="py-4"></p>
                        <div class="join">
                            <div>
                                <input
                                    class="input input-bordered join-item w-[450px] focus:border-green-700 focus:ring-green-700"
                                    type="search" wire:model.lazy='search_doctor' placeholder="Search" />
                            </div>
                            <div class="indicator">
                                <button class="text-white bg-green-700 btn join-item">Search</button>
                            </div>
                        </div>
                        <div wire:loading wire:target="search_doctor" class="mt-4 mx-44">
                            <span class="text-green-400 loading loading-md loading-spinner "></span>
                        </div>
                        <div class="mt-2 text-black font-extralight" wire:loading.remove>
                            <ul class="">
                                @if ($doctors)
                                    @forelse ($doctors as $doctor)
                                        <li class="w-full mt-2 rounded-sm shadow-lg cursor-pointer hover:bg-gray-300 bg-slate-200"
                                            wire:click='check_in_mo({{ $doctor->emp_id }})' for="searchDoctorMo">
                                            {{ $doctor->fullname() }}
                                        </li>
                                    @empty
                                        <div class="mx-1">No records!</div>
                                    @endforelse
                                @else
                            </ul>
                            @endif
                            </ul>
                            {{-- <div>
                                @if ($doctors != null)
                                    {{ $doctors->links() }}
                                @endif
                            </div> --}}
                        </div>
                        <div class="modal-action">
                            <label for="searchDoctorMo"wire:click="reset_patient_from_to_id" class="btn btn-sm">Close!</label>
                        </div>
                    </div>
                </div><!-- Modal for search doctor MO-->

                <input type="checkbox" id="searchDoctorMs" class="modal-toggle" /> <!-- search doctor MS-->
                <div class="modal ">
                    <div class="max-w-xl modal-box">
                        <h3 class="text-lg font-bold"></h3>
                        <p class="py-4"></p>
                        <div class="join">
                            <div>
                                <input
                                    class="input input-bordered join-item w-[450px] focus:border-green-700 focus:ring-green-700"
                                    type="search" wire:model.lazy='search_doctor' placeholder="Search" />
                            </div>
                            <div class="indicator">
                                <button class="text-white bg-green-700 btn join-item">Search</button>
                            </div>
                        </div>
                        <div wire:loading wire:target="search_doctor" class="mt-4 mx-44">
                            <span class="text-green-400 loading loading-md loading-spinner "></span>
                        </div>
                        <div class="mt-2 text-black font-extralight" wire:loading.remove>
                            <ul class="">
                                @if ($doctors)
                                    @forelse ($doctors as $doctor)
                                        <li class="w-full mt-2 rounded-sm shadow-lg cursor-pointer hover:bg-gray-300 bg-slate-200"
                                            wire:click='check_in_ms({{ $doctor->emp_id }})' for="searchDoctorMs">
                                            {{ $doctor->fullname() }}
                                        </li>
                                    @empty
                                        <div class="mx-1">No records!</div>
                                    @endforelse
                                @else
                            </ul>
                            @endif
                            </ul>
                            {{-- <div>
                                @if ($doctors != null)
                                    {{ $doctors->links() }}
                                @endif
                            </div> --}}
                        </div>
                        <div class="modal-action">
                            <label for="searchDoctorMs"wire:click="reset_patient_from_to_id" class="btn btn-sm">Close!</label>
                        </div>
                    </div>
                </div> <!-- For searchDoctorMs -->

                <input type="checkbox" id="editTransferFrom" class="modal-toggle" /> <!-- Edit for transfer from -->
                <div class="modal">
                    <div class="modal-box">
                        <div wire:loading wire:target="editTransferFromBack" class="mt-2 mx-44">
                            <span class="text-green-400 loading loading-lg loading-spinner "></span>
                        </div>
                        @if ($selected_patient)
                            <div>
                                <div class="join">
                                    <h3 class="font-bold text-black text-md join-item">
                                        Patient Name: &nbsp;
                                    </h3>
                                    <p class="text-green-600 underline join-item">
                                        {{ $selected_patient->patient->get_patient_name() }}</p>
                                </div>
                                <div class="py-2">

                                    <label for="diagnosis"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnosis</label>
                                    <textarea type="text" wire:model="getDiagnosis" id="diagnosis "
                                        class="block w-full text-sm text-gray-900 border rounded-md focus:border-green-700 focus:ring-green-700 bg-gray-50"
                                        required readonly> </textarea>
                                </div>
                                <div class="py-2">
                                    <label for="reason"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason</label>
                                    <textarea type="text" wire:model="getReason" id="reason "
                                        class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                        placeholder="Reason" required> </textarea>
                                </div>
                                <div class="py-2">
                                    <label for="facility"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transfering
                                        Facility</label>
                                    <input wire:model="getFacility" id="facility" required
                                        class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                        placeholder="Transfering Facility">
                                    </input>
                                </div>
                                <div class="modal-action">
                                    <label for="editTransferFrom" wire:click='refresh'
                                        class="btn btn-sm btn-danger">Close!</label>
                                    <label for="editTransferFrom" class="btn btn-sm btn-success"
                                        wire:click='updateTranssferFrom'>Update</label>

                                </div>
                            </div>
                        @else
                            <div class="modal-action">
                                <label for="editTransferFrom" wire:click='refresh'
                                    class="btn btn-sm btn-danger">Close!</label>
                            </div>
                        @endif

                    </div>
                </div> <!-- Edit for transfer from end -->

                <input type="checkbox" id="editTransferTo" class="modal-toggle" /> <!-- Edit for transfer to -->
                <div class="modal">
                    <div class="modal-box">
                        <div wire:loading wire:target="editTransferTo" class="mt-2 mx-44">
                            <span class="text-green-400 loading loading-lg loading-spinner "></span>
                        </div>
                        @if ($selected_patient)
                            <div>
                                <div class="join">
                                    <h3 class="font-bold text-black text-md join-item">
                                        Patient Name: &nbsp;
                                    </h3>
                                    <p class="text-green-600 underline join-item">
                                        {{ $selected_patient->patient->get_patient_name() }}</p>
                                </div>
                                <div class="py-2">

                                    <label for="diagnosis"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnosis</label>
                                    <textarea type="text" wire:model="getDiagnosis" id="diagnosis "
                                        class="block w-full text-sm text-gray-900 border rounded-md focus:border-green-700 focus:ring-green-700 bg-gray-50"
                                        required readonly> </textarea>
                                </div>
                                <div class="py-2">
                                    <label for="reason"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reason</label>
                                    <textarea type="text" wire:model="getReason" id="reason "
                                        class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                        placeholder="Reason" required> </textarea>
                                </div>
                                <div class="py-2">
                                    <label for="facility"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transfering
                                        Facility</label>
                                    <input wire:model="getFacility" id="facility" required
                                        class="block w-full text-sm text-gray-900 border rounded-md bg-gray-50 focus:border-green-700 focus:ring-green-700"
                                        placeholder="Transfering Facility">
                                    </input>
                                </div>
                                <div class="modal-action">
                                    <label for="editTransferTo" wire:click='refresh'
                                        class="btn btn-sm btn-danger">Close!</label>
                                    <label class="btn btn-sm btn-success" wire:click.lazy='updateTranssferTo'
                                        for="editTransferTo">Save</label>

                                </div>
                            </div>
                        @else
                            <div class="modal-action">
                                <label for="editTransferTo" wire:click='refresh' class="btn btn-sm btn-danger">Close!</label>
                            </div>
                        @endif
                    </div>
                </div> <!-- Edit for transfer to end-->
                <!-- For modals end-->
            </div> <!-- end of second div bg white -->
            <script>
                function deleteCheckMo(id) {
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
                            Livewire.emit('deleteComfirmedMo', id);
                        }
                    });
                }

                function deleteCheckMs(id) {
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
                            Livewire.emit('deleteComfirmedMs', id);
                        }
                    });
                }

                function deleteTransferFrom(id) {
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
                            Livewire.emit('deleteComfirmedTransferFrom', id);
                        }
                    });
                }

                function deleteTransferTo(id) {
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
                            Livewire.emit('deleteComfirmedTransferTo', id);
                        }
                    });
                }

                function permission() {
                    Swal.fire({
                        title: "You dont have permission!",
                        text: "Only doctors have the permission to this fucntion!",
                        icon: "warning",
                        confirmButtonColor: "#0f7d34",
                    });
                }
            </script>
        </div>
