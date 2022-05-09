import AppForm from '../app-components/Form/AppForm';

Vue.component('syncronitation-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                result:  '' ,
                
            }
        }
    }

});