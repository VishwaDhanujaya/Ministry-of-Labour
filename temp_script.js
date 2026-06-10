
function showPreviewModal(id, title, editUrl, deleteUrl) {
    document.getElementById('preview-title').textContent = title;
    document.getElementById('preview-content-container').innerHTML = document.getElementById('preview-content-' + id).innerHTML;
    document.getElementById('preview-edit-btn').href = editUrl;
    document.getElementById('preview-delete-btn').href = deleteUrl;
    
    const modal = document.getElementById('preview-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    void modal.offsetWidth; // trigger reflow
    modal.classList.remove('opacity-0');
    modalBox.classList.remove('scale-95');
    modalBox.classList.add('scale-100');
}

function hidePreviewModal() {
    const modal = document.getElementById('preview-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.add('opacity-0');
    modalBox.classList.remove('scale-100');
    modalBox.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

