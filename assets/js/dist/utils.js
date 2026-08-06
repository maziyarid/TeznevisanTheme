/**
 * Teznevisan Utility Functions
 * Shared utilities for theme functionality
 */
(function(global) {
    'use strict';
    
    const TeznevisanUtils = {
        
        // DOM utilities
        dom: {
            ready: function(callback) {
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', callback);
                } else {
                    callback();
                }
            },
            
            createElement: function(tag, attributes = {}, children = []) {
                const element = document.createElement(tag);
                
                Object.entries(attributes).forEach(([key, value]) => {
                    if (key === 'style' && typeof value === 'object') {
                        Object.assign(element.style, value);
                    } else if (key.startsWith('data-')) {
                        element.setAttribute(key, value);
                    } else if (key === 'className') {
                        element.className = value;
                    } else {
                        element[key] = value;
                    }
                });
                
                children.forEach(child => {
                    if (typeof child === 'string') {
                        element.appendChild(document.createTextNode(child));
                    } else if (child instanceof Element) {
                        element.appendChild(child);
                    }
                });
                
                return element;
            },
            
            findElement: function(selectors) {
                for (const selector of selectors) {
                    const element = document.querySelector(selector);
                    if (element) return element;
                }
                return null;
            }
        },
        
        // Persian utilities
        persian: {
            numbers: {
                toPersian: function(str) {
                    const english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                    const persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                    
                    for (let i = 0; i < english.length; i++) {
                        str = str.replace(new RegExp(english[i], 'g'), persian[i]);
                    }
                    return str;
                },
                
                toEnglish: function(str) {
                    const persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                    const english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                    
                    for (let i = 0; i < persian.length; i++) {
                        str = str.replace(new RegExp(persian[i], 'g'), english[i]);
                    }
                    return str;
                }
            },
            
            typography: {
                fixYeh: function(text) {
                    return text.replace(/ي/g, 'ی');
                },
                
                fixKaf: function(text) {
                    return text.replace(/ك/g, 'ک');
                },
                
                addZWNJ: function(text) {
                    // Add zero-width non-joiner where needed
                    return text
                        .replace(/\s+می\s+/g, ' می‌')
                        .replace(/\s+نمی\s+/g, ' نمی‌')
                        .replace(/\s+و\s+/g, ' و ')
                        .replace(/([آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی])\s+([آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی])/g, '$1‌$2');
                },
                
                cleanText: function(text) {
                    return this.addZWNJ(this.fixKaf(this.fixYeh(text)));
                }
            },
            
            wordCount: function(text) {
                const plainText = text.replace(/<[^>]*>/g, '');
                const words = plainText.match(/[\u0600-\u06FF\u0750-\u077F]+/g);
                return words ? words.length : 0;
            }
        },
        
        // Accessibility utilities
        accessibility: {
            announce: function(message, priority = 'polite') {
                let announcer = document.getElementById('tez-global-announcer');
                if (!announcer) {
                    announcer = this.dom.createElement('div', {
                        id: 'tez-global-announcer',
                        'aria-live': priority,
                        'aria-atomic': 'true',
                        className: 'sr-only'
                    });
                    document.body.appendChild(announcer);
                }
                
                announcer.textContent = '';
                setTimeout(() => {
                    announcer.textContent = message;
                }, 100);
            },
            
            trapFocus: function(container) {
                const focusableElements = container.querySelectorAll(
                    'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
                );
                
                if (focusableElements.length === 0) return;
                
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];
                
                container.addEventListener('keydown', (e) => {
                    if (e.key === 'Tab') {
                        if (e.shiftKey) {
                            if (document.activeElement === firstElement) {
                                e.preventDefault();
                                lastElement.focus();
                            }
                        } else {
                            if (document.activeElement === lastElement) {
                                e.preventDefault();
                                firstElement.focus();
                            }
                        }
                    }
                });
                
                // Focus first element
                firstElement.focus();
            },
            
            makeKeyboardNavigable: function(element, callback) {
                element.setAttribute('tabindex', '0');
                element.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        if (callback) callback(e);
                    }
                });
            }
        },
        
        // Device detection
        device: {
            isMobile: () => window.innerWidth <= 768,
            isTablet: () => window.innerWidth > 768 && window.innerWidth <= 1024,
            isTouch: () => 'ontouchstart' in window || navigator.maxTouchPoints > 0,
            isRTL: () => document.documentElement.dir === 'rtl' || 
                         document.documentElement.lang.startsWith('fa') ||
                         document.body.classList.contains('rtl')
        },
        
        // Animation utilities
        animation: {
            fadeIn: function(element, duration = 300) {
                element.style.opacity = '0';
                element.style.display = 'block';
                
                const start = performance.now();
                
                function animate(currentTime) {
                    const elapsed = currentTime - start;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    element.style.opacity = progress;
                    
                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    }
                }
                
                requestAnimationFrame(animate);
            },
            
            fadeOut: function(element, duration = 300, callback) {
                const start = performance.now();
                const initialOpacity = parseFloat(window.getComputedStyle(element).opacity);
                
                function animate(currentTime) {
                    const elapsed = currentTime - start;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    element.style.opacity = initialOpacity * (1 - progress);
                    
                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        element.style.display = 'none';
                        if (callback) callback();
                    }
                }
                
                requestAnimationFrame(animate);
            },
            
            slideToggle: function(element, duration = 300) {
                const isVisible = element.style.display !== 'none' && element.offsetHeight > 0;
                
                if (isVisible) {
                    const height = element.offsetHeight;
                    element.style.height = height + 'px';
                    element.style.overflow = 'hidden';
                    
                    requestAnimationFrame(() => {
                        element.style.transition = `height ${duration}ms ease`;
                        element.style.height = '0px';
                        
                        setTimeout(() => {
                            element.style.display = 'none';
                            element.style.height = '';
                            element.style.transition = '';
                            element.style.overflow = '';
                        }, duration);
                    });
                } else {
                    element.style.display = 'block';
                    const height = element.offsetHeight;
                    element.style.height = '0px';
                    element.style.overflow = 'hidden';
                    
                    requestAnimationFrame(() => {
                        element.style.transition = `height ${duration}ms ease`;
                        element.style.height = height + 'px';
                        
                        setTimeout(() => {
                            element.style.height = '';
                            element.style.transition = '';
                            element.style.overflow = '';
                        }, duration);
                    });
                }
            }
        },
        
        // Performance utilities
        performance: {
            debounce: function(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            },
            
            throttle: function(func, limit) {
                let lastFunc;
                let lastRan;
                return function executedFunction(...args) {
                    if (!lastRan) {
                        func(...args);
                        lastRan = Date.now();
                    } else {
                        clearTimeout(lastFunc);
                        lastFunc = setTimeout(() => {
                            if ((Date.now() - lastRan) >= limit) {
                                func(...args);
                                lastRan = Date.now();
                            }
                        }, limit - (Date.now() - lastRan));
                    }
                };
            },
            
            lazy: function(callback, delay = 100) {
                return setTimeout(callback, delay);
            }
        },
        
        // Storage utilities
        storage: {
            set: function(key, value) {
                try {
                    localStorage.setItem(`teznevisan_${key}`, JSON.stringify(value));
                    return true;
                } catch (e) {
                    console.warn('Storage not available:', e);
                    return false;
                }
            },
            
            get: function(key, defaultValue = null) {
                try {
                    const item = localStorage.getItem(`teznevisan_${key}`);
                    return item ? JSON.parse(item) : defaultValue;
                } catch (e) {
                    console.warn('Storage read error:', e);
                    return defaultValue;
                }
            },
            
            remove: function(key) {
                try {
                    localStorage.removeItem(`teznevisan_${key}`);
                    return true;
                } catch (e) {
                    console.warn('Storage remove error:', e);
                    return false;
                }
            },
            
            clear: function() {
                try {
                    Object.keys(localStorage).forEach(key => {
                        if (key.startsWith('teznevisan_')) {
                            localStorage.removeItem(key);
                        }
                    });
                    return true;
                } catch (e) {
                    console.warn('Storage clear error:', e);
                    return false;
                }
            }
        }
    };
    
    // Export utilities
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = TeznevisanUtils;
    } else {
        global.TeznevisanUtils = TeznevisanUtils;
    }
    
})(typeof window !== 'undefined' ? window : this);