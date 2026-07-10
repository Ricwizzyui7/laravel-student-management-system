<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Toolbar (hidden when printing) --}}
        <div class="no-print mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('students.show', $student->id) }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-blue-600 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Profile
                </a>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight mt-2">Student ID Card</h1>
                <p class="text-sm text-gray-500">Preview, print, or download the card as a PDF.</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl px-4 py-2.5 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print
                </button>
                <button type="button" id="downloadPdfBtn" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl px-4 py-2.5 shadow-sm transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span id="downloadPdfLabel">Download PDF</span>
                </button>
            </div>
        </div>

        {{-- ===================== ID CARD ===================== --}}
        {{-- Fixed pixel size = CR80 card at ~300dpi-ish ratio (1012 x 638 ≈ 3.375" x 2.125"). --}}
        <div class="print-area flex justify-center">
            <div id="idCard"
                 class="relative bg-white overflow-hidden shadow-xl"
                 style="width: 640px; height: 404px; border-radius: 18px;">

                {{-- Top band --}}
                <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-r from-blue-700 to-indigo-800"></div>
                <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full" style="background: rgba(255,255,255,0.08);"></div>
                <div class="absolute right-24 top-6 h-28 w-28 rounded-full" style="background: rgba(99,102,241,0.25); filter: blur(24px);"></div>

                {{-- Header: logo + institution --}}
                <div class="absolute top-0 left-0 right-0 h-24 px-6 flex items-center gap-3 text-white">
                    <div class="h-12 w-12 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-base font-extrabold tracking-wide uppercase">{{ $institution }}</div>
                        <div class="text-[11px] font-medium text-blue-100 tracking-widest uppercase">Student Identity Card</div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="absolute left-0 right-0 flex gap-5 px-6" style="top: 104px;">

                    {{-- Photo --}}
                    <div class="shrink-0">
                        <div class="h-36 w-28 rounded-xl bg-gray-100 border-4 border-white shadow-md overflow-hidden flex items-center justify-center ring-1 ring-gray-200">
                            @if($student->photo)
                                <img src="{{ $student->photo }}" crossorigin="anonymous" alt="{{ $student->fullname }}" class="h-full w-full object-cover">
                            @else
                                <svg class="w-12 h-12 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            @endif
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 min-w-0 pt-1">
                        <div class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">{{ $student->student_number }}</div>
                        <div class="text-xl font-extrabold text-gray-900 leading-tight mt-0.5 truncate">{{ $student->fullname }}</div>

                        <div class="mt-3 space-y-1.5">
                            <div class="flex items-baseline gap-2">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider w-20 shrink-0">Course</span>
                                <span class="text-xs font-semibold text-gray-800 truncate">{{ $student->course ?? '—' }}</span>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider w-20 shrink-0">Department</span>
                                <span class="text-xs font-semibold text-gray-800 truncate">{{ $department }}</span>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider w-20 shrink-0">Gender</span>
                                <span class="text-xs font-semibold text-gray-800">{{ ucfirst($student->gender) }}</span>
                            </div>
                            <div class="flex items-baseline gap-2">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider w-20 shrink-0">Issued</span>
                                <span class="text-xs font-semibold text-gray-800">{{ optional($issued)->format('M Y') ?? '—' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- QR --}}
                    <div class="shrink-0 flex flex-col items-center justify-start pt-1">
                        <div class="p-1.5 bg-white rounded-lg ring-1 ring-gray-200">
                            <canvas id="qrCanvas" width="96" height="96" class="block h-24 w-24"></canvas>
                        </div>
                        <div class="text-[9px] text-gray-400 mt-1 font-medium tracking-wide">SCAN TO VERIFY</div>
                    </div>
                </div>

                {{-- Footer strip --}}
                <div class="absolute inset-x-0 bottom-0 h-11 bg-gray-900 flex items-center justify-between px-6">
                    <div class="text-[10px] text-gray-300 font-medium">
                        <span class="text-gray-500 uppercase tracking-wider">Valid Thru</span>
                        <span class="ml-1 font-bold text-white">{{ optional($expiry)->format('M Y') }}</span>
                    </div>
                    <div class="text-[10px] text-gray-400 tracking-widest uppercase">Authorised Signature</div>
                </div>
            </div>
        </div>

        <p class="no-print text-center text-xs text-gray-400 mt-4">Standard CR80 card size · Optimised for print &amp; PDF export.</p>
    </div>

    @push('scripts')
    <style>
        /* Print: show only the card, centered, no browser chrome. */
        @media print {
            body * { visibility: hidden; }
            .print-area, .print-area * { visibility: visible; }
            .print-area { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; }
            .no-print { display: none !important; }
            @page { margin: 0; }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const payload = @json($qrPayload);

            // Render the QR code.
            if (window.QRCode) {
                window.QRCode.toCanvas(document.getElementById('qrCanvas'), payload, {
                    width: 96, margin: 0,
                    color: { dark: '#111827', light: '#ffffff' },
                }, function (err) { if (err) console.error(err); });
            }

            // Download the card as a PDF (client-side capture).
            const btn = document.getElementById('downloadPdfBtn');
            const label = document.getElementById('downloadPdfLabel');
            if (btn) {
                btn.addEventListener('click', async function () {
                    if (!window.html2canvas || !window.jspdf) return;
                    const original = label.textContent;
                    label.textContent = 'Generating…';
                    btn.disabled = true;
                    try {
                        const card = document.getElementById('idCard');
                        const canvas = await window.html2canvas(card, {
                            scale: 3, useCORS: true, backgroundColor: null,
                        });
                        const img = canvas.toDataURL('image/png');
                        // CR80 card: 85.6mm x 54mm.
                        const pdf = new window.jspdf.jsPDF({ orientation: 'landscape', unit: 'mm', format: [85.6, 54] });
                        pdf.addImage(img, 'PNG', 0, 0, 85.6, 54);
                        pdf.save('{{ \Illuminate\Support\Str::slug($student->fullname) }}-id-card.pdf');
                    } catch (e) {
                        console.error(e);
                        alert('Could not generate the PDF. If the photo failed to load, try again.');
                    } finally {
                        label.textContent = original;
                        btn.disabled = false;
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
