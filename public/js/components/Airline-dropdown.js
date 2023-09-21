const AirlineDropdown = {
    template: `<select v-model="selectedAirline"  id="airlines">
                    <option v-for="airline in airlines" :key="airline.id" :value="airline.id">{{ airline.name }}</option>
                </select>`,
    data() {
        return {
            selectedAirline: null,
            airlines: []
        };
    },
    mounted() {
        this.getAirlines();
        $(this.$el).select2({
            placeholder: "Select Airline",
            width: '200px'
        });
    },
    methods: {
        getAirlines() {
            axios.get('api/airlines')
                .then(response => {
                    this.airlines = response.data;
                });
        },
        airlineSelected() {
            this.$emit('airlineSelected', this.selectedAirline);
        },
    }
};

export default AirlineDropdown;
