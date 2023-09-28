const airlineSelect = {
    template: ` <div class="flex flex-col mb-4 justify-between">
                <label for="airlines" class="font-bold text-s tracking-wide">AIRLINE</label>
                    <select v-model="selectedAirline"  id="airlines">
                        <option v-for="airline in airlines" :key="airline.id" :value="airline.id">{{ airline.name }}</option>
                    </select>
                </div>`,
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

                $(this.$el).find('select').select2(select2Options).on('change', () => {
                    this.selectedAirline = $(this.$el).find('select').val();
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
};

export default airlineSelect;
