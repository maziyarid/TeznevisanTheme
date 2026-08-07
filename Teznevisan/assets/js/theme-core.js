/**
 * Teznevisan Core JavaScript - COMPLETE WITH CHATY
 */

(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Teznevisan Theme Loaded!');
        
        initThemeMode();
        initMobileMenu();
        initSearch();
        initScrollToTop();
        initChaty();
        initFAQ();
        initAccessibility();
        initScrollAnimations();
    });
    
    /**
     * Theme Mode Toggle
     */
    function initThemeMode() {
        const modeButtons = document.querySelectorAll('.mode-btn');
        const savedTheme = localStorage.getItem('theme') || 'light';
        
        document.documentElement.setAttribute('data-theme', savedTheme);
        modeButtons.forEach(btn => {
            if (btn.dataset.theme === savedTheme) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
        
        modeButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const theme = this.dataset.theme;
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                
                modeButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }
    
    /**
     * Mobile Menu
     */
    function initMobileMenu() {
        const toggle = document.querySelector('.mobile-menu-toggle');
        const menu = document.querySelector('.mobile-menu');
        const close = document.querySelector('.mobile-menu-close');
        const submenuToggles = document.querySelectorAll('.submenu-toggle');
        
        if (!toggle || !menu) return;
        
        toggle.addEventListener('click', () => {
            menu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        if (close) {
            close.addEventListener('click', () => {
                menu.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
        
        submenuToggles.forEach(btn => {
            btn.addEventListener('click', function() {
                const parent = this.closest('.has-submenu');
                const submenu = this.nextElementSibling;
                
                parent.classList.toggle('active');
                submenu.classList.toggle('active');
            });
        });
        
        menu.addEventListener('click', (e) => {
            if (e.target === menu) {
                menu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
    
    /**
     * Search Toggle
     */
    function initSearch() {
        const toggle = document.querySelector('.search-toggle');
        const overlay = document.querySelector('.fullscreen-search');
        const close = document.querySelector('.search-close');
        
        if (!toggle || !overlay) return;
        
        toggle.addEventListener('click', () => {
            overlay.classList.add('active');
            const input = overlay.querySelector('.search-input');
            if (input) setTimeout(() => input.focus(), 300);
        });
        
        if (close) {
            close.addEventListener('click', () => {
                overlay.classList.remove('active');
            });
        }
        
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && overlay.classList.contains('active')) {
                overlay.classList.remove('active');
            }
        });
    }
    
    /**
     * Scroll to Top
     */
    function initScrollToTop() {
        const btn = document.querySelector('.scroll-to-top');
        if (!btn) return;
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                btn.classList.add('visible');
            } else {
                btn.classList.remove('visible');
            }
        });
        
        btn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    /**
     * Chaty Toggle - FIXED
     */
    function initChaty() {
        const mainBtn = document.querySelector('.chaty-main-button');
        const channels = document.querySelector('.chaty-channels');
        
        if (!mainBtn || !channels) {
            console.log('Chaty elements not found!');
            return;
        }
        
        console.log('Chaty initialized!');
        
        mainBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            mainBtn.classList.toggle('active');
            channels.classList.toggle('active');
            
            console.log('Chaty toggled:', channels.classList.contains('active'));
        });
        
        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!mainBtn.contains(e.target) && !channels.contains(e.target)) {
                if (channels.classList.contains('active')) {
                    mainBtn.classList.remove('active');
                    channels.classList.remove('active');
                }
            }
        });
    }
    
    /**
     * FAQ Accordion
     */
    function initFAQ() {
        const faqItems = document.querySelectorAll('.faq-lead-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-lead-question');
            
            if (question) {
                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    
                    faqItems.forEach(i => i.classList.remove('active'));
                    
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            }
        });
    }
    
    /**
     * Accessibility Features
     */
    function initAccessibility() {
        const buttons = document.querySelectorAll('.a11y-btn');
        let fontSize = 16;
        
        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.dataset.action;
                
                switch(action) {
                    case 'increase-font':
                        fontSize = Math.min(fontSize + 2, 24);
                        document.documentElement.style.fontSize = fontSize + 'px';
                        break;
                    case 'decrease-font':
                        fontSize = Math.max(fontSize - 2, 12);
                        document.documentElement.style.fontSize = fontSize + 'px';
                        break;
                    case 'high-contrast':
                        document.body.classList.toggle('high-contrast');
                        break;
                    case 'reading-guide':
                        document.body.classList.toggle('reading-guide');
                        break;
                    case 'reset':
                        fontSize = 16;
                        document.documentElement.style.fontSize = '16px';
                        document.body.classList.remove('high-contrast', 'reading-guide');
                        break;
                }
            });
        });
    }
    
    /**
     * Scroll Animations
     */
    function initScrollAnimations() {
        const elements = document.querySelectorAll('.scroll-animate');
        
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            elements.forEach(el => observer.observe(el));
        } else {
            elements.forEach(el => el.classList.add('animated'));
        }
    }
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
    
})();

function scrollToForm() {
    const form = document.getElementById('order-form');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
