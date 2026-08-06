/**
 * Mobile Chat Widget - Fixed functionality
 */

(function() {
    'use strict';
    
    let isOpen = false;
    
    function init() {
        console.log('✅ Mobile Chat: Starting...');
        
        const toggle = document.getElementById('chaty-toggle');
        const channels = document.getElementById('chaty-channels');
        
        if (!toggle || !channels) {
            console.error('❌ Mobile Chat: Elements not found');
            return;
        }
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (isOpen) {
                closeWidget();
            } else {
                openWidget();
            }
        });
        
        // Close on outside click
        document.addEventListener('click', function(e) {
            const widget = document.getElementById('chaty-widget');
            if (isOpen && widget && !widget.contains(e.target)) {
                closeWidget();
            }
        });
        
        // Channel tracking
        const channelLinks = channels.querySelectorAll('.chaty-channel');
        channelLinks.forEach(link => {
            link.addEventListener('click', function() {
                const type = this.classList[1];
                console.log('✅ Chaty: ' + type + ' clicked');
            });
        });
        
        console.log('✅ Mobile Chat: Initialized');
    }
    
    function openWidget() {
        const toggle = document.getElementById('chaty-toggle');
        const channels = document.getElementById('chaty-channels');
        
        isOpen = true;
        toggle.classList.add('active');
        toggle.innerHTML = '<i class="fas fa-times"></i>';
        channels.classList.add('open');
        channels.setAttribute('aria-hidden', 'false');
        
        console.log('✅ Mobile Chat: Opened');
    }
    
    function closeWidget() {
        const toggle = document.getElementById('chaty-toggle');
        const channels = document.getElementById('chaty-channels');
        
        isOpen = false;
        toggle.classList.remove('active');
        toggle.innerHTML = '<i class="fas fa-comments"></i>';
        channels.classList.remove('open');
        channels.setAttribute('aria-hidden', 'true');
        
        console.log('✅ Mobile Chat: Closed');
    }
    
    window.TezChaty = { openWidget, closeWidget, isOpen: () => isOpen };
    
    // Initialize
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
})();