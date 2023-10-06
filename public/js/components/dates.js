const datePicker = {
    template:`  <div class="flex flex-col mb-4 justify-between">
                    <label for="label + 'date'" class="font-bold text-s tracking-wide">{{label.toUpperCase()}}</label>
                    <input type="datetime-local" :min="minDate" :max="maxDate" v-model="mydate" class="border border-gray-400 rounded w-5/6">
                    <span v-if="error"><p class="text-xs text-red-500 text-center">Error, invalid time!</p></span>
                </div>`,
    data() {
        return{
            mydate: null,
        }
    },
    props: ['label', 'minDate', 'maxDate', 'error', 'preSelected'],
    methods: {
        emitValues() {
          this.$emit('update:mydate', this.mydate);
        },
      },
      watch: {
        mydate: 'emitValues',
        preSelected(value){
            this.mydate = value;
        }
      },
};

export default datePicker;
