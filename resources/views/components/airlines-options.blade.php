<div id="app">
    <airline-dropdown></airline-dropdown>
</div>

<script type="module">
import AirlineDropdown from "{{ asset('js/components/Airline-dropdown.js') }}";

    const app = Vue.createApp({
        components: {
                'airline-dropdown': AirlineDropdown
            }
    });

    app.mount('#app');
</script>
