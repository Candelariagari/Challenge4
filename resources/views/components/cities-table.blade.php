@props(['cities'])
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
            <th class="text-left text-gray-900 px-6 py-4">
                Id
            </th>
            <th id="citiesNames" class="text-left text-gray-900 px-6 py-4 hover:text-purple hover:cursor-pointer">
                City Name
            </th>
            <th class="text-left text-gray-900 px-6 py-4">
                Departures
            </th>
            <th class="text-left text-gray-900 px-6 py-4">
                Arrivals
            </th>
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
