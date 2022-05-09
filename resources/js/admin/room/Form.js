import AppForm from '../app-components/Form/AppForm';

Vue.component('room-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                room:  '' ,
                
            }
        }
    }

});