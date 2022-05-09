import AppForm from '../app-components/Form/AppForm';

Vue.component('movie-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                title:  '' ,
                synopsis:  '' ,
                duration:  '' ,
                date:  '' ,
                trailer:  '' ,
                type:  '' ,
                premiere:  '' ,
                buy:  '' ,
                active:  false ,
                update:  false ,
                qualification: '',
                actors: '',
                directors: '',
            },
            mediaCollections: ['backgrounds','posters'],
        }
    },
    props: [
        'qualifications',
        'actors',
        'directors',
    ]

});