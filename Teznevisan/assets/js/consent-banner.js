/**
 * GDPR-Compliant Consent Banner for Teznevisan
 * Handles Google Analytics & Clarity consent for EU users
 * @version 1.0.0
 */

(function() {
    'use strict';

    // Check if user is in EU (simplified check)
    const EU_COUNTRIES = ['AT','BE','BG','HR','CY','CZ','DK','EE','FI','FR','DE','GR','HU','IE','IT','LV','LT','LU','MT','NL','PL','PT','RO','SK','SI','ES','SE','GB'];
    
    function isEU() {
        try {
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            // Simplified EU detection - you can enhance with IP geolocation API
            return timezone.includes('Europe') || localStorage.getItem('tz_show_consent') === 'true';
        } catch (e) {
            return false;
        }
    }

    function getConsent(type) {
        return localStorage.getItem('tz_consent_' + type) === 'granted';
    }

    function setConsent(type, value) {
        localStorage.setItem('tz_consent_' + type, value);
        localStorage.setItem('tz_consent_timestamp', Date.now());
    }

    function updateGoogleConsent() {
        if (typeof gtag === 'function') {
            gtag('consent', 'update', {
                'analytics_storage': getConsent('analytics') ? 'granted' : 'denied',
                'ad_storage': getConsent('marketing') ? 'granted' : 'denied',
                'ad_user_data': getConsent('marketing') ? 'granted' : 'denied',
                'ad_personalization': getConsent('marketing') ? 'granted' : 'denied'
            });
        }
    }

    function createBanner() {
        const banner = document.createElement('div');
        banner.id = 'consent-banner';
        banner.className = 'consent-banner';
        banner.setAttribute('role', 'dialog');
        banner.setAttribute('aria-labelledby', 'consent-title');
        banner.setAttribute('aria-describedby', 'consent-desc');
        
        banner.innerHTML = `
            <div class="consent-content">
                <h3 id="consent-title">🍪 حریم خصوصی شما مهم است</h3>
                <p id="consent-desc">ما از کوکی‌ها برای بهبود تجربه شما و تحلیل ترافیک سایت استفاده می‌کنیم. لطفاً انتخاب کنید:</p>
                <div class="consent-buttons">
                    <button id="consent-accept-all" class="consent-btn consent-accept" type="button">
                        قبول همه
                    </button>
                    <button id="consent-necessary" class="consent-btn consent-partial" type="button">
                        فقط ضروری
                    </button>
                    <button id="consent-customize" class="consent-btn consent-settings" type="button">
                        تنظیمات
                    </button>
                </div>
            </div>
            <div class="consent-details" id="consent-details" hidden>
                <div class="consent-option">
                    <label>
                        <input type="checkbox" id="consent-necessary-check" checked disabled>
                        <span>کوکی‌های ضروری (الزامی)</span>
                    </label>
                    <p class="consent-option-desc">برای عملکرد اصلی سایت ضروری هستند.</p>
                </div>
                <div class="consent-option">
                    <label>
                        <input type="checkbox" id="consent-analytics-check">
                        <span>کوکی‌های تحلیلی</span>
                    </label>
                    <p class="consent-option-desc">به ما کمک می‌کنند سایت را بهبود دهیم.</p>
                </div>
                <div class="consent-option">
                    <label>
                        <input type="checkbox" id="consent-marketing-check">
                        <span>کوکی‌های تبلیغاتی</span>
                    </label>
                    <p class="consent-option-desc">برای نمایش تبلیغات مرتبط استفاده می‌شوند.</p>
                </div>
                <div class="consent-buttons">
                    <button id="consent-save" class="consent-btn consent-accept" type="button">
                        ذخیره تنظیمات
                    </button>
                    <button id="consent-back" class="consent-btn consent-secondary" type="button">
                        بازگشت
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(banner);

        // Event Listeners
        document.getElementById('consent-accept-all').addEventListener('click', function() {
            setConsent('necessary', 'granted');
            setConsent('analytics', 'granted');
            setConsent('marketing', 'granted');
            updateGoogleConsent();
            hideBanner();
        });

        document.getElementById('consent-necessary').addEventListener('click', function() {
            setConsent('necessary', 'granted');
            setConsent('analytics', 'denied');
            setConsent('marketing', 'denied');
            updateGoogleConsent();
            hideBanner();
        });

        document.getElementById('consent-customize').addEventListener('click', function() {
            document.querySelector('.consent-content').hidden = true;
            document.getElementById('consent-details').hidden = false;
        });

        document.getElementById('consent-back').addEventListener('click', function() {
            document.querySelector('.consent-content').hidden = false;
            document.getElementById('consent-details').hidden = true;
        });

        document.getElementById('consent-save').addEventListener('click', function() {
            setConsent('necessary', 'granted');
            setConsent('analytics', document.getElementById('consent-analytics-check').checked ? 'granted' : 'denied');
            setConsent('marketing', document.getElementById('consent-marketing-check').checked ? 'granted' : 'denied');
            updateGoogleConsent();
            hideBanner();
        });
    }

    function hideBanner() {
        const banner = document.getElementById('consent-banner');
        if (banner) {
            banner.style.transform = 'translateY(100%)';
            setTimeout(() => banner.remove(), 300);
        }
    }

    function showBanner() {
        createBanner();
        setTimeout(() => {
            const banner = document.getElementById('consent-banner');
            if (banner) banner.classList.add('show');
        }, 100);
    }

    // Initialize
    function init() {
        // Check if consent already given (within 365 days)
        const timestamp = localStorage.getItem('tz_consent_timestamp');
        const oneYear = 365 * 24 * 60 * 60 * 1000;
        
        if (timestamp && (Date.now() - parseInt(timestamp)) < oneYear) {
            // Consent already given, update Google
            updateGoogleConsent();
            return;
        }

        // Show banner only for EU users
        if (isEU()) {
            // Wait for page load
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    setTimeout(showBanner, 1000);
                });
            } else {
                setTimeout(showBanner, 1000);
            }
        } else {
            // Non-EU: grant all consent by default
            setConsent('necessary', 'granted');
            setConsent('analytics', 'granted');
            setConsent('marketing', 'granted');
            updateGoogleConsent();
        }
    }

    // Inject CSS
    const style = document.createElement('style');
    style.textContent = `
        .consent-banner{position:fixed;bottom:0;left:0;right:0;background:#fff;box-shadow:0 -4px 20px rgba(0,0,0,.15);padding:1.5rem;z-index:99999;transform:translateY(100%);transition:transform .3s ease;font-family:Tahoma,Arial,sans-serif;direction:rtl}
        .consent-banner.show{transform:translateY(0)}
        .consent-content{max-width:900px;margin:0 auto}
        #consent-title{font-size:1.25rem;margin-bottom:.75rem;color:#111}
        #consent-desc{margin-bottom:1rem;color:#666;line-height:1.6}
        .consent-buttons{display:flex;gap:.75rem;flex-wrap:wrap}
        .consent-btn{padding:.75rem 1.5rem;border:none;border-radius:8px;font-weight:600;cursor:pointer;transition:all .2s;font-size:1rem}
        .consent-accept{background:#1FA640;color:#fff}
        .consent-accept:hover{background:#178533}
        .consent-partial{background:#6b7280;color:#fff}
        .consent-partial:hover{background:#4b5563}
        .consent-settings{background:#2563eb;color:#fff}
        .consent-settings:hover{background:#1e40af}
        .consent-secondary{background:#e5e7eb;color:#111}
        .consent-secondary:hover{background:#d1d5db}
        .consent-details{max-width:600px;margin:1rem auto 0}
        .consent-option{margin-bottom:1rem;padding:1rem;background:#f9fafb;border-radius:8px}
        .consent-option label{display:flex;align-items:center;gap:.5rem;cursor:pointer;font-weight:600}
        .consent-option-desc{margin:.5rem 0 0 1.75rem;font-size:.875rem;color:#666}
        @media (max-width:640px){
            .consent-banner{padding:1rem}
            .consent-buttons{flex-direction:column}
            .consent-btn{width:100%}
        }
    `;
    document.head.appendChild(style);

    init();
})();
