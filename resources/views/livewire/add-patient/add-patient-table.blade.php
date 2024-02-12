<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-500">
        Add Patient
    </h2>
</x-slot>
<div class="flex flex-col mx-auto mt-12 max-w-7xl">
    @if ($errors->first())
        <div class="mx-auto mb-2 max-w-7xl">
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

    <div class="p-6 bg-white "> {{-- main content begin --}}
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                    name</label>
                <input wire:model="first_name" type="text"
                    id="first_name"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
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
                <label for="age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                <input type="text" wire:model="age" id="age"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Age" required readonly>
            </div>
            <div>
                <label for="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                    Province</label>
                <select wire:model="province_id" id="province"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option> Select Province</option>
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
                        <option> Select Municipality</option>
                        @forelse ($municipalities as $mun)
                            <option value="{{ $mun->municipality_id }}"> {{ $mun->municipality_name }} </option>
                        @empty
                            <span> No Data </span>
                        @endforelse
                    </select>
                </div>
            @endif
            @if ($barangays)
                <div>
                    <label for="barangay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        Barangay</label>
                    <select wire:model="barangay_id" id="barangay"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">>
                        <option> Select Barangay</option>
                        @forelse ($barangays as $barangay)
                            <option value="{{ $barangay->barangay_id }}"> {{ $barangay->barangay_name }} </option>
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
                <label for="birth_place" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birth
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
                <label for="emp_stat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Empployment
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
                <select wire:model="nationality_id" id="Nationality"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">>
                    <option value="608">Philippine, Pilipino</option>
                    @if ($nationalities)
                        @forelse ($nationalities as $nationality)
                            <option value="{{ $nationality->nationality_id }}"> {{ $nationality->nationality }}
                            </option>
                        @empty
                            <span> No Data </span>
                        @endforelse
                    @endif

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
            <label wire:click="save()" class="btn btn-success btn-sm">Submit</label>
        </div>


    </div>

</div>
</div>{{--  --}}
