import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import es from 'vuetify/es5/locale/es';

Vue.use(Vuetify);

export default new Vuetify({
    lang:{
        locales:{ es },
        current: 'es'
    }
});
