@props(['airline'])
@props(['cities'])
@props(['selectedCities'])
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

                <div class="mb-6 flex w-1/2 mx-auto space-x-4 items-center justify-center ">
                    <label class="block mb-2 font-bold uppercase text-s text-gray-700 ">Cities:</label>
                    <ul class="ml-0 list-none text-left">
                        @foreach ($cities as $city)
                            <li class="mb-2 py-1">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="cities[]" value="{{ $city->id }}" {{ ($airline->cities->contains($city->id)) ? 'checked' : '' }}>
                                    <span class="ml-2">{{ $city->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
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

function citiesOfAirline()
{
    var selectedCities = [];
    var allCities = document.querySelectorAll('input[name="cities[]"]');

    allCities.forEach(function (city) {
        if (city.checked) {
            selectedCities.push(city.value);
        }
    });

    return selectedCities;
}

var updateAirlineButton = document.getElementById('updateAirline');

updateAirlineButton.addEventListener("click", function(event){
    event.preventDefault();
    var airlineId = updateAirlineButton.getAttribute('data-airline-id');
    var nameNewAirline = document.getElementById('nameAirline').value;
    var descNewAirline = document.getElementById('descriptionAirline').value;
    var idSelectedcities = citiesOfAirline();

    fetch('/api/airlines/'+airlineId , {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: nameNewAirline,
            description: descNewAirline,
            cities: idSelectedcities
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
    .then(function(location) {
        window.location.href = '/airlines';
    })
    .catch(error => {
        console.error('Request couldnt be processed');
    });
});
</script>
