export default Vue.component('v-tip', {
  props: ['val'],
  template: `
    <span class="v_tip">
        <i class="fas fa-question-circle vv_icon"></i>
         <div v-if="selected">
            {{val}}
         </div>        
    </span>
  `,
    data: function () {
        return { 
            open: false,
            selected: true,
            active: '',
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
