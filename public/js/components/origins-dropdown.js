const OriginCitiesDropdown = {
    template: `<select v-model="selectedOrigin"  id="selectOrigin">
                    <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
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
            placeholder: "Posible origins...",
            width: '200px'
        });
    },
    watch: {
        selectedOriginCity() {
            this.$emit('origin-selected', this.selectedOrigin);
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
