import AppForm from '../app-components/Form/AppForm';

Vue.component('projection-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                hour:  '' ,
                release_date:  '' ,
                movie_id:  '' ,
                room_id:  '' ,
                cinema_id:  '' ,
                syncronitation_id:  '' ,
                movie: '',
                room:'',
                cinema: '',
                syncronitation:'',
            }
        }
    },
    props: [
        'movies',
        'rooms',
        'cinemas',
        'syncronitations'
    ]

});