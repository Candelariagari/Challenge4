@stack('scripts')
<x-layout>
    <x-table-style>
        <x-table :flights="$flights"/>
    </x-table-style>

    <div class="bg-gray-50 border border-black border-opacity-5 rounded-xl  py-5 mx-20 mt-12">
        <h2 class="ml-10 font-bold font-serif text-xl mb-5">Add a new flight</h2>
        <div id="app" class="mx-10">
            <form>
                <create-flight ref="createFlight"></create-flight>
                <div class="flex justify-center">
                    <button class="bg-blue-400 text-white bold py-2 px-8 hover:bgg-blue-500 uppercase rounded-xl flex"
                            id="addFlight">
                        submit
                    </button>
                </div>
            </form>
        </div>
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

    import createFlightForm from "{{ asset('js/components/createFlight.js')}}";

    const newFlight = Vue.createApp({
        components: {
            'create-flight': createFlightForm
        },
    }).mount('#app');

    const newFlightData = newFlight.$refs.createFlight;

    function addRow(flight) {
        console.log(flight);
        var newRow = `<tr id="row${flight.id}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> ${flight.departure_date}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> ${flight.origin.name}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900"> ${flight.arrival_date}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900"> ${flight.destination.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><a href="/flights/${flight.id}"> Edit </a></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <form><button class="text-gray-400 hover:text-blue-500 visited:text-purple-600 deleteButton" id="${flight.id}"> Delete </button></form>
                            </td>
                     </tr>`;

        var flightsTable = document.getElementById("flightsTable");
        flightsTable.innerHTML += newRow;
    };

    function resetFormData() {
        newFlightData.selectedAirlineId = null;
        newFlightData.selectedOriginId = null;
        newFlightData.selectedDestinationId = null;
        newFlightData.depDate = null;
        newFlightData.arrivalDate = null;
    }

    var addFlightButton = document.getElementById('addFlight');

    addFlightButton.addEventListener("click", function(event){
        event.preventDefault();

        axios({
            method: 'post',
            url: 'api/flights',
            data: {
                airline_id: newFlightData.selectedAirlineId,
                departure_date: newFlightData.formattedDepDate,
                origin_id: newFlightData.selectedOriginId,
                arrival_date: newFlightData.formattedArrivalDate,
                destination_id: newFlightData.selectedDestinationId,
            }
        })
        .then((response) => {
            addRow(response.data);
            resetFormData();
        })
        .catch((error) => {
            console.log(error);
            alert('Could not create flight.');
        });
    });
</script>
