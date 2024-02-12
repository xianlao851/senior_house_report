<x-slot name="header">
    <h2 class="font-semibold leading-tight text-black text-md">
        SENIOR HOUSE OFFICER'S REPORT LIST
    </h2>
</x-slot>
<div class="flex flex-col max-w-6xl p-4 mx-auto mt-4 rounded-md ">
    <div class="bg-white">
        <table class="table border rounded table-zebra">
            <thead class="text-black bg-gray-300 ">
                <tr class="uppercase">
                    <th>REPORT DATE</th>
                    <th>SENIOR OFFICER IN CHARGE</th>
                    <th>Action</th>
                    {{-- <th>Print</th> --}}
                    {{-- <th>PDF</th> --}}
                    {{-- <th>DOCTORS ON DUTY</th>
                        <th>PATIENTS</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($shodetails as $shodetail)
                    <tr class="hover">
                        <td>
                            {{-- <a href="{{ route('viewshoreports', ['id' => $shodetail->id]) }}"> --}}
                            {{ \Carbon\Carbon::parse($shodetail->report_date)->format('M-j-Y') }} </a>
                        </td>
                        <td>
                            {{-- <a href="{{ route('viewshoreports', ['id' => $shodetail->id]) }}"> --}}
                            {{ $shodetail->employee->fullname() }} </a>
                        </td>
                        {{-- <td>
                            <a href="{{ route('viewshoreports', ['id' => $shodetail->id]) }}"
                                class="btn btn-info btn-xs">
                                View
                            </a>
                        </td> --}}
                        <td>
                            <a @if ($getPosition == 19 or $getPosition == 18 or $getPosition == 57 or $getPosition == 58 or $getPosition == 59) href="{{ route('view_print', ['id' => $shodetail->id]) }}"
                            @else onclick="permission()" @endif
                                class="btn btn-primary btn-xs hover:bg-slate-500">
                                <i class="las la-eye la-2x"></i>
                            </a>
                        </td>
                        {{-- <td>
                            <a href="{{ route('printtwo', ['id' => $shodetail->id]) }}">
                                <i class="text-sm las la-file-alt la-2x">PDF</i>
                            </a>
                        </td> - --}}
                    </tr>
                    {{-- <i class="las la-eye la-2x"></i> --}}
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="w-full px-10 mt-2">
        <div class="">
            <div>{{ $shodetails->links() }}</div>
        </div>
    </div>
    <script>
        function permission() {
            Swal.fire({
                title: "You dont have permission",
                text: "Only doctors have the permission to this fucntion!",
                icon: "warning",
                confirmButtonColor: "#0f7d34",
            });
        }
    </script>
</div>
