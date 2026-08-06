/**
 * Teznevisan React Components Bundle
 * Reusable UI components for the theme
 */
(function (global, factory) {
    if (typeof exports === 'object' && typeof module !== 'undefined') {
        module.exports = factory(require('react'));
    } else if (typeof define === 'function' && define.amd) {
        define(['react'], factory);
    } else {
        (global = global || self);
        global.TeznevisanComponents = factory(global.React);
    }
}(this, function (React) {
    'use strict';
    
    const { useState, useEffect, useRef } = React;
    
    // Button Component
    function Button({ children, variant = 'primary', size = 'medium', onClick, disabled, ...props }) {
        const baseStyles = {
            display: 'inline-flex',
            alignItems: 'center',
            justifyContent: 'center',
            gap: '8px',
            fontFamily: 'IRANSans, Arial, sans-serif',
            fontWeight: '600',
            border: 'none',
            borderRadius: '6px',
            cursor: disabled ? 'not-allowed' : 'pointer',
            transition: 'all 0.3s ease',
            textDecoration: 'none',
            opacity: disabled ? 0.6 : 1,
            touchAction: 'manipulation'
        };
        
        const variants = {
            primary: {
                background: '#1FA547',
                color: '#ffffff',
                border: '2px solid #1FA547'
            },
            secondary: {
                background: '#ffffff',
                color: '#1FA547',
                border: '2px solid #1FA547'
            },
            danger: {
                background: '#dc3545',
                color: '#ffffff',
                border: '2px solid #dc3545'
            }
        };
        
        const sizes = {
            small: { padding: '6px 12px', fontSize: '13px' },
            medium: { padding: '10px 16px', fontSize: '14px' },
            large: { padding: '12px 20px', fontSize: '16px' }
        };
        
        const style = {
            ...baseStyles,
            ...variants[variant],
            ...sizes[size]
        };
        
        return React.createElement('button', {
            ...props,
            onClick: disabled ? undefined : onClick,
            style: style,
            onMouseEnter: (e) => {
                if (!disabled) {
                    if (variant === 'primary') {
                        e.target.style.background = '#178A3A';
                    } else if (variant === 'secondary') {
                        e.target.style.background = '#f8f9fa';
                    }
                }
            },
            onMouseLeave: (e) => {
                if (!disabled) {
                    e.target.style.background = variants[variant].background;
                }
            }
        }, children);
    }
    
    // Modal Component
    function Modal({ isOpen, onClose, title, children, size = 'medium' }) {
        useEffect(() => {
            const handleEscape = (e) => {
                if (e.key === 'Escape' && isOpen) {
                    onClose();
                }
            };
            
            if (isOpen) {
                document.addEventListener('keydown', handleEscape);
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
            
            return () => {
                document.removeEventListener('keydown', handleEscape);
                document.body.style.overflow = '';
            };
        }, [isOpen, onClose]);
        
        if (!isOpen) return null;
        
        const sizes = {
            small: { maxWidth: '400px' },
            medium: { maxWidth: '600px' },
            large: { maxWidth: '800px' }
        };
        
        return React.createElement('div', {
            className: 'modal-overlay',
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
                padding: '20px'
            },
            onClick: (e) => {
                if (e.target === e.currentTarget) {
                    onClose();
                }
            }
        }, React.createElement('div', {
            className: 'modal-content',
            style: {
                background: '#fff',
                borderRadius: '12px',
                padding: '24px',
                width: '100%',
                maxHeight: '90vh',
                overflow: 'auto',
                direction: 'rtl',
                fontFamily: 'IRANSans, Arial, sans-serif',
                ...sizes[size]
            }
        }, [
            title && React.createElement('div', {
                key: 'header',
                className: 'modal-header',
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
                }, title),
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
                        borderRadius: '4px'
                    }
                }, '×')
            ]),
            
            React.createElement('div', {
                key: 'body',
                className: 'modal-body'
            }, children)
        ]));
    }
    
    // Loading Spinner Component
    function LoadingSpinner({ size = 'medium', color = '#1FA547' }) {
        const sizes = {
            small: '20px',
            medium: '32px',
            large: '48px'
        };
        
        return React.createElement('div', {
            className: 'loading-spinner',
            style: {
                display: 'inline-block',
                width: sizes[size],
                height: sizes[size],
                border: `3px solid ${color}33`,
                borderTop: `3px solid ${color}`,
                borderRadius: '50%',
                animation: 'spin 1s linear infinite'
            }
        });
    }
    
    // Toast Notification Component
    function Toast({ message, type = 'info', duration = 3000, onClose }) {
        useEffect(() => {
            if (duration > 0) {
                const timer = setTimeout(() => {
                    if (onClose) onClose();
                }, duration);
                
                return () => clearTimeout(timer);
            }
        }, [duration, onClose]);
        
        const types = {
            success: { background: '#d4edda', color: '#155724', border: '#c3e6cb' },
            error: { background: '#f8d7da', color: '#721c24', border: '#f5c6cb' },
            warning: { background: '#fff3cd', color: '#856404', border: '#ffeaa7' },
            info: { background: '#d1ecf1', color: '#0c5460', border: '#bee5eb' }
        };
        
        return React.createElement('div', {
            className: `toast toast-${type}`,
            style: {
                position: 'fixed',
                top: '20px',
                right: '20px',
                padding: '12px 16px',
                borderRadius: '6px',
                border: `1px solid ${types[type].border}`,
                background: types[type].background,
                color: types[type].color,
                fontFamily: 'IRANSans, Arial, sans-serif',
                fontSize: '14px',
                zIndex: 10001,
                minWidth: '200px',
                animation: 'slideInRight 0.3s ease'
            }
        }, [
            React.createElement('div', {
                key: 'content',
                style: { display: 'flex', alignItems: 'center', gap: '8px' }
            }, [
                React.createElement('span', { key: 'message' }, message),
                onClose && React.createElement('button', {
                    key: 'close',
                    onClick: onClose,
                    style: {
                        background: 'none',
                        border: 'none',
                        fontSize: '16px',
                        cursor: 'pointer',
                        color: 'inherit',
                        marginLeft: 'auto'
                    }
                }, '×')
            ])
        ]);
    }
    
    // Progress Bar Component
    function ProgressBar({ value, max = 100, showPercentage = true }) {
        const percentage = Math.round((value / max) * 100);
        
        return React.createElement('div', {
            className: 'progress-bar',
            style: {
                width: '100%',
                height: '8px',
                background: '#e0e0e0',
                borderRadius: '4px',
                overflow: 'hidden',
                position: 'relative'
            }
        }, [
            React.createElement('div', {
                key: 'fill',
                style: {
                    width: `${percentage}%`,
                    height: '100%',
                    background: 'linear-gradient(90deg, #1FA547, #2FD65A)',
                    transition: 'width 0.3s ease'
                }
            }),
            
            showPercentage && React.createElement('span', {
                key: 'percentage',
                style: {
                    position: 'absolute',
                    top: '50%',
                    left: '50%',
                    transform: 'translate(-50%, -50%)',
                    fontSize: '12px',
                    fontWeight: '600',
                    color: percentage > 50 ? '#fff' : '#333'
                }
            }, `${percentage}%`)
        ]);
    }
    
    // Form Field Component
    function FormField({ label, type = 'text', value, onChange, error, required, ...props }) {
        const fieldId = `field-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
        
        return React.createElement('div', {
            className: 'form-field',
            style: { marginBottom: '16px' }
        }, [
            React.createElement('label', {
                key: 'label',
                htmlFor: fieldId,
                style: {
                    display: 'block',
                    marginBottom: '6px',
                    fontWeight: '600',
                    color: '#333',
                    fontSize: '14px',
                    fontFamily: 'IRANSans, Arial, sans-serif'
                }
            }, [
                label,
                required && React.createElement('span', {
                    key: 'required',
                    style: { color: '#dc3545', marginRight: '4px' }
                }, '*')
            ]),
            
            React.createElement(type === 'textarea' ? 'textarea' : 'input', {
                key: 'input',
                id: fieldId,
                type: type === 'textarea' ? undefined : type,
                value: value,
                onChange: (e) => onChange && onChange(e.target.value),
                style: {
                    width: '100%',
                    padding: '10px 12px',
                    border: `2px solid ${error ? '#dc3545' : '#e0e0e0'}`,
                    borderRadius: '6px',
                    fontSize: '14px',
                    fontFamily: 'IRANSans, Arial, sans-serif',
                    transition: 'border-color 0.3s ease',
                    background: '#fff'
                },
                onFocus: (e) => {
                    e.target.style.borderColor = error ? '#dc3545' : '#1FA547';
                    e.target.style.outline = 'none';
                },
                onBlur: (e) => {
                    e.target.style.borderColor = error ? '#dc3545' : '#e0e0e0';
                },
                ...props
            }),
            
            error && React.createElement('span', {
                key: 'error',
                style: {
                    display: 'block',
                    marginTop: '4px',
                    fontSize: '12px',
                    color: '#dc3545',
                    fontWeight: '500'
                }
            }, error)
        ]);
    }
    
    // Add CSS animations
    const styleSheet = document.createElement('style');
    styleSheet.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    `;
    
    document.head.appendChild(styleSheet);
    
    // Export all components
    return {
        Button,
        Modal,
        LoadingSpinner,
        Toast,
        ProgressBar,
        FormField
    };
}));