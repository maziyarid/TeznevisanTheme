jQuery(document).ready(function($) {
    'use strict';
    
    // Initialize counters for dynamic fields
    let featureIndex = $('.feature-item-row').length || 0;
    let stepIndex = $('.process-step-row').length || 0;
    let faqIndex = $('.faq-item-row').length || 0;
    let legacyStepIndex = $('.legacy-step-row').length || 0;
    
    // Tab switching functionality
    function initTabSwitching() {
        $(".meta-tab-btn").on("click", function(e) {
            e.preventDefault();
            
            const targetTab = $(this).data("tab");
            
            // Remove active classes
            $(".meta-tab-btn").removeClass("active");
            $(".meta-tab-content").removeClass("active");
            
            // Add active classes
            $(this).addClass("active");
            $(`.meta-tab-content[data-tab="${targetTab}"]`).addClass("active");
            
            // Trigger custom event for tab change
            $(document).trigger('teznevisan:tab-changed', [targetTab]);
        });
    }
    
    // Features management
    function initFeatureManagement() {
        // Add feature
        $("#add-service-feature").on("click", function(e) {
            e.preventDefault();
            
            const html = `
                <div class="feature-item-row">
                    <div class="feature-fields">
                        <input type="text" 
                               name="service_features[${featureIndex}][title]" 
                               placeholder="عنوان ویژگی"
                               class="feature-title">
                        <textarea name="service_features[${featureIndex}][description]" 
                                  placeholder="توضیحات ویژگی"
                                  class="feature-description"></textarea>
                    </div>
                    <button type="button" class="button button-secondary remove-feature">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </div>
            `;
            
            $("#service-features-list").append(html);
            featureIndex++;
            
            // Focus on the new title field
            $("#service-features-list .feature-item-row:last .feature-title").focus();
        });
        
        // Remove feature
        $(document).on("click", ".remove-feature", function(e) {
            e.preventDefault();
            
            const $row = $(this).closest(".feature-item-row");
            
            if (confirm('آیا از حذف این ویژگی اطمینان دارید؟')) {
                $row.fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
    }
    
    // Process steps management
    function initProcessManagement() {
        // Add process step
        $("#add-process-step").on("click", function(e) {
            e.preventDefault();
            
            const html = `
                <div class="process-step-row">
                    <div class="step-number">${stepIndex + 1}</div>
                    <div class="step-fields">
                        <input type="text" 
                               name="process_steps[${stepIndex}][title]" 
                               placeholder="عنوان مرحله"
                               class="step-title">
                        <textarea name="process_steps[${stepIndex}][description]" 
                                  placeholder="توضیحات مرحله"
                                  class="step-description"></textarea>
                        <input type="text" 
                               name="process_steps[${stepIndex}][duration]" 
                               placeholder="مدت زمان (مثال: 2 روز)"
                               class="step-duration">
                    </div>
                    <button type="button" class="button button-secondary remove-step">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </div>
            `;
            
            $("#process-steps-list").append(html);
            stepIndex++;
            updateStepNumbers();
            
            // Focus on the new title field
            $("#process-steps-list .process-step-row:last .step-title").focus();
        });
        
        // Remove process step
        $(document).on("click", ".remove-step", function(e) {
            e.preventDefault();
            
            const $row = $(this).closest(".process-step-row");
            
            if (confirm('آیا از حذف این مرحله اطمینان دارید؟')) {
                $row.fadeOut(300, function() {
                    $(this).remove();
                    updateStepNumbers();
                });
            }
        });
        
        // Add legacy step
        $("#add-legacy-step").on("click", function(e) {
            e.preventDefault();
            
            const html = `
                <div class="legacy-step-row">
                    <textarea name="service_steps[${legacyStepIndex}]" 
                              placeholder="توضیحات مرحله قدیمی"
                              class="legacy-step-text"></textarea>
                    <button type="button" class="button button-secondary remove-legacy-step">حذف</button>
                </div>
            `;
            
            $("#legacy-steps-list").append(html);
            legacyStepIndex++;
            
            // Focus on the new textarea
            $("#legacy-steps-list .legacy-step-row:last .legacy-step-text").focus();
        });
        
        // Remove legacy step
        $(document).on("click", ".remove-legacy-step", function(e) {
            e.preventDefault();
            
            const $row = $(this).closest(".legacy-step-row");
            
            if (confirm('آیا از حذف این مرحله اطمینان دارید؟')) {
                $row.fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
    }
    
    // Update step numbers
    function updateStepNumbers() {
        $("#process-steps-list .process-step-row").each(function(index) {
            $(this).find(".step-number").text(index + 1);
        });
    }
    
    // FAQ management
    function initFAQManagement() {
        // Add FAQ
        $("#add-service-faq").on("click", function(e) {
            e.preventDefault();
            
            const html = `
                <div class="faq-item-row">
                    <div class="faq-fields">
                        <input type="text" 
                               name="service_faq[${faqIndex}][question]" 
                               placeholder="سوال متداول"
                               class="faq-question">
                        <textarea name="service_faq[${faqIndex}][answer]" 
                                  placeholder="پاسخ کامل و مفصل"
                                  class="faq-answer"></textarea>
                    </div>
                    <button type="button" class="button button-secondary remove-faq">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </div>
            `;
            
            $("#service-faq-list").append(html);
            faqIndex++;
            
            // Focus on the new question field
            $("#service-faq-list .faq-item-row:last .faq-question").focus();
        });
        
        // Remove FAQ
        $(document).on("click", ".remove-faq", function(e) {
            e.preventDefault();
            
            const $row = $(this).closest(".faq-item-row");
            
            if (confirm('آیا از حذف این سوال اطمینان دارید؟')) {
                $row.fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
    }
    
    // Related services management
    function initRelatedServicesManagement() {
        $(".related-service-item").on("click", function(e) {
            if ($(e.target).is('input[type="checkbox"]')) {
                return; // Let the checkbox handle itself
            }
            
            e.preventDefault();
            
            const checkbox = $(this).find(".related-service-checkbox");
            const isChecked = checkbox.prop("checked");
            
            checkbox.prop("checked", !isChecked);
            
            if (!isChecked) {
                $(this).addClass("selected");
            } else {
                $(this).removeClass("selected");
            }
            
            updateRelatedServicesLimit();
        });
        
        // Handle direct checkbox clicks
        $(".related-service-checkbox").on("change", function() {
            const $item = $(this).closest(".related-service-item");
            
            if ($(this).is(":checked")) {
                $item.addClass("selected");
            } else {
                $item.removeClass("selected");
            }
            
            updateRelatedServicesLimit();
        });
        
        // Update related services limit
        function updateRelatedServicesLimit() {
            const selectedCount = $(".related-service-checkbox:checked").length;
            const maxSelections = 3;
            
            if (selectedCount >= maxSelections) {
                $(".related-service-checkbox:not(:checked)").prop("disabled", true);
                $(".related-service-item:not(.selected)").addClass("disabled");
                
                // Show warning message
                if (!$(".related-limit-warning").length) {
                    $(".related-services-grid").after(
                        '<p class="related-limit-warning description" style="color: #dc3545; font-weight: 600;">' +
                        'حداکثر ' + maxSelections + ' خدمت قابل انتخاب است. برای انتخاب خدمت جدید، یکی از موارد انتخاب شده را حذف کنید.' +
                        '</p>'
                    );
                }
            } else {
                $(".related-service-checkbox").prop("disabled", false);
                $(".related-service-item").removeClass("disabled");
                $(".related-limit-warning").remove();
            }
        }
        
        // Initialize on page load
        updateRelatedServicesLimit();
    }
    
    // Form validation
    function initFormValidation() {
        // Real-time validation for required fields
        $('.large-text, .regular-text, textarea').on('blur', function() {
            validateField($(this));
        });
        
        $('.large-text, .regular-text, textarea').on('input', function() {
            clearFieldError($(this));
        });
        
        function validateField($field) {
            const value = $field.val().trim();
            const isRequired = $field.prop('required') || $field.hasClass('required');
            
            clearFieldError($field);
            
            if (isRequired && !value) {
                showFieldError($field, 'این فیلد الزامی است');
                return false;
            }
            
            // Specific validations
            if ($field.attr('type') === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    showFieldError($field, 'آدرس ایمیل معتبر نیست');
                    return false;
                }
            }
            
            if ($field.attr('type') === 'url' && value) {
                try {
                    new URL(value);
                } catch {
                    showFieldError($field, 'آدرس URL معتبر نیست');
                    return false;
                }
            }
            
            if ($field.attr('type') === 'number' && value) {
                if (isNaN(value) || value < 0) {
                    showFieldError($field, 'لطفاً یک عدد معتبر وارد کنید');
                    return false;
                }
            }
            
            showFieldSuccess($field);
            return true;
        }
        
        function showFieldError($field, message) {
            $field.css({
                'border-color': '#dc3545',
                'box-shadow': '0 0 0 3px rgba(220, 53, 69, 0.2)'
            });
            
            const errorId = 'error-' + $field.attr('name');
            $('#' + errorId).remove();
            
            $field.after(`<div id="${errorId}" class="field-error" style="color: #dc3545; font-size: 12px; margin-top: 5px;"><i class="fas fa-exclamation-triangle"></i> ${message}</div>`);
        }
        
        function showFieldSuccess($field) {
            $field.css({
                'border-color': '#28a745',
                'box-shadow': '0 0 0 3px rgba(40, 167, 69, 0.2)'
            });
        }
        
        function clearFieldError($field) {
            $field.css({
                'border-color': '#e9ecef',
                'box-shadow': 'none'
            });
            
            const errorId = 'error-' + $field.attr('name');
            $('#' + errorId).remove();
        }
    }
    
    // Auto-save functionality (optional)
    function initAutoSave() {
        let autoSaveTimeout;
        
        $('.large-text, .regular-text, textarea').on('input', function() {
            clearTimeout(autoSaveTimeout);
            
            autoSaveTimeout = setTimeout(function() {
                // Show auto-save indicator
                showAutoSaveIndicator();
            }, 2000); // Auto-save after 2 seconds of inactivity
        });
        
        function showAutoSaveIndicator() {
            if ($('.auto-save-indicator').length) return;
            
            $('body').append(`
                <div class="auto-save-indicator" style="
                    position: fixed;
                    top: 50px;
                    right: 20px;
                    background: #1FA547;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 20px;
                    font-size: 14px;
                    z-index: 9999;
                    box-shadow: 0 4px 15px rgba(31, 165, 71, 0.3);
                ">
                    <i class="fas fa-cloud-upload-alt"></i> ذخیره خودکار...
                </div>
            `);
            
            setTimeout(function() {
                $('.auto-save-indicator').fadeOut(500, function() {
                    $(this).remove();
                });
            }, 2000);
        }
    }
    
    // Utility functions
    function showNotification(message, type = 'success') {
        const bgColor = type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#ffc107';
        
        $('body').append(`
            <div class="admin-notification" style="
                position: fixed;
                top: 50px;
                right: 20px;
                background: ${bgColor};
                color: white;
                padding: 15px 25px;
                border-radius: 6px;
                font-size: 14px;
                z-index: 9999;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                max-width: 300px;
            ">
                ${message}
            </div>
        `);
        
        setTimeout(function() {
            $('.admin-notification').fadeOut(500, function() {
                $(this).remove();
            });
        }, 3000);
    }
    
    // Keyboard shortcuts
    function initKeyboardShortcuts() {
        $(document).on('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.keyCode === 83) {
                e.preventDefault();
                $('#publish, #save-post').trigger('click');
                showNotification('در حال ذخیره...');
            }
            
            // Ctrl/Cmd + Tab to switch tabs
            if ((e.ctrlKey || e.metaKey) && e.keyCode === 9) {
                e.preventDefault();
                const $activTab = $('.meta-tab-btn.active');
                const $nextTab = $activTab.next('.meta-tab-btn');
                
                if ($nextTab.length) {
                    $nextTab.trigger('click');
                } else {
                    $('.meta-tab-btn:first').trigger('click');
                }
            }
        });
    }
    
    // Initialize everything
    function init() {
        initTabSwitching();
        initFeatureManagement();
        initProcessManagement();
        initFAQManagement();
        initRelatedServicesManagement();
        initFormValidation();
        initAutoSave();
        initKeyboardShortcuts();
        
        // Show welcome message
        if (window.location.search.includes('post=') && !window.location.search.includes('action=edit')) {
            showNotification('خوش آمدید! تمام فیلدهای خدمت آماده تکمیل است.', 'success');
        }
    }
    
    // Custom events
    $(document).on('teznevisan:tab-changed', function(e, tabName) {
        console.log('Tab changed to:', tabName);
        
        // Trigger specific actions based on tab
        switch(tabName) {
            case 'features':
                // Auto-focus first empty feature if exists
                const $emptyFeature = $('.feature-title').filter(function() {
                    return !$(this).val();
                }).first();
                if ($emptyFeature.length) {
                    $emptyFeature.focus();
                }
                break;
                
            case 'pricing':
                // Validate price ranges
                validatePriceRanges();
                break;
        }
    });
    
    function validatePriceRanges() {
        const minPrice = parseInt($('#price_range_min').val()) || 0;
        const maxPrice = parseInt($('#price_range_max').val()) || 0;
        
        if (maxPrice > 0 && minPrice > maxPrice) {
            showNotification('حداقل قیمت نمی‌تواند بیشتر از حداکثر قیمت باشد', 'error');
        }
    }
    
    // Initialize when document is ready
    init();
    
    // Debug info (remove in production)
    if (window.console) {
        console.log('Teznevisan Service Meta initialized successfully');
    }
});