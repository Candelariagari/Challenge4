<x-layout>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:mx-6 lg:-mx-8 px-20">
            <div class="oy-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-5">
                    <table class="min-w-full divide-y divide-gray-200 mx-auto-50">
                        <tbody class="bg-white divide-y divide-gray-200" id="citiesTable">
                            @if (count($airlines) == 0)
                                <tr class="px-6 py-4 whitespace-nowrap">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-600 text-center">
                                            There are no airlines registered.
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($airlines as $airline)
                                        <tr id="fila{{  $airline->id  }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{  $airline->id  }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{  $airline->name  }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{  $airline->description  }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    0
                                                    {{-- aca va a ir un numero que es la cantidad de vuelos activos que tiene esta airline --}}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <a href="" class="text-gray-600 hover:text-blue-500 visited:text-purple-600 ">
                                                        Edit
                                                    </a>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <form>
                                                        <button class="text-gray-400 hover:text-blue-500 visited:text-purple-600 deleteButton">
                                                            Delete
                                                        </button>
                                                    </form>
                                            </td>
                                        </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if (count($airlines) != 0)
        <div class="mt-10 flex justify-center items-center">
            {{  $airlines->links()  }}
        </div>
    @endif

    {{-- <div class="mt-10 flex justify-center items-center" id="newsLetter">
        <div class="relative inline-block mx-auto lg:bg-gray-200 rounded-full">
            <form class="lg:flex">
                <div class="lg:py-3 lg:px-5 flex items-center">
                    <label for="newCityName" class="hidden lg:inline-block text-gray-500">
                       Name of the new airline:
                    </label>

                    <input id="newCityName" type="text"
                           class="lg:bg-transparent py-2 lg:py-0 pl-4 focus-within:outline-none bg-cyan-900">
                </div>

                <button type="submit"
                        class="transition-colors duration-300 bg-{#1d5b81} mt-4 lg:mt-0 rounded-full text-xs font-semibold text-white uppercase py-3 px-8 addCityButton">
                    ADD
                </button>
            </form>
        </div>
    </div> --}}
</x-layout>
