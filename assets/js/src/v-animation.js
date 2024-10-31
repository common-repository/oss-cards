export default Vue.component('v-animation', {
  props: ['val'],
  template: `
    <div>
     <label class="v_drop" v-on:click="selected=!selected">
        Animation
        <i v-if="!selected" class="fas fa-angle-down"></i> 
        <i v-if="selected" class="fas fa-angle-up"></i> 
     </label> 
     <div v-if="selected">
        <select class="v_select_list" v-model="cat_selected">
            <option v-for="el in cat" :value="el">{{el}}</option>
        </select>
     </div>
     <ul v-if="selected" class="v_drop_list">
        <li v-if="anim_cat(index)" v-for="(el, index) in anim" :class="active_style(el.val)" v-on:click="selectItem(el.val)">
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
            cat_selected: 'all',
            cat: ["all","basic","bounce","scale","rotate","flip","blurred","elliptic","focus","swing","puff","tilt","tracking","roll","jello", "shadow"],
            anim: [
                {val: "none", pro:false, title: "None", cat:""},
                {val: "uk-animation-fade", pro:false, title: "Fade", cat:"basic"},
                {val: "uk-animation-slide-top-medium", pro:false, title: "Slide Top", cat:"basic"},
                {val: "uk-animation-slide-bottom-medium", pro:false, title: "Slide Bottom", cat:"basic"},
                {val: "uk-animation-slide-left-medium", pro:false, title: "Slide Left", cat:"basic"},
                {val: "uk-animation-slide-right-medium", pro:false, title: "Slide Right", cat:"basic"},
                {val: "uk-animation-slide-top-small", pro:true, title: "Slide Top Small", cat:"basic"},
                {val: "uk-animation-slide-bottom-small ", pro:true, title: "Slide Bottom Small", cat:"basic"},
                {val: "uk-animation-slide-left-small", pro:true, title: "Slide Left Small", cat:"basic"},
                {val: "uk-animation-slide-right-small", pro:true, title: "Slide Right Small", cat:"basic"},
                {val: "bounce-in-top", pro:true, title: "Bounce Top", cat:"bounce"},
                {val: "bounce-in-right", pro:true, title: "Bounce Right", cat:"bounce"},
                {val: "bounce-in-bottom", pro:true, title: "Bounce Bottom", cat:"bounce"},
                {val: "bounce-in-left", pro:true, title: "Bounce Left", cat:"bounce"},
                {val: "bounce-in-fwd", pro:true, title: "Bounce fwd", cat:"bounce"},
                {val: "scale-in-center", pro:true, title: "Scale Center", cat:"scale"},
                {val: "scale-in-bottom", pro:true, title: "Scale Bottom", cat:"scale"},
                {val: "scale-in-hor-center", pro:true, title: "Scale hor-center", cat:"scale"},
                {val: "scale-in-hor-left", pro:true, title: "Scale hor-left", cat:"scale"},
                {val: "scale-in-hor-right", pro:true, title: "Scale hor-right", cat:"scale"},
                {val: "scale-in-ver-center", pro:true, title: "Scale ver-center", cat:"scale"},
                {val: "scale-in-ver-top", pro:true, title: "Scale ver-top", cat:"scale"},
                {val: "scale-in-ver-bottom", pro:true, title: "Scale ver-bottom", cat:"scale"},


                {val: "rotate-in-hor", pro:true, title: "Rotate hor ", cat:"rotate"},
                {val: "rotate-in-ver", pro:true, title: "Rotate ver", cat:"rotate"},
                // {val: "rotate-in-2-cw", pro:true, title: "Rotate 2-cw", cat:"rotate"},
                // {val: "rotate-in-2-ccw", pro:true, title: "Rotate 2-ccw", cat:"rotate"},
                // {val: "rotate-in-2-fwd-cw", pro:true, title: "Rotate 2-fwd-cw", cat:"rotate"},
                // {val: "rotate-in-2-fwd-ccw", pro:true, title: "Rotate 2-fwd-ccw", cat:"rotate"},
                // {val: "rotate-in-2-bck-cw", pro:true, title: "Rotate 2-bck-cw", cat:"rotate"},
                // {val: "rotate-in-2-bck-ccw", pro:true, title: "Rotate 2-bck-ccw", cat:"rotate"},


                {val: "flip-in-hor-bottom", pro:true, title: "Flip hor-bottom", cat:"flip"},
                {val: "flip-in-ver-right", pro:true, title: "Flip ver-right", cat:"flip"},
                // {val: "flip-in-diag-1-tr", pro:true, title: "Flip diag-1-tr", cat:"flip"},
                // {val: "flip-in-diag-2-tl", pro:true, title: "Flip diag-2-tl", cat:"flip"},



                // {val: "slide-in-blurred-top", pro:true, title: "Blurred Top", cat:"blurred"},//??
                {val: "slide-in-blurred-right", pro:true, title: "Blurred Right", cat:"blurred"},
                {val: "slide-in-blurred-left", pro:true, title: "Blurred Left", cat:"blurred"},



                // {val: "slide-in-blurred-bottom", pro:true, title: "Blurred Bottom", cat:"blurred"},
                // {val: "slide-in-blurred-left", pro:true, title: "Blurred Left", cat:"blurred"},
                {val: "slide-in-elliptic-top-fwd", pro:true, title: "Elliptic Top-fwd", cat:"elliptic"},
                {val: "slide-in-elliptic-right-fwd", pro:true, title: "Elliptic Right-fwd", cat:"elliptic"},
                {val: "slide-in-elliptic-bottom-fwd", pro:true, title: "Elliptic Bottom-fwd", cat:"elliptic"},
                {val: "slide-in-elliptic-left-fwd", pro:true, title: "Elliptic Left-fwd", cat:"elliptic"},

                {val: "roll-in-left", pro:true, title: "Roll Left", cat:"roll"},
                {val: "roll-in-top", pro:true, title: "Roll Top", cat:"roll"},
                {val: "roll-in-right", pro:true, title: "Roll Right", cat:"roll"},
                {val: "roll-in-bottom", pro:true, title: "Roll Bottom", cat:"roll"},
                {val: "tracking-in-expand", pro:true, title: "Tracking expand", cat:"tracking"},
                {val: "tracking-in-expand-fwd-top ", pro:true, title: "Tracking expand-fwd-top ", cat:"tracking"},
                {val: "tracking-in-expand-fwd-bottom", pro:true, title: "Tracking expand-fwd-bottom", cat:"tracking"},
                {val: "tracking-in-contract", pro:true, title: "Tracking contract", cat:"tracking"},
                {val: "tracking-in-contract-bck-top", pro:true, title: "Tracking contract-bck-top", cat:"tracking"},
                {val: "tracking-in-contract-bck-bottom", pro:true, title: "Tracking contract-bck-bottom", cat:"tracking"},

                {val: "text-focus-in ", pro:true, title: "Focus text-focus-in ", cat:"focus"},
                {val: "focus-in-expand", pro:true, title: "Focus focus-in-expand", cat:"focus"},
                // {val: "focus-in-contract", pro:true, title: "Focus focus-in-contract", cat:"focus"},

                {val: "shadow-drop-2-bl", pro:true, title: "shadow Soft(overwrites)", cat:"shadow"},
                {val: "shadow-pop-tl", pro:true, title: "Shadow tl(overwrites)", cat:"shadow"},
                {val: "shadow-pop-bl", pro:true, title: "Shadow bl(overwrites)", cat:"shadow"},
                {val: "shadow-pop-br", pro:true, title: "Shadow br(overwrites)", cat:"shadow"},
                {val: "shadow-pop-tr", pro:true, title: "Shadow tr(overwrites)", cat:"shadow"},



                {val: "tilt-in-right-1", pro:true, title: "Tilt Right", cat:"tilt"},
                {val: "tilt-in-left-1", pro:true, title: "Tilt Left", cat:"tilt"},
                {val: "tilt-in-top-1", pro:true, title: "Tilt Top", cat:"tilt"},
                {val: "tilt-in-bottom-1", pro:true, title: "Tilt Bottom", cat:"tilt"},
                {val: "swing-in-top-fwd", pro:true, title: "Swing  Top", cat:"swing"},
                {val: "swing-in-right-fwd", pro:true, title: "Swing  Right", cat:"swing"},
                {val: "swing-in-bottom-fwd", pro:true, title: "Swing  Bottom", cat:"swing"},
                {val: "swing-in-left-fwd", pro:true, title: "Swing  Left", cat:"swing"},


                // {val: "puff-in-center", pro:true, title: "Puff  Center", cat:"puff"},
                {val: "puff-in-ver", pro:true, title: "Puff  Vertical", cat:"puff"},
                {val: "puff-in-hor", pro:true, title: "Puff  Horisontal", cat:"puff"},


                // {val: "puff-in-ver", pro:true, title: "Puff  ver", cat:"puff"},

                {val: "jello-horizontal", pro:true, title: "Jello  horizontal", cat:"jello"},
                {val: "jello-vertical", pro:true, title: "Jello  vertical", cat:"jello"},
                {val: "jello-diagonal-1", pro:true, title: "Jello  diagonal-1", cat:"jello"},
                {val: "jello-diagonal-2", pro:true, title: "Jello  diagonal-2", cat:"jello"}
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
        anim_cat(i){
            var selected = this.cat_selected;
            if(this.anim[i].cat == selected) {
                return true;
            }
            if(selected == 'all') {
                return true;
            }
        },
    },

    style: `
    <style lang="scss" scoped>
    </style>
    `,
});
