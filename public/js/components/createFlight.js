import airlineSelect from "./Airline-dropdown.js";
import citiesDropdowns from "./selectCities.js";
import datePicker from "./dates.js";

const createFlightForm = {
    template: ` <div class="lg:grid lg:grid-cols-5">
                    <airline-dropdown :airlines="posibleAirlines" @airline-selected="handleSelectedAirline" :airline="selectedAirlineId" required></airline-dropdown>
                    <date-picker :label="departureLabel"  :minDate="minDepDate" :maxDate="oneYear" :error="errorDepartureTime" v-model:mydate="depDate" :preSelected="depDate" required></date-picker>
                    <cities-dropdown :label="originlabel" :cities="posibleOriginCities" @city-changed="handleSelectedOrigin" :preSelected="selectedOriginId"></cities-dropdown>
                    <date-picker :label="arrivalLabel" :minDate="minArrivalDate" :maxDate="maxArrivalDate" :error="errorArivalTime" v-model:mydate="arrivalDate" :preSelected="arrivalDate" required></date-picker>
                    <cities-dropdown :label="destinationlabel" :cities="posibleDestinationCities" @city-changed="handleSelectedDestination" :preSelected="selectedDestinationId"></cities-dropdown>
                </div>`,
    components: {
        'airline-dropdown': airlineSelect,
        'cities-dropdown': citiesDropdowns,
        'date-picker': datePicker
    },
    data() {
        return {
            selectedAirlineId: null,
            posibleAirlines: null,
            posibleOriginCities: null,
            selectedOriginId: null,
            posibleDestinationCities: null,
            originlabel: "orgin",
            destinationlabel: "destination",
            selectedDestinationId: null,

            departureLabel: "Departure Date & Time",
            minDepDate: null,
            oneYear: null,
            depDate: null,
            formattedDepDate: null,
            errorDepartureTime: false,

            arrivalLabel: "Arrival Date & Time",
            arrivalDate: null,
            formattedArrivalDate: null,
            minArrivalDate: null,
            maxArrivalDate: null,
            errorArivalTime: false,
        };
    },
    props: ['flight'],
    methods: {
        handleSelectedAirline(value){
            if(value == null){
                this.posibleOriginCities = null;
            } else{
                var airline = this.posibleAirlines.find(airline => airline.id == parseInt(value));
                this.posibleOriginCities = airline.cities;
                this.selectedAirlineId = parseInt(value);
            }
        },
        handleSelectedOrigin(value){
            this.selectedOriginId = parseInt(value);
        },
        handleSelectedDestination(value){
            this.selectedDestinationId = parseInt(value);
        },
        getAirlines() {
            return axios.get('/api/airlines')
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
        },
        formatDate(date){

        }
    },
    async mounted() {
        try {
            await this.getAirlines();
        }catch(e) {
            console.log(e);
        }
        this.minDepartureDate();
        this.maxDate();

        if(this.flight != null){
            this.selectedAirlineId = this.flight.airline_id;
            this.selectedOriginId = this.flight.origin_id;
            this.selectedDestinationId = this.flight.destination_id;
            this.depDate = this.flight.departure_date.replace(" ", "T").slice(0, 16);
            this.arrivalDate = this.flight.arrival_date.replace(" ", "T").slice(0, 16);
        }
    },
    watch: {
        selectedAirlineId(value){
            this.handleSelectedAirline(value);
        },
        selectedOriginId(value){
            if(value == null){
                this.posibleDestinationCities = null;
            }else{
                this.posibleDestinationCities = this.posibleOriginCities.filter(city => city.id != value);
            }
        },
        depDate(date) {
            if(date == null){
                this.formattedDepDate = null;
            }else{
                this.minArrivalDate  = date;
                const depDateObj = new Date(date);
                depDateObj.setDate(depDateObj.getDate() + 3);
                this.maxArrivalDate = depDateObj.toISOString().slice(0, 16);

                this.errorDepartureTime = false;
                if(date < this.minDepDate){
                    this.errorDepartureTime = true;
                }
                this.formattedDepDate = date.replace("T", " ")+":00";
            }
        },
        arrivalDate(date){
            if(date == null){
                this.formattedArrivalDate = null;
            }else{
                this.errorArivalTime = false;
                if(date <= this.minArrivalDate){
                    this.errorArivalTime = true;
                }
                this.formattedArrivalDate = date.replace("T", " ")+":00";
            }
        }
    }
};

export default createFlightForm;
