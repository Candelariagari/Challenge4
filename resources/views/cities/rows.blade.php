@props(['city'])
<tr id="">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">
           {{  $city->id  }}
        </div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">
            {{  $city->name  }}
        </div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">
            {{  $city->departures  }}
        </div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">
            {{  $city->arrivals  }}
        </div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900">
            <a href="#">
                Edit
            </a>
        </div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900"> {{-- tiene que invocar una funcion --}}
           <a href="#">
                Delete
           </a>
        </div>
    </td>
</tr>


