import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Chart from 'chart.js/auto';

// Expose Chart.js for inline chart initialisation in Blade views.
window.Chart = Chart;
