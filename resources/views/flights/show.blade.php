@stack('scripts')
<x-layout>
    <x-table>
        @if (count($flights) == 0)
            <tr class="px-6 py-4 whitespace-nowrap">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-600 text-center">
                        There are no flights available to show.
                    </div>
                </td>
            </tr>
        @else
            <th class="text-left text-gray-900 px-6 py-4">
                Departure date
            </th>

            <th class="text-left text-gray-900 px-6 py-4">
                Origin
            </th>

            <th class="text-left text-gray-900 px-6 py-4">
                Arrival date
            </th>

            <th class="text-left text-gray-900 px-6 py-4">
                Destination
            </th>

            @foreach ($flights as $flight)
                <tr id="row{{  $flight->id  }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{  $flight->departure_date  }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{  $flight->origin->name  }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{  $flight->arrival_date  }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{  $flight->destination->name  }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 hover:text-blue-500 visited:text-purple-600">
                            <a href="/flights/{{  $flight->id  }}">
                                Edit
                            </a>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <form>
                            <button class="text-gray-400 hover:text-blue-500 visited:text-purple-600 deleteButton" id="{{  $flight->id  }}">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </x-table>

    <div class="bg-gray-50 border border-black border-opacity-5 rounded-xl  py-5 mx-20 mt-12">
        <h2 class="ml-10 font-bold font-serif">Add a new flight</h2>
        <div class="text-center mx-10" id="root">
            <input type="text" v-model="greeting">
            @{{ greeting }}
        </div>
        {{-- PQ NO ANDA ESTO?<airlines-options></airlines-options> --}}
        <div id="app" class="mx-10">
            <airline-dropdown airlineSelected="handleAirlineSelected"></airline-dropdown>
            <origins-dropdown :selected-airline="selectedAirline" originSelected="handleOriginSelected"></origins-dropdown>
        </div>
        {{-- <button type="button" href="#" class="bg-blue-900 text-white bold py-2 px-8 hover:bgg-blue-500 uppercase rounded-xl font-bold">Add a new flight</button> --}}
    </div>
</x-layout>


<script type="module">
    function deleteFlight(button)
    {
        var flightId = button.id;
        var rowToDelete = document.getElementById('row' + flightId);

        axios.delete(`/api/flights/${flightId}`)
                .then(function (msg){
                    alert("Airline was removed!");
                    rowToDelete.parentNode.removeChild(rowToDelete);
                });
    }

    var deleteButtons = document.querySelectorAll('.deleteButton');

    deleteButtons.forEach(function (button){
        button.addEventListener("click", function (event){
            event.preventDefault();

            var confirmation = confirm('Are you sure you want to delete this flight?');
            if(confirmation){
                deleteFlight(button);
            }
        });
    });

    Vue.createApp({
        data(){
            return {
                greeting: 'Hello World!'
            };
        }
    }).mount('#root');


    import AirlineDropdown from "{{ asset('js/components/Airline-dropdown.js') }}";
    import OriginCitiesDropdown from "{{ asset('js/components/origins-dropdown.js')}}";
    const app = Vue.createApp({
        components: {
                'airline-dropdown': AirlineDropdown,
                'origins-dropdown': OriginCitiesDropdown
        },
        data() {
            return {
                selectedAirline: null,
                selectedOrigin: null
            };
        },
        methods: {
            handleAirlineSelected(airlineId) {
                this.selectedAirline = airlineId;
            },
            handleOriginSelected(cityId) {
                this.selectedOrigin = cityId;
            }
        }
    });

    app.mount('#app');
</script>
