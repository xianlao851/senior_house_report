<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-black">
        PATIENT LIST
    </h2>
</x-slot>
<div class="flex flex-col max-w-6xl mx-auto mt-8 ">
    <div class="w-full p-2 bg-white rounded-md">
        <div class="flex justify-end mb-3 space-x-2 space-y-2">
            <div class="join">
                <div>
                    <div>
                        <input class="input input-bordered join-item focus:border-green-700 focus:ring-green-700"
                            placeholder="Search" wire:model.lazy="search_patient" />
                    </div>
                </div>
                <select class=" select select-bordered join-item focus:border-green-700 focus:ring-green-700"
                    wire:model="get_option">
                    <option>Filter</option>
                    <option value="id">Patient ID</option>
                    <option value="first_name">First Name</option>
                    <option value="last_name">Last Name</option>
                </select>
                <div class="indicator">
                    {{-- <span class="indicator-item badge badge-secondary"></span> --}}
                    <button class="text-white bg-green-600 btn join-item">Search</button>
                </div>
            </div>
        </div>
        <div class="">
            <table class="table border rounded table-zebra">
                <thead class="text-md">
                    <tr class="uppercase">
                        <th>PATIENT ID</th>
                        <th>PATIENT NAME</th>
                        <th>ADDRESS</th>
                        <th class="col-span-2"> ACTION</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr class="hover">
                            <td class="text-base">Patient ID: {{ $patient->id }} </td>
                            <td class="text-base"> {{ $patient->get_patient_name() }}</td>
                            <td class="text-base">
                                {{ $patient->address->province->province_name }},
                                {{ $patient->address->municipality->municipality_name }}, Barangay
                                {{ $patient->address->barangay->barangay_name }}
                            </td>
                            <td class="text-base"> <label wire:click="get_patient({{ $patient->id }})" for="my_modal_6"
                                    class="text-black btn btn-xs btn-warning hover hover:bg-green-100"> EDIT</label>
                            </td>
                            <td class="text-base">
                                <label wire:click="view_patient({{ $patient->id }})" for="view_patient"
                                    class="btn btn-xs">View</label>
                            </td>
                            {{-- <td > <a href="{{ route('viewshoreports', ['id'=>$shodetail->id]) }}"> Doctors</a> </td>
                    <td > <a href="{{ route('viewPatient', ['id'=>$shodetail->id]) }}"> Patients</a> </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="px-8 mt-2 ">{{ $patients->links() }}</div>

    <!-- The button to open modal -->
    <!-- Put this part before </body> tag -->

    <!-- Edit patient info-->
    <input type="checkbox" id="my_modal_6" class="modal-toggle" />
    <div class="modal">
        <div class="max-w-7xl modal-box ">
            <h3 class="text-lg font-bold">Edit Patient Information</h3>
            <p class="py-4"></p>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                        name</label>
                    <input wire:model="first_name" type="text" id="first_name" value=""
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="First Name" required>
                </div>
                <div>
                    <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle
                        Name</label>
                    <input wire:model="middle_name" type="text"
                        id="last_name"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Middle Name" required>
                </div>
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                        Name</label>
                    <input type="text" wire:model="last_name" id="last_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Last Name" required>
                </div>
                <div>
                    <label for="Suffix"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Suffix</label>
                    <input type="text" wire:model="suffix"
                        id="Suffix"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Suffix" required>
                </div>
                <div>
                    <label for="Preffix"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preffix</label>
                    <input type="text" wire:model="preffix" id="Preffix"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Preffix" required>
                </div>
                <div>
                    <label for="Allias"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Allias</label>
                    <input type="text" wire:model="alias" id="Allias"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Allias" required>
                </div>
                <div>
                    <label for="Birt_Date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birth
                        Date</label>
                    <input type="date" wire:model="birth_date" id="Date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Birth Date" required>
                </div>
                <div>
                    <label for="age"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                    <input type="text" wire:model="age" id="age"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Age" required readonly>
                </div>
                <div>
                    <label for="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        Province</label>
                    <select wire:model="province_id" id="province"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="getprovince"> </option>
                        @forelse ($provinces as $province)
                            <option value="{{ $province->province_id }}"> {{ $province->province_name }} </option>
                        @empty
                            <span> No Data </span>
                        @endforelse
                    </select>
                </div>
                @if ($municipalities)
                    <div>
                        <label for="municipality"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                            Municipality</label>
                        <select wire:model="municipality_id" id="municipality"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=""> </option>
                            @forelse ($municipalities as $mun)
                                <option value="{{ $mun->municipality_id }}"> {{ $mun->municipality_name }}
                                </option>
                            @empty
                                <span> No Data </span>
                            @endforelse
                        </select>
                    </div>
                @endif
                @if ($barangays)
                    <div>
                        <label for="barangay"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                            Barangay</label>
                        <select wire:model="barangay_id" id="barangay"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">>
                            <option> Select Barangay</option>
                            @forelse ($barangays as $barangay)
                                <option value="{{ $barangay->barangay_id }}"> {{ $barangay->barangay_name }}
                                </option>
                            @empty
                                <span> No Data </span>
                            @endforelse
                        </select>
                    </div>
                @endif
                <div>
                    <label for="Contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact
                        Number</label>
                    <input type="text" wire:model="contact_no" id="Contact"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Contact Number" required>
                </div>
                <div>
                    <label for="birth_place"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birth
                        Place</label>
                    <input type="text" wire:model='birth_place' id="birth_place"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Birth Place" required>
                </div>
                <div>
                    <label for="gender"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                    <select wire:model="gender" id="gender"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <label for="civil_stat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Civil
                        Status</label>
                    <select wire:model="civil_stat" id="civil_stat"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="">Select Civil Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                    </select>
                </div>
                <div>
                    <label for="emp_stat"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employment
                        Status</label>
                    <select wire:model="emp_stat" id="emp_stat"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="">Employed or Not</option>
                        <option value="Employed">Employed</option>
                        <option value="Unemployed">Unemployed</option>
                    </select>
                </div>
                <div>
                    <label for="ethnicity"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ethnicity</label>
                    <input type="text" wire:model="ethnicity" id="ethnicity "
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Ethnicity" required>
                </div>
                <div>
                    <label for="Nationality"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nationality</label>
                    <select wire:model="nationality" id="Nationality"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">>
                        <option> Select Nationality</option>
                        @forelse ($nationalities as $nationality)
                            <option value="{{ $nationality->nationality }}"> {{ $nationality->nationality }}
                            </option>
                        @empty
                            <span> No Data </span>
                        @endforelse
                    </select>
                </div>
                <div>
                    <label for="Religion"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Religion</label>
                    <input type="text" wire:model="religion" id="Religion "
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Religion" required>
                </div>
                <div>
                    <label for="blood_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Blood
                        Type</label>
                    <input type="text" wire:model="blood_type" id="blood_type "
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Blood Type" required>
                </div>
            </div>
            <div class="modal-action">
                <label class="btn btn-success btn-sm" wire:click="update">Update!</label>
                <label for="my_modal_6" wire:click="clear" class="btn btn-danger btn-sm">Close!</label>
            </div>
        </div>
    </div>

    <!-- View patient info modal-->
    <div class="">
        <input type="checkbox" id="view_patient" class="modal-toggle" />
        <div class="modal">
            <div class="max-w-3xl bg-white modal-box">
                @if ($getPatientInfo)
                    <div class="">
                        <h1 class="font-sans text-2xl font-extrabold text-black">
                            {{ $getPatientInfo->get_patient_name() }}
                        </h1>
                    </div>
                    <div class="grid grid-cols-2 mt-2">
                        <div class="join join-vertical lg:join-horizontal">
                            <p class="font-bold text-black join-item">Patient ID:</p>
                            <p class="px-2 text-green-600 join-item">{{ $getPatientInfo->id }}</p>
                        </div>
                        <div class="join join-vertical lg:join-horizontal">
                            <p class="font-bold text-black join-item">Date / Time :</p>
                            <p class="px-2 text-green-600 join-item">{{ $getPatientInfo->created_at }}</p>
                        </div>
                    </div>

                    <div class="w-full mt-2 join join-vertical">
                        <div class="w-20 px-2 text-sm text-white bg-green-700 join-item">Address</div>
                        <div class="h-10 border-2 join-item w-90 ">
                            <p class="mt-2 ml-2 font-bold text-black text-md">
                                {{ $getPatientInfo->address->province->province_name }}
                                {{ $getPatientInfo->address->municipality->municipality_name }}
                                {{ $getPatientInfo->address->barangay->barangay_name }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 mt-2">
                        <div class="w-full join join-vertical">
                            <div class="w-24 px-2 text-sm text-white bg-green-700 join-item">Birth Date</div>
                            <div class="w-64 h-10 border-2 join-item">
                                <p class="mt-2 ml-2 font-bold text-black text-md">
                                    {{ \Carbon\Carbon::parse($getPatientInfo->birth_date)->format('F-j-Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="w-full join join-vertical">
                            <div class="px-2 text-sm text-white bg-green-700 join-item w-28">Place of Birth</div>
                            <div class="w-64 h-10 border-2 join-item">
                                <p class="mt-2 ml-2 font-bold text-black text-md">{{ $getPatientInfo->birth_place }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 mt-2">
                        <div class="w-full join join-vertical">
                            <div class="join-item bg-green-700 w-[70px] text-white px-2 text-sm"> Age</div>
                            <div class="w-64 h-10 border-2 join-item">
                                <p class="mt-2 ml-2 font-bold text-black text-md">{{ $getPatientInfo->age }} </p>
                            </div>
                        </div>
                        <div class="w-full join join-vertical">
                            <div class="w-24 px-2 text-sm text-white bg-green-700 join-item"> Nationality</div>
                            <div class="w-64 h-10 border-2 join-item">
                                <p class="mt-2 ml-2 font-bold text-black text-md">
                                    {{ $getPatientInfo->nationalities->nationalityName() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 mt-3">
                        <div class="w-full join join-vertical">
                            <div class="join-item bg-green-700 w-[70px] text-white px-2 text-sm"> Gender</div>
                            <div class="w-40 h-10 border-2 join-item">
                                <p class="mt-2 ml-2 font-bold text-black text-md">{{ $getPatientInfo->gender }} </p>
                            </div>
                        </div>

                        <div class="w-full join join-vertical">
                            <div class="join-item bg-green-700 w-[70px] text-white px-2 text-sm"> Status</div>
                            <div class="w-40 h-10 border-2 join-item">
                                <p class="mt-2 ml-2 font-bold text-black text-md">{{ $getPatientInfo->civil_stat }}
                                </p>
                            </div>
                        </div>
                        <div class="w-full join join-vertical">
                            <div class="w-24 px-2 text-sm text-white bg-green-700 join-item"> Contact No</div>
                            <div class="w-40 h-10 border-2 join-item">
                                <p class="mt-2 ml-2 font-bold text-black text-md">{{ $getPatientInfo->contact_no }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 mt-2">
                        <div class="w-full join join-vertical">
                            <div class="w-24 px-2 text-sm text-white bg-green-700 join-item"> Blood Type</div>
                            <div class="w-40 h-10 border-2 join-item">
                                <p class="mt-2 ml-2 font-bold text-black text-md">{{ $getPatientInfo->blood_type }}
                                </p>
                            </div>
                        </div>

                        <div class="w-full join join-vertical">
                            <div class="w-24 px-2 text-sm text-white bg-green-700 join-item"> Ethnicity</div>
                            <div class="w-40 h-10 border-2 join-item">
                                @if ($getPatientInfo->ethnicity)
                                    <p class="mt-2 ml-2 font-bold text-black text-md">{{ $getPatientInfo->ethnicity }}
                                    </p>
                                @else
                                    <p class="mt-2 ml-2 font-bold text-black text-md">None </p>
                                @endif

                            </div>
                        </div>
                        <div class="w-full join join-vertical">
                            <div class="w-24 px-2 text-sm text-white bg-green-700 join-item"> Religion</div>
                            <div class="w-40 h-10 border-2 join-item">
                                @if ($getPatientInfo->religion)
                                    <p class="mt-2 ml-2 font-bold text-black text-md">{{ $getPatientInfo->religion }}
                                    </p>
                                @else
                                    <p class="mt-2 ml-2 font-bold text-black text-md">None </p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="w-full join join-vertical">
                            <div class="w-full px-2 text-sm text-white bg-green-700 join-item">
                                Operations Done
                            </div>
                            <div class="p-2 border-2 join-item">
                                @if (!$getPatientOperations->isEmpty())
                                    <div class="grid grid-cols-2 px-1">
                                        @foreach ($getPatientOperations as $getPatientOperation)
                                            <div>
                                                <p class="text-black">
                                                    {{ $count++ }}:)
                                                    &nbsp;{{ $getPatientOperation->getDepartment->department }}</p>
                                            </div>
                                            <div>
                                                <p class="text-black">
                                                    {{ $getPatientOperation->operation_done }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-black join-item">
                                        No record
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-2">
                        <div class="w-full join join-vertical ">
                            <div class="w-full px-2 text-sm text-white bg-green-700 join-item">Transfered From</div>
                            <div class="border-2 join-item">
                                @if ($getTransferFrom)
                                    <div>
                                        <div class="join">
                                            <p class="font-bold text-black join-item">Hospital name:
                                            </p>
                                            <p class="px-1 text-black join-item">
                                                &nbsp;{{ $getTransferFrom->hospital->hospital_name }}</p>
                                        </div>
                                        <div class="join">
                                            <p class="font-bold text-black join-item">Diagnosis:</p>
                                            <p class="px-1 text-black join-item">{{ $getTransferFrom->diagnosis }}</p>
                                        </div>
                                        <div class="join">
                                            <p class="font-bold text-black join-item">Reason for transfer:
                                            </p>
                                            <p class="px-1 text-black join-item">{{ $getTransferFrom->reason }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if (is_null($getTransferFrom))
                                <div>
                                    <p class="text-black join-item">No Record</p>
                                </div>
                            @endif
                        </div>

                        <div class="w-full join join-vertical ">
                            <div class="w-full px-2 text-sm text-white bg-green-700 join-item">Transfered To</div>
                            <div class="border-2 join-item">
                                @if ($getTransferTo)
                                    <div>
                                        <div class="join">
                                            <p class="font-bold text-black join-item">Hospital name:
                                            </p>
                                            <p class="px-1 text-black join-item">
                                                &nbsp;{{ $getTransferTo->hospital->hospital_name }}</p>
                                        </div>
                                        <div class="join">
                                            <p class="font-bold text-black join-item">Diagnosis:</p>
                                            <p class="px-1 text-black join-item">{{ $getTransferTo->diagnosis }}</p>
                                        </div>
                                        <div class="join">
                                            <p class="font-bold text-black join-item">Reason for transfer:
                                            </p>
                                            <p class="px-1 text-black join-item">{{ $getTransferTo->reason }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if (is_null($getTransferTo))
                                <div class="text-black join-item">
                                    <p>No Record</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="modal-action">
                    <label for="view_patient" wire:click="close" class="btn btn-xs btn-warning">Close!</label>
                </div>
            </div>
        </div>
    </div>
</div>
