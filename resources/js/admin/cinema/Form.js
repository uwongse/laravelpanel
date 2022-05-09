import AppForm from '../app-components/Form/AppForm';

Vue.component('cinema-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                cinema:  '' ,
                
            }
        }
    }

});