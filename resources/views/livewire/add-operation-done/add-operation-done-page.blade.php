<div class="py-6 bg-gray-300 px-96">
    <div class="py-2">
        <div class="p-6 bg-white"> {{-- main content begin --}}

            <div class="">
                <label for="operation_done" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Operation Done</label>
                <textarea wire:model="operation_done" id="operation_done" class="textarea" placeholder=""></textarea>
            </div>
            <button wire:click="save()" type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </div>
        </div>
    </div>
</div>

