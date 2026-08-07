<?php
/*
Template Name: My Account
*/

if (!is_user_logged_in()) {
    wp_redirect(home_url('/'));
    exit;
}

get_header();

$current_user = wp_get_current_user();
$telegram_photo = get_user_meta($current_user->ID, 'telegram_photo_url', true);

// Handle profile update
if (isset($_POST['update_profile']) && wp_verify_nonce($_POST['_wpnonce'], 'update_profile')) {
    wp_update_user([
        'ID' => $current_user->ID,
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name' => sanitize_text_field($_POST['last_name']),
        'description' => sanitize_textarea_field($_POST['description']),
    ]);
    
    echo '<div class="alert alert-success" style="margin: 2rem auto; max-width: 800px;">
        <i class="fa-solid fa-check-circle"></i>
        <span>پروفایل شما با موفقیت به‌روزرسانی شد.</span>
    </div>';
    
    // Refresh user data
    $current_user = wp_get_current_user();
}
?>

<div class="my-account-page section">
    <div class="container">
        
        <!-- Page Header -->
        <div class="page-header" data-animate="fadeInDown">
            <h1><?php _e('پروفایل من', 'teznevisan'); ?></h1>
            <p><?php _e('مدیریت اطلاعات حساب کاربری شما', 'teznevisan'); ?></p>
        </div>

        <div class="account-grid">
            
            <!-- Sidebar -->
            <aside class="account-sidebar" data-animate="fadeInRight" data-delay="100">
                <div class="user-card">
                    <div class="user-avatar-large">
                        <?php if ($telegram_photo) : ?>
                            <img src="<?php echo esc_url($telegram_photo); ?>" alt="<?php echo esc_attr($current_user->display_name); ?>">
                        <?php else : ?>
                            <?php echo get_avatar($current_user->ID, 120); ?>
                        <?php endif; ?>
                    </div>
                    <h3><?php echo esc_html($current_user->display_name); ?></h3>
                    <p class="user-email"><?php echo esc_html($current_user->user_email); ?></p>
                    <span class="user-role badge badge-primary">
                        <?php 
                        $roles = $current_user->roles;
                        echo esc_html(translate_user_role(ucfirst($roles[0])));
                        ?>
                    </span>
                </div>

                <nav class="account-nav">
                    <a href="#profile" class="account-nav-item active">
                        <i class="fa-solid fa-user"></i>
                        <span><?php _e('پروفایل', 'teznevisan'); ?></span>
                    </a>
                    <?php if (current_user_can('manage_options')) : ?>
                    <a href="<?php echo esc_url(admin_url()); ?>" class="account-nav-item">
                        <i class="fa-solid fa-gauge"></i>
                        <span><?php _e('داشبورد', 'teznevisan'); ?></span>
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="account-nav-item logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span><?php _e('خروج', 'teznevisan'); ?></span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="account-main" data-animate="fadeInLeft" data-delay="200">
                <div class="account-card">
                    <div class="card-header">
                        <h2><?php _e('اطلاعات پروفایل', 'teznevisan'); ?></h2>
                        <p><?php _e('اطلاعات شخصی خود را ویرایش کنید', 'teznevisan'); ?></p>
                    </div>

                    <form method="post" action="" class="profile-form">
                        <?php wp_nonce_field('update_profile'); ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">
                                    <?php _e('نام', 'teznevisan'); ?>
                                    <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    class="form-control" 
                                    value="<?php echo esc_attr($current_user->first_name); ?>"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="last_name">
                                    <?php _e('نام خانوادگی', 'teznevisan'); ?>
                                    <span class="required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name" 
                                    class="form-control" 
                                    value="<?php echo esc_attr($current_user->last_name); ?>"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_email">
                                <?php _e('ایمیل', 'teznevisan'); ?>
                            </label>
                            <input 
                                type="email" 
                                id="user_email" 
                                class="form-control" 
                                value="<?php echo esc_attr($current_user->user_email); ?>"
                                disabled
                            >
                            <small class="form-text"><?php _e('ایمیل قابل تغییر نیست', 'teznevisan'); ?></small>
                        </div>

                        <div class="form-group">
                            <label for="description">
                                <?php _e('بیوگرافی', 'teznevisan'); ?>
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                class="form-control" 
                                rows="5"
                                placeholder="<?php esc_attr_e('درباره خودتان بنویسید...', 'teznevisan'); ?>"
                            ><?php echo esc_textarea($current_user->description); ?></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="update_profile" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-save"></i>
                                <?php _e('ذخیره تغییرات', 'teznevisan'); ?>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Account Stats -->
                <div class="account-stats">
                    <div class="stat-card" data-animate="fadeInUp" data-delay="300">
                        <div class="stat-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="stat-content">
                            <h4><?php _e('تاریخ عضویت', 'teznevisan'); ?></h4>
                            <p><?php echo date_i18n('j F Y', strtotime($current_user->user_registered)); ?></p>
                        </div>
                    </div>

                    <div class="stat-card" data-animate="fadeInUp" data-delay="400">
                        <div class="stat-icon">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <div class="stat-content">
                            <h4><?php _e('نقش کاربری', 'teznevisan'); ?></h4>
                            <p><?php echo esc_html(translate_user_role(ucfirst($current_user->roles[0]))); ?></p>
                        </div>
                    </div>

                    <div class="stat-card" data-animate="fadeInUp" data-delay="500">
                        <div class="stat-icon">
                            <i class="fa-brands fa-telegram"></i>
                        </div>
                        <div class="stat-content">
                            <h4><?php _e('ورود از طریق', 'teznevisan'); ?></h4>
                            <p><?php _e('تلگرام', 'teznevisan'); ?></p>
                        </div>
                    </div>
                </div>

            </main>

        </div>
    </div>
</div>

<style>
/* My Account Page Styles */
.my-account-page {
    padding: 4rem 0;
    min-height: 60vh;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.page-header p {
    color: var(--gray-600);
    font-size: 1.125rem;
}

.account-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 992px) {
    .account-grid {
        grid-template-columns: 320px 1fr;
    }
}

/* Sidebar */
.account-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.user-card {
    background: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: 2rem;
    text-align: center;
    box-shadow: var(--shadow-md);
}

.user-avatar-large {
    width: 120px;
    height: 120px;
    margin: 0 auto 1.5rem;
    border-radius: var(--radius-full);
    overflow: hidden;
    border: 4px solid var(--primary-color);
    box-shadow: var(--shadow-lg);
}

.user-avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-color);
}

.user-email {
    color: var(--gray-600);
    font-size: 0.9375rem;
    margin-bottom: 1rem;
}

.user-role {
    display: inline-block;
}

.account-nav {
    background: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
}

.account-nav-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    color: var(--text-color);
    transition: all var(--transition-fast);
    border-bottom: 1px solid var(--border-color);
}

.account-nav-item:last-child {
    border-bottom: none;
}

.account-nav-item:hover,
.account-nav-item.active {
    background: var(--primary-color);
    color: white;
}

.account-nav-item.logout {
    color: var(--danger-color);
}

.account-nav-item.logout:hover {
    background: var(--danger-color);
    color: white;
}

.account-nav-item i {
    width: 1.25rem;
    font-size: 1.125rem;
}

/* Main Content */
.account-main {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.account-card {
    background: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-xl);
    padding: 2rem;
    box-shadow: var(--shadow-md);
}

.card-header {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.card-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-color);
}

.card-header p {
    color: var(--gray-600);
    margin: 0;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .form-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

.form-text {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: var(--gray-500);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

/* Account Stats */
.account-stats {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .account-stats {
        grid-template-columns: repeat(3, 1fr);
    }
}

.stat-card {
    background: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: var(--shadow-sm);
    transition: all var(--transition-base);
}

.stat-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-3px);
}

.stat-icon {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: var(--radius-lg);
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-content h4 {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-600);
    margin-bottom: 0.25rem;
}

.stat-content p {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-color);
    margin: 0;
}

/* Alert Styles */
.alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-md);
    animation: slideInDown 0.3s ease;
}

.alert i {
    font-size: 1.25rem;
}

/* Responsive */
@media (max-width: 991px) {
    .account-sidebar {
        order: 2;
    }

    .account-main {
        order: 1;
    }
}

@media (max-width: 768px) {
    .my-account-page {
        padding: 3rem 0;
    }

    .page-header h1 {
        font-size: 2rem;
    }

    .account-card {
        padding: 1.5rem;
    }

    .user-card {
        padding: 1.5rem;
    }

    .user-avatar-large {
        width: 100px;
        height: 100px;
    }
}
</style>

<?php get_footer(); ?>