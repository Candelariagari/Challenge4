const OriginCitiesDropdown = {
    template: `<select v-model="selectedOrigin"  id="selectOrigin">
                    <option v-for="city in posibleOrigins" :key="city.id" :value="city.id">{{ city.name }}</option>
                </select>`,
    data() {
        return {
            selectedOrigin: null,
            cities: []
        };
    },
    props: {
        selectedAirline: Number
    },
    computed: {
        posibleOrigins(){
            if(this.selectedAirline){
                return this.cities.filter(city => city.airlines.includes(this.selectedAirline));
            }

            return this.cities;
        }
    },
    mounted() {
        this.getCities();

        $(this.$el).select2({
            placeholder: "Select Airline",
            width: '200px'
        });
    },
    watch: {
        selectedOriginCity() {
            // Emitir un evento para que AirlineDropdown pueda actualizar su lista de aerolíneas según la ciudad seleccionada
            this.$emit('originSelected', this.selectedOrigin);
        },
    },
    methods: {
        getCities(){
            axios.get('/api/cities')
                .then( response =>{
                    this.cities = response.data;
                });
        }
    }
};

export default OriginCitiesDropdown;
