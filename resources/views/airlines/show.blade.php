<x-layout>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:mx-6 lg:-mx-8 px-20">
            <div class="oy-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-5">
                    <table class="min-w-full divide-y divide-gray-200 mx-auto-50 px-10 scroll-m-0">
                        <tbody class="bg-white divide-y divide-gray-200" id="airlinesTable">
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
                                                    0
                                                    {{-- aca va a ir un numero que es la cantidad de vuelos activos que tiene esta airline --}}
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
</script>
