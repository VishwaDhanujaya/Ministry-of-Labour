<!-- Floating PDF Viewer Modal -->
<div id="pdf-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-6 opacity-0 pointer-events-none transition-all duration-300">
    <!-- Backdrop -->
    <div id="pdf-modal-backdrop" class="absolute inset-0 bg-[#13273F]/40 backdrop-blur-sm transition-opacity duration-300"></div>
    
    <!-- Modal Content Box -->
    <div id="pdf-modal-box" class="relative w-full max-w-5xl h-[85vh] bg-white rounded-2xl shadow-2xl border-[0.5px] border-[#D4D4D4] flex flex-col overflow-hidden transform scale-95 transition-all duration-300 z-10">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary/10 rounded-lg text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                        <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                        <path d="M10 9H8"/>
                        <path d="M16 13H8"/>
                        <path d="M16 17H8"/>
                    </svg>
                </div>
                <div>
                    <h3 id="pdf-modal-title" class="font-semibold font-montserrat text-gray-900 text-base md:text-lg">Document</h3>
                    <p class="text-xs font-inter text-gray-500 hidden sm:block">Ministry of Labour</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <!-- Download Inside Modal -->
                <a href="#" id="pdf-modal-download" download class="p-2.5 text-gray-500 hover:text-primary hover:bg-gray-100 rounded-xl transition-colors" title="Download PDF">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </a>
                <!-- Close Button -->
                <button id="close-modal-btn" class="p-2.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors" aria-label="Close Preview">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- PDF Iframe Container -->
        <div class="flex-1 w-full h-full bg-gray-100 relative">
            <iframe id="pdf-iframe" class="w-full h-full border-none" src=""></iframe>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('pdf-modal');
    const modalBox = document.getElementById('pdf-modal-box');
    const modalBackdrop = document.getElementById('pdf-modal-backdrop');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const iframe = document.getElementById('pdf-iframe');
    const titleElem = document.getElementById('pdf-modal-title');
    const downloadBtn = document.getElementById('pdf-modal-download');

    if (modal && closeModalBtn && iframe) {
        // Event delegation for opening modals
        document.body.addEventListener('click', function(e) {
            const btn = e.target.closest('.open-pdf-modal');
            if (btn) {
                e.preventDefault();
                const url = btn.getAttribute('data-pdf-url');
                const title = btn.getAttribute('data-pdf-title');
                
                iframe.src = url;
                if (titleElem && title) titleElem.textContent = title;
                if (downloadBtn && url) downloadBtn.href = url;
                
                // Show modal
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100');
                
                // Scale up modal box
                setTimeout(() => {
                    modalBox.classList.remove('scale-95');
                    modalBox.classList.add('scale-100');
                }, 50);
                
                // Prevent background scrolling
                document.body.style.overflow = 'hidden';
            }
        });

        function closeModal() {
            // Scale down modal box
            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-95');
            
            // Fade out modal
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0', 'pointer-events-none');
            
            // Clear iframe src to stop loading PDF
            setTimeout(() => {
                iframe.src = '';
            }, 300);
            
            // Restore background scrolling
            document.body.style.overflow = '';
        }

        closeModalBtn.addEventListener('click', closeModal);
        modalBackdrop.addEventListener('click', closeModal);
        
        // ESC key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('opacity-0')) {
                closeModal();
            }
        });
    }
});
</script>
