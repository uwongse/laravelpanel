import AppForm from '../app-components/Form/AppForm';

Vue.component('slide-form', {
    mixins: [AppForm],
    
    data: function() {
        return {
            form: {
                title:  '' ,
                url:  '' ,
                active:  false ,
                updated:  '' ,
            },
            mediaCollections: ['cover']
        }
    }
    

});
