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

    <div class="bg-gray-50 border border-black border-opacity-5 rounded-xl text-center py-5 mx-20 mt-12">
        <button type="button" href="#" class="bg-blue-900 text-white bold py-2 px-8 hover:bgg-blue-500 uppercase rounded-xl font-bold">Add a new flight</button>
    </div>
</x-layout>

<script>
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


</script>
