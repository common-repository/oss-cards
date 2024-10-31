
//data------------------
import anim from './build/animation.js'
import effects from './build/card-effects.js'
import icons_fa from './build/icons-fa.js'//rm
import icons_fa_cats from './build/icon-fa-categories.js'//rm
// functions -------------
import vvselect from './src/select-content-modal.js'
import com_icoms from './src/icons.js'
import { tabShow, tabVisible } from './src/nav.js'
import { addItem, del } from './src/add.js'
import { move } from './src/move.js'
import { media, delMedia } from './src/media.js'
import v_animation from './src/v-animation.js'
import v_card_style from './src/v-card-style.js'
import { editElMain, editEl, do_active_anim, active_anim , do_active_style, active_style, closeModals, activeIcon, active_tab, editNow } from './src/edit.js'
import { anim_cat_selected, pro_note1, pro_note2, ratio, circleBg, animParam, refresh, filter_fa, toString, } from './src/functions.js'
import { icon_cat_selected, icon_filter, loadMore } from './src/icon-load.js'//rm
import { icon_style, linkStyle, icon_style_box, icon_style_circle,  media_style, cardGrid, classic_title, cardbox_style, animation } from './src/style.js'
var app = new Vue({
el: '#app-cards',
    data:{ 
        rest_api_ok: true,
        rest_api_note: false,
        cards: null,
        tooltipTimer: false,
        help_item:'',
        help_ref:'',
        limit: 20, 
        img_default:'', 
        mode_item: 1,
        mode_link: 2,
        upgrade: false,
        tabs:[

            {
                elem: "main",
                title: "Add",
                tooltip: false,
                use: "uk-active",
                icon: "fas fas fa-plus",
            },
            {
                elem: "style",
                title: "Style",
                tooltip: false,
                use: false,
                icon: "fas fa-cog",
            },
            {
                elem: "icons",
                title: "Icon Style",
                tooltip: false,
                use: false,
                icon: "fab fa-fonticons",
            },
            {
                elem: "export",
                title: "Export",
                tooltip: false,
                use: false,
                icon: "fas fa-code",
            },
            {
                elem: "full",
                title: "Full Width",
                tooltip: false,
                use: false,
                icon: "fas fa-arrows-alt-h",
            },
            {
                elem: "hints",
                title: "Hints",
                tooltip: false,
                use: false,
                icon: "fas fa-info-circle",
            },
            {
                elem: "back",
                title: "Back to List",
                use: false,
                icon: "fas fa-arrow-alt-circle-left",
            },
        ],
        item:{
            edit:false,
            imgManager: false,
            img:"",
            title:"Lorem Ipsum",
            icon:"fab fa-wordpress",
            icon_show:"",
            icon_color:"",
            subtitle:"Lorem Ipsum",
            text:"Lorem Ipsum",
            link:"",
            link_text:"Read More",
            link_icon:"",
            animation:"",
            animation_on:"",
            p1:"",//confirm delay
            p2:"",//confirm install
            p3:"",
            p4:"",
            p5:"",
            p6:"",
            p7:"",
            p8:"",
            p9:"",
        },
        display:true,
        side_tab:"",
        keyword:"",
        anim_group:"",
        animation_on:0,
        panel: 1,
        show_data: 0,
        show_cards: 1,
        osti_show_data: false,
        anim_set:{//rm
            group:"all",
            options:["all","basic","bounce","scale","rotate","flip","blurred","elliptic","focus","swing","puff","tilt","tracking","roll","jello", "shadow"],
            els: anim,
        },     
        icon_fa:{
            search_cat: "all",
            search: "",
            icons: icons_fa,
            cats: icons_fa_cats,
        },
        effects: effects,
        loader: false,
        ready: true,

    },
    methods: {
        active_anim, activeIcon, active_style, active_tab, addItem, animation, animParam, anim_cat_selected, cardbox_style, cardGrid, circleBg, classic_title, closeModals, delMedia, del, do_active_anim, do_active_style, editElMain, editEl, filter_fa, icon_cat_selected, icon_style_box, icon_style_circle, icon_filter, icon_style, linkStyle, loadMore, media_style, media, move, pro_note1, pro_note2, ratio, refresh, tabShow, tabVisible, toString, editNow,
        //version 1.1.0 new functions
        mouseover(tab){
            tab.tooltip = true;
            this.tooltipTimer = false; // Reset the tooltip display
            setTimeout(() => { this.tooltipTimer = true; }, 1500);
        },
        mouseleave(tab){
            tab.tooltip = false;
        },
        help(el){
          if (this.help_item !== el) {
            this.help_item = el;
          }else{
            this.help_item = '';
          }
        },

        help_hide(){
          this.help_item = false;
        },
        viewHelpAll(){
            if (this.side_tab == 'help') {
                this.help_ref = 'main';
            }
        },
        scrollTo(el){
            // console.log("el", el);
            this.help_ref = el;
            this.$refs[el].scrollIntoView({ behavior: 'smooth'});
        },
        showHelp(el){
            if (this.help_item == el) {
                return true;
            }
            if (this.side_tab == 'help') {
                return true;
            }

        },
        rest_api_false(){
            this.rest_api_ok = false;
        },
    },
    computed: {
        iconsFiltered() {//rm
          return this.icon_fa.icons.filter((el) => {
            return el.toLowerCase().includes(this.icon_fa.search.toLowerCase());
          });
        },
        filtered_icons() {//rm
          return this.icon_set.icons.filter((el) => {
            return el.toLowerCase().includes(this.icon_set.search.toLowerCase());
          });
        },
        filteredAnimList() {
          return this.anim.filter((el) => {
            return el.value.toLowerCase().includes(this.anim_group.toLowerCase());
          });
        },
        passData() {
            let data = '';       
            if (typeof OSDATA !== 'undefined') {
                data = JSON.parse(OSDATA);
            }else{
                data = {
                    title: "", 
                    edit_mode: false, 
                    items: [], 
                    params:{
                        type: "image", 
                        card_style: "oss-effect-classic", 
                        orientation: "horizontal", 
                        grid: "uk-child-width-1-3@s", 
                        full: "", 
                        icon_size: "100", 
                        icon_color: "#0F3D58", 
                        icon_bg: "#b0bec5", 
                        icon_circle: "osc-icon-box",
                        edit: "1", 
                        border: "uk-card-default", 
                        border_color: "", 
                        card_bg: "", 
                        title_color: "", 
                        color: "", 
                        link_type: "uk-button uk-button-default", 
                        but_bg: "#D9DFEF", 
                        link_color: "", 
                        toggle_sidebar: "", 
                        animation: "uk-animation-fade", 
                        title_effect: "osc-text-tactile", 
                        ratio: "oss-ratio-3-2", 
                        circle_bg: "", 
                        text_align: "oss-text-left",  
                        activ_anim: 0, 
                        activ_style: 0, 
                        style_card:"", 
                        style_icon:"", 
                        style_icon_box:"", 
                        style_icon_circle:"", 
                        style_grid:"",  
                        style_link:"",   
                        p1:"osc-icon-box-span", 
                        p2:"", 
                        p3:"", 
                        p4:"", 
                        p5:"", 
                        p6:"", 
                        p7:"",
                    }
                };   
            }
          return data;
        },
        defaultData() {
            let data = '';       
            if (typeof OSDEFAULT !== 'undefined') {
                data = OSDEFAULT;  
            }
          return data;
        },
    },
    created() {
        //card data if mode edit
        this.cards = this.passData; 
        //default data if set
        if (this.defaultData) {
            this.item.link_text = this.defaultData.read_more; 
            this.limit = this.defaultData.length;  
        }   
      },
})
