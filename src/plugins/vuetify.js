import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import es from 'vuetify/es5/locale/es';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
			themes: {
				light: {
					celeste: '#0096cb', // CELESTE
					rosa: '#bf1c7f',    // ROSA
					amarillo: '#f4e200',// AMARILLO
					negro: '#272727',   // NEGRO
					morado: '#894975',  // MORADO
					gris: '#6f7170',     // GRIS
					primary: '#0096cb', // CELESTE

				},
			},
		},

    lang:{
        locales:{ es },
        current: 'es'
    }
});
