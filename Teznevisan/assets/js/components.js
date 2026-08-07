/* ====================================
   Teznevisan Components JavaScript
   ==================================== */

(function() {
    'use strict';

    /* ====================================
       1. Service Cards Interactive
       ==================================== */
    const serviceCards = document.querySelectorAll('.service-card');
    
    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    /* ====================================
       2. Testimonial Slider (if needed)
       ==================================== */
    class TestimonialSlider {
        constructor(container) {
            this.container = container;
            this.slides = container.querySelectorAll('.testimonial-card');
            this.currentSlide = 0;
            this.autoplayInterval = null;
            
            if (this.slides.length > 0) {
                this.init();
            }
        }
        
        init() {
            this.createControls();
            this.createIndicators();
            this.startAutoplay();
        }
        
        createControls() {
            const prevBtn = document.createElement('button');
            prevBtn.className = 'slider-control slider-prev';
            prevBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            prevBtn.addEventListener('click', () => this.prevSlide());
            
            const nextBtn = document.createElement('button');
            nextBtn.className = 'slider-control slider-next';
            nextBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            nextBtn.addEventListener('click', () => this.nextSlide());
            
            this.container.appendChild(prevBtn);
            this.container.appendChild(nextBtn);
        }
        
        createIndicators() {
            const indicators = document.createElement('div');
            indicators.className = 'slider-indicators';
            
            for (let i = 0; i < this.slides.length; i++) {
                const dot = document.createElement('button');
                dot.className = 'slider-indicator' + (i === 0 ? ' active' : '');
                dot.addEventListener('click', () => this.goToSlide(i));
                indicators.appendChild(dot);
            }
            
            this.container.appendChild(indicators);
        }
        
        goToSlide(index) {
            this.slides[this.currentSlide].classList.remove('active');
            this.currentSlide = index;
            this.slides[this.currentSlide].classList.add('active');
            this.updateIndicators();
        }
        
        nextSlide() {
            const next = (this.currentSlide + 1) % this.slides.length;
            this.goToSlide(next);
        }
        
        prevSlide() {
            const prev = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            this.goToSlide(prev);
        }
        
        updateIndicators() {
            const indicators = this.container.querySelectorAll('.slider-indicator');
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === this.currentSlide);
            });
        }
        
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.nextSlide();
            }, 5000);
        }
        
        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
            }
        }
    }
    
    // Initialize testimonial slider if exists
    const testimonialContainer = document.querySelector('.testimonials-slider');
    if (testimonialContainer) {
        new TestimonialSlider(testimonialContainer);
    }
    
    /* ====================================
       3. Trust Bar Animation
       ==================================== */
    const trustItems = document.querySelectorAll('.trust-item');
    
    const trustObserver = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                trustObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });
    
    trustItems.forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'all 0.5s ease-out';
        trustObserver.observe(item);
    });
    
    /* ====================================
       4. Form Step Navigation (if multi-step)
       ==================================== */
    class MultiStepForm {
        constructor(formElement) {
            this.form = formElement;
            this.steps = formElement.querySelectorAll('.form-step');
            this.currentStep = 0;
            this.progressBar = formElement.querySelector('.progress-bar');
            
            if (this.steps.length > 0) {
                this.init();
            }
        }
        
        init() {
            this.showStep(0);
            this.createNavigation();
            this.updateProgress();
        }
        
        createNavigation() {
            this.steps.forEach((step, index) => {
                if (index < this.steps.length - 1) {
                    const nextBtn = step.querySelector('.btn-next');
                    if (nextBtn) {
                        nextBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (this.validateStep(index)) {
                                this.nextStep();
                            }
                        });
                    }
                }
                
                if (index > 0) {
                    const prevBtn = step.querySelector('.btn-prev');
                    if (prevBtn) {
                        prevBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            this.prevStep();
                        });
                    }
                }
            });
        }
        
        showStep(index) {
            this.steps.forEach((step, i) => {
                step.style.display = i === index ? 'block' : 'none';
            });
            this.currentStep = index;
            this.updateProgress();
        }
        
        nextStep() {
            if (this.currentStep < this.steps.length - 1) {
                this.showStep(this.currentStep + 1);
            }
        }
        
        prevStep() {
            if (this.currentStep > 0) {
                this.showStep(this.currentStep - 1);
            }
        }
        
        validateStep(stepIndex) {
            const step = this.steps[stepIndex];
            const inputs = step.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
            });
            
            return isValid;
        }
        
        updateProgress() {
            if (this.progressBar) {
                const progress = ((this.currentStep + 1) / this.steps.length) * 100;
                this.progressBar.style.width = progress + '%';
            }
        }
    }
    
    // Initialize multi-step forms
    document.querySelectorAll('.multi-step-form').forEach(form => {
        new MultiStepForm(form);
    });
    
    /* ====================================
       5. Modal Functionality
       ==================================== */
    class Modal {
        constructor(modalId) {
            this.modal = document.getElementById(modalId);
            if (!this.modal) return;
            
            this.closeBtn = this.modal.querySelector('.modal-close');
            this.overlay = this.modal.querySelector('.modal-overlay');
            
            this.init();
        }
        
        init() {
            this.closeBtn?.addEventListener('click', () => this.close());
            this.overlay?.addEventListener('click', () => this.close());
            
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.modal.classList.contains('active')) {
                    this.close();
                }
            });
        }
        
        open() {
            this.modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        close() {
            this.modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
    // Initialize modals
    document.querySelectorAll('[data-modal]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const modalId = this.dataset.modal;
            const modal = new Modal(modalId);
            modal.open();
        });
    });
    
    /* ====================================
       6. Tabs Functionality
       ==================================== */
    class Tabs {
        constructor(container) {
            this.container = container;
            this.tabButtons = container.querySelectorAll('.tab-button');
            this.tabPanels = container.querySelectorAll('.tab-panel');
            
            if (this.tabButtons.length > 0) {
                this.init();
            }
        }
        
        init() {
            this.tabButtons.forEach((button, index) => {
                button.addEventListener('click', () => this.switchTab(index));
            });
            
            this.switchTab(0);
        }
        
        switchTab(index) {
            this.tabButtons.forEach((btn, i) => {
                btn.classList.toggle('active', i === index);
            });
            
            this.tabPanels.forEach((panel, i) => {
                panel.style.display = i === index ? 'block' : 'none';
            });
        }
    }
    
    // Initialize tabs
    document.querySelectorAll('.tabs-container').forEach(container => {
        new Tabs(container);
    });
    
    /* ====================================
       7. Price Calculator
       ==================================== */
    class PriceCalculator {
        constructor(formElement) {
            this.form = formElement;
            this.inputs = formElement.querySelectorAll('input, select');
            this.resultElement = formElement.querySelector('.price-result');
            
            if (this.inputs.length > 0) {
                this.init();
            }
        }
        
        init() {
            this.inputs.forEach(input => {
                input.addEventListener('change', () => this.calculate());
            });
        }
        
        calculate() {
            // Base prices
            const prices = {
                thesis_masters: 5000000,
                thesis_phd: 10000000,
                proposal: 2000000,
                article: 3000000,
                analysis: 1500000,
                translation: 500000,
                programming: 4000000
            };
            
            const serviceType = this.form.querySelector('[name="service"]')?.value;
            const pages = parseInt(this.form.querySelector('[name="pages"]')?.value) || 0;
            const urgency = this.form.querySelector('[name="urgency"]')?.value;
            
            let basePrice = prices[serviceType] || 0;
            
            // Adjust for pages
            if (pages > 50) {
                basePrice += (pages - 50) * 50000;
            }
            
            // Adjust for urgency
            if (urgency === 'urgent') {
                basePrice *= 1.5;
            } else if (urgency === 'express') {
                basePrice *= 2;
            }
            
            if (this.resultElement) {
                this.resultElement.textContent = this.formatPrice(basePrice);
            }
        }
        
        formatPrice(price) {
            return new Intl.NumberFormat('fa-IR', {
                style: 'currency',
                currency: 'IRR',
                maximumFractionDigits: 0
            }).format(price);
        }
    }
    
    // Initialize price calculators
    document.querySelectorAll('.price-calculator-form').forEach(form => {
        new PriceCalculator(form);
    });
    
    /* ====================================
       8. File Upload Preview
       ==================================== */
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const files = this.files;
            const preview = this.nextElementSibling;
            
            if (preview && preview.classList.contains('file-preview')) {
                preview.innerHTML = '';
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    fileItem.innerHTML = `
                        <i class="fas fa-file"></i>
                        <span>${file.name}</span>
                        <span class="file-size">${formatFileSize(file.size)}</span>
                    `;
                    preview.appendChild(fileItem);
                }
            }
        });
    });
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
    
    /* ====================================
       9. Dynamic Content Loading
       ==================================== */
    window.loadMoreContent = function(btn) {
        const container = btn.previousElementSibling;
        const page = parseInt(btn.dataset.page || 1) + 1;
        
        btn.disabled = true;
        btn.innerHTML = '<span class="loading-spinner"></span> در حال بارگذاری...';
        
        // Simulate AJAX request
        setTimeout(() => {
            // Add new content here
            const newItems = generateContentItems(6);
            container.insertAdjacentHTML('beforeend', newItems.join(''));
            
            btn.dataset.page = page;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plus"></i> بیشتر';
            
            // Hide button if no more content
            if (page >= 3) {
                btn.style.display = 'none';
            }
        }, 1000);
    };
    
    function generateContentItems(count) {
        let html = '';
        for (let i = 0; i < count; i++) {
            html += `
                <div class="content-item scroll-animate">
                    <h3>عنوان محتوا ${i + 1}</h3>
                    <p>توضیحات محتوا...</p>
                </div>
            `;
        }
        return html;
    }
    
    /* ====================================
       10. Initialize All Components
       ==================================== */
    window.addEventListener('DOMContentLoaded', function() {
        console.log('Teznevisan Components Initialized');
    });

})();