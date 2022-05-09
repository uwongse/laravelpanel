import AppForm from '../app-components/Form/AppForm';

Vue.component('director-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                director:  '' ,
                
            }
        }
    }

});