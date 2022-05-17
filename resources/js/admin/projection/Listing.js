import AppListing from '../app-components/Listing/AppListing';

Vue.component('projection-listing', {
    mixins: [AppListing],

    data() {
        return {
            showAuthorsFilter: false,
            authorsMultiselect: {},
            showAuthorsFilter2: false,
            authorsMultiselect2: {},
            showAuthorsFilter3: false,
            authorsMultiselect3: {},
            showAuthorsFilter4: false,
            authorsMultiselect4: {},
            filters: {
                movies: [],
                rooms: [],
                cinemas: [],

            },
        }
    },

    watch: {
        showAuthorsFilter: function (newVal, oldVal) {
            this.authorsMultiselect = [];
        },
        authorsMultiselect: function(newVal, oldVal) {
            this.filters.movies = newVal.map(function(object) { return object['key']; });
            this.filter('movies', this.filters.movies);
        },
        showAuthorsFilter2: function (newVal, oldVal) {
            this.authorsMultiselect2 = [];
        },
        authorsMultiselect2: function(newVal, oldVal) {
            this.filters.rooms = newVal.map(function(object) { return object['key']; });
            this.filter('rooms', this.filters.rooms);
        },
        showAuthorsFilter3: function (newVal, oldVal) {
            this.authorsMultiselect3 = [];
        },
        authorsMultiselect3: function(newVal, oldVal) {
            this.filters.cinemas = newVal.map(function(object) { return object['key']; });
            this.filter('cinemas', this.filters.cinemas);
        }, showAuthorsFilter4: function (newVal, oldVal) {
            this.authorsMultiselect4 = [];
        },
        
    }
});