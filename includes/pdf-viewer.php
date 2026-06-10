<?php
// includes/pdf-viewer.php
// Inputs: $pdfId, $pdfUrl, $pdfTitle
?>
<div class="group bg-white rounded-2xl overflow-hidden shadow-2xl shadow-gray-200/60 border-[0.5px] border-[#D4D4D4] w-full max-w-[491px] h-[600px] relative">
    
    <!-- PDF Content Area -->
    <div class="w-full h-full bg-white flex justify-center items-center">
        <canvas id="pdf-canvas-<?php echo $pdfId; ?>" class="w-full h-full object-cover origin-top"></canvas>
        
        <!-- Loader -->
        <div id="pdf-loader-<?php echo $pdfId; ?>" class="absolute inset-0 flex items-center justify-center bg-white z-10">
            <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
        </div>
    </div>
    
    <!-- Hover Overlay -->
    <div class="absolute inset-0 bg-[#13273F]/50 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col sm:flex-row items-center justify-center gap-4 z-20">
        <!-- Fullscreen / Preview Icon -->
        <button type="button" data-pdf-url="<?php echo htmlspecialchars($pdfUrl); ?>" data-pdf-title="<?php echo htmlspecialchars($pdfTitle); ?>" class="open-pdf-modal bg-white text-[#13273F] px-6 py-3 rounded-xl font-semibold text-sm hover:bg-gray-100 transition-colors shadow-lg flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 duration-300 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 3H5a2 2 0 0 0-2 2v3"></path>
                <path d="M21 8V5a2 2 0 0 0-2-2h-3"></path>
                <path d="M3 16v3a2 2 0 0 0 2 2h3"></path>
                <path d="M16 21h3a2 2 0 0 0 2-2v-3"></path>
            </svg>
            Open PDF
        </button>
        <!-- Download Icon -->
        <a href="<?php echo htmlspecialchars($pdfUrl); ?>" download aria-label="Download PDF" class="bg-primary text-white px-6 py-3 rounded-xl font-semibold text-sm hover:bg-[#13273F] hover:text-white transition-colors shadow-lg flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 duration-300 delay-75">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Download
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function initPdf_<?php echo str_replace('-', '_', $pdfId); ?>() {
        if (typeof pdfjsLib !== 'undefined') {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

            const url = '<?php echo $pdfUrl; ?>';
            
            pdfjsLib.getDocument(url).promise.then(pdfDoc => {
                return pdfDoc.getPage(1);
            }).then(page => {
                const canvas = document.getElementById('pdf-canvas-<?php echo $pdfId; ?>');
                const ctx = canvas.getContext('2d');
                const container = canvas.parentElement;
                
                const unscaledViewport = page.getViewport({ scale: 1.0 });
                const renderScale = (container.clientWidth / unscaledViewport.width) * 2;
                const viewport = page.getViewport({ scale: renderScale });
                
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                
                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                
                return page.render(renderContext).promise;
            }).then(() => {
                document.getElementById('pdf-loader-<?php echo $pdfId; ?>').style.display = 'none';
            }).catch(err => {
                console.error('Error loading PDF:', err);
                document.getElementById('pdf-loader-<?php echo $pdfId; ?>').style.display = 'none';
            });
        }
    }
    
    if (typeof pdfjsLib !== 'undefined') {
        initPdf_<?php echo str_replace('-', '_', $pdfId); ?>();
    } else {
        if (!document.getElementById('pdfjs-lib-script')) {
            const script = document.createElement('script');
            script.id = 'pdfjs-lib-script';
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
            document.head.appendChild(script);
            
            script.onload = () => {
                window.dispatchEvent(new Event('pdfjsLoaded'));
            };
        }
        window.addEventListener('pdfjsLoaded', () => {
            initPdf_<?php echo str_replace('-', '_', $pdfId); ?>();
        });
    }
});
</script>

