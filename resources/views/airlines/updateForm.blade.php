@props(['airline'])
<x-layout>
    <div class="bg-gray-50 border border-black border-opacity-5 rounded-xl text-center py-5 px-5 mt-16">
        <h2 class="text-center font-bold text-xl font-serif font-semibold text-sky-100 tracking-widest"> Update the airline!</h1>
            <form class="mt-10" id="newAirlineForm">
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
                            value="{{  $airline->name  }}"
                            required
                    >
                </div>

                <div class="mb-6 flex w-1/2 mx-auto space-x-4 items-center">
                    <label class="block mb-2 font-bold uppercase text-s text-gray-700"
                        for="description">
                        Description:
                    </label>
                    <textarea name="description" id="descriptionAirline" cols="83" rows="4"
                            class="rounded-xl border border-gray-200" style="text-align: center;">
                        {{  $airline->description  }}
                    </textarea>
                </div>

                <div class="mb-2">
                    <button type="submit"
                            class="bg-blue-400 text-white bold py-2 px-8 hover:bgg-blue-500 uppercase rounded-xl"
                            id="updateAirline"
                            data-airline-id="{{  $airline->id  }}"
                            required
                    >
                        Submit
                    </button>
                </div>

                @foreach ($errors->all() as $error)
                    <li>{{  $error  }}</li>
                @endforeach
            </form>
</x-layout>

<script>


var updateAirlineButton = document.getElementById('updateAirline');

updateAirlineButton.addEventListener("click", function(event){
    event.preventDefault();
    var airlineId = updateAirlineButton.getAttribute('data-airline-id');
    var nameNewAirline = document.getElementById('nameAirline').value;
    var descNewAirline = document.getElementById('descriptionAirline').value;

    fetch('/api/airlines/'+airlineId , {
        method: 'PUT',
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
            if(nameNewAirline == "" || descNewAirline == ""){
                alert("Name and description should have information.");
            } else {
                throw new Error('Error.');
            }
        }
    })
    .then(function(loc) {
        window.location.href = '/airlines';
    })
    .catch(error => {
        console.error(error);
    });
});
</script>
