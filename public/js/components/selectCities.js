const citiesDropdowns = {
    template: `<div class="flex flex-col mb-4 justify-between">
                    <label for="'select' + label" class="font-bold text-s tracking-wide">{{label.toUpperCase()}}</label>
                    <select v-model="selectedCity"  :id="'select' + label">
                        <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                    </select>
                </div>`,
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
        $(this.$el).find('select').select2(select2Options).on('change', () => {
            this.selectedCity = $(this.$el).find('select').val();
            this.$forceUpdate();
        });
    },
    emits: ['city-changed'],
    watch: {
        selectedCity(newval) {
            this.$emit('city-changed', newval);
        }
    }
};

export default citiesDropdowns;
