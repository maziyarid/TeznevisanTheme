<div class="lead-form-box" id="inquiry-form">
    <div class="form-header">
        <div class="form-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <h3><?php _e('Free Service Consultation', 'teznevisan'); ?></h3>
        <p><?php _e('Enter your information so our experts can contact you as soon as possible and provide the necessary guidance.', 'teznevisan'); ?></p>
        <div class="form-benefits">
            <div class="benefit-item"><i class="fas fa-check"></i> <?php _e('Expert Consultation', 'teznevisan'); ?></div>
            <div class="benefit-item"><i class="fas fa-check"></i> <?php _e('Cost Estimation', 'teznevisan'); ?></div>
            <div class="benefit-item"><i class="fas fa-check"></i> <?php _e('Answer Questions', 'teznevisan'); ?></div>
        </div>
    </div>
    
    <form class="lead-form inquiry-form" novalidate>
        <?php wp_nonce_field('teznevisan_inquiry', 'inquiry_nonce'); ?>
        <input type="hidden" name="action" value="submit_inquiry">
        <input type="hidden" name="service_id" value="<?php echo get_the_ID(); ?>">
        
        <div class="form-row">
            <div class="form-group">
                <label for="inquiry_name"><?php _e('Full Name', 'teznevisan'); ?> <span class="required">*</span></label>
                <input type="text" id="inquiry_name" name="name" class="form-control" required aria-required="true">
            </div>
            <div class="form-group">
                <label for="inquiry_phone"><?php _e('Phone Number', 'teznevisan'); ?> <span class="required">*</span></label>
                <input type="tel" id="inquiry_phone" name="phone" class="form-control" required aria-required="true">
            </div>
        </div>
        
        <div class="form-group">
            <label for="inquiry_email"><?php _e('Email Address', 'teznevisan'); ?></label>
            <input type="email" id="inquiry_email" name="email" class="form-control">
        </div>
        
                <div class="form-group">
            <label for="inquiry_field"><?php _e('Field of Study', 'teznevisan'); ?></label>
            <div class="select-wrapper">
                <select id="inquiry_field" name="field" class="form-control">
                    <option value=""><?php _e('Select Field', 'teznevisan'); ?></option>
                    <option value="engineering"><?php _e('Engineering', 'teznevisan'); ?></option>
                    <option value="medical"><?php _e('Medical', 'teznevisan'); ?></option>
                    <option value="humanities"><?php _e('Humanities', 'teznevisan'); ?></option>
                    <option value="science"><?php _e('Basic Sciences', 'teznevisan'); ?></option>
                    <option value="art"><?php _e('Art', 'teznevisan'); ?></option>
                    <option value="management"><?php _e('Management', 'teznevisan'); ?></option>
                    <option value="other"><?php _e('Other', 'teznevisan'); ?></option>
                </select>
                <i class="fas fa-chevron-down select-arrow"></i>
            </div>
        </div>
        
        <div class="form-group">
            <label for="inquiry_degree"><?php _e('Academic Level', 'teznevisan'); ?></label>
            <div class="select-wrapper">
                <select id="inquiry_degree" name="degree" class="form-control">
                    <option value=""><?php _e('Select Level', 'teznevisan'); ?></option>
                    <option value="bachelor"><?php _e('Bachelor', 'teznevisan'); ?></option>
                    <option value="masters"><?php _e('Masters', 'teznevisan'); ?></option>
                    <option value="phd"><?php _e('PhD', 'teznevisan'); ?></option>
                </select>
                <i class="fas fa-chevron-down select-arrow"></i>
            </div>
        </div>
        
        <div class="form-group">
            <label for="inquiry_message"><?php _e('Description or Topic', 'teznevisan'); ?></label>
            <div class="textarea-wrapper">
                <textarea id="inquiry_message" name="message" class="form-control" rows="4" maxlength="500" placeholder="<?php _e('Topic, initial questions, or any details you find necessary...', 'teznevisan'); ?>"></textarea>
                <div class="char-counter">
                    <span class="current-chars">0</span>/<span class="max-chars">500</span>
                </div>
            </div>
        </div>
        
        <div class="form-footer">
            <p class="privacy-notice">
                <i class="fas fa-lock"></i> <?php _e('Your information will remain completely confidential.', 'teznevisan'); ?>
            </p>
            <button type="submit" class="btn btn-primary btn-block btn-submit">
                <span class="btn-text"><i class="fas fa-paper-plane"></i> <?php _e('Send Request', 'teznevisan'); ?></span>
                <span class="btn-loading"><i class="fas fa-spinner fa-spin"></i> <?php _e('Sending...', 'teznevisan'); ?></span>
            </button>
        </div>
    </form>
</div>