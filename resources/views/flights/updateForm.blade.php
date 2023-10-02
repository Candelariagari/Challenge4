@props(['flight'])
@stack('scripts')
<x-layout>
    <div class="bg-gray-50 border border-black border-opacity-5 rounded-xl  py-5 mx-20 mt-12">
        <h2 class="ml-10 font-bold font-serif text-xl mb-5">Add a new flight</h2>
        <div id="app" class="mx-10">
            <form>
                <create-flight ref="updateFlight" :flight="{{$flight}}"></create-flight>
                <div class="flex justify-center">
                    <button class="bg-blue-400 text-white bold py-2 px-8 hover:bgg-blue-500 uppercase rounded-xl flex"
                            id="update"
                            data-flight-id="{{  $flight->id  }}">
                        submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>

<script type="module">
    import createFlightForm from "{{ asset('js/components/createFlight.js')}}";

    const flightToUpdate = Vue.createApp({
        components: {
            'create-flight': createFlightForm
        }
    }).mount('#app');

    const flightData = flightToUpdate.$refs.updateFlight;
    var updateButton = document.getElementById('update');

    updateButton.addEventListener("click", function(event){
        event.preventDefault();

        var flightId = updateButton.getAttribute('data-flight-id');
        axios({
            method: 'put',
            url: `/api/flights/${flightId}`,
            data: {
                airline_id: flightData.selectedAirlineId,
                departure_date: flightData.formattedDepDate,
                origin_id: flightData.selectedOriginId,
                arrival_date: flightData.formattedArrivalDate,
                destination_id: flightData.selectedDestinationId,
            }
        })
        .then((response) => {
            window.location.href = '/flights';
        })
        .catch((error) => {
            console.log(error);
            alert('Could not create flight.');
        });
    });
</script>
