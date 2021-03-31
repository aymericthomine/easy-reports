<div class="flex justify-around">
    <a wire:click="openModal('view',{{ $id }})" class="p-1 text-teal-600 hover:bg-teal-600 hover:text-white rounded">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
        </svg>
    </a>

    <a wire:click="openModal('update',{{ $id }})" class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
        </svg>
    </a>

    <a wire:click="openModal('duplicate',{{ $id }})" class="p-1 hover:bg-gray-700 hover:text-white rounded">
        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="margin-top: 2px;" class="w-4 h-4 ml-1" viewBox="0 0 512 512"><g><path xmlns="http://www.w3.org/2000/svg" d="m279.652344 122.015625c-8.597656 0-15.566406-6.96875-15.566406-15.566406v-106.449219h-129.894532c-8.597656 0-15.570312 6.96875-15.570312 15.570312v71.914063h42.390625c4.1875 0 8.148437 1.695313 11.023437 4.566406l122.015625 122.019531c2.738281 2.734376 4.566407 6.6875 4.566407 11v192.84375h71.914062c8.601562 0 15.570312-6.972656 15.570312-15.570312v-280.328125zm0 0"/><path xmlns="http://www.w3.org/2000/svg" d="m295.222656 22.015625v68.863281h68.863282zm0 0"/><path xmlns="http://www.w3.org/2000/svg" d="m145.453125 225.070312v-106.449218h-129.882813c-8.601562 0-15.570312 6.972656-15.570312 15.570312v362.238282c0 8.601562 6.96875 15.570312 15.570312 15.570312h236.339844c8.597656 0 15.570313-6.96875 15.570313-15.570312v-255.789063h-106.460938c-8.59375 0-15.566406-6.964844-15.566406-15.570313zm0 0"/><path xmlns="http://www.w3.org/2000/svg" d="m176.589844 209.5h68.863281l-68.863281-68.851562zm0 0"/></g></svg>
    </a>

    <button wire:click="openModal('destroy',{{ $id }})" class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
        </svg>
    </button>
</div>

