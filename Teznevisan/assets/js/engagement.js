/* ====================================
   User Engagement System
   Comments, Ratings, Likes, Reviews
   ==================================== */

class EngagementSystem {
    constructor() {
        this.storageKey = 'teznevisan_engagement';
        this.pageId = this.generatePageId();
        this.data = this.loadData();
        this.init();
    }
    
    init() {
        this.injectEngagementUI();
        this.bindEvents();
        this.loadPageEngagement();
    }
    
    generatePageId() {
        return window.location.pathname.replace(/\//g, '_').replace('.html', '');
    }
    
    loadData() {
        const stored = localStorage.getItem(this.storageKey);
        return stored ? JSON.parse(stored) : {};
    }
    
    saveData() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.data));
    }
    
    injectEngagementUI() {
        // Find injection point (after main content)
        const mainContent = document.querySelector('main, .site-main');
        if (!mainContent) return;
        
        const engagementHTML = `
            <section class="engagement-section">
                <div class="container">
                    <!-- Page Rating -->
                    <div class="page-rating-card">
                        <h3>
                            <i class="fa-solid fa-star"></i>
                            آیا این صفحه برای شما مفید بود؟
                        </h3>
                        <div class="rating-container">
                            <div class="stars" id="page-rating">
                                ${[5,4,3,2,1].map(n => `
                                    <i class="fa-star star" data-rating="${n}"></i>
                                `).join('')}
                            </div>
                            <div class="rating-stats">
                                <span class="rating-average" id="rating-average">0</span>
                                <span class="rating-count" id="rating-count">(0 رای)</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Reactions -->
                    <div class="quick-reactions">
                        <button class="reaction-btn" data-reaction="helpful">
                            <i class="fa-solid fa-thumbs-up"></i>
                            <span>مفید بود</span>
                            <span class="count" id="helpful-count">0</span>
                        </button>
                        <button class="reaction-btn" data-reaction="love">
                            <i class="fa-solid fa-heart"></i>
                            <span>عالی</span>
                            <span class="count" id="love-count">0</span>
                        </button>
                        <button class="reaction-btn" data-reaction="bookmark">
                            <i class="fa-solid fa-bookmark"></i>
                            <span>ذخیره</span>
                            <span class="count" id="bookmark-count">0</span>
                        </button>
                        <button class="reaction-btn" data-reaction="share">
                            <i class="fa-solid fa-share-alt"></i>
                            <span>اشتراک</span>
                            <span class="count" id="share-count">0</span>
                        </button>
                    </div>
                    
                    <!-- Comments Section -->
                    <div class="comments-section" id="comments-section">
                        <h3>
                            <i class="fa-solid fa-comments"></i>
                            نظرات کاربران
                            <span class="comment-count" id="total-comments">0</span>
                        </h3>
                        
                        <!-- Comment Form -->
                        <div class="comment-form-card">
                            <h4>دیدگاه خود را بنویسید</h4>
                            <form id="comment-form">
                                <div class="form-row">
                                    <div class="form-group">
                                        <input type="text" id="comment-name" placeholder="نام شما *" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" id="comment-email" placeholder="ایمیل *" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea id="comment-text" rows="4" placeholder="متن نظر... *" required></textarea>
                                </div>
                                <div class="form-footer">
                                    <label class="save-info">
                                        <input type="checkbox" id="save-info">
                                        <span>ذخیره اطلاعات برای دفعات بعد</span>
                                    </label>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        ارسال نظر
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Comments List -->
                        <div class="comments-list" id="comments-list">
                            <!-- Comments will be injected here -->
                        </div>
                    </div>
                </div>
            </section>
        `;
        
        mainContent.insertAdjacentHTML('beforeend', engagementHTML);
    }
    
    bindEvents() {
        // Star rating
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', (e) => this.handleRating(e));
            star.addEventListener('mouseenter', (e) => this.previewRating(e));
        });
        
        document.getElementById('page-rating')?.addEventListener('mouseleave', () => {
            this.resetRatingPreview();
        });
        
        // Reactions
        document.querySelectorAll('.reaction-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.handleReaction(e));
        });
        
        // Comment form
        document.getElementById('comment-form')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitComment();
        });
        
        // Share button
        document.querySelector('[data-reaction="share"]')?.addEventListener('click', () => {
            this.shareThought();
        });
    }
    
    loadPageEngagement() {
        if (!this.data[this.pageId]) {
            this.data[this.pageId] = {
                ratings: [],
                reactions: { helpful: 0, love: 0, bookmark: 0, share: 0 },
                comments: [],
                userActions: {}
            };
        }
        
        this.updateRatingDisplay();
        this.updateReactionCounts();
        this.renderComments();
    }
    
    handleRating(e) {
        const rating = parseInt(e.target.dataset.rating);
        const userId = this.getUserId();
        
        // Check if user already rated
        if (this.data[this.pageId].userActions[userId]?.rated) {
            alert('شما قبلاً به این صفحه امتیاز داده‌اید');
            return;
        }
        
        this.data[this.pageId].ratings.push(rating);
        
        if (!this.data[this.pageId].userActions[userId]) {
            this.data[this.pageId].userActions[userId] = {};
        }
        this.data[this.pageId].userActions[userId].rated = true;
        
        this.saveData();
        this.updateRatingDisplay();
        this.showToast('امتیاز شما ثبت شد!', 'success');
    }
    
    previewRating(e) {
        const rating = parseInt(e.target.dataset.rating);
        const stars = document.querySelectorAll('.star');
        stars.forEach(star => {
            const starRating = parseInt(star.dataset.rating);
            if (starRating >= rating) {
                star.classList.add('fa-solid', 'hover');
                star.classList.remove('fa-regular');
            } else {
                star.classList.add('fa-regular');
                star.classList.remove('fa-solid', 'hover');
            }
        });
    }
    
    resetRatingPreview() {
        this.updateRatingDisplay();
    }
    
    updateRatingDisplay() {
        const ratings = this.data[this.pageId].ratings;
        const average = ratings.length > 0 
            ? (ratings.reduce((a, b) => a + b, 0) / ratings.length).toFixed(1)
            : 0;
        
        document.getElementById('rating-average').textContent = average;
        document.getElementById('rating-count').textContent = `(${ratings.length} رای)`;
        
        // Update star display
        const stars = document.querySelectorAll('.star');
        const roundedAverage = Math.round(average);
        stars.forEach(star => {
            const starRating = parseInt(star.dataset.rating);
            if (starRating >= roundedAverage) {
                star.classList.add('fa-solid');
                star.classList.remove('fa-regular');
            } else {
                star.classList.add('fa-regular');
                star.classList.remove('fa-solid');
            }
        });
    }
    
    handleReaction(e) {
        const btn = e.currentTarget;
        const reaction = btn.dataset.reaction;
        const userId = this.getUserId();
        
        // Toggle reaction
        const userReactions = this.data[this.pageId].userActions[userId]?.reactions || {};
        
        if (userReactions[reaction]) {
            this.data[this.pageId].reactions[reaction]--;
            delete userReactions[reaction];
            btn.classList.remove('active');
        } else {
            this.data[this.pageId].reactions[reaction]++;
            userReactions[reaction] = true;
            btn.classList.add('active');
        }
        
        if (!this.data[this.pageId].userActions[userId]) {
            this.data[this.pageId].userActions[userId] = {};
        }
        this.data[this.pageId].userActions[userId].reactions = userReactions;
        
        this.saveData();
        this.updateReactionCounts();
    }
    
    updateReactionCounts() {
        const reactions = this.data[this.pageId].reactions;
        Object.keys(reactions).forEach(reaction => {
            const countEl = document.getElementById(`${reaction}-count`);
            if (countEl) {
                countEl.textContent = reactions[reaction];
            }
        });
        
        // Mark user's reactions as active
        const userId = this.getUserId();
        const userReactions = this.data[this.pageId].userActions[userId]?.reactions || {};
        Object.keys(userReactions).forEach(reaction => {
            document.querySelector(`[data-reaction="${reaction}"]`)?.classList.add('active');
        });
    }
    
    submitComment() {
        const name = document.getElementById('comment-name').value;
        const email = document.getElementById('comment-email').value;
        const text = document.getElementById('comment-text').value;
        const saveInfo = document.getElementById('save-info').checked;
        
        if (saveInfo) {
            localStorage.setItem('teznevisan_user_name', name);
            localStorage.setItem('teznevisan_user_email', email);
        }
        
        const comment = {
            id: Date.now(),
            name: name,
            email: email,
            text: text,
            date: new Date().toISOString(),
            likes: 0
        };
        
        this.data[this.pageId].comments.push(comment);
        this.saveData();
        
        document.getElementById('comment-form').reset();
        this.renderComments();
        this.showToast('نظر شما ثبت شد و پس از تایید نمایش داده می‌شود', 'success');
    }
    
    renderComments() {
        const comments = this.data[this.pageId].comments;
        const commentsContainer = document.getElementById('comments-list');
        
        document.getElementById('total-comments').textContent = comments.length;
        
        if (comments.length === 0) {
            commentsContainer.innerHTML = '<p class="no-comments">هنوز نظری ثبت نشده است. اولین نفر باشید!</p>';
            return;
        }
        
        commentsContainer.innerHTML = comments.reverse().map(comment => `
            <div class="comment-item" data-comment-id="${comment.id}">
                <div class="comment-avatar">
                    <i class="fa-solid fa-user-circle"></i>
                </div>
                <div class="comment-content">
                    <div class="comment-header">
                        <strong class="comment-author">${this.escapeHtml(comment.name)}</strong>
                        <span class="comment-date">${this.formatDate(comment.date)}</span>
                    </div>
                    <p class="comment-text">${this.escapeHtml(comment.text)}</p>
                    <div class="comment-actions">
                        <button class="comment-like-btn" data-id="${comment.id}">
                            <i class="fa-solid fa-thumbs-up"></i>
                            <span>${comment.likes}</span>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
        
        // Bind like buttons
        document.querySelectorAll('.comment-like-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.likeComment(e));
        });
    }
    
    likeComment(e) {
        const commentId = parseInt(e.currentTarget.dataset.id);
        const comment = this.data[this.pageId].comments.find(c => c.id === commentId);
        
        if (comment) {
            comment.likes++;
            this.saveData();
            this.renderComments();
        }
    }
    
    sharePage() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                text: document.querySelector('meta[name="description"]')?.content || '',
                url: window.location.href
            });
        } else {
            // Fallback: copy link
            navigator.clipboard.writeText(window.location.href);
            this.showToast('لینک کپی شد!', 'success');
        }
    }
    
    getUserId() {
        let userId = localStorage.getItem('teznevisan_user_id');
        if (!userId) {
            userId = 'user_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('teznevisan_user_id', userId);
        }
        return userId;
    }
    
    formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = now - date;
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        
        if (days === 0) return 'امروز';
        if (days === 1) return 'دیروز';
        if (days < 7) return `${days} روز پیش`;
        
        return new Intl.DateTimeFormat('fa-IR').format(date);
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    showToast(message, type = 'info') {
        // Use existing toast function from main.js or create inline
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.remove(), 3000);
    }
}

// Engagement Styles (inject dynamically)
const engagementStyles = `
<style>
.engagement-section {
    padding: 3rem 0;
    background: var(--gray-50);
}

.page-rating-card {
    background: var(--bg-color);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: 2rem;
    text-align: center;
    margin-bottom: 2rem;
}

.page-rating-card h3 {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.rating-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.stars {
    display: flex;
    gap: 0.5rem;
    font-size: 2rem;
}

.star {
    color: var(--accent-color);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.star:hover, .star.hover {
    transform: scale(1.2);
}

.rating-stats {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.125rem;
}

.rating-average {
    font-weight: 700;
    color: var(--secondary-color);
}

.quick-reactions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 3rem;
}

.reaction-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--bg-color);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-lg);
    cursor: pointer;
    transition: all var(--transition-base);
    font-weight: 600;
    color: var(--text-color);
}

.reaction-btn:hover {
    border-color: var(--secondary-color);
    background: rgba(31, 166, 64, 0.05);
    transform: translateY(-2px);
}

.reaction-btn.active {
    background: var(--secondary-color);
    color: var(--white);
    border-color: var(--secondary-color);
}

.reaction-btn .count {
    background: var(--gray-100);
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-full);
    font-size: 0.875rem;
}

.reaction-btn.active .count {
    background: rgba(255, 255, 255, 0.2);
    color: var(--white);
}

.comments-section {
    background: var(--bg-color);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: 2rem;
}

.comments-section > h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
    font-size: 1.5rem;
}

.comment-count {
    background: var(--secondary-color);
    color: var(--white);
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-full);
    font-size: 0.875rem;
}

.comment-form-card {
    background: var(--gray-50);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.comment-form-card h4 {
    margin-bottom: 1rem;
}

.comment-item {
    display: flex;
    gap: 1rem;
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--border-color);
}

.comment-item:last-child {
    border-bottom: none;
}

.comment-avatar {
    font-size: 3rem;
    color: var(--gray-400);
}

.comment-content {
    flex: 1;
}

.comment-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.comment-author {
    font-weight: 700;
}

.comment-date {
    font-size: 0.875rem;
    color: var(--gray-500);
}

.comment-text {
    line-height: 1.8;
    margin-bottom: 0.75rem;
}

.comment-like-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: none;
    border: 1px solid var(--border-color);
    padding: 0.5rem 1rem;
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.comment-like-btn:hover {
    border-color: var(--secondary-color);
    color: var(--secondary-color);
}

.no-comments {
    text-align: center;
    padding: 2rem;
    color: var(--gray-500);
}

.save-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

@media (max-width: 767px) {
    .quick-reactions {
        grid-template-columns: 1fr 1fr;
    }
}
</style>
`;

// Inject styles
document.head.insertAdjacentHTML('beforeend', engagementStyles);

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    new EngagementSystem();
});
