@props(['slot']);

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:mx-6 lg:-mx-8 px-20">
        <div class="oy-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-5">
               {{ $slot }}
            </div>
        </div>
    </div>
</div>
