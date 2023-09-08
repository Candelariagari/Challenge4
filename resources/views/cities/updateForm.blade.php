
@props(['city'])
<x-layout>
    <div class="flex justify-center items-center">
        <div class="w-1/2">
            <form class="border border-gray-200 p-6 rounded-xl">

                <label for="newName" class="flex justify-center font-bold">Name of the city:</label>

                <div class="mt-6">
                    <input type="text" id="newName" placeholder="Update your cities name" class="w-full text-sm focus:outline-none focus:ring" placeholder="Update your cities name">
                    @error('name')
                        <span class="text-xs text-red-500 p-y">{{  $message  }}</span>
                    @enderror
                </div>

                <div class="flex justify-end mt-10 border-t border-gray-200 pt-6">
                    <button type="submit"
                        class="bg-blue-500 text-white uppercase font-semibold text-xs py-2 px-5 rounded-2xl hover:bg-blue=600 updateButton"
                        data-city-id="{{  $city->id  }}"
                        >Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>

<script>
    $(document).ready(function () {
        $('.updateButton').on('click', function (e) {
            e.preventDefault();

            var cityId = $(this).data('city-id');
            var cityName = $('#newName').val();

            $.ajax({
                method: 'PUT',
                url: `/api/cities/${cityId}`,
                data: { name: cityName },
                // success: function( msg ) {
                //     alert( 'City updated successfully.');
                //     window.location.replace('/cities');
                // },
                // error: function(error) {
                //     alert('Error changing de name.')
                // },
            })

            .done(function( msg ) {
                window.location.replace('/cities');
            })

            .fail( function(error) {
                alert('Error', error.responseText);
            })
        });
    });
</script>
