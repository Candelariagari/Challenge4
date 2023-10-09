<x-layout>
    <div class="flex items-center justify-between px-20 pb-8">
        <div class="ml-5">
            <h3 class="font-serif font-semibold tracking-widest">Cities</h3>
        </div>

        <div class="flex">
            <label for="select_airline" class="mr-2">Filter cities by: </label>
            <div class="relative flex items-center rounded-xl border border-gray-100">

                <select class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold" id="select_airline">
                    <option disabled selected>Select airline</option>
                    @foreach ($airlines as $airline)
                        <option value="{{ $airline->id  }}">{{  $airline->name  }}</option>
                    @endforeach
                    <option value="0">All airliness</option>
                </select>

                <svg class="transform -rotate-90 absolute pointer-events-none" style="right: 12px;" width="22" height="22" viewBox="0 0 22 22">
                    <g fill="none" fill-rule="evenodd">
                        <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z"></path>
                        <path fill="#222" d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z"></path>
                    </g>
                </svg>
            </div>
        </div>
    </div>

    <x-table-style>
        <table class="min-w-full divide-y divide-gray-200 mx-auto-50" id="mitabla">
                @if (count($cities) == 0)
                <tbody class="bg-white divide-y divide-gray-200" id="citiesTable">
                    <tr class="px-6 py-4 whitespace-nowrap">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-600 text-center">
                                There are no cities to show.
                            </div>
                        </td>
                    </tr>
                </tbody>
                @else
                <thead>
                    <th class="text-left text-gray-900 px-6 py-4">
                        <button class="font-bold" id="cities_id">Id</button>
                    </th>
                    <th class="text-left text-gray-900 px-6 py-4">
                        <button class="font-bold" id="cities_name">City Name</button>
                    </th>
                    <th class="text-left text-gray-900 px-6 py-4">
                        Departures
                    </th>
                    <th class="text-left text-gray-900 px-6 py-4">
                        Arrivals
                    </th>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="citiesTable">
                    @foreach ($cities as $city)
                            <tr id="fila{{  $city->id  }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{  $city->id  }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{  $city->name  }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{  $city->departures->count()  }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{  $city->arrivals->count()  }}
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
    </x-table-style>

    @if (count($cities) > 0)
        <div class="mt-10 flex justify-center items-center pagination">
            {{  $cities->withQueryString()->links()  }}
        </div>
    @endif

    <div class="flex justify-center items-center py-4">
        <div class="w-1/2">
            <form class="border border-gray-200 p-6 rounded-xl">
                <label for="newCityName" class="flex justify-center font-bold">Name of the new city:</label>
                <div class="mt-6">
                    <input type="text" id="newCityName" placeholder="" class="w-full text-sm focus:outline-none focus:ring">
                    @error('name')
                        <span class="text-xs text-red-500 p-y">{{  $message  }}</span>
                    @enderror
                </div>

                <div class="flex justify-end mt-10 border-t border-gray-200 pt-6">
                    <button type="submit"
                        class="bg-blue-500 text-white uppercase font-semibold text-xs py-2 px-5 rounded-2xl hover:bg-blue=600 addCityButton"
                        >Add
                    </button>
                </div>
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
            $('.pagination').html(city.links);

        }

        $('.addCityButton').on('click', function (e) {
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

        let params = new URL(document.location).searchParams;
        var selectElement = document.getElementById('select_airline');

        $('#cities_id').on('click', function(e){
            params.delete('order_by');
            params.append('order_by', 'id');
            localStorage.setItem('selectedAirline', selectElement.value);
            window.location.search = params.toString();
        });

        $('#cities_name').on('click', function(e){
            params.delete('order_by');
            params.append('order_by', 'name');
            localStorage.setItem('selectedAirline', selectElement.value);
            window.location.search = params.toString();
        });

        selectElement.addEventListener('change', function() {
            params.delete('airline');
            if(this.value != 0){
                params.append('airline', this.value)
            }
            localStorage.setItem('selectedAirline', this.value);
            window.location.search = params.toString();
        });

        var selectedAirline = localStorage.getItem('selectedAirline');

        if (selectedAirline !== null) {
            selectElement.value = selectedAirline;
        }
    });
</script>
