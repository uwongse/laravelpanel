import AppForm from '../app-components/Form/AppForm';

Vue.component('qualification-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                qualification:  '' ,
                abbreviation:  '' ,
                image:  '' ,
                
            }
        }
    }

});