/*!
 * Frontend Editor JavaScript
 * TezNevisan Theme - Version 2.0.0
 * Persian RTL Support with comprehensive editing capabilities
 */

(function($) {
    'use strict';

    /* ==========================================================================
       CONFIGURATION & CONSTANTS
       ========================================================================== */

    const EDITOR_CONFIG = {
        autosaveInterval: 30000, // 30 seconds
        maxHistoryStates: 50,
        allowedTags: ['p', 'br', 'strong', 'em', 'u', 'a', 'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        apiEndpoint: teznevisanAjax?.ajaxurl || '/wp-admin/admin-ajax.php',
        debounceDelay: 300
    };

    const PERSIAN_STRINGS = {
        loading: 'در حال بارگذاری...',
        editMode: 'حالت ویرایش',
        exitEditMode: 'خروج از حالت ویرایش',
        saveChanges: 'ذخیره تغییرات',
        undo: 'بازگردانی',
        redo: 'تکرار',
        bold: 'ضخیم',
        italic: 'مورب',
        underline: 'زیرخط',
        insertLink: 'درج لینک',
        insertImage: 'درج تصویر',
        textColor: 'رنگ متن',
        settings: 'تنظیمات',
        edit: 'ویرایش',
        saved: 'ذخیره شد',
        error: 'خطا',
        success: 'موفقیت‌آمیز',
        confirm: 'آیا مطمئن هستید؟'
    };

    /* ==========================================================================
       GLOBAL STATE
       ========================================================================== */

    let editorState = {
        isActive: false,
        currentElement: null,
        isDirty: false,
        history: [],
        historyIndex: -1,
        autosaveTimer: null,
        editableElements: new Map(),
        debounceTimer: null
    };

    /* ==========================================================================
       MAIN EDITOR CLASS
       ========================================================================== */

    class TezNevisanEditor {
        constructor() {
            this.init();
        }

        /**
         * Initialize the editor
         */
        init() {
            console.log('تزنویسان ویرایشگر در حال بارگذاری...');

            if (!this.checkPermissions()) {
                console.warn('شما مجوز ویرایش ندارید');
                return;
            }

            this.createEditorToolbar();
            this.initEditableElements();
            this.bindEvents();
            this.startAutosave();

            console.log('تزنویسان ویرایشگر بارگذاری شد ✓');
        }

        /**
         * Check if user has edit permissions
         * @returns {boolean}
         */
        checkPermissions() {
            return document.body.classList.contains('logged-in') && 
                   (document.body.classList.contains('admin-bar') ||
                    window.teznevisanAjax?.canEdit);
        }

        /* ==========================================================================
           TOOLBAR CREATION
           ========================================================================== */

        /**
         * Create and inject the editor toolbar
         */
        createEditorToolbar() {
            const toolbar = this.getToolbarHTML();
            $('body').prepend(toolbar);
            this.toolbar = $('.teznevisan-editor-toolbar');
        }

        /**
         * Get toolbar HTML structure
         * @returns {jQuery}
         */
        getToolbarHTML() {
            return $(`
                <div class="teznevisan-editor-toolbar">
                    <div class="teznevisan-editor-controls">
                        ${this.getMainControlsHTML()}
                        ${this.getFormattingControlsHTML()}
                        ${this.getInsertControlsHTML()}
                        ${this.getSettingsControlsHTML()}
                        ${this.getSaveStatusHTML()}
                    </div>
                </div>
            `);
        }

        /**
         * Get main controls HTML
         * @returns {string}
         */
        getMainControlsHTML() {
            return `
                <div class="editor-control-group">
                    <button class="editor-btn" id="toggle-edit-mode" title="${PERSIAN_STRINGS.editMode}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="editor-btn" id="save-changes" title="${PERSIAN_STRINGS.saveChanges}" disabled>
                        <i class="fas fa-save"></i>
                    </button>
                    <button class="editor-btn" id="undo-changes" title="${PERSIAN_STRINGS.undo}" disabled>
                        <i class="fas fa-undo"></i>
                    </button>
                    <button class="editor-btn" id="redo-changes" title="${PERSIAN_STRINGS.redo}" disabled>
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            `;
        }

        /**
         * Get formatting controls HTML
         * @returns {string}
         */
        getFormattingControlsHTML() {
            return `
                <div class="editor-control-group">
                    <button class="editor-btn" id="format-bold" title="${PERSIAN_STRINGS.bold}">
                        <i class="fas fa-bold"></i>
                    </button>
                    <button class="editor-btn" id="format-italic" title="${PERSIAN_STRINGS.italic}">
                        <i class="fas fa-italic"></i>
                    </button>
                    <button class="editor-btn" id="format-underline" title="${PERSIAN_STRINGS.underline}">
                        <i class="fas fa-underline"></i>
                    </button>
                    <select class="editor-select" id="format-heading">
                        <option value="">متن عادی</option>
                        <option value="h1">تیتر 1</option>
                        <option value="h2">تیتر 2</option>
                        <option value="h3">تیتر 3</option>
                        <option value="h4">تیتر 4</option>
                    </select>
                </div>
            `;
        }

        /**
         * Get insert controls HTML
         * @returns {string}
         */
        getInsertControlsHTML() {
            return `
                <div class="editor-control-group">
                    <button class="editor-btn" id="insert-link" title="${PERSIAN_STRINGS.insertLink}">
                        <i class="fas fa-link"></i>
                    </button>
                    <button class="editor-btn" id="insert-image" title="${PERSIAN_STRINGS.insertImage}">
                        <i class="fas fa-image"></i>
                    </button>
                    <div class="color-picker-wrapper">
                        <div class="color-picker-preview" style="background: #000;" title="${PERSIAN_STRINGS.textColor}">
                            <input type="color" class="color-picker-input" id="text-color" value="#000000">
                        </div>
                    </div>
                </div>
            `;
        }

        /**
         * Get settings controls HTML
         * @returns {string}
         */
        getSettingsControlsHTML() {
            return `
                <div class="editor-control-group">
                    <button class="editor-btn" id="editor-settings" title="${PERSIAN_STRINGS.settings}">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            `;
        }

        /**
         * Get save status HTML
         * @returns {string}
         */
        getSaveStatusHTML() {
            return `
                <div class="save-status" id="save-status" style="display: none;">
                    <i class="fas fa-circle"></i>
                    <span></span>
                </div>
            `;
        }

        /* ==========================================================================
           EDITABLE ELEMENTS MANAGEMENT
           ========================================================================== */

        /**
         * Initialize all editable elements
         */
        initEditableElements() {
            const editableSelectors = [
                '[data-editable]',
                '.post-title',
                '.post-content',
                '.service-title',
                '.service-description',
                '.service-price',
                '.hero-title',
                '.hero-subtitle',
                '.hero-description',
                '.section-title',
                '.section-subtitle'
            ];

            editableSelectors.forEach(selector => {
                $(selector).each((index, element) => {
                    this.makeElementEditable($(element));
                });
            });
        }

        /**
         * Make an element editable
         * @param {jQuery} $element
         */
        makeElementEditable($element) {
            const elementId = this.generateElementId();

            $element.attr({
                'contenteditable': 'false',
                'data-editor-id': elementId,
                'tabindex': '0'
            }).addClass('teznevisan-editable');

            // Add edit overlay if not exists
            if (!$element.find('.edit-overlay').length) {
                $element.append(`<span class="edit-overlay">${PERSIAN_STRINGS.edit}</span>`);
            }

            // Store element data
            editorState.editableElements.set(elementId, {
                element: $element,
                originalContent: $element.html(),
                type: this.getElementType($element)
            });
        }

        /**
         * Generate unique element ID
         * @returns {string}
         */
        generateElementId() {
            return 'editor-' + Math.random().toString(36).substr(2, 9);
        }

        /**
         * Determine element type
         * @param {jQuery} $element
         * @returns {string}
         */
        getElementType($element) {
            if ($element.hasClass('service-price') || $element.data('type') === 'price') {
                return 'price';
            }
            if ($element.is('h1, h2, h3, h4, h5, h6') || $element.hasClass('title')) {
                return 'title';
            }
            if ($element.hasClass('description') || $element.data('type') === 'description') {
                return 'description';
            }
            return 'text';
        }

        /* ==========================================================================
           EVENT BINDING
           ========================================================================== */

        /**
         * Bind all event handlers
         */
        bindEvents() {
            this.bindToolbarEvents();
            this.bindEditableElementEvents();
            this.bindKeyboardShortcuts();
            this.bindWindowEvents();
        }

        /**
         * Bind toolbar event handlers
         */
        bindToolbarEvents() {
            $('#toggle-edit-mode').on('click', () => this.toggleEditMode());
            $('#save-changes').on('click', () => this.saveChanges());
            $('#undo-changes').on('click', () => this.undo());
            $('#redo-changes').on('click', () => this.redo());

            // Formatting controls
            $('#format-bold').on('click', () => this.execCommand('bold'));
            $('#format-italic').on('click', () => this.execCommand('italic'));
            $('#format-underline').on('click', () => this.execCommand('underline'));
            
            $('#format-heading').on('change', (e) => {
                const tag = $(e.target).val();
                if (tag) this.execCommand('formatBlock', tag);
            });

            // Insert controls
            $('#text-color').on('change', (e) => {
                const color = $(e.target).val();
                this.execCommand('foreColor', color);
                $('.color-picker-preview').css('background', color);
            });

            $('#insert-link').on('click', () => this.insertLink());
            $('#insert-image').on('click', () => this.insertImage());
            $('#editor-settings').on('click', () => this.openSettings());
        }

        /**
         * Bind editable element events
         */
        bindEditableElementEvents() {
            $(document).on('click', '.teznevisan-editable', (e) => {
                if (editorState.isActive) {
                    e.preventDefault();
                    this.editElement($(e.currentTarget));
                }
            });

            $(document).on('input', '.teznevisan-editable', () => {
                this.handleContentChange();
            });
        }

        /**
         * Bind keyboard shortcuts
         */
        bindKeyboardShortcuts() {
            $(document).on('keydown', (e) => {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key) {
                        case 's':
                            e.preventDefault();
                            this.saveChanges();
                            break;
                        case 'z':
                            e.preventDefault();
                            if (e.shiftKey) {
                                this.redo();
                            } else {
                                this.undo();
                            }
                            break;
                    }
                }
            });
        }

        /**
         * Bind window events
         */
        bindWindowEvents() {
            $(window).on('beforeunload', () => {
                if (editorState.isDirty) {
                    return 'تغییرات شما ذخیره نشده است. آیا مطمئن هستید؟';
                }
            });
        }

        /* ==========================================================================
           EDITING FUNCTIONALITY
           ========================================================================== */

        /**
         * Toggle edit mode on/off
         */
        toggleEditMode() {
            editorState.isActive = !editorState.isActive;
            const $toggleBtn = $('#toggle-edit-mode');

            if (editorState.isActive) {
                this.activateEditMode($toggleBtn);
            } else {
                this.deactivateEditMode($toggleBtn);
            }

            this.updateToolbarState();
        }

        /**
         * Activate edit mode
         * @param {jQuery} $toggleBtn
         */
        activateEditMode($toggleBtn) {
            $toggleBtn.addClass('active').attr('title', PERSIAN_STRINGS.exitEditMode);
            $('.teznevisan-editable').attr('contenteditable', 'true');
            $('body').addClass('editor-active');
            this.showNotification('حالت ویرایش فعال شد', 'success');
        }

        /**
         * Deactivate edit mode
         * @param {jQuery} $toggleBtn
         */
        deactivateEditMode($toggleBtn) {
            $toggleBtn.removeClass('active').attr('title', PERSIAN_STRINGS.editMode);
            $('.teznevisan-editable').attr('contenteditable', 'false').removeClass('editing');
            $('body').removeClass('editor-active');
            this.showNotification('حالت ویرایش غیرفعال شد', 'info');
        }

        /**
         * Edit a specific element
         * @param {jQuery} $element
         */
        editElement($element) {
            $('.teznevisan-editable').removeClass('editing');
            editorState.currentElement = $element;
            $element.addClass('editing').focus();
            this.updateFormattingToolbar($element);
        }

        /**
         * Update formatting toolbar based on element type
         * @param {jQuery} $element
         */
        updateFormattingToolbar($element) {
            const elementType = this.getElementType($element);

            if (elementType === 'price') {
                $('.editor-control-group').not(':first').hide();
                $('#format-heading').closest('.editor-control-group').show();
            } else {
                $('.editor-control-group').show();
            }
        }

        /**
         * Execute formatting command
         * @param {string} command
         * @param {*} value
         * @returns {boolean}
         */
        execCommand(command, value = null) {
            if (!editorState.isActive || !editorState.currentElement) {
                return false;
            }

            document.execCommand(command, false, value);
            this.handleContentChange();
            return true;
        }

        /**
         * Handle content changes with debouncing
         */
        handleContentChange() {
            this.markDirty();

            // Debounce history saving
            clearTimeout(editorState.debounceTimer);
            editorState.debounceTimer = setTimeout(() => {
                this.saveToHistory();
            }, EDITOR_CONFIG.debounceDelay);
        }

        /* ==========================================================================
           INSERT FUNCTIONALITY
           ========================================================================== */

        /**
         * Insert a link
         */
        insertLink() {
            const url = prompt('URL لینک را وارد کنید:');
            if (url && this.isValidUrl(url)) {
                this.execCommand('createLink', url);
            } else if (url) {
                this.showNotification('URL وارد شده معتبر نیست', 'error');
            }
        }

        /**
         * Validate URL
         * @param {string} url
         * @returns {boolean}
         */
        isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch {
                return false;
            }
        }

        /**
         * Insert an image
         */
        insertImage() {
            const fileInput = $('<input type="file" accept="image/*" style="display: none;">');
            $('body').append(fileInput);

            fileInput.on('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    this.uploadImage(file);
                }
                fileInput.remove();
            });

            fileInput.click();
        }

        /**
         * Upload image to server
         * @param {File} file
         */
        uploadImage(file) {
            if (!this.validateImageFile(file)) {
                this.showNotification('فایل انتخاب شده معتبر نیست', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'upload_editor_image');
            formData.append('image', file);
            formData.append('nonce', teznevisanAjax.nonce);

            this.showLoading();

            $.ajax({
                url: EDITOR_CONFIG.apiEndpoint,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => this.handleImageUploadSuccess(response),
                error: () => this.handleImageUploadError()
            });
        }

        /**
         * Validate image file
         * @param {File} file
         * @returns {boolean}
         */
        validateImageFile(file) {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            return allowedTypes.includes(file.type) && file.size <= maxSize;
        }

        /**
         * Handle successful image upload
         * @param {Object} response
         */
        handleImageUploadSuccess(response) {
            this.hideLoading();
            if (response.success) {
                const img = `<img src="${response.data.url}" alt="${response.data.alt}" style="max-width: 100%; height: auto;">`;
                this.execCommand('insertHTML', img);
                this.showNotification('تصویر با موفقیت درج شد', 'success');
            } else {
                this.showNotification('خطا در آپلود تصویر: ' + response.data, 'error');
            }
        }

        /**
         * Handle image upload error
         */
        handleImageUploadError() {
            this.hideLoading();
            this.showNotification('خطا در ارتباط با سرور', 'error');
        }

        /* ==========================================================================
           SAVE FUNCTIONALITY
           ========================================================================== */

        /**
         * Save all changes
         */
        saveChanges() {
            if (!editorState.isDirty) {
                this.showNotification('تغییری برای ذخیره وجود ندارد', 'info');
                return;
            }

            this.showSaveStatus('saving');
            const changes = this.collectChanges();

            $.ajax({
                url: EDITOR_CONFIG.apiEndpoint,
                type: 'POST',
                data: {
                    action: 'save_frontend_editor_changes',
                    changes: JSON.stringify(changes),
                    nonce: teznevisanAjax.nonce,
                    page_id: this.getCurrentPageId()
                },
                success: (response) => this.handleSaveSuccess(response),
                error: () => this.handleSaveError()
            });
        }

        /**
         * Collect all changes
         * @returns {Array}
         */
        collectChanges() {
            const changes = [];

            editorState.editableElements.forEach((data, elementId) => {
                const currentContent = data.element.html();
                if (currentContent !== data.originalContent) {
                    changes.push({
                        elementId: elementId,
                        selector: this.getElementSelector(data.element),
                        type: data.type,
                        originalContent: data.originalContent,
                        newContent: currentContent
                    });
                }
            });

            return changes;
        }

        /**
         * Get CSS selector for element
         * @param {jQuery} $element
         * @returns {string}
         */
        getElementSelector($element) {
            let selector = $element[0].tagName.toLowerCase();

            if ($element.attr('id')) {
                selector = '#' + $element.attr('id');
            } else if ($element.attr('class')) {
                const classes = $element.attr('class').split(' ')
                    .filter(cls => !cls.startsWith('teznevisan-') && cls !== 'editing')
                    .slice(0, 2)
                    .join('.');
                if (classes) {
                    selector += '.' + classes;
                }
            }

            return selector;
        }

        /**
         * Get current page ID
         * @returns {string}
         */
        getCurrentPageId() {
            return $('body').attr('class').match(/page-id-(\d+)/)?.[1] || 
                   $('body').attr('class').match(/postid-(\d+)/)?.[1] || 
                   '0';
        }

        /**
         * Handle successful save
         * @param {Object} response
         */
        handleSaveSuccess(response) {
            if (response.success) {
                editorState.isDirty = false;
                this.showSaveStatus('saved');
                this.showNotification('تغییرات ذخیره شد', 'success');
                this.updateToolbarState();
            } else {
                this.showSaveStatus('error');
                this.showNotification('خطا در ذخیره: ' + response.data, 'error');
            }
        }

        /**
         * Handle save error
         */
        handleSaveError() {
            this.showSaveStatus('error');
            this.showNotification('خطا در ارتباط با سرور', 'error');
        }

        /* ==========================================================================
           HISTORY MANAGEMENT
           ========================================================================== */

        /**
         * Save current state to history
         */
        saveToHistory() {
            const state = this.getCurrentState();

            // Remove future states if not at end
            if (editorState.historyIndex < editorState.history.length - 1) {
                editorState.history.splice(editorState.historyIndex + 1);
            }

            // Add new state
            editorState.history.push(state);
            editorState.historyIndex++;

            // Limit history size
            if (editorState.history.length > EDITOR_CONFIG.maxHistoryStates) {
                editorState.history.shift();
                editorState.historyIndex--;
            }

            this.updateToolbarState();
        }

        /**
         * Get current editor state
         * @returns {Object}
         */
        getCurrentState() {
            const state = {};
            editorState.editableElements.forEach((data, elementId) => {
                state[elementId] = data.element.html();
            });
            return state;
        }

        /**
         * Undo last change
         */
        undo() {
            if (editorState.historyIndex > 0) {
                editorState.historyIndex--;
                this.restoreState(editorState.history[editorState.historyIndex]);
                this.markDirty();
                this.updateToolbarState();
            }
        }

        /**
         * Redo last undone change
         */
        redo() {
            if (editorState.historyIndex < editorState.history.length - 1) {
                editorState.historyIndex++;
                this.restoreState(editorState.history[editorState.historyIndex]);
                this.markDirty();
                this.updateToolbarState();
            }
        }

        /**
         * Restore editor state
         * @param {Object} state
         */
        restoreState(state) {
            editorState.editableElements.forEach((data, elementId) => {
                if (state[elementId]) {
                    data.element.html(state[elementId]);
                }
            });
        }

        /* ==========================================================================
           AUTO-SAVE FUNCTIONALITY
           ========================================================================== */

        /**
         * Start auto-save timer
         */
        startAutosave() {
            editorState.autosaveTimer = setInterval(() => {
                if (editorState.isDirty) {
                    this.autosave();
                }
            }, EDITOR_CONFIG.autosaveInterval);
        }

        /**
         * Perform auto-save
         */
        autosave() {
            const changes = this.collectChanges();
            if (changes.length === 0) return;

            $.ajax({
                url: EDITOR_CONFIG.apiEndpoint,
                type: 'POST',
                data: {
                    action: 'autosave_frontend_editor',
                    changes: JSON.stringify(changes),
                    nonce: teznevisanAjax.nonce,
                    page_id: this.getCurrentPageId()
                },
                success: (response) => {
                    if (response.success) {
                        console.log('تغییرات به صورت خودکار ذخیره شد');
                    }
                }
            });
        }

        /* ==========================================================================
           SETTINGS PANEL
           ========================================================================== */

        /**
         * Open settings panel
         */
        openSettings() {
            this.createSettingsPanel();
        }

        /**
         * Create settings panel
         */
        createSettingsPanel() {
            if ($('.editor-settings-panel').length) {
                $('.editor-settings-panel').addClass('open');
                return;
            }

            const panel = $(this.getSettingsPanelHTML());
            $('body').append(panel);
            panel.addClass('open');
            this.bindSettingsPanelEvents(panel);
        }

        /**
         * Get settings panel HTML
         * @returns {string}
         */
        getSettingsPanelHTML() {
            return `
                <div class="editor-settings-panel">
                    <div class="settings-panel-header">
                        <h3 class="settings-panel-title">تنظیمات ویرایشگر</h3>
                        <button class="editor-btn settings-panel-close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="settings-panel-content">
                        ${this.getGeneralSettingsHTML()}
                        ${this.getFontSettingsHTML()}
                        ${this.getActionButtonsHTML()}
                    </div>
                </div>
            `;
        }

        /**
         * Get general settings HTML
         * @returns {string}
         */
        getGeneralSettingsHTML() {
            return `
                <div class="settings-group">
                    <h4 class="settings-group-title">تنظیمات عمومی</h4>
                    <div class="settings-field">
                        <label class="settings-label">
                            <input type="checkbox" id="enable-autosave" checked>
                            ذخیره خودکار
                        </label>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">
                            <input type="checkbox" id="show-element-borders" checked>
                            نمایش حاشیه المان‌ها
                        </label>
                    </div>
                </div>
            `;
        }

        /**
         * Get font settings HTML
         * @returns {string}
         */
        getFontSettingsHTML() {
            return `
                <div class="settings-group">
                    <h4 class="settings-group-title">قلم و نمایش</h4>
                    <div class="settings-field">
                        <label class="settings-label">اندازه قلم پیش‌فرض</label>
                        <select class="settings-select" id="default-font-size">
                            <option value="14">۱۴px</option>
                            <option value="16" selected>۱۶px</option>
                            <option value="18">۱۸px</option>
                            <option value="20">۲۰px</option>
                        </select>
                    </div>
                </div>
            `;
        }

        /**
         * Get action buttons HTML
         * @returns {string}
         */
        getActionButtonsHTML() {
            return `
                <div class="settings-group">
                    <button class="editor-btn" id="reset-all-changes">
                        <i class="fas fa-undo-alt"></i>
                        بازگردانی تمام تغییرات
                    </button>
                    <button class="editor-btn" id="export-changes">
                        <i class="fas fa-download"></i>
                        خروجی تغییرات
                    </button>
                </div>
            `;
        }

        /**
         * Bind settings panel events
         * @param {jQuery} panel
         */
        bindSettingsPanelEvents(panel) {
            panel.find('.settings-panel-close').on('click', () => {
                panel.removeClass('open');
                setTimeout(() => panel.remove(), 300);
            });

            panel.find('#enable-autosave').on('change', (e) => {
                if (e.target.checked) {
                    this.startAutosave();
                } else {
                    clearInterval(editorState.autosaveTimer);
                }
            });

            panel.find('#show-element-borders').on('change', (e) => {
                $('body').toggleClass('show-element-borders', e.target.checked);
            });

            panel.find('#reset-all-changes').on('click', () => {
                if (confirm('آیا مطمئن هستید که می‌خواهید تمام تغییرات را بازگردانی کنید؟')) {
                    this.resetAllChanges();
                }
            });

            panel.find('#export-changes').on('click', () => {
                this.exportChanges();
            });
        }

        /* ==========================================================================
           UTILITY FUNCTIONS
           ========================================================================== */

        /**
         * Mark editor as dirty (has unsaved changes)
         */
        markDirty() {
            editorState.isDirty = true;
            this.updateToolbarState();
        }

        /**
         * Update toolbar button states
         */
        updateToolbarState() {
            $('#save-changes').prop('disabled', !editorState.isDirty);
            $('#undo-changes').prop('disabled', editorState.historyIndex <= 0);
            $('#redo-changes').prop('disabled', editorState.historyIndex >= editorState.history.length - 1);
        }

        /**
         * Reset all changes to original state
         */
        resetAllChanges() {
            editorState.editableElements.forEach((data) => {
                data.element.html(data.originalContent);
            });

            editorState.isDirty = false;
            editorState.history = [];
            editorState.historyIndex = -1;

            this.updateToolbarState();
            this.showNotification('تمام تغییرات بازگردانی شد', 'info');
        }

        /**
         * Export changes as JSON file
         */
        exportChanges() {
            const changes = this.collectChanges();
            const dataStr = JSON.stringify(changes, null, 2);
            const dataBlob = new Blob([dataStr], {type: 'application/json'});
            const url = URL.createObjectURL(dataBlob);

            const link = document.createElement('a');
            link.href = url;
            link.download = 'teznevisan-editor-changes-' + Date.now() + '.json';
            link.click();

            URL.revokeObjectURL(url);
            this.showNotification('فایل تغییرات دانلود شد', 'success');
        }

        /* ==========================================================================
           UI FEEDBACK FUNCTIONS
           ========================================================================== */

        /**
         * Show save status
         * @param {string} status
         */
        showSaveStatus(status) {
            const $saveStatus = $('#save-status');
            const statusTexts = {
                saving: 'در حال ذخیره...',
                saved: 'ذخیره شد',
                error: 'خطا در ذخیره'
            };

            $saveStatus.removeClass('saving saved error')
                      .addClass(status)
                      .find('span').text(statusTexts[status]);
            $saveStatus.show();

            if (status === 'saved') {
                setTimeout(() => $saveStatus.fadeOut(), 3000);
            }
        }

        /**
         * Show loading overlay
         */
        showLoading() {
            if (!$('.loading-overlay').length) {
                $('body').append(`
                    <div class="loading-overlay">
                        <div class="loading-spinner"></div>
                    </div>
                `);
            }
            $('.loading-overlay').addClass('show');
        }

        /**
         * Hide loading overlay
         */
        hideLoading() {
            $('.loading-overlay').removeClass('show');
        }

        /**
         * Show notification
         * @param {string} message
         * @param {string} type
         */
        showNotification(message, type = 'info') {
            const notification = $(`
                <div class="editor-notification ${type}">
                    <i class="fas fa-${this.getNotificationIcon(type)}"></i>
                    ${message}
                </div>
            `);

            $('body').append(notification);

            setTimeout(() => notification.addClass('show'), 100);
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        /**
         * Get notification icon based on type
         * @param {string} type
         * @returns {string}
         */
        getNotificationIcon(type) {
            const icons = {
                success: 'check-circle',
                error: 'exclamation-circle',
                warning: 'exclamation-triangle',
                info: 'info-circle'
            };
            return icons[type] || 'info-circle';
        }
    }

    /* ==========================================================================
       INITIALIZATION
       ========================================================================== */

    /**
     * Initialize editor when document is ready
     */
    $(document).ready(() => {
        if (document.body.classList.contains('logged-in') && 
            (document.body.classList.contains('admin-bar') || window.teznevisanAjax?.canEdit)) {
            
            window.teznevisanEditor = new TezNevisanEditor();
        }
    });

    /**
     * Handle AJAX completion
     */
    $(document).ajaxComplete((event, xhr, settings) => {
        if (settings.data && settings.data.indexOf('action=save_frontend_editor_changes') !== -1) {
            console.log('تغییرات ویرایشگر ذخیره شد');
        }
    });

})(jQuery);
