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
  
                movie: '',
                room:'',
                cinema: '',

            }
        }
    },
    props: [
        'movies',
        'rooms',
        'cinemas',

    ]

});