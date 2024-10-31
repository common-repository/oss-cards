export default Vue.component('v-card-style', {
  props: ['val'],
  template: `
    <div>
     <label class="v_drop" v-on:click="selected=!selected">
        Effects
        <!-- <span>Effects <span data-tooltip="Tooltip help here!Tooltip help here!Tooltip help here!Tooltip help here!" data-flow="right"><i class="fas fa-question-circle"></i></span></span> -->

        <i v-if="!selected" class="fas fa-angle-down"></i> 
        <i v-if="selected" class="fas fa-angle-up"></i> 
     </label> 
     <ul v-if="selected" class="v_drop_list">
        <li v-for="(el, index) in effects" :class="active_style(el.val)" v-on:click="selectItem(el.val)">
            {{el.title}}
            <span v-if="el.pro">Pro</span>
        </li>
     </ul>
        
    </div>
  `,
    data: function () {
        return { 
            open: false,
            selected: null,
            active: '',
            effects: [
                {val: "oss-effect-classic", pro:false, title: "Classic", cat:""},
                {val: "oss-effect-circle", pro:true, title: "Circle", cat:""},
                {val: "oss-effect-selena", pro:true, title: "Selena", cat:""},
                {val: "oss-effect-lily", pro:true, title: "Lily", cat:""},
                {val: "oss-effect-sadie", pro:true, title: "Sadie", cat:""},
                {val: "oss-effect-layla", pro:true, title: "Layla", cat:""},
                {val: "oss-effect-oscar", pro:true, title: "Oscar", cat:""},
                {val: "oss-effect-marley", pro:true, title: "Marley", cat:""},
                {val: "oss-effect-ruby", pro:true, title: "Ruby", cat:""},
                {val: "oss-effect-roxy", pro:true, title: "Roxy", cat:""},
                {val: "oss-effect-bubba", pro:true, title: "Bubba", cat:""},
                {val: "oss-effect-romeo", pro:true, title: "Romeo", cat:""},
                {val: "oss-effect-dexter", pro:true, title: "Dexter", cat:""},
                {val: "oss-effect-sarah", pro:true, title: "Sarah", cat:""},
                {val: "oss-effect-chico", pro:true, title: "Chico", cat:""},
                {val: "oss-effect-milo", pro:true, title: "Milo", cat:""},
                {val: "oss-effect-goliath", pro:true, title: "Goliath", cat:""},
                {val: "oss-effect-apollo", pro:true, title: "Apollo", cat:""},
                {val: "oss-effect-jazz", pro:true, title: "Jazz", cat:""},
                {val: "oss-effect-ming", pro:true, title: "Ming", cat:""},
                {val: "oss-effect-lexi", pro:true, title: "Lexi", cat:""},
                {val: "oss-effect-duke", pro:true, title: "Duke", cat:""},
                {val: "oss-effect-moses", pro:true, title: "Moses", cat:""},
                {val: "oss-effect-steve", pro:true, title: "Steve", cat:""},
                {val: "oss-effect-kira", pro:true, title: "Kira", cat:""},
                {val: "oss-effect-hera", pro:true, title: "Hera", cat:""},
            {val: "oss-effect-julia", pro:true, title: "Julia", cat:""},
            ],
        }
    },
    methods:{
        active_style(e){
            if (this.active == e) {
                return 'v_active';
            }
            if (this.val == e) {
                return 'v_active';
            }
        },
        selectItem(e){
            this.active = e;
            this.$emit('update:val', e);
        },
        vTip(d){

        },
    },

    style: `
    <style lang="scss" scoped>
    </style>
    `,
});
