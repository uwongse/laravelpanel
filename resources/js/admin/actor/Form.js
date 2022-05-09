import AppForm from '../app-components/Form/AppForm';

Vue.component('actor-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                actor:  '' ,
                
            }
        }
    }

});