const createFlightForm = {
    template: ` <airline-dropdown :airlines="posibleAirlines" @airline-selected="handleSelectedAirline" :originCity="originSelected"></airline-dropdown>
                <cities-dropdown :cities="posibleOriginCities" :airline="airlineSelected" @origin-selected="handleSelectedOrigin"></cities-dropdown>`,
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
            template: `<select v-model="selectedOrigin"  id="selectOrigin">
                            <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                        </select>`,
            data() {
                return {
                    selectedOrigin: null,
                };
            },
            props: ['cities'],
            mounted() {
                const select2Options = {
                    placeholder: "Posible origins...",
                    width: '200px'
                };

                $(this.$el).select2(select2Options).on('change', () => {
                    this.selectedOrigin = $(this.$el).val();
                    this.$forceUpdate();
                });
            },
            computed: {

            },
            emits: ['origin-selected'],
            watch: {
                selectedOrigin(newval) {
                    this.$emit('origin-selected', newval);
                }
            }
        },
    },
    data() {
        return {
            selectedAirlineId: null,
            posibleAirlines: null,
            selectedOriginId: null,
            posibleOriginCities: null
        };
    },
    methods: {
        handleSelectedAirline(value){
            this.selectedAirlineId = parseInt(value);
        },

        handleSelectedOrigin(value){
            this.selectedOriginId = parseInt(value);
        },
        getAirlines() {
            axios.get('api/airlines')
                .then(response => {
                    this.posibleAirlines = response.data;
                });
        },
        getCities() {
            axios.get('api/cities')
                .then(response => {
                    this.posibleOriginCities = response.data;
                });
        },
        getCitiesOfAirline(airlineId) {
            axios.get(`api/airlines/cities/${airlineId}`)
                .then(response =>{
                    if(response.data.length == 0){
                        this.posibleOriginCities = null;
                    } else{
                        this.posibleOriginCities = response.data;
                    }
                });
        },
        getAirlinesofCity(cityId){
            axios.get(`api/cities/airlines/${cityId}`)
                .then(response => {
                        if(response.data.length == 0){
                            this.posibleAirlines = null
                        } else {
                            this.posibleAirlines = response.data;
                        }
                });
        }
    },
    mounted() {
        this.getAirlines();
        this.getCities();
    },
    computed: {
        airlineSelected(){
            if(this.selectedAirlineId){
                this.getCitiesOfAirline(this.selectedAirlineId);
                return this.posibleAirlines.find(airline => airline.id === this.selectedAirlineId);

            }
        },
        originSelected() {
            if(this.selectedOriginId){
                this.getAirlinesofCity(this.selectedOriginId);
            }
        }
    }
};

export default createFlightForm;
