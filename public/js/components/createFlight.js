const createFlightForm = {
    template: ` <airline-dropdown :airlines="posibleAirlines" @airline-selected="handleSelectedAirline"></airline-dropdown>
                <cities-dropdown :label="originlabel" :cities="posibleOriginCities" @city-changed="handleSelectedOrigin"></cities-dropdown>
                <cities-dropdown :label="destinationlabel" :cities="posibleDestinationCities" @city-changed="handleSelectedDestination"></cities-dropdown>`,
    components: {
        'airline-dropdown': {
            template: ` <select v-model="selectedAirline"  id="airlines">
                            <option v-for="airline in airlines" :key="airline.id" :value="airline.id">{{ airline.name }}</option>
                        </select>`,
            data() {
                return {
                    selectedAirline: null
                };
            },
            mounted() {
                const select2Options = {
                    placeholder: "Posible airlines...",
                    width: '200px'
                };

                $(this.$el).select2(select2Options).on('change', () => {
                    this.selectedAirline = $(this.$el).val();
                    this.$forceUpdate();
                });
            },
            props: ['airlines'],
            emits: ['airline-selected'],
            watch: {
                selectedAirline(newval) {
                    this.$emit('airline-selected', newval);
                }
            }
        },
        'cities-dropdown': {
            template: `<select v-model="selectedCity"  :id="'select' + label">
                            <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                        </select>`,
            data() {
                return {
                    selectedCity: null,
                };
            },
            props: ['cities', 'label'],
            mounted() {
                const select2Options = {
                    placeholder: `Posible ${this.label}s ...`,
                    width: '200px'
                };

                $(this.$el).select2(select2Options).on('change', () => {
                    this.selectedCity = $(this.$el).val();
                    this.$forceUpdate();
                });
            },
            emits: ['city-changed'],
            watch: {
                selectedCity(newval) {
                    this.$emit('city-changed', newval);
                }
            },

        }
    },
    data() {
        return {
            selectedAirline: null,
            posibleAirlines: null,
            posibleOriginCities: null,
            selectedOriginId: null,
            posibleDestinationCities: null,
            originlabel: "orgin",
            destinationlabel: "destination"
        };
    },
    methods: {
        handleSelectedAirline(value){
            this.selectedAirline = this.posibleAirlines.find(airline => airline.id == parseInt(value));
            this.posibleOriginCities = this.selectedAirline.cities;
        },
        handleSelectedOrigin(value){
            this.selectedOriginId = parseInt(value);
        },
        handleSelectedDestination(value){
            this.selectedDestinationId = parseInt(value);
        },
        getAirlines() {
            axios.get('api/airlines')
                .then(response => {
                    this.posibleAirlines = response.data;
                });
        }
    },
    mounted() {
        this.getAirlines();
    },
    computed: {
        originSelected() {
            if(this.selectedOriginId){
                console.log("holsa");
                this.posibleDestinationCities = this.posibleOriginCities.filter(city => city.id != this.selectedOriginId);
            }
        }
    }
};

export default createFlightForm;
