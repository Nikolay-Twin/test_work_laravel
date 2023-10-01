import AppListing from '../app-components/Listing/AppListing';

Vue.component('user-listing', {
    mixins: [AppListing],
    data: function() {
        return {
            fieldsSearch: '',
            filters: {
                fieldsSearch: '',
            },
            filterData: null,
            arrIndex: 0,
            dataIsLoadingASD: true,
            studios: [],
            studio: '',
            searchStudios: '',
            studioSelected: '',
            customDatetimePickerConfig: {
                enableTime: true,
                time_24hr: true,
                enableSeconds: true,
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                altFormat: 'd.m.Y H:i:S',
                locale: null,
            },
            filterSearch: {
                filterSearch: 1,
                type: '',
                ref_id: '',
                mref_id: '',
                ban: '',
                verified: '',
                studio: '',
                created_at: [
                    '',
                    ''
                ],
                last_login: [
                    '',
                    ''
                ],
                balance: [
                    '',
                    ''
                ],
                birth_date: [
                    '',
                    ''
                ],
                tr_day: [
                    '',
                    ''
                ],
                kyc_approved_at: [
                    '',
                    ''
                ],
            },
        }
    },
    methods: {
        openModal(arrIndex) {
            this.studioSelected = null
            this.arrIndex = arrIndex
            this.dataIsLoadingASD = true
            this.$modal.show('user-modal')
            this.dataIsLoadingASD = false

            if(this.collection[arrIndex].studio) {
                // ищем выбранную студию присваеваем её в модель чтобы показать юзеру
                let v = this.studios
                let currentStudio = this.collection[this.arrIndex].studio ?? null
                this.studioSelected = v.find(v => v.id === currentStudio.id) ?? ''
            }
        },
        closeModal() {
            this.$modal.hide('user-modal')
        },
        getFilterData() {
            axios.get('/admin/filter_data').then((data)=> {
                this.filterData = data.data
                this.studios = data.data.studios
                this.studios.push({id: 0})
            })
        },
        getFilterResults() {
            //remove empty
            let filterSearch = this.filterSearch
            filterSearch.studio = filterSearch.studio.id ?? ''

            //пагинация и страница
            filterSearch.per_page = this.pagination.state.per_page
            filterSearch.page = this.pagination.state.current_page

            axios.get('/admin/users', {params: filterSearch}).then((data)=> {
                 this.collection = data.data.data.data
            })
        },
        saveUser(val) {
            let userSave = this.collection[this.arrIndex]

            if(this.studioSelected) {
                userSave.studio = this.studioSelected
            }

            axios.post('/admin/users/'+userSave.id, userSave).then((data)=> {
                this.getFilterResults()
                //this.collection[this.arrIndex].studio = this.studioSelected.id
            })
        },
        resetFilter() {
            this.filterSearch.type = '';
            this.filterSearch.ref_id = '';
            this.filterSearch.mref_id = '';
            this.filterSearch.ban = '';
            this.filterSearch.verified = '';
            this.filterSearch.studio = '';
            this.filterSearch.balance = ['', ''];
            this.filterSearch.created_at = ['', ''];
            this.filterSearch.last_login = ['', ''];
            this.filterSearch.birth_date = ['', ''];
            this.filterSearch.tr_day = ['', ''];
            this.getFilterResults();
        },
    },
    mounted () {
        this.pagination.state.per_page = 100
        this.getFilterData()
    },

    watch: {
        fieldsSearch: function(newVal) {
            this.filters.fieldsSearch = newVal
        },
    }
});
