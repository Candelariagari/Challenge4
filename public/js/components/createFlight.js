import airlineSelect from "./Airline-dropdown.js";
import citiesDropdowns from "./selectCities.js";
import datePicker from "./dates.js";

const createFlightForm = {
    template: ` <div class="lg:grid lg:grid-cols-5">
                    <airline-dropdown :airlines="posibleAirlines" @airline-selected="handleSelectedAirline"></airline-dropdown>
                    <date-picker :label="departureLabel"  :minDate="minDepDate" :maxDate="oneYear" :error="errorDepartureTime" v-model:mydate="depDate"></date-picker>
                    <cities-dropdown :label="originlabel" :cities="posibleOriginCities" @city-changed="handleSelectedOrigin"></cities-dropdown>
                    <date-picker :label="arrivalLabel" :minDate="minArrivalDate" :maxDate="maxArrivalDate" :error="errorArivalTime" v-model:mydate="arrivalDate"></date-picker>
                    <cities-dropdown :label="destinationlabel" :cities="posibleDestinationCities" @city-changed="handleSelectedDestination"></cities-dropdown>
                </div>`,
    components: {
        'airline-dropdown': airlineSelect,
        'cities-dropdown': citiesDropdowns,
        'date-picker': datePicker
    },
    data() {
        return {
            selectedAirline: null,
            posibleAirlines: null,
            posibleOriginCities: null,
            selectedOriginId: null,
            posibleDestinationCities: null,
            originlabel: "orgin",
            destinationlabel: "destination",

            departureLabel: "Departure Date & Time",
            minDepDate: null,
            oneYear: null,
            depDate: null,
            errorDepartureTime: false,

            arrivalLabel: "Arrival Date & Time",
            arrivalDate: null,
            minArrivalDate: null,
            maxArrivalDate: null,
            errorArivalTime: false,
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
        },
        minDepartureDate() {
            var now = new Date();
            now.setHours(now.getHours() - 3);
            this.minDepDate  = now.toISOString().slice(0, 16);
        },
        maxDate() {
            const oneYearLater = new Date();
            oneYearLater.setFullYear(oneYearLater.getFullYear() + 1);
            oneYearLater.setHours(0, 0, 0, 0);
            this.oneYear = oneYearLater.toISOString().slice(0, 16);
        }
    },
    mounted() {
        this.getAirlines();
        this.minDepartureDate();
        this.maxDate();
    },
    watch: {
        selectedOriginId(value){
            this.posibleDestinationCities = this.posibleOriginCities.filter(city => city.id != value);
        },
        depDate(date) {
            this.minArrivalDate = date;

            const depDateObj = new Date(date);
            depDateObj.setDate(depDateObj.getDate() + 3);
            this.maxArrivalDate = depDateObj.toISOString().slice(0, 16);

            this.errorDepartureTime = false;
            if(date < this.minDepDate){
                this.errorDepartureTime = true;
            }

        },
        arrivalDate(date){
            this.errorArivalTime = false;
            if(date < this.minArrivalDate){
                this.errorArivalTime = true;
            }
        }
    }
};

export default createFlightForm;
