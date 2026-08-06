/**
 * Mobile Menu Handler - FIXED VERSION
 * Handles empty mobile menu with robust fallbacks
 */
(function($) {
    'use strict';
    
    class TeznevisanMobileMenu {
        constructor() {
            this.isRTL = $('html[dir="rtl"]').length > 0 || $('body').hasClass('rtl');
            this.init();
            this.setupFallback();
            this.bindEvents();
        }
        
        init() {
            // Find mobile menu elements with multiple selectors
            this.triggers = $('.mobile-menu-toggle, .hamburger-menu, .mobile-nav-toggle, [data-mobile-toggle]');
            this.overlay = $('#mobile-menu-overlay, .mobile-menu-overlay');
            this.wrapper = $('.mobile-menu-wrapper, .mobile-navigation-wrapper');
            this.closeBtn = $('#mobile-menu-close, .mobile-menu-close, .mobile-close');
            this.menuContainer = $('.mobile-navigation, .mobile-menu-content, .mobile-menu-container');
            
            this.isOpen = false;
            
            // Create missing elements if needed
            this.ensureElements();
            this.setupAriaAttributes();
        }
        
        ensureElements() {
            // Create mobile menu overlay if missing
            if (!this.overlay.length) {
                const overlayHtml = `
                    <div id="mobile-menu-overlay" class="mobile-menu-overlay" aria-hidden="true">
                        <div class="mobile-menu-wrapper">
                            <div class="mobile-menu-header">
                                <span id="mobile-menu-title">منوی اصلی</span>
                                <button class="mobile-menu-close" id="mobile-menu-close" aria-label="بستن منو">
                                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="mobile-menu-content">
                                <nav class="mobile-navigation" role="navigation" aria-labelledby="mobile-menu-title">
                                    <!-- Menu will be injected here -->
                                </nav>
                            </div>
                        </div>
                    </div>
                `;
                
                $('body').append(overlayHtml);
                
                // Update references
                this.overlay = $('#mobile-menu-overlay');
                this.wrapper = $('.mobile-menu-wrapper');
                this.closeBtn = $('#mobile-menu-close');
                this.menuContainer = $('.mobile-navigation');
            }
            
            // Create mobile toggle button if missing
            if (!this.triggers.length) {
                const triggerHtml = `
                    <button class="mobile-menu-toggle" aria-label="باز کردن منوی اصلی" aria-expanded="false">
                        <span class="hamburger-lines">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </span>
                    </button>
                `;
                
                // Try to find header navigation area
                const headerNav = $('.site-header .navigation, .main-navigation, .primary-navigation, header nav').first();
                            if (headerNav.length) {
                headerNav.append(triggerHtml);
            } else {
                // Fallback: add to header or body
                const header = $('header, .site-header').first();
                if (header.length) {
                    header.append(triggerHtml);
                } else {
                    $('body').prepend('<div class="mobile-menu-trigger-wrapper">' + triggerHtml + '</div>');
                }
            }
            
            // Update reference
            this.triggers = $('.mobile-menu-toggle');
        }
    }
    
    setupAriaAttributes() {
        this.triggers.attr({
            'role': 'button',
            'tabindex': '0',
            'aria-expanded': 'false',
            'aria-label': 'باز/بسته کردن منوی اصلی',
            'aria-controls': 'mobile-menu-overlay'
        });
        
        this.overlay.attr({
            'role': 'dialog',
            'aria-modal': 'true',
            'aria-hidden': 'true',
            'aria-labelledby': 'mobile-menu-title'
        });
    }
    
    setupFallback() {
        console.log('Setting up mobile menu fallback...');
        
        // Check if mobile menu container is empty
        const currentMenu = this.menuContainer.find('ul, .menu');
        
        if (!currentMenu.length || currentMenu.children().length === 0) {
            console.log('Mobile menu is empty, creating fallback...');
            
            // Try to clone primary menu first
            let sourceMenu = null;
            
            // Look for primary menu in various locations
            const menuSelectors = [
                '.primary-menu ul',
                '.main-navigation ul',
                '.site-navigation ul',
                'nav[role="navigation"] ul',
                '.navigation-primary ul',
                '.menu-primary-container ul',
                '#site-navigation ul'
            ];
            
            for (const selector of menuSelectors) {
                const found = $(selector).first();
                if (found.length && found.find('li').length > 0) {
                    sourceMenu = found;
                    console.log('Found primary menu to clone:', selector);
                    break;
                }
            }
            
            if (sourceMenu) {
                this.clonePrimaryMenu(sourceMenu);
            } else {
                console.log('No primary menu found, creating default menu...');
                this.createDefaultMenu();
            }
        } else {
            console.log('Mobile menu already has content');
            this.addMobileMenuIcons();
        }
    }
    
    clonePrimaryMenu(sourceMenu) {
        const clonedMenu = sourceMenu.clone(true); clonedMenu.removeClass().addClass('mobile-menu');
                // Add mobile-specific styling and icons
        this.processMobileMenu(clonedMenu);
        
        // Clear and append
        this.menuContainer.empty().append(clonedMenu);
    }
    
    createDefaultMenu() {
        const homeUrl = typeof tezThemeData !== 'undefined' ? tezThemeData.homeUrl : window.location.origin;
        
        const defaultMenu = `
            <ul class="mobile-menu">
                <li><a href="${homeUrl}"><i class="fa-solid fa-house" aria-hidden="true"></i><span>خانه</span></a></li>
                <li><a href="${homeUrl}/about"><i class="fa-solid fa-circle-info" aria-hidden="true"></i><span>درباره ما</span></a></li>
                <li><a href="${homeUrl}/services"><i class="fa-solid fa-gear" aria-hidden="true"></i><span>خدمات</span></a></li>
                <li><a href="${homeUrl}/portfolio"><i class="fa-solid fa-briefcase" aria-hidden="true"></i><span>نمونه کارها</span></a></li>
                <li><a href="${homeUrl}/blog"><i class="fa-solid fa-blog" aria-hidden="true"></i><span>وبلاگ</span></a></li>
                <li><a href="${homeUrl}/contact"><i class="fa-solid fa-envelope" aria-hidden="true"></i><span>تماس با ما</span></a></li>
            </ul>
        `;
        
        this.menuContainer.html(defaultMenu);
    }
    
    processMobileMenu($menu) {
        $menu.find('li').each((index, li) => {
            const $li = $(li);
            const $link = $li.find('a').first();
            
            if ($link.length) {
                const text = $link.text().trim();
                const icon = this.getIconForMenuItem(text);
                
                // Add icon if not present
                if (icon && !$link.find('i, .fa').length) {
                    $link.prepend(`<i class="${icon}" aria-hidden="true"></i>`);
                }
                
                // Ensure proper structure
                const textContent = $link.contents().filter(function() {
                    return this.nodeType === 3; // Text nodes
                }).text().trim();
                
                if (textContent && !$link.find('span').length) {
                    $link.contents().filter(function() {
                        return this.nodeType === 3;
                    }).wrap('<span></span>');
                }
            }
            
            // Handle submenus
            const $submenu = $li.find('ul').first();
            if ($submenu.length) {
                $li.addClass('has-submenu');
                $link.attr('aria-expanded', 'false');
                $submenu.addClass('sub-menu').attr('aria-hidden', 'true');
            }
        });
    }
    
    addMobileMenuIcons() {
        this.menuContainer.find('a').each((index, link) => {
            const $link = $(link);
            const text = $link.text().trim();
            const icon = this.getIconForMenuItem(text);
            
            if (icon && !$link.find('i, .fa').length) {
                $link.prepend(`<i class="${icon}" aria-hidden="true"></i>`);
            }
        });
    }
    
    getIconForMenuItem(text) {
        const lowerText = text.toLowerCase();
        
        const iconMap = {
            'خانه': 'fa-solid fa-house',
            'home': 'fa-solid fa-house',
            'صفحه اصلی': 'fa-solid fa-house',
            'خدمات': 'fa-solid fa-gear',
            'services': 'fa-solid fa-gear',
            'سرویس': 'fa-solid fa-gear',
            'درباره': 'fa-solid fa-circle-info',
            'about': 'fa-solid fa-circle-info',
            'معرفی': 'fa-solid fa-circle-info',
            'تماس': 'fa-solid fa-envelope',
            'contact': 'fa-solid fa-envelope',
            'ارتباط': 'fa-solid fa-envelope',
            'وبلاگ': 'fa-solid fa-blog',
            'blog': 'fa-solid fa-blog',
            'مقالات': 'fa-solid fa-blog',
            'نمونه': 'fa-solid fa-briefcase',
            'portfolio': 'fa-solid fa-briefcase',
            'کارها': 'fa-solid fa-briefcase',
            'گالری': 'fa-solid fa-images',
            'gallery': 'fa-solid fa-images',
            'تصاویر': 'fa-solid fa-images'
        };
        
        for (const [keyword, icon] of Object.entries(iconMap)) {
            if (lowerText.includes(keyword.toLowerCase())) {
                return icon;
            }
        }
        
        return 'fa-solid fa-circle';
    }
    
    bindEvents() {
        // Menu toggle
        this.triggers.on('click keydown', (e) => {
            if (e.type === 'click' || (e.type === 'keydown' && (e.key === 'Enter' || e.key === ' '))) {
                e.preventDefault();
                this.toggleMenu();
            }
        });
        
        // Close button
        this.closeBtn.on('click', (e) => {
            e.preventDefault();
            this.closeMenu();
        });
        
        // Close on overlay click
        this.overlay.on('click', (e) => {
            if (e.target === this.overlay[0]) {
                this.closeMenu();
            }
        });
        
        // Close on Escape key
        $(document).on('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeMenu();
            }
        });
        
        // Submenu toggles
        this.overlay.on('click', '.has-submenu > a', (e) => {
            e.preventDefault();
            this.toggleSubmenu($(e.currentTarget).parent());
        });
        
        // Regular menu links
        this.overlay.on('click', 'a:not(.has-submenu > a)', () => {
            setTimeout(() => {
                this.closeMenu();
            }, 150);
        });
        
        // Window resize handler
        $(window).on('resize', () => {
            if ($(window).width() > 768 && this.isOpen) {
                this.closeMenu();
            }
        });
    }
    
    toggleMenu() {
        if (this.isOpen) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }
    
    openMenu() {
        this.overlay.addClass('active open').attr('aria-hidden', 'false');
        this.triggers.addClass('active').attr('aria-expanded', 'true');
        $('body').addClass('mobile-menu-open').css('overflow', 'hidden');
        
        this.isOpen = true;
        
        // Focus management
        setTimeout(() => {
            const firstLink = this.overlay.find('.mobile-menu a:visible:first');
            if (firstLink.length) {
                firstLink.focus();
            }
        }, 300);
        
        // Setup focus trap
        this.setupFocusTrap();
    }
    
    closeMenu() {
        this.overlay.removeClass('active open').attr('aria-hidden', 'true');
        this.triggers.removeClass('active').attr('aria-expanded', 'false');
        $('body').removeClass('mobile-menu-open').css('overflow', '');
        
        // Close all submenus
        this.overlay.find('.has-submenu').removeClass('open');
        this.overlay.find('.sub-menu').attr('aria-hidden', 'true');
        
        this.isOpen = false;
        
        // Return focus to trigger
        this.triggers.first().focus();
    }
    
    toggleSubmenu($item) {
        const isOpen = $item.hasClass('open');
        const $link = $item.find('> a');
        const $submenu = $item.find('.sub-menu');
        
        // Close other submenus
        this.overlay.find('.has-submenu').not($item).removeClass('open');
        this.overlay.find('.sub-menu').not($submenu).attr('aria-hidden', 'true');
        
        // Toggle current submenu
        $item.toggleClass('open', !isOpen);
        $link.attr('aria-expanded', !isOpen ? 'true' : 'false');
        $submenu.attr('aria-hidden', !isOpen ? 'false' : 'true');
    }
    
    setupFocusTrap() {
        this.overlay.on('keydown.focustrap', (e) => {
            if (e.key === 'Tab') {
                const focusableElements = this.overlay.find('a, button, [tabindex]:not([tabindex="-1"])');
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
        });
    }
}

// Initialize when DOM is ready
$(document).ready(() => {
    new TeznevisanMobileMenu();
});
})(jQuery);