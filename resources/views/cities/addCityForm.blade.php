<x-layout>
    <div class="flex justify-center items-center">
        <div class="w-1/2">
            <form action="/cities" method="POST" class="border border-gray-200 p-6 rounded-xl">
                @csrf

                <header class="flex justify-center font-bold">
                    <h2>Name of the city:</h2>
                </header>

                <div class="mt-6">
                    <textarea name="name" cols="30" rows="5" placeholder="Update your cities name" class="w-full text-sm focus:outline-none focus:ring"></textarea>
                    @error('name')
                        <span class="text-xs text-red-500 p-y">{{  $message  }}</span>
                    @enderror
                </div>

                <div class="flex justify-end mt-10 border-t border-gray-200 pt-6">
                    <button type="submit"
                        class="bg-blue-500 text-white uppercase font-semibold text-xs py-2 px-5 rounded-2xl hover:bg-blue=600"
                        >Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
