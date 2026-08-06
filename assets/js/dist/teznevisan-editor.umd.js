/**
 * Teznevisan React Editor - UMD Build
 * Rich text editor with FontAwesome and Persian support
 */
(function (global, factory) {
    if (typeof exports === 'object' && typeof module !== 'undefined') {
        module.exports = factory(require('react'), require('react-dom'));
    } else if (typeof define === 'function' && define.amd) {
        define(['react', 'react-dom'], factory);
    } else {
        global = global || self;
        global.TeznevisanEditor = factory(global.React, global.ReactDOM);
    }
}(this, function (React, ReactDOM) {
    'use strict';

    const { useState, useEffect, useRef } = React;

    // Icon Picker Component
    function IconPicker({ onSelect, isOpen, onClose }) {
        const [searchTerm, setSearchTerm] = useState('');
        const [selectedCategory, setSelectedCategory] = useState('solid');

        const icons = {
            solid: [
                { name: 'خانه', class: 'fa-solid fa-house' },
                { name: 'کاربر', class: 'fa-solid fa-user' },
                { name: 'ایمیل', class: 'fa-solid fa-envelope' },
                { name: 'تلفن', class: 'fa-solid fa-phone' },
                { name: 'موقعیت', class: 'fa-solid fa-location-dot' },
                { name: 'زمان', class: 'fa-solid fa-clock' },
                { name: 'تاریخ', class: 'fa-solid fa-calendar' },
                { name: 'جستجو', class: 'fa-solid fa-magnifying-glass' },
                { name: 'تنظیمات', class: 'fa-solid fa-gear' },
                { name: 'ستاره', class: 'fa-solid fa-star' },
                { name: 'قلب', class: 'fa-solid fa-heart' },
                { name: 'تیک', class: 'fa-solid fa-check' },
                { name: 'ابزار', class: 'fa-solid fa-tools' },
                { name: 'کتاب', class: 'fa-solid fa-book' }
            ],
            brands: [
                { name: 'واتساپ', class: 'fa-brands fa-whatsapp' },
                { name: 'تلگرام', class: 'fa-brands fa-telegram' },
                { name: 'اینستاگرام', class: 'fa-brands fa-instagram' },
                { name: 'فیسبوک', class: 'fa-brands fa-facebook' },
                { name: 'توییتر', class: 'fa-brands fa-twitter' }
            ]
        };

        const filteredIcons = icons[selectedCategory].filter(icon =>
            icon.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            icon.class.toLowerCase().includes(searchTerm.toLowerCase())
        );

        if (!isOpen) return null;

        return React.createElement('div', {
            className: 'icon-picker-overlay',
            style: {
                position: 'fixed',
                top: 0,
                left: 0,
                right: 0,
                bottom: 0,
                background: 'rgba(0, 0, 0, 0.5)',
                zIndex: 10000,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
            }
        },
            React.createElement('div', {
                className: 'icon-picker-modal',
                style: {
                    background: '#fff',
                    borderRadius: '12px',
                    padding: '24px',
                    maxWidth: '600px',
                    maxHeight: '80vh',
                    overflow: 'auto',
                    direction: 'rtl',
                    fontFamily: 'IRANSans, Arial, sans-serif',
                }
            }, [
                React.createElement('div', {
                    key: 'header',
                    style: {
                        display: 'flex',
                        justifyContent: 'space-between',
                        alignItems: 'center',
                        marginBottom: '20px',
                        paddingBottom: '16px',
                        borderBottom: '2px solid #f0f0f0'
                    }
                }, [
                    React.createElement('h3', {
                        key: 'title',
                        style: { margin: 0, color: '#333', fontSize: '18px', fontWeight: '700' }
                    }, 'انتخاب آیکون'),
                    React.createElement('button', {
                        key: 'close',
                        onClick: onClose,
                        style: {
                            background: 'none',
                            border: 'none',
                            fontSize: '24px',
                            cursor: 'pointer',
                            color: '#666',
                            padding: '4px',
                            borderRadius: '4px',
                        }
                    }, '×')
                ]),
                React.createElement('div', {
                    key: 'search',
                    style: { marginBottom: '16px' }
                }, React.createElement('input', {
                    type: 'text',
                    placeholder: 'جستجوی آیکون...',
                    value: searchTerm,
                    onChange: e => setSearchTerm(e.target.value),
                    style: {
                        width: '100%',
                        padding: '10px',
                        border: '2px solid #e0e0e0',
                        borderRadius: '6px',
                        fontSize: '14px',
                        fontFamily: 'IRANSans, Arial, sans-serif',
                    }
                })),
                React.createElement('div', {
                    key: 'tabs',
                    style: { display: 'flex', gap: '8px', marginBottom: '20px' }
                }, Object.keys(icons).map(category =>
                    React.createElement('button', {
                        key: category,
                        onClick: () => setSelectedCategory(category),
                        style: {
                            padding: '8px 16px',
                            border: 'none',
                            borderRadius: '6px',
                            cursor: 'pointer',
                            fontSize: '14px',
                            fontWeight: '600',
                            background: selectedCategory === category ? '#1FA547' : '#f5f5f5',
                            color: selectedCategory === category ? '#fff' : '#333',
                            fontFamily: 'IRANSans, Arial, sans-serif',
                        }
                    }, category === 'solid' ? 'Solid' : 'Brands')
                )),
                React.createElement('div', {
                    key: 'icons',
                    style: {
                        display: 'grid',
                        gridTemplateColumns: 'repeat(auto-fill, minmax(100px, 1fr))',
                        gap: '12px',
                        maxHeight: '300px',
                        overflow: 'auto',
                        border: '1px solid #e0e0e0',
                        borderRadius: '6px',
                        padding: '16px',
                    }
                }, filteredIcons.map(icon =>
                    React.createElement('div', {
                        key: icon.class,
                        onClick: () => onSelect(icon),
                        style: {
                            display: 'flex',
                            flexDirection: 'column',
                            alignItems: 'center',
                            padding: '12px',
                            border: '2px solid #e0e0e0',
                            borderRadius: '6px',
                            cursor: 'pointer',
                            transition: 'all 0.3s ease',
                            background: '#fff',
                        },
                        onMouseEnter: e => {
                            e.currentTarget.style.borderColor = '#1FA547';
                            e.currentTarget.style.background = '#f8f9fa';
                        },
                        onMouseLeave: e => {
                            e.currentTarget.style.borderColor = '#e0e0e0';
                            e.currentTarget.style.background = '#fff';
                        }
                    }, [
                        React.createElement('i', {
                            key: 'icon',
                            className: icon.class,
                            style: { fontSize: '24px', marginBottom: '8px', color: '#1FA547' }
                        }),
                        React.createElement('span', {
                            key: 'name',
                            style: {
                                fontSize: '10px',
                                textAlign: 'center',
                                fontWeight: '500',
                                color: '#333',
                            }
                        }, icon.name)
                    ])
                ))
            ])
        );
    }

    // Rich Text Editor Component
    function RichTextEditor({ initialContent, onChange, config }) {
        const editorRef = useRef(null);
        const [content, setContent] = useState(initialContent || '');
        const [isIconPickerOpen, setIsIconPickerOpen] = useState(false);
        const [editorInstance, setEditorInstance] = useState(null);

        useEffect(() => {
            if (typeof tinymce !== 'undefined') {
                initializeTinyMCE();
            } else {
                loadTinyMCE().then(() => initializeTinyMCE());
            }

            return () => {
                if (editorInstance) editorInstance.destroy();
            };
        }, []);

        const loadTinyMCE = () => new Promise(resolve => {
            const script = document.createElement('script');
            script.src = '/wp-includes/js/tinymce/tinymce.min.js';
            script.onload = resolve;
            document.head.appendChild(script);
        });

        const initializeTinyMCE = () => {
            const editorConfig = {
                selector: `#${editorRef.current.id}`,
                height: 400,
                language: 'fa',
                directionality: 'rtl',
                skin: 'oxide',
                content_css: config?.contentCss || '/assets/css/editor-fontawesome.css',
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste help wordcount',
                toolbar: 'undo redo | bold italic underline | fontfamily fontsize | forecolor backcolor | alignleft aligncenter alignright alignjustify | numlist bullist | link image | iconpicker | code preview fullscreen',
                menubar: false,
                branding: false,
                setup: (editor) => {
                    editor.ui.registry.addButton('iconpicker', {
                        text: 'آیکون',
                        onAction: () => setIsIconPickerOpen(true),
                    });
                    editor.on('change', () => {
                        const newContent = editor.getContent();
                        setContent(newContent);
                        if (onChange) onChange(newContent);
                    });
                    setEditorInstance(editor);
                },
                init_instance_callback: (editor) => {
                    editor.setContent(content);
                }
            };
            tinymce.init(editorConfig);
        };

        const handleIconSelect = icon => {
            if (editorInstance) {
                const iconHTML = `<i class="${icon.class}" aria-hidden="true"></i>`;
                editorInstance.insertContent(iconHTML);
            }
            setIsIconPickerOpen(false);
        };

        return React.createElement('div', { className: 'teznevisan-rich-editor', style: { width: '100%' } }, [
            React.createElement('textarea', {
                key: 'editor',
                ref: editorRef,
                id: `tez-editor-${Date.now()}`,
                value: content,
                onChange: e => setContent(e.target.value),
                style: {
                    width: '100%',
                    minHeight: '400px',
                    fontFamily: 'IRANSans, Arial, sans-serif',
                    fontSize: '16px',
                    padding: '16px',
                    border: '2px solid #e0e0e0',
                    borderRadius: '8px',
                }
            }),
            React.createElement(IconPicker, {
                key: 'iconpicker',
                isOpen: isIconPickerOpen,
                onSelect: handleIconSelect,
                onClose: () => setIsIconPickerOpen(false),
            }),
        ]);
    }

    // Main Editor Component
    function TeznevisanEditor({ locale = 'fa', theme = 'teznevisan', apiUrl, nonce }) {
        const [content, setContent] = useState('');
        const [isSaving, setIsSaving] = useState(false);
        const [saveStatus, setSaveStatus] = useState('');
        const [templates, setTemplates] = useState([]);
        const [showTemplates, setShowTemplates] = useState(false);

        useEffect(() => {
            loadTemplates();
        }, []);

        const loadTemplates = async () => {
            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'teznevisan_react_editor',
                        editor_action: 'load_templates',
                        nonce: nonce
                    })
                });
                const result = await response.json();
                if (result.success) setTemplates(result.templates || []);
            } catch (error) {
                console.error('Failed to load templates:', error);
            }
        };

        const saveContent = async () => {
            if (!content.trim()) return;
            setIsSaving(true);
            setSaveStatus('در حال ذخیره...');
            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'teznevisan_react_editor',
                        editor_action: 'save_content',
                        content: content,
                        nonce: nonce
                    }),
                });
                const result = await response.json();
                if (result.success) {
                    setSaveStatus('ذخیره شد ✓');
                    setTimeout(() => setSaveStatus(''), 2000);
                } else {
                    setSaveStatus('خطا در ذخیره');
                }
            } catch (error) {
                console.error('Save failed:', error);
                setSaveStatus('خطا در ذخیره');
            } finally {
                setIsSaving(false);
            }
        };

        const insertTemplate = template => {
            setContent(prev => prev + '\n\n' + template.content);
            setShowTemplates(false);
        };

        return React.createElement('div', {
            className: `teznevisan-editor theme-${theme}`,
            style: {
                fontFamily: 'IRANSans, Arial, sans-serif',
                direction: locale === 'fa' ? 'rtl' : 'ltr',
            }
        }, [
            React.createElement('div', {
                key: 'toolbar',
                className: 'editor-toolbar',
                style: {
                    display: 'flex',
                    gap: '12px',
                    marginBottom: '20px',
                    padding: '16px',
                    background: '#f8f9fa',
                    borderRadius: '8px',
                    alignItems: 'center'
                }
            }, [
                React.createElement('button', {
                    key: 'save',
                    onClick: saveContent,
                    disabled: isSaving,
                    style: {
                        padding: '10px 20px',
                        background: '#1FA547',
                        color: '#fff',
                        border: 'none',
                        borderRadius: '6px',
                        cursor: isSaving ? 'not-allowed' : 'pointer',
                        fontFamily: 'IRANSans, Arial, sans-serif',
                        fontWeight: '600',
                        fontSize: '14px',
                        opacity: isSaving ? 0.6 : 1,
                    }
                }, isSaving ? 'در حال ذخیره...' : 'ذخیره محتوا'),
                React.createElement('button', {
                    key: 'templates',
                    onClick: () => setShowTemplates(!showTemplates),
                    style: {
                        padding: '10px 16px',
                        background: '#6c757d',
                        color: '#fff',
                        border: 'none',
                        borderRadius: '6px',
                        cursor: 'pointer',
                        fontFamily: 'IRANSans, Arial, sans-serif',
                        fontWeight: '600',
                        fontSize: '14px',
                    }
                }, 'قالب‌ها'),
                React.createElement('span', {
                    key: 'status',
                    style: {
                        marginLeft: 'auto',
                        fontSize: '14px',
                        fontWeight: '500',
                        color: saveStatus.includes('✓')
                            ? '#28a745'
                            : saveStatus.includes('خطا')
                                ? '#dc3545'
                                : '#6c757d',
                    }
                }, saveStatus),
            ]),
            showTemplates && React.createElement('div', {
                key: 'templates-panel',
                className: 'templates-panel',
                style: {
                    marginBottom: '20px',
                    padding: '16px',
                    background: '#fff',
                    border: '2px solid #e0e0e0',
                    borderRadius: '8px',
                }
            }, [
                React.createElement('h4', {
                    key: 'templates-title',
                    style: { marginBottom: '12px', color: '#333' }
                }, 'قالب‌های محتوا'),
                React.createElement('div', {
                    key: 'templates-grid',
                    style: {
                        display: 'grid',
                        gridTemplateColumns: 'repeat(auto-fill, minmax(200px, 1fr))',
                        gap: '12px',
                    }
                }, templates.map(template =>
                    React.createElement('div', {
                        key: template.name,
                        onClick: () => insertTemplate(template),
                        style: {
                            padding: '12px',
                            border: '1px solid #ddd',
                            borderRadius: '6px',
                            cursor: 'pointer',
                            transition: 'all 0.3s ease',
                            background: '#fff',
                        },
                        onMouseEnter: e => {
                            e.currentTarget.style.borderColor = '#1FA547';
                            e.currentTarget.style.background = '#f8f9fa';
                        },
                        onMouseLeave: e => {
                            e.currentTarget.style.borderColor = '#ddd';
                            e.currentTarget.style.background = '#fff';
                        }
                    }, [
                        React.createElement('h5', {
                            key: 'name',
                            style: { margin: '0 0 8px 0', fontSize: '14px', fontWeight: '600' }
                        }, template.name),
                        React.createElement('p', {
                            key: 'preview',
                            style: {
                                margin: 0,
                                fontSize: '12px',
                                color: '#666',
                                overflow: 'hidden',
                                textOverflow: 'ellipsis',
                                whiteSpace: 'nowrap',
                            }
                        }, template.content.substring(0, 50) + '...')
                    ])
                ))
            ]),
            React.createElement(RichTextEditor, {
                key: 'editor',
                initialContent: content,
                onChange: setContent,
                config: { contentCss: undefined, locale: locale }
            }),
        ]);
    }

    return TeznevisanEditor;
}));
