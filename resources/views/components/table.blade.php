@props(['flights'])
<table class="min-w-full divide-y divide-gray-200 mx-auto-50" >
    <tbody class="bg-white divide-y divide-gray-200" id="flightsTable">
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
                    {{ date('H:i d-m-Y', strtotime($flight->departure_date)) }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{  $flight->origin->name  }}
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ date('H:i d-m-Y', strtotime($flight->arrival_date)) }}
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
    </tbody>
</table>
