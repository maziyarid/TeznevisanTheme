<?php
/**
 * Comments Template
 * 
 * @package Teznevisan
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <i class="fas fa-comments"></i>
            <?php
            $comments_number = get_comments_number();
            if ('1' === $comments_number) {
                printf(_x('یک دیدگاه', 'comments title', 'teznevisan'));
            } else {
                printf(
                    _nx(
                        '%1$s دیدگاه',
                        '%1$s دیدگاه',
                        $comments_number,
                        'comments title',
                        'teznevisan'
                    ),
                    number_format_i18n($comments_number)
                );
            }
            ?>
        </h2>
        
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 50,
                'callback' => 'teznevisan_custom_comment',
            ));
            ?>
        </ol>
        
        <?php
        the_comments_navigation(array(
            'prev_text' => '<i class="fas fa-chevron-right"></i> دیدگاه‌های قدیمی‌تر',
            'next_text' => 'دیدگاه‌های جدیدتر <i class="fas fa-chevron-left"></i>',
        ));
        ?>
        
    <?php endif; ?>
    
    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e('امکان ثبت دیدگاه وجود ندارد.', 'teznevisan'); ?></p>
    <?php endif; ?>
    
    <?php
    comment_form(array(
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title"><i class="fas fa-edit"></i> ',
        'title_reply_after' => '</h3>',
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('دیدگاه', 'noun', 'teznevisan') . '</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
        'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s"><i class="fas fa-paper-plane"></i> %4$s</button>',
        'class_submit' => 'submit-comment',
    ));
    ?>
    
</div>

<?php
/**
 * Custom Comment Display
 */
function teznevisan_custom_comment($comment, $args, $depth) {
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <article class="comment-body">
            <div class="comment-author-avatar">
                <?php echo get_avatar($comment, 50); ?>
            </div>
            
            <div class="comment-content-wrapper">
                <div class="comment-meta">
                    <div class="comment-author-name">
                        <?php comment_author_link(); ?>
                        <?php if ('1' == $comment->user_id) : ?>
                            <span class="admin-badge">نویسنده</span>
                        <?php endif; ?>
                    </div>
                    <div class="comment-metadata">
                        <time datetime="<?php comment_time('c'); ?>">
                            <i class="fas fa-clock"></i>
                            <?php printf(_x('%1$s در %2$s', 'date and time', 'teznevisan'), get_comment_date(), get_comment_time()); ?>
                        </time>
                    </div>
                </div>
                
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>
                
                <div class="comment-actions">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'add_below' => 'comment',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'before' => '<div class="reply-link">',
                        'after' => '</div>',
                    )));
                    ?>
                    
                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation">
                            <i class="fas fa-hourglass-half"></i>
                            <?php _e('دیدگاه شما در انتظار بررسی است.', 'teznevisan'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    <?php
}
?>

<style>
.comments-area {
    background: var(--bg-main);
    padding: 3rem;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

.comments-title {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: inherit;
}

.comments-title i {
    color: var(--primary-color);
}

.comment-list {
    list-style: none;
    padding: 0;
    margin: 0 0 3rem 0;
}

.comment-list > li {
    margin-bottom: 2rem;
}

.comment-body {
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
    border-radius: 15px;
    border: 1px solid var(--border-color);
}

.comment-author-avatar img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid var(--primary-color);
}

.comment-content-wrapper {
    flex: 1;
}

.comment-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.comment-author-name {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: var(--text-primary);
    font-family: inherit;
}

.admin-badge {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: inherit;
}

.comment-metadata {
    font-size: 0.85rem;
    color: var(--text-muted);
    font-family: inherit;
}

.comment-content {
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 1rem;
    font-family: inherit;
}

.comment-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.reply-link a {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    background: rgba(31, 165, 71, 0.1);
    border-radius: 15px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.reply-link a:hover {
    background: var(--primary-color);
    color: white;
}

.comment-awaiting-moderation {
    background: #FFA500;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.85rem;
    margin: 0;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-family: inherit;
}

.comment-respond {
    margin-top: 3rem;
    padding-top: 3rem;
    border-top: 2px solid var(--border-color);
}

.comment-reply-title {
    color: var(--text-primary);
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: inherit;
}

.comment-reply-title i {
    color: var(--primary-color);
}

.comment-form {
    display: grid;
    gap: 1.5rem;
}

.comment-form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
    font-family: inherit;
}

.comment-form input[type="text"],
.comment-form input[type="email"],
.comment-form input[type="url"],
.comment-form textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-family: inherit;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.comment-form input:focus,
.comment-form textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(31, 165, 71, 0.1);
}

.comment-form textarea {
    min-height: 150px;
    resize: vertical;
}

.submit-comment {
    background: var(--primary-color);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
    transition: all 0.3s ease;
    font-family: inherit;
}

.submit-comment:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(31, 165, 71, 0.3);
}

.children {
    list-style: none;
    padding: 0 0 0 3rem;
    margin-top: 1rem;
}

.no-comments {
    text-align: center;
    padding: 3rem;
    color: var(--text-muted);
    font-style: italic;
    font-family: inherit;
}

@media (max-width: 768px) {
    .comments-area {
        padding: 2rem;
    }
    
    .comment-body {
        flex-direction: column;
        gap: 1rem;
    }
    
    .children {
        padding-left: 1.5rem;
    }
}
</style>
