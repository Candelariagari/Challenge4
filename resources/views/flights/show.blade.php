@stack('scripts')
<x-layout>

    <x-table :flights="$flights" />

    <div class="bg-gray-50 border border-black border-opacity-5 rounded-xl  py-5 mx-20 mt-12">
        <h2 class="ml-10 font-bold font-serif text-xl mb-5">Add a new flight</h2>

        <div id="app" class="mx-10">
            <form action="">
                <create-flight></create-flight>
                <div class="flex justify-center">
                <button class="bg-blue-400 text-white bold py-2 px-8 hover:bgg-blue-500 uppercase rounded-xl flex"
                        id="addFlight">submit</button>
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

    Vue.createApp({
        components: {
            'create-flight': createFlightForm
        },
    }).mount('#app');
</script>
