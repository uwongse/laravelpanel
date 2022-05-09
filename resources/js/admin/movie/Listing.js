import AppListing from '../app-components/Listing/AppListing';

Vue.component('movie-listing', {
    mixins: [AppListing],

    data() {
        return {
            showFilter: false,
            qualificationsMultiselect: {},

            filters: {
                qualifications: [],
            },
        }
    },

    watch: {
        showFilter: function (newVal, oldVal) {
            this.qualificationsMultiselect = [];
        },
        qualificationsMultiselect: function(newVal, oldVal) {
            this.filters.qualifications = newVal.map(function(object) { return object['key']; });
            this.filter('qualifications', this.filters.qualifications);
        }
    }
});