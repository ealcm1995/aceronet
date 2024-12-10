document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.createElement('button');
    toggleBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
    toggleBtn.className = 'sidebar-collapse-btn';
    
    document.querySelector('.sidebar').appendChild(toggleBtn);
    
    toggleBtn.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('minimized');
        toggleBtn.querySelector('i').classList.toggle('fa-chevron-right');
        toggleBtn.querySelector('i').classList.toggle('fa-chevron-left');
    });
}); 