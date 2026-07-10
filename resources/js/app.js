import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Chart from 'chart.js/auto';

// Expose Chart.js for inline chart initialisation in Blade views.
window.Chart = Chart;

// ID card tooling: QR generation + client-side PDF export.
import QRCode from 'qrcode';
import html2canvas from 'html2canvas';
import { jsPDF } from 'jspdf';

window.QRCode = QRCode;
window.html2canvas = html2canvas;
window.jspdf = { jsPDF };
