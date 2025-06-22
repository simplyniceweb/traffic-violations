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
        // Optional: preselect if needed
    },

    loadProvinces() {
        this.resetBelow('province');
        if (!this.selectedRegion) return;

        this.isLoadingProvinces = true;
        fetch(`/provinces/${this.selectedRegion}`)
            .then(res => res.json())
            .then(data => this.provinces = data)
            .finally(() => this.isLoadingProvinces = false);
    },

    loadCities() {
        this.resetBelow('city');
        if (!this.selectedProvince) return;

        this.isLoadingCities = true;
        fetch(`/cities/${this.selectedProvince}`)
            .then(res => res.json())
            .then(data => this.cities = data)
            .finally(() => this.isLoadingCities = false);
    },

    loadBarangays() {
        this.resetBelow('barangay');
        if (!this.selectedCity) return;

        this.isLoadingBarangays = true;
        fetch(`/barangays/${this.selectedCity}`)
            .then(res => res.json())
            .then(data => this.barangays = data)
            .finally(() => this.isLoadingBarangays = false);
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
