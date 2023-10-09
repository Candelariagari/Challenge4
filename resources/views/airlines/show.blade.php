<x-layout>
    <div class="flex items-center justify-end px-20 pb-8">
        <label for="cities" class="mr-2">Filter airlines by: </label>
        <div class="relative flex items-center rounded-xl border border-gray-100">
            <select class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold" id="cities">
                <option disabled selected>Select city</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id  }}">{{  $city->name  }}</option>
                @endforeach
                <option value="0">All cities</option>
            </select>

            <svg class="transform -rotate-90 absolute pointer-events-none" style="right: 12px;" width="22" height="22" viewBox="0 0 22 22">
                <g fill="none" fill-rule="evenodd">
                    <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z"></path>
                    <path fill="#222" d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z"></path>
                </g>
            </svg>
        </div>

        <label for="active_flights" class="mr-2">Active flights: </label>
        <div class="relative flex items-center rounded-xl border border-gray-100">
            <input type="number" min="0" class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold" id="active_flights">
        </div>
    </div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:mx-6 lg:-mx-8 px-20">
            <div class="oy-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-5">
                    <table class="min-w-full divide-y divide-gray-200 mx-auto-50 px-10 scroll-m-0">

                        @if (count($airlines) == 0)
                            <tr class="px-6 py-4 whitespace-nowrap">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-600 text-center">
                                        There are no airlines registered.
                                    </div>
                                </td>
                            </tr>
                        @else
                            <thead>
                                <th class="text-left text-gray-900 px-6 py-4">
                                    Id
                                </th>
                                <th class="text-left text-gray-900 px-6 py-4">
                                    Name
                                </th>
                                <th class="text-left text-gray-900 px-6 py-4">
                                    Description
                                </th>
                                <th class="text-left text-gray-900 px-6 py-4">
                                    Flights
                                </th>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="airlinesTable">
                                @foreach ($airlines as $airline)
                                    <tr id="row{{  $airline->id  }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{  $airline->id  }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{  $airline->name  }}
                                        </td>

                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                {{  $airline->description  }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{  $airline->active_flights()->count()  }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <a href="/airlines/{{  $airline->id  }}" class="text-gray-600 hover:text-blue-500 visited:text-purple-600" id="edit">
                                                    Edit
                                                </a>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <form>
                                                    <button class="text-gray-400 hover:text-blue-500 visited:text-purple-600 deleteButton" id="{{  $airline->id  }}">
                                                        Delete
                                                    </button>
                                                </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if (count($airlines) > 0)
        <div class="mt-10 flex justify-center items-center">
            {{  $airlines->withQueryString()->links()  }}
        </div>
    @endif

    <div class="bg-gray-50 border border-black border-opacity-5 rounded-xl text-center py-5 px-5 mt-16">
        <h2 class="text-center font-bold text-xl font-serif font-semibold text-sky-100 tracking-widest"> Add a new Airline!</h1>
            <form action="" method="" class="mt-10" id="newAirlineForm">
                @csrf
                <div class="mb-6 flex w-1/2 mx-auto space-x-4 items-center">
                    <label class="block mb-2 font-bold uppercase text-s text-gray-700"
                            for="name">
                            Name:
                    </label>

                    <input class="border border-gray-200 p-2 w-full rounded-xl"
                            type="text"
                            name="name"
                            id="nameAirline"
                            required
                    >
                </div>

                <div class="mb-6 flex w-1/2 mx-auto space-x-4 items-center">
                    <label class="block mb-2 font-bold uppercase text-s text-gray-700"
                        for="description">
                        Description:
                    </label>
                    <textarea name="description" id="descriptionAirline" cols="83" rows="4"
                            class="rounded-xl border border-gray-200" required>
                    </textarea>
                </div>

                <div class="mb-2">
                    <button type="submit"
                            class="bg-blue-400 text-white bold py-2 px-8 hover:bgg-blue-500 uppercase rounded-xl"
                            id="addAirline"
                    >
                        Submit
                    </button>
                </div>

                @foreach ($errors->all() as $error)
                    <li>{{  $error  }}</li>
                @endforeach
            </form>
    </div>
</x-layout>

<script>
    var deleteButtons = document.querySelectorAll('.deleteButton');

    deleteButtons.forEach(function (button){
        button.addEventListener("click", function (event){
            event.preventDefault();

            var airlineId = button.id;
            var rowToDelete = document.getElementById('row' + airlineId);

            fetch(`/api/airlines/${airlineId}`, {
                method: 'DELETE',
            }).then(function (msg){
                alert("Airline was removed!");
                rowToDelete.parentNode.removeChild(rowToDelete);
            });
        });
    });

    function addRow(airline) {
        var newRow = `<tr id="row${airline.id}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> ${airline.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> ${airline.name}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900"> ${airline.description}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> 0 </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><a href="/airlines/${airline.id}"> Edit </a></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <form><button class="text-gray-400 hover:text-blue-500 visited:text-purple-600 deleteButton" id="${airline.id}"> Delete </button></form>
                        </td>
                        </tr>`;

        var airlinesTable = document.getElementById("airlinesTable");
        airlinesTable.innerHTML += newRow;
    };

    var addAirlineButton = document.getElementById('addAirline');

    addAirlineButton.addEventListener("click", function(event){
        event.preventDefault();
        var nameNewAirline = document.getElementById('nameAirline').value;
        var descNewAirline = document.getElementById('descriptionAirline').value;

        fetch('/api/airlines', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: nameNewAirline,
                description: descNewAirline
            })
        })
        .then(function(response) {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error.');
            }
        })
        .then(function(airline){
            addRow(airline);
        })
        .catch(error => {
            console.error(error);
        });
    });

    let params = new URL(document.location).searchParams;

    var select_city = document.getElementById('cities');
    select_city.addEventListener('change', function() {
        params.delete('city');
        if(this.value != 0){
            params.append('city', this.value)
        }
        localStorage.setItem('selected_city', this.value);
        window.location.search = params.toString();
    });
    select_city.value = localStorage.getItem('selected_city') !== null ? localStorage.getItem('selected_city') : "";

    var filter_active_flights = document.getElementById('active_flights');
    filter_active_flights.addEventListener('change', function() {
        params.delete('active_flights');
        if(this.value != ""){
            params.append('active_flights', this.value);
        }
        window.location.search = params.toString();
        localStorage.setItem('filtering_active_flights', this.value);
    });
    filter_active_flights.value = localStorage.getItem('filtering_active_flights') !== null ? localStorage.getItem('filtering_active_flights') : "";
</script>
