<div class="os-tabs os-tabs-left-fixed">
    <ul class="oci-tab uk-tab-left uk-tab">
        <li v-if="tabVisible(index)" v-for="(tab, index) in tabs" :key="index" :class="[tab.elem, tab.use]"
            v-on:click="tabShow(index)" v-on:mouseover="mouseover(tab)" v-on:mouseleave="mouseleave(tab)">
            <i :class="tab.icon"></i>
            <span v-if="tooltipTimer && tab.tooltip" class="vv_side_tooltip">{{tab.title}}</span>
        </li>
        <li v-if="!rest_api_ok" class="v-rest-note" v-on:click="rest_api_note=!rest_api_note">
            <i class="fas fa-info"></i>
        </li>
        <?php include 'com_upgrade.php' ?>
    </ul>
</div>
<aside class="oss-menu-form oss_sidebar_over_wp_sidebar">
    <ul class="oci-tabs-content">
        <transition-group name="slideL">
            <li v-if="tab.use" v-for="(tab, index) in tabs" :key="index">
                <!-- MAIN ADD -->
                <template v-if="tab.elem=='main'">
                    <h3><?php esc_html_e('Add') ?></h3>
                    <vv-content-modal v-if="rest_api_ok" :item="item" :limit="limit"
                                      :mode="mode_item"></vv-content-modal>
                    <template v-if="cards.params.type=='image'">
                        <div class="oss_media">
                            <label for="oci-form_image"><?php esc_html_e('Image') ?></label>
                            <img v-if="item.img" :src="item.img" alt="">
                            <input type="text" v-model="item.img"/>
                            <div class="oss_double_but">
                                <span class="oss_select" v-on:click="media(1)">Select</span>
                                <span class="oss_del" v-on:click="delMedia(1)"><i class="fas fa-times"></i></span>
                            </div>
                        </div>
                    </template>
                    <template v-if="cards.params.type=='icon'">
                        <vv-icons :output="item.icon" v-on:update:output="item.icon = $event"></vv-icons>
                    </template>
                    <label for=""><?php esc_html_e('Title') ?></label>
                    <input id="oci-form_title" type="text" v-model="item.title" placeholder="Title">
                    <template v-if="cards.params.card_style!=='oss-effect-classic'">
                        <label for="oci-form_subtitle"><?php esc_html_e('Subtitle', 'oss-cards') ?></label>
                        <input id="oci-form_subtitle" type="text" v-model="item.subtitle" placeholder="optionally...">
                    </template>
                    <label for=""><?php esc_html_e('Description') ?></label>
                    <textarea id="oci-form_text" rows="3" v-model="item.text"></textarea>
                    <label for="oci-form_link"><?php esc_html_e('Url') ?> <span
                                class="osc_note_span">(<?php esc_html_e('Leave empty if no need', 'oss-cards') ?>
                            )</span></label>
                    <div class="vv_url">
                        <input id="oci-form_link" type="text" v-model="item.link">
                        <vv-content-modal v-if="rest_api_ok" :item="item" :limit="limit"
                                          :mode="mode_link"></vv-content-modal>
                    </div>
                    <label><?php esc_html_e('Link') ?><?php esc_html_e('Text') ?></label>
                    <input type="text" v-model="item.link_text">
                    <span class="osci_but" v-on:click="addItem()">Add Item</span>
                </template>
                <!-- STYLE -->
                <template v-if="tab.elem=='style'">
                    <h3><?php esc_html_e('Card Style', 'oss-cards') ?></h3>
                    <v-animation :val="cards.params.animation"
                                 v-on:update:val="cards.params.animation = $event"></v-animation>
                    <template v-if="cards.params.type=='image'">
                        <v-card-style :val="cards.params.card_style"
                                      v-on:update:val="cards.params.card_style = $event"></v-card-style>
                        <template v-if="cards.params.card_style=='oss-effect-circle'">
                            <label for=""><?php esc_html_e('Top Background', 'oss-cards') ?></label>
                            <div class="osi-colorpicker" :style="{background: cards.params.circle_bg}">
                                <colorpicker :color="cards.params.circle_bg" v-model="cards.params.circle_bg"/>
                            </div>
                        </template>
                        <template v-if="cards.params.card_style!=='oss-effect-circle'">
                            <label for="st-ratio"><?php esc_html_e('Image Ratio', 'oss-cards') ?></label>
                            <select id="st-ratio" v-model="cards.params.ratio" v-on:change="ratio()">
                                <option value="oss-ratio-3-2">3-2(most used)</option>
                                <option value="oss-ratio-16-9">16-9</option>
                                <option value="oss-ratio-18-6">18-6</option>
                                <option value="oss-ratio-4-3">4-3</option>
                                <option value="oss-ratio-1">1-1(only if images are square or portrait)</option>
                                <option value="oss-ratio-3-4">3-4(only if images are portrait orientation)</option>
                                <option value="def">No Ratio, As Is(not recomended)</option>
                            </select>
                        </template>
                    </template>
                    <label for="st-title_effect"><?php esc_html_e('Card ', 'oss-cards') . esc_html_e('Style') ?></label>
                    <div class="os_ui_box">
                        <label for="st-title_effect"><?php esc_html_e('Title') ?><?php esc_html_e('Style') ?></label>
                        <select id="st-title_effect" v-model="cards.params.title_effect">
                            <option value="">No Style</option>
                            <option value="osc-text-tactile">Tactile</option>
                            <option value="osc-text-flame">Blue Flame</option>
                            <option value="osc-text-neon">Neon</option>
                            <option value="osc-text-vegas">Vegas</option>
                            <option value="osc-text-fire">Fire</option>
                            <option value="osc-text-shadow">Simple Shadow</option>
                            <option value="osc-text-inset">Inset</option>
                            <option value="osc-text-blur">Blur</option>
                            <option value="osc-text-deep">Deep</option>
                            <option value="osc-text-grave">Grave</option>
                            <option value="osc-text-simple3d">Simple 3d</option>
                            <option value="osc-text-realistic3d">Realistic 3d</option>
                        </select>
                        <label for="st-border_color"><?php esc_html_e('Border') ?></label>
                        <select id="st-border_color'" v-model="cards.params.border">
                            <option value="osc-depth-0">No Border</option>
                            <option value="os-border-solid">Simple Border</option>
                            <option value="os-border-round">Rounded</option>
                            <option value="os-border-round-big">Rounded Big</option>
                            <option value="uk-card-default">Soft Shadow</option>
                            <option value="osc-depth-05">Shadow Depth-0.5</option>
                            <option value="osc-depth-1">Shadow Depth-1</option>
                            <option value="osc-depth-2">Shadow Depth-2</option>
                            <option value="osc-depth-3">Shadow Depth-3</option>
                            <option value="osc-depth-4">Shadow Depth-4</option>
                            <option value="osc-depth-5">Shadow Depth-5</option>
                        </select>
                        <template
                                v-if="cards.params.border=='os-border-solid' ||cards.params.border=='os-border-round' ||cards.params.border=='os-border-round-big'">
                            <label><?php esc_html_e('Border') ?><?php esc_html_e('Color') ?></label>
                            <div class="osi-colorpicker" :style="{background: cards.params.border_color}">
                                <colorpicker :color="cards.params.border_color" v-model="cards.params.border_color"/>
                            </div>
                        </template>
                        <label><?php esc_html_e('Title') ?><?php esc_html_e('Color') ?></label>
                        <div class="osi-colorpicker" :style="{background: cards.params.title_color}">
                            <colorpicker :color="cards.params.title_color" v-model="cards.params.title_color"/>
                        </div>
                        <label><?php esc_html_e('Background') ?></label>
                        <div class="osi-colorpicker" :style="{background: cards.params.card_bg}">
                            <colorpicker :color="cards.params.card_bg" v-model="cards.params.card_bg"/>
                        </div>
                        <label><?php esc_html_e('Color') ?></label>
                        <div class="osi-colorpicker" :style="{background: cards.params.color}">
                            <colorpicker :color="cards.params.color" v-model="cards.params.color"/>
                        </div>
                    </div>
                    <label><?php esc_html_e('Link') ?></label>
                    <div class="os_ui_box">
                        <label><?php esc_html_e('Type') ?></label>
                        <select id="st-link_type" v-model="cards.params.link_type">
                            <option value="uk-button uk-button-default">Button</option>
                            <option value="uk-button uk-button-link">Text</option>
                            <option value="whole-card">Whole Card</option>
                        </select>
                        <template v-if="cards.params.link_type=='uk-button uk-button-default'">
                            <label for="oci-form_button_bg"><?php esc_html_e('Button') ?><?php esc_html_e('Background') ?></label>
                            <div class="osi-colorpicker" :style="{background: cards.params.but_bg}">
                                <colorpicker :color="cards.params.but_bg" v-model="cards.params.but_bg"/>
                            </div>
                        </template>
                        <template v-if="cards.params.link_type!=='whole-card'">
                            <label><?php esc_html_e('Link') ?><?php esc_html_e('Color') ?></label>
                            <div class="osi-colorpicker" :style="{background: cards.params.link_color}">
                                <colorpicker :color="cards.params.link_color" v-model="cards.params.link_color"/>
                            </div>
                        </template>
                    </div>
                    <label for="st-text_align"><?php esc_html_e('Text') ?><?php esc_html_e('Align') ?></label>
                    <select id="st-text_align'" v-model="cards.params.text_align">
                        <option value="oss-text-left">left</option>
                        <option value="oss-text-right">right</option>
                        <option value="oss-text-center">center</option>
                    </select>
                </template>
                <!-- ICON STYLE -->
                <template v-if="tab.elem=='icons'">
                    <h3><?php esc_html_e('Icon Box Settings', 'oss-cards') ?></h3>
                    <label for="st-icon_size"><?php esc_html_e('Icon Size', 'oss-cards') ?> -
                        {{cards.params.icon_size}}px</label>
                    <input id="st-icon_size" type="range" min="60" max="250" step="1" v-model="cards.params.icon_size">
                    <label for="st-icon-style"><?php esc_html_e('Icon Style', 'oss-cards') ?></label>
                    <select name="st-icon-style" id="st-icon-style" v-model="cards.params.icon_circle">
                        <option value="osc-icon-box">Box</option>
                        <option value="osc-icon-circle">Circle</option>
                        <option value="osc-icon-rounded">Rounded</option>
                    </select>
                    <p v-if="cards.params.icon_circle=='osc-icon-circle'"
                       class="osc_note"><?php esc_html_e('Note: Using this style don not use wide or non symmetrical icons or it will be used not balanced or even outside the circle', 'oss-cards') ?></p>
                    <label><?php esc_html_e('Icon Background', 'oss-cards') ?></label>
                    <div class="osi-colorpicker" :style="{background: cards.params.icon_bg}">
                        <colorpicker :color="cards.params.icon_bg" v-model="cards.params.icon_bg"/>
                    </div>
                    <label><?php esc_html_e('Icon Color', 'oss-cards') ?></label>
                    <div class="osi-colorpicker" :style="{background: cards.params.icon_color}">
                        <colorpicker :color="cards.params.icon_color" v-model="cards.params.icon_color"/>
                    </div>
                </template>
                <!-- EXPORT    -->
                <template v-if="tab.elem=='export'">
                    <h3><?php esc_html_e('Data Code', 'oss-cards') ?></h3>
                    <p><?php esc_html_e('Data for export, or for debugging(send to support)', 'oss-cards') ?></p>
                </template>
                <!-- SIDEBAR -->
                <template v-if="tab.elem=='sidebar'">
                    <p><?php esc_html_e('If sidebar not displaying click icon cog top right', 'oss-cards') ?></p>
                </template>
                <!-- HINTS -->
                <template v-if="tab.elem=='hints'">
                    <h3><?php esc_html_e('Help') ?></h3>
                </template>
            </li>
        </transition-group>
    </ul>
</aside>
<!-- edit panels -->
<transition-group name="fade">
    <aside class="oci-card-edit-panel oss_sidebar_over_wp_sidebar" v-if="el.edit" v-for="(el, index) in cards.items"
           :key="index">
        <h3><?php esc_html_e('Edit') ?> {{el.title}}</h3>
        <vv-content-modal v-if="rest_api_ok" :item="el" :limit="limit" :mode="mode_item"></vv-content-modal>
        <template v-if="cards.params.type=='image'">
            <div class="oss_media">
                <label for="oci-form_image"><?php esc_html_e('Image') ?></label>
                <img v-if="item.img" :src="el.img" alt="">
                <input type="text" v-model="el.img"/>
                <div class="oss_double_but">
                    <span class="oss_select" v-on:click="media(2,index)">Select</span>
                    <span class="oss_del" v-on:click="delMedia(2,index)"><i class="fas fa-times"></i></span>
                </div>
            </div>
        </template>
        <template v-if="cards.params.type=='icon'">
            <vv-icons :output="el.icon" v-on:update:output="el.icon = $event"></vv-icons>
        </template>
        </template>
        <label for="oci-form_title"><?php esc_html_e('Title') ?></label>
        <input id="oci-form_title" type="text" v-model="el.title" placeholder="Title">
        <template v-if="cards.params.card_style!=='oss-effect-classic'">
            <label for="oci-form_subtitle"><?php esc_html_e('Subtitle', 'oss-cards') ?></label>
            <input id="oci-form_subtitle" type="text" v-model="el.subtitle" placeholder="optionally...">
        </template>
        <label for="oci-form_text"><?php esc_html_e('Description') ?></label>
        <textarea id="oci-form_text" rows="3" v-model="el.text"></textarea>
        <label for="oci-form_link"><?php esc_html_e('Link Url', 'oss-cards') ?></label>
        <p class="osc_note"><?php esc_html_e('Leave empty if no need', 'oss-cards') ?></p>
        <div class="vv_url">
            <input id="oci-form_link" type="text" v-model="el.link" placeholder="https://">
            <vv-content-modal v-if="rest_api_ok" :item="item" :limit="limit" :mode="mode_link"></vv-content-modal>
        </div>
        <label><?php esc_html_e('Link Text', 'oss-cards') ?></label>
        <input id="oci-form_link" type="text" v-model="el.link_text">
    </aside>
</transition-group>
<div id="oss_leave_page">
    <p><?php esc_html_e('Are you sure you want to leave page?', 'oss-cards') ?>
        <br>
        <?php esc_html_e('All not saved changes will be lost!', 'oss-cards') ?></p>
    <span class="uk-button uk-button-default"><?php esc_html_e('Cancel', 'oss-cards') ?></span>
    <a href="edit.php?post_type=oss_cards"
       class="uk-button uk-button-primary"><?php esc_html_e('Leave', 'oss-cards') ?></a>
</div>