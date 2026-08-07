/* ====================================
   FIXED Rating System with Schema
   ==================================== */

class RatingSystem {
    constructor() {
        this.apiUrl = 'https://teznevisan3.com/api/ratings.php';
        this.pageId = this.getPageId();
        this.init();
    }

    async init() {
        await this.injectRatingUI();
        await this.loadRatings();
        this.bindEvents();
        this.generateSchema();
    }

    getPageId() {
        return window.location.pathname.replace(/\//g, '_').replace('.html', '') || 'home';
    }

    async injectRatingUI() {
        const mainContent = document.querySelector('main');
        if (!mainContent) return;

        const ratingHTML = `
            <div class="rating-section" id="rating-section">
                <div class="container">
                    <div class="rating-card">
                        <h3>
                            <i class="fa-solid fa-star"></i>
                            این صفحه را امتیاز دهید
                        </h3>
                        <div class="rating-stars" id="rating-stars">
                            ${[5,4,3,2,1].map(n => `
                                <button class="star-btn" data-rating="${n}" aria-label="${n} ستاره">
                                    <i class="fa-regular fa-star"></i>
                                </button>
                            `).join('')}
                        </div>
                        <div class="rating-summary">
                            <div class="rating-average">
                                <span class="average-number" id="average-rating">0</span>
                                <div class="stars-display" id="stars-display"></div>
                            </div>
                            <div class="rating-count">
                                از <span id="total-ratings">0</span> رای
                            </div>
                        </div>
                    </div>

                    <div class="feedback-buttons">
                        <button class="feedback-btn like-btn" data-type="like" aria-label="مفید بود">
                            <i class="fa-solid fa-thumbs-up"></i>
                            <span>مفید بود</span>
                            <span class="count" id="like-count">0</span>
                        </button>
                        <button class="feedback-btn dislike-btn" data-type="dislike" aria-label="مفید نبود">
                            <i class="fa-solid fa-thumbs-down"></i>
                            <span>مفید نبود</span>
                            <span class="count" id="dislike-count">0</span>
                        </button>
                    </div>
                </div>
            </div>

            <style>
            .rating-section{padding:3rem 0;background:var(--gray-50)}
            .rating-card{background:var(--bg-color);border:2px solid var(--border-color);border-radius:1rem;padding:2rem;text-align:center;margin-bottom:2rem}
            .rating-stars{display:flex;justify-content:center;gap:.5rem;margin:1.5rem 0}
            .star-btn{background:none;border:none;font-size:2.5rem;color:#f59e0b;cursor:pointer;transition:all .2s}
            .star-btn:hover,.star-btn.active{transform:scale(1.2)}
            .star-btn.active i{font-weight:900}
            .stars-display{display:flex;justify-content:center;gap:.25rem;margin:.5rem 0}
            .stars-display i{color:#f59e0b;font-size:1.25rem}
            .average-number{font-size:2rem;font-weight:700;color:var(--secondary-color)}
            .feedback-buttons{display:flex;justify-content:center;gap:1rem}
            .feedback-btn{display:flex;align-items:center;gap:.75rem;padding:1rem 2rem;border:2px solid var(--border-color);border-radius:.75rem;background:var(--bg-color);cursor:pointer;transition:all .3s}
            .feedback-btn:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,.1)}
            .feedback-btn.active.like-btn{background:var(--secondary-color);color:white;border-color:var(--secondary-color)}
            .feedback-btn.active.dislike-btn{background:var(--danger-color);color:white;border-color:var(--danger-color)}
            .feedback-btn .count{background:var(--gray-100);padding:.25rem .75rem;border-radius:1rem;font-weight:600}
            .feedback-btn.active .count{background:rgba(255,255,255,.2);color:white}
            </style>
        `;

        mainContent.insertAdjacentHTML('beforeend', ratingHTML);
    }

    bindEvents() {
        document.querySelectorAll('.star-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.submitRating(e));
            btn.addEventListener('mouseenter', (e) => this.previewRating(e));
        });

        document.getElementById('rating-stars')?.addEventListener('mouseleave', () => {
            this.resetPreview();
        });

        document.querySelectorAll('.feedback-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.submitFeedback(e));
        });
    }

    async loadRatings() {
        try {
            const response = await fetch(`${this.apiUrl}?action=get&page=${this.pageId}`);
            const data = await response.json();
            
            if (data.success) {
                this.updateDisplay(data.ratings);
            }
        } catch (error) {
            console.error('Error loading ratings:', error);
        }
    }

    async submitRating(e) {
        const rating = parseInt(e.currentTarget.dataset.rating);
        
        try {
            const response = await fetch(this.apiUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'rate',
                    page: this.pageId,
                    rating: rating
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showToast('امتیاز شما ثبت شد!', 'success');
                this.updateDisplay(data.ratings);
                this.generateSchema();
            } else {
                this.showToast(data.message, 'error');
            }
        } catch (error) {
            console.error('Error submitting rating:', error);
            this.showToast('خطا در ثبت امتیاز', 'error');
        }
    }

    async submitFeedback(e) {
        const btn = e.currentTarget;
        const type = btn.dataset.type;
        
        try {
            const response = await fetch(this.apiUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'feedback',
                    page: this.pageId,
                    type: type
                })
            });

            const data = await response.json();
            
            if (data.success) {
                btn.classList.toggle('active');
                this.updateDisplay(data.ratings);
            }
        } catch (error) {
            console.error('Error submitting feedback:', error);
        }
    }

    previewRating(e) {
        const rating = parseInt(e.currentTarget.dataset.rating);
        document.querySelectorAll('.star-btn').forEach(btn => {
            const btnRating = parseInt(btn.dataset.rating);
            if (btnRating >= rating) {
                btn.classList.add('active');
                btn.querySelector('i').classList.remove('fa-regular');
                btn.querySelector('i').classList.add('fa-solid');
            } else {
                btn.classList.remove('active');
                btn.querySelector('i').classList.add('fa-regular');
                btn.querySelector('i').classList.remove('fa-solid');
            }
        });
    }

    resetPreview() {
        const currentAverage = parseFloat(document.getElementById('average-rating').textContent);
        const roundedAverage = Math.round(currentAverage);
        
        document.querySelectorAll('.star-btn').forEach(btn => {
            const btnRating = parseInt(btn.dataset.rating);
            if (btnRating >= (6 - roundedAverage)) {
                btn.classList.add('active');
                btn.querySelector('i').classList.remove('fa-regular');
                btn.querySelector('i').classList.add('fa-solid');
            } else {
                btn.classList.remove('active');
                btn.querySelector('i').classList.add('fa-regular');
                btn.querySelector('i').classList.remove('fa-solid');
            }
        });
    }

    updateDisplay(ratings) {
        document.getElementById('average-rating').textContent = ratings.average || '0';
        document.getElementById('total-ratings').textContent = ratings.total || '0';
        document.getElementById('like-count').textContent = ratings.likes || '0';
        document.getElementById('dislike-count').textContent = ratings.dislikes || '0';
        
        // Update star display
        const starsDisplay = document.getElementById('stars-display');
        const average = parseFloat(ratings.average) || 0;
        const fullStars = Math.floor(average);
        
        starsDisplay.innerHTML = '';
        for (let i = 0; i < 5; i++) {
            const star = document.createElement('i');
            star.className = i < fullStars ? 'fa-solid fa-star' : 'fa-regular fa-star';
            starsDisplay.appendChild(star);
        }
        
        this.resetPreview();
    }

    generateSchema() {
        const average = parseFloat(document.getElementById('average-rating').textContent) || 0;
        const total = parseInt(document.getElementById('total-ratings').textContent) || 0;
        
        if (total === 0) return;
        
        const schema = {
            "@context": "https://schema.org",
            "@type": "AggregateRating",
            "ratingValue": average,
            "bestRating": "5",
            "worstRating": "1",
            "ratingCount": total,
            "itemReviewed": {
                "@type": "WebPage",
                "name": document.title,
                "url": window.location.href
            }
        };
        
        let schemaScript = document.getElementById('rating-schema');
        if (!schemaScript) {
            schemaScript = document.createElement('script');
            schemaScript.id = 'rating-schema';
            schemaScript.type = 'application/ld+json';
            document.head.appendChild(schemaScript);
        }
        schemaScript.textContent = JSON.stringify(schema);
    }

    showToast(message, type) {
    const toastElement = document.createElement('div'); // FIXED: was 'toast'
    toastElement.className = 'toast toast-' + type;
    toastElement.style.cssText = 'position:fixed;top:5rem;right:2rem;background:white;padding:1rem 1.5rem;border-radius:.5rem;box-shadow:0 10px 25px rgba(0,0,0,.1);z-index:9999;animation:slideIn .3s';
    toastElement.innerHTML = ` 
        <div style="display:flex;align-items:center;gap:.75rem">
            <i class="fa-solid fa-${type === 'success' ? 'check' : 'times'}-circle" style="color:${type === 'success' ? 'var(--success-color)' : 'var(--danger-color)'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toastElement);
    setTimeout(() => toastElement.remove(), 3000);
}

}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    new RatingSystem();
});
