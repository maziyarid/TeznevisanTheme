/**
 * Accessibility Widget - Mobile-Friendly & Touch-Ready
 * WCAG AA Compliant with proper ARIA support
 */
(function($) {
    'use strict';
    
    class TeznevisanAccessibility {
        constructor() {
            this.settings = this.loadSettings();
            this.isMobile = window.innerWidth <= 768;
            this.isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0; this.init(); this.bindEvents(); this.applySettings(); }
             init() {
     this.widget = $('#accessibility-widget');
     this.toggle = $('#accessibility-toggle');
     this.panel = $('#accessibility-panel');
     this.closeBtn = $('#accessibility-close, .accessibility-close-fixed');
     
     if (!this.widget.length) {
         console.warn('Accessibility widget not found in DOM');
         return;
     }
     
     this.isOpen = false;
     this.setupAriaAttributes();
     this.makeMobileFriendly();
     this.createAnnouncer();
 }
 
 setupAriaAttributes() {
     // Fix missing ARIA labels that cause axe issues
     this.toggle.attr({
         'role': 'button',
         'tabindex': '0',
         'aria-expanded': 'false',
         'aria-controls': 'accessibility-panel',
         'aria-label': 'باز کردن پنل تنظیمات دسترسی'
     });
     
     this.panel.attr({
         'role': 'dialog',
         'aria-modal': 'false',
         'aria-hidden': 'true',
         'aria-labelledby': 'accessibility-panel-title'
     });
     
     // Add proper labels to control buttons
     $('#font-increase').attr('aria-label', 'افزایش اندازه فونت');
     $('#font-decrease').attr('aria-label', 'کاهش اندازه فونت');
     $('#font-reset').attr('aria-label', 'بازنشانی اندازه فونت');
     $('#reading-guide').attr('aria-label', 'فعال/غیرفعال کردن راهنمای خواندن');
     $('#focus-mode').attr('aria-label', 'فعال/غیرفعال کردن حالت تمرکز');
     $('#reset-all').attr('aria-label', 'بازنشانی همه تنظیمات دسترسی');
     
     // Theme buttons
     $('.theme-btn-fixed').each(function() {
         const theme = $(this).data('theme');
         const labels = {
             'light': 'تم روشن',
             'dark': 'تم تیره',
             'sepia': 'تم کاغذی',
             'contrast': 'تم کنتراست بالا'
         };
         $(this).attr('aria-label', labels[theme] || theme);
     });
     
     // Add title to panel if missing
     if (!$('#accessibility-panel-title').length) {
         this.panel.prepend('<h3 id="accessibility-panel-title" class="sr-only">پنل تنظیمات دسترسی</h3>');
     }
 }
 
 makeMobileFriendly() {
     if (this.isMobile || this.isTouch) {
         // Increase touch targets
         this.toggle.css({
             'min-width': '60px',
             'min-height': '60px',
             'touch-action': 'manipulation'
         });
         
         // Make panel more mobile-friendly
         this.panel.css({
             'max-width': 'calc(100vw - 20px)',
             'max-height': '80vh'
         });
         
         // Add mobile-specific classes
         this.widget.addClass('accessibility-mobile');
         
         // Adjust positioning for mobile
         if (this.isMobile) {
             this.widget.css({
                 'bottom': '20px',
                 'top': 'auto',
                 'transform': 'none'
             });
             
             this.panel.css({
                 'top': 'auto',
                 'bottom': '70px',
                 'transform': 'scale(0.8)'
             });
         }
     }
 }
 
 createAnnouncer() {
     if (!$('#accessibility-announcer').length) {
         $('<div>', {
             id: 'accessibility-announcer',
             'aria-live': 'polite',
             'aria-atomic': 'true',
             class: 'sr-only'
         }).appendTo('body');
     }
 }
 
 bindEvents() {
     // Toggle panel - handle both click and touch
     this.toggle.on('click touchend', (e) => {
         e.preventDefault();
         if (e.type === 'touchend') {
             e.stopPropagation();
         }
         this.togglePanel();
     });
     
     // Keyboard support for toggle
     this.toggle.on('keydown', (e) => {
         if (e.key === 'Enter' || e.key === ' ') {
             e.preventDefault();
             this.togglePanel();
         }
     });
     
     // Close button
     this.closeBtn.on('click touchend', (e) => {
         e.preventDefault();
         this.closePanel();
     });
     
     // Theme buttons
     $('.theme-btn-fixed').on('click touchend', (e) => {
         e.preventDefault();
         const theme = $(e.currentTarget).data('theme');
         this.setTheme(theme);
     });
     
     // Font size controls
     $('#font-increase').on('click touchend', (e) => {
         e.preventDefault();
         this.adjustFontSize(2);
     });
     
     $('#font-decrease').on('click touchend', (e) => {
         e.preventDefault();
         this.adjustFontSize(-2);
     });
     
     $('#font-reset').on('click touchend', (e) => {
         e.preventDefault();
         this.resetFontSize();
     });
     
     // Accessibility tools
     $('#reading-guide').on('click touchend', (e) => {
         e.preventDefault();
         this.toggleReadingGuide();
     });
     
     $('#focus-mode').on('click touchend', (e) => {
         e.preventDefault();
         this.toggleFocusMode();
     });
     
     $('#reset-all').on('click touchend', (e) => {
         e.preventDefault();
         this.resetAll();
     });
     
     // Keyboard navigation
     this.setupKeyboardNavigation();
     
     // Touch-friendly interactions
     if (this.isTouch) {
         this.setupTouchInteractions();
     }
     
     // Close on outside click/touch
     $(document).on('click touchstart', (e) => {
         if (this.isOpen && !this.widget.is(e.target) && this.widget.has(e.target).length === 0) {
             this.closePanel();
         }
     });
     
     // Window resize handler
     $(window).on('resize orientationchange', () => {
         this.handleResize();
     });
 }
 
 setupKeyboardNavigation() {
     // ESC key to close
     $(document).on('keydown', (e) => {
         if (e.key === 'Escape' && this.isOpen) {
             this.closePanel();
         }
     });
     
     // Focus trap
     this.panel.on('keydown', (e) => {
         if (e.key === 'Tab') {
             this.trapFocus(e);
         }
     });
     
     // Arrow key navigation for theme buttons
     $('.theme-btn-fixed').on('keydown', (e) => {
         if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
             e.preventDefault();
             const buttons = $('.theme-btn-fixed');
             const current = buttons.index(e.target);
             const next = e.key === 'ArrowRight' ? 
                 (current + 1) % buttons.length : 
                 (current - 1 + buttons.length) % buttons.length;
             buttons.eq(next).focus();
         }
     });
 }
 
 setupTouchInteractions() {
     // Prevent double-tap zoom on buttons
     $('.theme-btn-fixed, .font-btn-fixed, .feature-btn-fixed, .reset-btn-fixed').css('touch-action', 'manipulation');
     
     // Add haptic feedback simulation for touch
     $('.theme-btn-fixed, .font-btn-fixed, .feature-btn-fixed, .reset-btn-fixed').on('touchstart', function() {
         $(this).addClass('touch-active');
     }).on('touchend touchcancel', function() {
         $(this).removeClass('touch-active');
     });
 }
 
 trapFocus(e) {
     const focusableElements = this.panel.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
     const firstFocusable = focusableElements.first();
     const lastFocusable = focusableElements.last();
     
     if (e.shiftKey) {
         if (document.activeElement === firstFocusable[0]) {
             e.preventDefault();
             lastFocusable.focus();
         }
     } else {
         if (document.activeElement === lastFocusable[0]) {
             e.preventDefault();
             firstFocusable.focus();
         }
     }
 }
 
 togglePanel() {
     if (this.isOpen) {
         this.closePanel();
     } else {
         this.openPanel();
     }
 }
 
 openPanel() {
     this.panel.addClass('open').attr('aria-hidden', 'false');
     this.toggle.attr('aria-expanded', 'true').addClass('active');
     this.isOpen = true;
     
     // Mobile-specific adjustments
     if (this.isMobile) {
         $('body').addClass('accessibility-panel-open');
         this.panel.css('transform', 'scale(1)');
     }
     
     // Focus management
     setTimeout(() => {
         const firstButton = this.panel.find('button:visible:first');
         if (firstButton.length) {
             firstButton.focus(); } }, this.isMobile ? 300 : 100);
                     this.announce('پنل دسترسی باز شد');
    }
    
    closePanel() {
        this.panel.removeClass('open').attr('aria-hidden', 'true');
        this.toggle.attr('aria-expanded', 'false').removeClass('active');
        this.isOpen = false;
        
        // Mobile-specific cleanup
        if (this.isMobile) {
            $('body').removeClass('accessibility-panel-open');
            this.panel.css('transform', 'scale(0.8)');
        }
        
        // Return focus to toggle
        this.toggle.focus();
        
        this.announce('پنل دسترسی بسته شد');
    }
    
    setTheme(theme) {
        // Remove previous theme classes
        $('body, html').removeClass('theme-light theme-dark theme-sepia theme-contrast');
        
        // Add new theme
        $('body, html').addClass(`theme-${theme}`).attr('data-theme', theme);
        
        // Update button states
        $('.theme-btn-fixed').removeClass('active-fixed').attr('aria-pressed', 'false');
        $(`.theme-btn-fixed[data-theme="${theme}"]`).addClass('active-fixed').attr('aria-pressed', 'true');
        
        this.settings.theme = theme;
        this.saveSettings();
        
        const themeLabels = {
            'light': 'روشن',
            'dark': 'تیره',
            'sepia': 'کاغذی',
            'contrast': 'کنتراست بالا'
        };
        
        this.announce(`تم ${themeLabels[theme]} فعال شد`);
    }
    
    adjustFontSize(delta) {
        const newSize = Math.max(12, Math.min(24, this.settings.fontSize + delta));
        
        if (newSize !== this.settings.fontSize) {
            this.settings.fontSize = newSize;
            this.applyFontSize();
            this.announce(`اندازه فونت: ${newSize} پیکسل`);
        }
    }
    
    resetFontSize() {
        this.settings.fontSize = 16;
        this.applyFontSize();
        this.announce('اندازه فونت به حالت عادی بازگشت');
    }
    
    applyFontSize() {
        const size = this.settings.fontSize;
        
        // Apply to body
        $('body').css('font-size', `${size}px`);
        
        // Apply size class for better control
        $('body').removeClass('font-size-small font-size-large font-size-xlarge');
        
        if (size <= 14) {
            $('body').addClass('font-size-small');
        } else if (size >= 18 && size < 22) {
            $('body').addClass('font-size-large');
        } else if (size >= 22) {
            $('body').addClass('font-size-xlarge');
        }
        
        this.saveSettings();
    }
    
    toggleReadingGuide() {
        this.settings.readingGuide = !this.settings.readingGuide;
        
        let $guide = $('#reading-guide-line');
        if (!$guide.length) {
            $guide = $('<div id="reading-guide-line" class="reading-guide-line-fixed"></div>').appendTo('body');
        }
        
        if (this.settings.readingGuide) {
            $guide.show();
            $('#reading-guide').addClass('active-fixed').attr('aria-pressed', 'true');
            $('body').addClass('reading-guide-active');
            
            // Setup mouse tracking
            $(document).on('mousemove.readingguide', (e) => {
                $guide.css('top', `${e.clientY}px`);
            });
            
            this.announce('راهنمای خواندن فعال شد');
        } else {
            $guide.hide();
            $('#reading-guide').removeClass('active-fixed').attr('aria-pressed', 'false');
            $('body').removeClass('reading-guide-active');
            
            // Remove mouse tracking
            $(document).off('mousemove.readingguide');
            
            this.announce('راهنمای خواندن غیرفعال شد');
        }
        
        this.saveSettings();
    }
    
    toggleFocusMode() {
        this.settings.focusMode = !this.settings.focusMode;
        
        if (this.settings.focusMode) {
            $('body').addClass('focus-mode');
            $('#focus-mode').addClass('active-fixed').attr('aria-pressed', 'true');
            this.announce('حالت تمرکز فعال شد');
        } else {
            $('body').removeClass('focus-mode');
            $('#focus-mode').removeClass('active-fixed').attr('aria-pressed', 'false');
            this.announce('حالت تمرکز غیرفعال شد');
        }
        
        this.saveSettings();
    }
    
    resetAll() {
        // Reset all settings
        this.settings = {
            theme: 'light',
            fontSize: 16,
            readingGuide: false,
            focusMode: false
        };
        
        // Apply defaults
        this.setTheme('light');
        this.applyFontSize();
        
        if ($('#reading-guide').hasClass('active-fixed')) {
            this.toggleReadingGuide();
        }
        
        if ($('#focus-mode').hasClass('active-fixed')) {
            this.toggleFocusMode();
        }
        
        // Clear storage
        this.saveSettings();
        
        this.announce('همه تنظیمات دسترسی بازنشانی شد');
    }
    
    handleResize() {
        const wasMobile = this.isMobile;
        this.isMobile = window.innerWidth <= 768;
        
        if (wasMobile !== this.isMobile) {
            // Re-apply mobile-friendly adjustments
            this.makeMobileFriendly();
            
            // Close panel on orientation change if open
            if (this.isOpen) {
                this.closePanel();
            }
        }
    }
    
    applySettings() {
        // Apply saved settings
        if (this.settings.theme) {
            this.setTheme(this.settings.theme);
        }
        
        if (this.settings.fontSize !== 16) {
            this.applyFontSize();
        }
        
        if (this.settings.readingGuide) {
            this.toggleReadingGuide();
        }
        
        if (this.settings.focusMode) {
            this.toggleFocusMode();
        }
    }
    
    saveSettings() {
        try {
            localStorage.setItem('teznevisan_accessibility', JSON.stringify(this.settings));
        } catch (e) {
            console.warn('Could not save accessibility settings:', e);
        }
    }
    
    loadSettings() {
        try {
            const saved = localStorage.getItem('teznevisan_accessibility');
            if (saved) {
                return Object.assign({
                    theme: 'light',
                    fontSize: 16,
                    readingGuide: false,
                    focusMode: false
                }, JSON.parse(saved));
            }
        } catch (e) {
            console.warn('Could not load accessibility settings:', e);
        }
        
        return {
            theme: 'light',
            fontSize: 16,
            readingGuide: false,
            focusMode: false
        };
    }
    
    announce(message) {
        const announcer = $('#accessibility-announcer');
        if (announcer.length) {
            // Clear and set new message
            announcer.empty();
            setTimeout(() => {
                announcer.text(message);
            }, 100);
        }
    }
}

// Initialize when DOM is ready
$(document).ready(() => {
    // Wait for theme initialization
    setTimeout(() => {
        if (typeof window.TeznevisanAccessibility === 'undefined') {
            window.TeznevisanAccessibility = new TeznevisanAccessibility();
        }
    }, 500);
});
})(jQuery);