import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('locationDropdowns', () => ({
    selectedRegion: '',
    selectedProvince: '',
    selectedCity: '',
    selectedBarangay: '',

    provinces: [],
    cities: [],
    barangays: [],

    isLoadingProvinces: false,
    isLoadingCities: false,
    isLoadingBarangays: false,

    init() {
        // ✅ Pull values from data-* attributes on the element
        this.selectedRegion = this.$el.dataset.initialRegion || '';
        this.selectedProvince = this.$el.dataset.initialProvince || '';
        this.selectedCity = this.$el.dataset.initialCity || '';
        this.selectedBarangay = this.$el.dataset.initialBarangay || '';

        if (this.selectedRegion) {
            this.loadProvinces(true); // true = auto-load next levels
        }
    },

    async loadProvinces(isInit = false) {
        this.resetBelow('province');
        if (!this.selectedRegion) return;

        this.isLoadingProvinces = true;
        const res = await fetch(`/provinces/${this.selectedRegion}`);
        this.provinces = await res.json();
        this.isLoadingProvinces = false;

        if (isInit && this.$el.dataset.initialProvince) {
            // Re-assign selectedProvince AFTER provinces are loaded
            this.selectedProvince = this.$el.dataset.initialProvince;
            this.loadCities(true); // load cities next
        }
    },

    async loadCities(isInit = false) {
        this.resetBelow('city');
        if (!this.selectedProvince) return;

        this.isLoadingCities = true;
        const res = await fetch(`/cities/${this.selectedProvince}`);
        this.cities = await res.json();
        this.isLoadingCities = false;

        if (isInit && this.$el.dataset.initialCity) {
            this.selectedCity = this.$el.dataset.initialCity;
            this.loadBarangays(true);
        }
    },

    async loadBarangays(isInit = false) {
        this.resetBelow('barangay');
        if (!this.selectedCity) return;

        this.isLoadingBarangays = true;
        const res = await fetch(`/barangays/${this.selectedCity}`);
        this.barangays = await res.json();
        this.isLoadingBarangays = false;

        if (isInit && this.$el.dataset.initialBarangay) {
            this.selectedBarangay = this.$el.dataset.initialBarangay;
        }
    },

    resetBelow(level) {
        if (level === 'province') {
            this.selectedProvince = '';
            this.provinces = [];
            this.resetBelow('city');
        }
        if (level === 'city') {
            this.selectedCity = '';
            this.cities = [];
            this.resetBelow('barangay');
        }
        if (level === 'barangay') {
            this.selectedBarangay = '';
            this.barangays = [];
        }
    }
}));


Alpine.start();
