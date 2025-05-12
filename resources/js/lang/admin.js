import { createI18n } from 'vue-i18n';
import ar from "./translation/ar.json";


const i18n = createI18n({
    locale: 'ar', // set locale
    fallbackLocale: 'ar', // set fallback locale
    legacy:false,
    messages: {
        ar
    }
});


export default i18n;
