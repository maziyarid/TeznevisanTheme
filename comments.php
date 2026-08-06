<?php
if (post_password_required()) {
    return;
}

$comments_number = get_comments_number();
?>

<div id="comments" class="comments-area-enhanced">
    
    <!-- Comments Header -->
    <div class="comments-header">
        <h3 class="comments-title">
            <i class="fas fa-comments"></i>
            <?php
            if ($comments_number == 0) {
                echo 'اولین نفری باشید که دیدگاه می‌دهد';
            } elseif ($comments_number == 1) {
                echo '۱ دیدگاه';
            } else {
                echo $comments_number . ' دیدگاه';
            }
            ?>
        </h3>
        
        <?php if ($comments_number > 0) : ?>
            <div class="comments-stats">
                <div class="stat-item">
                    <i class="fas fa-thumbs-up"></i>
                    <span>نظرات مثبت: ۸۵%</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-star"></i>
                    <span>میانگین امتیاز: ۴.۳</span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if (have_comments()) : ?>
        
        <!-- Comments Sort -->
        <div class="comments-controls">
            <div class="sort-controls">
                <label for="comments-sort">مرتب‌سازی:</label>
                <select id="comments-sort">
                    <option value="newest">جدیدترین</option>
                    <option value="oldest">قدیمی‌ترین</option>
                    <option value="most-liked">محبوب‌ترین</option>
                    <option value="most-replied">بیشترین پاسخ</option>
                </select>
            </div>
            
            <div class="view-controls">
                <button class="view-btn active" data-view="threaded">
                    <i class="fas fa-comments"></i>
                    نمایش درختی
                </button>
                <button class="view-btn" data-view="flat">
                    <i class="fas fa-list"></i>
                    نمایش فهرستی
                </button>
            </div>
        </div>

        <!-- Comments List -->
        <ol class="comment-list-enhanced" id="comments-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 60,
                'callback' => 'teznevisan_enhanced_comment_callback',
                'reply_text' => 'پاسخ',
                'login_text' => 'برای پاسخ دادن وارد شوید',
            ));
            ?>
        </ol>

        <!-- Comments Navigation -->
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation-enhanced" role="navigation">
                <div class="nav-links">
                    <?php
                    previous_comments_link('<i class="fas fa-arrow-right"></i> دیدگاه‌های قبلی');
                    next_comments_link('دیدگاه‌های بعدی <i class="fas fa-arrow-left"></i>');
                    ?>
                </div>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <div class="no-comments-message">
            <i class="fas fa-lock"></i>
            <p>امکان ثبت دیدگاه جدید وجود ندارد.</p>
        </div>
    <?php endif; ?>

    <!-- Comment Form Enhanced -->
    <?php if (comments_open()) : ?>
        <div class="comment-form-wrapper">
            <div class="comment-form-header">
                <h4>
                    <i class="fas fa-edit"></i>
                    دیدگاه خود را بنویسید
                </h4>
                <p>نظر شما برای ما ارزشمند است. لطفاً با احترام و رعایت قوانین، دیدگاه خود را ارسال کنید.</p>
            </div>
            
            <!-- Comment Guidelines -->
            <div class="comment-guidelines">
                <button class="guidelines-toggle" id="guidelines-toggle">
                    <i class="fas fa-info-circle"></i>
                    راهنمای نوشتن دیدگاه
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="guidelines-content" id="guidelines-content">
                    <ul>
                        <li><i class="fas fa-check"></i> از زبان محترمانه استفاده کنید</li>
                        <li><i class="fas fa-check"></i> نظرات سازنده و مرتبط با موضوع بنویسید</li>
                        <li><i class="fas fa-check"></i> از ارسال اسپم یا تبلیغات خودداری کنید</li>
                        <li><i class="fas fa-check"></i> اطلاعات شخصی خود و دیگران را فاش نکنید</li>
                    </ul>
                </div>
            </div>
            
            <?php
            comment_form(array(
                'title_reply' => '',
                'title_reply_to' => 'پاسخ به %s',
                'cancel_reply_link' => 'لغو پاسخ',
                'label_submit' => 'ارسال دیدگاه',
                'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-primary btn-submit-comment"><i class="fas fa-paper-plane"></i> <span>%4$s</span></button>',
                'class_form' => 'comment-form-enhanced',
                'comment_field' => '
                    <div class="form-group comment-field-group">
                        <label for="comment">
                            <i class="fas fa-comment"></i>
                            دیدگاه شما <span class="required">*</span>
                        </label>
                        <div class="textarea-wrapper-enhanced">
                            <textarea id="comment" name="comment" class="form-control comment-textarea" rows="6" required maxlength="1000" placeholder="دیدگاه خود را اینجا بنویسید..."></textarea>
                            <div class="textarea-footer">
                                <div class="char-counter">
                                    <span class="current-chars">0</span>/<span class="max-chars">1000</span>
                                </div>
                                <div class="emoji-picker">
                                    <button type="button" class="emoji-btn" title="اضافه کردن ایموجی">
                                        <i class="fas fa-smile"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>',
                'fields' => array(
                    'author' => '
                        <div class="form-row">
                            <div class="form-group">
                                <label for="author">
                                    <i class="fas fa-user"></i>
                                    نام <span class="required">*</span>
                                </label>
                                <input id="author" name="author" type="text" class="form-control" required />
                            </div>',
                    'email' => '
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i>
                                    ایمیل <span class="required">*</span>
                                </label>
                                <input id="email" name="email" type="email" class="form-control" required />
                            </div>
                        </div>',
                    'url' => '
                        <div class="form-group website-group">
                            <label for="url">
                                <i class="fas fa-globe"></i>
                                وب‌سایت (اختیاری)
                            </label>
                            <input id="url" name="url" type="url" class="form-control" placeholder="https://example.com" />
                        </div>',
                ),
                'class_submit' => 'btn btn-primary btn-submit-comment',
                'format' => 'html5',
            ));
            ?>
        </div>
    <?php endif; ?>
</div>

<style>
/* Enhanced Comments Area */
.comments-area-enhanced {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-top: 3rem;
    border: 1px solid var(--border-light);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.comments-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--border-light);
}

.comments-title {
    color: var(--text-primary);
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.comments-title i {
    color: var(--primary-color);
    font-size: 1.5rem;
}

.comments-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 1rem;
}

.comments-stats .stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.comments-stats .stat-item i {
    color: var(--primary-color);
}

.comments-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    border: 1px solid var(--border-light);
}

.sort-controls {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.sort-controls label {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.sort-controls select {
    padding: 0.5rem 1rem;
    border: 1px solid var(--border-light);
    border-radius: var(--radius-sm);
    background: var(--bg-card);
    color: var(--text-primary);
    font-family: inherit;
    cursor: pointer;
}

.view-controls {
    display: flex;
    gap: 0.5rem;
}

.view-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--bg-card);
    border: 1px solid var(--border-light);
    color: var(--text-secondary);
    border-radius: var(--radius-sm);
    cursor: pointer;
    font-family: inherit;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.view-btn:hover,
.view-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.comment-list-enhanced {
    list-style: none;
    padding: 0;
    margin: 0 0 3rem 0;
}

.comment-list-enhanced .comment {
    margin-bottom: 2rem;
}

.comment-list-enhanced .children {
    list-style: none;
    margin: 1rem 0 0 2rem;
    padding: 0;
}

/* Comment Form Enhanced */
.comment-form-wrapper {
    background: var(--bg-secondary);
    border-radius: var(--radius-lg);
    padding: 2rem;
    border: 1px solid var(--border-light);
    position: relative;
}

.comment-form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.comment-form-header h4 {
    color: var(--text-primary);
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.comment-form-header h4 i {
    color: var(--primary-color);
}

.comment-form-header p {
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.6;
}

.comment-guidelines {
    margin-bottom: 2rem;
}

.guidelines-toggle {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: var(--bg-card);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    font-family: inherit;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.guidelines-toggle:hover {
    background: rgba(31, 165, 71, 0.05);
    border-color: var(--primary-color);
}

.guidelines-toggle i:first-child {
    color: var(--primary-color);
}

.guidelines-toggle i:last-child {
    transition: transform 0.3s ease;
}

.guidelines-toggle.active i:last-child {
    transform: rotate(180deg);
}

.guidelines-content {
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
    background: var(--bg-card);
    border: 1px solid var(--border-light);
    border-top: none;
    border-radius: 0 0 var(--radius-md) var(--radius-md);
}

.guidelines-content.active {
    max-height: 300px;
    padding: 1rem;
}

.guidelines-content ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.guidelines-content li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
}

.guidelines-content li:last-child {
    margin-bottom: 0;
}

.guidelines-content li i {
    color: var(--primary-color);
    font-size: 0.8rem;
}

.comment-form-enhanced {
    background: var(--bg-card);
    padding: 2rem;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-light);
    margin-top: 1rem;
}

.comment-form-enhanced .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.comment-form-enhanced .form-group {
    margin-bottom: 1.5rem;
}

.comment-form-enhanced label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.95rem;
}

.comment-form-enhanced label i {
    color: var(--primary-color);
    width: 16px;
    text-align: center;
}

.required {
    color: #dc3545;
    font-weight: bold;
}

.comment-form-enhanced .form-control {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid var(--border-light);
    border-radius: var(--radius-md);
    background: var(--bg-main);
    color: var(--text-primary);
    font-family: inherit;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.comment-form-enhanced .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(31, 165, 71, 0.1);
    outline: none;
    transform: translateY(-1px);
}

.comment-field-group {
    grid-column: 1 / -1;
}

.textarea-wrapper-enhanced {
    position: relative;
}

.comment-textarea {
    resize: vertical;
    min-height: 120px;
    padding-bottom: 3rem;
}

.textarea-footer {
    position: absolute;
    bottom: 0.75rem;
    left: 1rem;
    right: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.char-counter {
    font-size: 0.8rem;
    color: var(--text-muted);
    background: var(--bg-card);
    padding: 0.25rem 0.5rem;
    border-radius: var(--radius-sm);
    border: 1px solid var(--border-light);
}

.current-chars {
    color: var(--primary-color);
    font-weight: 600;
}

.emoji-picker .emoji-btn {
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 1.1rem;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.emoji-picker .emoji-btn:hover {
    color: var(--primary-color);
    background: var(--bg-secondary);
}

.website-group {
    grid-column: 1 / -1;
}

.btn-submit-comment {
    position: relative;
    overflow: hidden;
    font-size: 1rem;
    font-weight: 600;
    padding: 1rem 2rem;
    margin-top: 1rem;
}

.btn-submit-comment:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(31, 165, 71, 0.3);
}

.no-comments-message {
    text-align: center;
    padding: 3rem;
    color: var(--text-muted);
}

.no-comments-message i {
    font-size: 2rem;
    margin-bottom: 1rem;
    display: block;
}

.comment-navigation-enhanced {
    margin: 2rem 0;
    text-align: center;
}

.comment-navigation-enhanced .nav-links {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

.comment-navigation-enhanced a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--bg-secondary);
    color: var(--text-primary);
    text-decoration: none;
    border-radius: var(--radius-md);
    border: 1px solid var(--border-light);
    transition: all 0.3s ease;
    font-weight: 500;
}

.comment-navigation-enhanced a:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .comments-area-enhanced {
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .comments-title {
        font-size: 1.5rem;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .comments-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .comments-controls {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .sort-controls,
    .view-controls {
        justify-content: center;
    }
    
    .comment-form-enhanced {
        padding: 1.5rem;
    }
    
    .comment-form-enhanced .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .comment-navigation-enhanced .nav-links {
        flex-direction: column;
    }
    
    .textarea-footer {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
}

@media (max-width: 480px) {
    .comments-area-enhanced {
        padding: 1rem;
    }
    
    .comment-form-wrapper {
        padding: 1.5rem;
    }
    
    .comment-form-enhanced {
        padding: 1rem;
    }
    
    .comment-form-header h4 {
        font-size: 1.1rem;
    }
    
    .guidelines-content {
        padding: 0.75rem;
    }
    
    .view-controls {
        gap: 0.25rem;
    }
    
    .view-btn {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for comment textarea
    const commentTextarea = document.getElementById('comment');
    const currentChars = document.querySelector('.current-chars');
    
    if (commentTextarea && currentChars) {
        function updateCharCount() {
            const count = commentTextarea.value.length;
            currentChars.textContent = count;
            
            if (count > 900) {
                currentChars.style.color = '#dc3545';
            } else if (count > 700) {
                currentChars.style.color = '#ffc107';
            } else {
                currentChars.style.color = 'var(--primary-color)';
            }
        }
        
        commentTextarea.addEventListener('input', updateCharCount);
        updateCharCount();
    }
    
    // Comment guidelines toggle
    const guidelinesToggle = document.getElementById('guidelines-toggle');
    const guidelinesContent = document.getElementById('guidelines-content');
    
    if (guidelinesToggle && guidelinesContent) {
        guidelinesToggle.addEventListener('click', function() {
            const isActive = this.classList.contains('active');
            this.classList.toggle('active');
            guidelinesContent.classList.toggle('active');
        });
    }
    
    // Comments sorting
    const sortSelect = document.getElementById('comments-sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const commentsList = document.getElementById('comments-list');
            const comments = Array.from(commentsList.querySelectorAll('.comment'));
            
            // Simple client-side sorting
            comments.sort((a, b) => {
                switch (sortValue) {
                    case 'newest':
                        return new Date(b.querySelector('.comment-date')?.textContent || 0) - 
                               new Date(a.querySelector('.comment-date')?.textContent || 0);
                    case 'oldest':
                        return new Date(a.querySelector('.comment-date')?.textContent || 0) - 
                               new Date(b.querySelector('.comment-date')?.textContent || 0);
                    case 'most-liked':
                        return (parseInt(b.querySelector('.comment-likes')?.textContent) || 0) - 
                               (parseInt(a.querySelector('.comment-likes')?.textContent) || 0);
                    default:
                        return 0;
                }
            });
            
            comments.forEach(comment => commentsList.appendChild(comment));
        });
    }
    
    // Comment view toggle
    const viewBtns = document.querySelectorAll('.view-btn');
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.getAttribute('data-view');
            const commentsList = document.getElementById('comments-list');
            
            if (view === 'flat') {
                commentsList.classList.add('flat-view');
            } else {
                commentsList.classList.remove('flat-view');
            }
        });
    });
    
    // Enhanced comment form submission
    const commentForm = document.querySelector('.comment-form-enhanced');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-submit-comment');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال ارسال...';
            submitBtn.disabled = true;
            
            // Re-enable after submission (WordPress handles the actual submission)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });
    }
});
</script>

<?php
// Enhanced Comment Callback Function
function teznevisan_enhanced_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $comment_id = get_comment_ID();
    $likes = get_comment_meta($comment_id, 'comment_likes', true) ?: 0;
    $dislikes = get_comment_meta($comment_id, 'comment_dislikes', true) ?: 0;
    ?>
    <li <?php comment_class('comment-enhanced'); ?> id="comment-<?php comment_ID(); ?>">
        <article class="comment-body-enhanced">
            <div class="comment-header-enhanced">
                <div class="comment-avatar-enhanced">
                    <?php echo get_avatar($comment, 60, '', '', array('class' => 'avatar-enhanced')); ?>
                    <div class="comment-status">
                        <?php if (user_can($comment->user_id, 'manage_options')) : ?>
                            <span class="author-badge admin">
                                <i class="fas fa-crown"></i>
                                مدیر
                            </span>
                        <?php elseif ($comment->user_id == get_post()->post_author) : ?>
                            <span class="author-badge post-author">
                                <i class="fas fa-pencil-alt"></i>
                                نویسنده
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="comment-meta-enhanced">
                    <div class="comment-author-info">
                        <cite class="comment-author-name">
                            <?php comment_author_link(); ?>
                        </cite>
                        
                        <div class="comment-metadata">
                            <time datetime="<?php comment_time('c'); ?>" class="comment-date">
                                <i class="fas fa-clock"></i>
                                <?php printf('%s پیش', human_time_diff(get_comment_time('U'), current_time('timestamp'))); ?>
                            </time>
                            
                            <?php if ($depth < $args['max_depth']) : ?>
                                <div class="comment-reply-link">
                                    <?php comment_reply_link(array_merge($args, array(
                                        'depth' => $depth,
                                        'max_depth' => $args['max_depth'],
                                        'reply_text' => '<i class="fas fa-reply"></i> پاسخ',
                                    ))); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="comment-actions">
                        <button class="comment-like-btn" data-comment-id="<?php comment_ID(); ?>" data-action="like">
                            <i class="fas fa-thumbs-up"></i>
                            <span class="like-count"><?php echo $likes; ?></span>
                        </button>
                        <button class="comment-dislike-btn" data-comment-id="<?php comment_ID(); ?>" data-action="dislike">
                            <i class="fas fa-thumbs-down"></i>
                            <span class="dislike-count"><?php echo $dislikes; ?></span>
                        </button>
                        <button class="comment-share-btn" data-comment-id="<?php comment_ID(); ?>">
                            <i class="fas fa-share"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="comment-content-enhanced">
                <?php if ($comment->comment_approved == '0') : ?>
                    <div class="comment-awaiting-moderation">
                        <i class="fas fa-hourglass-half"></i>
                        دیدگاه شما در انتظار تأیید است.
                    </div>
                <?php endif; ?>
                
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>
                
                <?php if ($likes > 5 || $comment->comment_karma > 0) : ?>
                    <div class="comment-highlight-badge">
                        <i class="fas fa-fire"></i>
                        <span>دیدگاه برتر</span>
                    </div>
                <?php endif; ?>
            </div>
        </article>
        
        <style>
        .comment-enhanced {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .comment-enhanced:hover {
            box-shadow: 0 8px 25px rgba(31, 165, 71, 0.1);
            transform: translateY(-2px);
        }

        .comment-enhanced.bypostauthor {
            border-color: var(--primary-color);
            background: rgba(31, 165, 71, 0.02);
        }

        .comment-enhanced.comment-highlight {
            border-color: #ffc107;
            background: rgba(255, 193, 7, 0.05);
        }

        .comment-body-enhanced {
            padding: 1.5rem;
        }

        .comment-header-enhanced {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .comment-avatar-enhanced {
            position: relative;
            flex-shrink: 0;
        }

        .avatar-enhanced {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid var(--border-light);
            transition: all 0.3s ease;
        }

        .comment-enhanced:hover .avatar-enhanced {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        .comment-status {
            position: absolute;
            bottom: -5px;
            left: -5px;
        }

        .author-badge {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: var(--radius-sm);
            font-size: 0.7rem;
            font-weight: 600;
            border: 2px solid var(--bg-card);
        }

        .author-badge.admin {
            background: #dc3545;
            color: white;
        }

        .author-badge.post-author {
            background: var(--primary-color);
            color: white;
        }

        .comment-meta-enhanced {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .comment-author-name {
            font-style: normal;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1rem;
            text-decoration: none;
        }

        .comment-author-name:hover {
            color: var(--primary-color);
        }

        .comment-metadata {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 0.25rem;
        }

        .comment-date {
            color: var(--text-muted);
            font-size: 0.85rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .comment-reply-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            transition: color 0.3s ease;
        }

        .comment-reply-link a:hover {
            color: var(--primary-dark);
        }

        .comment-actions {
            display: flex;
            gap: 0.5rem;
        }

        .comment-like-btn,
        .comment-dislike-btn,
        .comment-share-btn {
            background: var(--bg-secondary);
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            padding: 0.5rem;
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-family: inherit;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .comment-like-btn:hover {
            background: rgba(40, 167, 69, 0.1);
            border-color: #28a745;
            color: #28a745;
        }

        .comment-dislike-btn:hover {
            background: rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
            color: #dc3545;
        }

        .comment-share-btn:hover {
            background: rgba(31, 165, 71, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .comment-like-btn.active {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .comment-dislike-btn.active {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .comment-content-enhanced {
            position: relative;
        }

        .comment-awaiting-moderation {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
            padding: 1rem;
            border-radius: var(--radius-md);
            border: 1px solid rgba(255, 193, 7, 0.3);
            margin-bottom: 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .comment-text {
            line-height: 1.7;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .comment-text p {
            margin-bottom: 1rem;
        }

        .comment-text p:last-child {
            margin-bottom: 0;
        }

        .comment-highlight-badge {
            position: absolute;
            top: -1rem;
            left: 1rem;
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
        }

        .comment-list-enhanced.flat-view .children {
            margin-right: 0;
            margin-top: 1rem;
        }

        .comment-list-enhanced.flat-view .comment-enhanced {
            border-right: 4px solid var(--primary-color);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .comment-header-enhanced {
                flex-direction: column;
                gap: 1rem;
            }
            
            .comment-meta-enhanced {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            
            .comment-actions {
                justify-content: center;
            }
            
            .avatar-enhanced {
                width: 50px;
                height: 50px;
            }
            
            .comment-body-enhanced {
                padding: 1rem;
            }
        }
        </style>
    <?php
}
?>