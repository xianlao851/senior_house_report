<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Employee List') }}
    </h2>
</x-slot>

<div class="w-full p-8 mx-auto max-w-7xl">
    <div class="flex flex-col h-screen p-3 bg-white rounded">
        <div class="flex justify-end mb-3 space-x-2">
            <div class="join">
                <div>
                    <div>
                        <input class="input input-bordered join-item" placeholder="Search..." wire:model.lazy="search" />
                    </div>
                </div>
                <div class="indicator">
                    <button class="btn join-item">Search</button>
                </div>
            </div>
        </div>
        <table class="table border rounded table-zebra">
            <thead>
                <tr class="uppercase">
                    <th>Emp ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Designation</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $emp)
                    <tr class="hover">
                        <td>{{ sprintf('%06d', $emp->id) }}</td>
                        <td>{{ $emp->name() }}</td>
                        <td>{{ $emp->user->first()->email ?? '' }}</td>
                        <td>{{ $emp->department->department }}</td>
                        <td>{{ $emp->position->position_title }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
