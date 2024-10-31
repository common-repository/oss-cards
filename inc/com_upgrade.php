<li class="v_upgrade" v-on:click="upgrade=!upgrade"><i class="fas fa-star"></i></li>
<div v-if="upgrade" class="v_upgrade_screen">
    <i class="fas fa-times" v-on:click="upgrade=!upgrade"></i>
    <i class="far fa-heart"></i>
    <h1 class="vv_heading"><?php esc_html_e('Thanks for using our plugin!', 'oss-cards') ?></h1>
    <h4><?php esc_html_e('Get the version Pro to contribute the further project development. It costs just same as couple of cups of coffee', 'oss-cards') ?></h4>
    <a class="uk-button uk-button-primary" href="http://vivapro.net/oss-cards/"
       target="_blank"><?php esc_html_e('Click to upgrade for Pro!', 'oss-cards') ?></a>
</div>