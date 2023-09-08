<x-layout>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:mx-6 lg:-mx-8 px-20">
            <div class="oy-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-5">
                    <table class="min-w-full divide-y divide-gray-200 mx-auto-50">
                        <tbody class="bg-white divide-y divide-gray-200" id="citiesTable">
                            @if (count($cities) == 0)
                                <tr class="px-6 py-4 whitespace-nowrap">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-600 text-center">
                                            There are no cities registered.
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($cities as $city)
                                        <tr id="fila{{  $city->id  }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{  $city->id  }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{  $city->name  }}
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{-- {{  $city->departures  }} --}}
                                                    0
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{-- {{  $city->arrivals  }} --}}
                                                    0
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <a href="/cities/{{  $city->id  }}">
                                                        Edit
                                                    </a>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <form>
                                                        <button class="text-gray-400 hover:text-blue-500 visited:text-purple-600 deleteButton" data-city-id="{{$city->id }}">
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

    @if (count($cities) != 0)
        <div class="mt-10 flex justify-center items-center">
            {{  $cities->links()  }}
        </div>
    @endif

    <div class="mt-10 flex justify-center items-center" id="newsLetter">
        <div class="relative inline-block mx-auto lg:bg-gray-200 rounded-full">
            <form class="lg:flex">
                <div class="lg:py-3 lg:px-5 flex items-center">
                    <label for="newCityName" class="hidden lg:inline-block text-gray-500">
                       Name of the new city:
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
    </div>
</x-layout>


<script>
    $(document).ready(function () {
        $('.deleteButton').on('click', function (e) {
            e.preventDefault();

        var cityId = $(this).data('city-id');
        var rowToDelete = $(`#fila${cityId}`);


            $.ajax({
                method: 'DELETE',
                url: `/api/cities/${cityId}`,
            })
            .done(function( msg ) {
                alert( 'City deleted successfully.');
                rowToDelete.remove();
            });
        });
    });

    $(document).ready(function () {
        function addRow(city) {
            var newRow = `<tr id="${city.id}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> ${city.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> ${city.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> 0 </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> 0 </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><a href="/cities/${city.id}"> Edit </a></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <form><button class="text-gray-400 hover:text-blue-500 visited:text-purple-600 deleteButton" data-city-id="${city.id}"> Delete </button></form>
                        </td>
                        </tr>`;

            $('#citiesTable').append(newRow);
        }

        $('.addCityButton').on('click', function (e) {
            console.log('Apretaste boton');
            e.preventDefault();

            var newCityName = $('#newCityName').val();

            $.ajax({
                method: 'POST',
                url: '/api/cities',
                data: { name: newCityName },
            })
            .done(function(city) {
                addRow(city);
                alert('City created successfully.');
            })
            .fail(function (response) {
                alert('Could not create the city.');
            })

        });
    });
</script>


