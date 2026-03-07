<?php

declare(strict_types=1);

/**
 * Contact Form Template Part
 *
 * Multi-step contact form with 3 steps:
 * - Step 1: Category, Problem Description, COI, COI File
 * - Step 2: Date, Appointment Time
 * - Step 3: Full Name, Address, City, Postcode, Phone, Email
 */

// Get ACF fields for form options
$categories = get_field('form_categories') ?: [];

// Default categories if ACF is empty
if (empty($categories)) {
    $categories = [
        ['value' => 'refrigerator', 'label' => 'Refrigerator'],
        ['value' => 'dishwasher', 'label' => 'Dishwasher'],
        ['value' => 'washer', 'label' => 'Washing Machine'],
        ['value' => 'dryer', 'label' => 'Dryer'],
        ['value' => 'oven', 'label' => 'Oven/Stove'],
        ['value' => 'other', 'label' => 'Other'],
    ];
}

// COI options
$coi_options = [
    ['value' => 'yes', 'label' => 'Yes'],
    ['value' => 'no', 'label' => 'No'],
    ['value' => 'not_sure', 'label' => 'Not Sure'],
];

// Get admin email from ACF or use default
$admin_email = get_field('form_admin_email') ?: get_option('admin_email');

// Generate nonce for security
$form_nonce = wp_create_nonce('contact_form_submit');
?>

<div class="contact-form-wrapper">
    <!-- Step Indicators -->
    <div class="contact-form__steps">
        <div class="contact-form__step-indicator active" data-step="1">
            <span class="contact-form__step-number">1</span>
            <span class="contact-form__step-label">Details</span>
        </div>
        <div class="contact-form__step-line"></div>
        <div class="contact-form__step-indicator" data-step="2">
            <span class="contact-form__step-number">2</span>
            <span class="contact-form__step-label">Schedule</span>
        </div>
        <div class="contact-form__step-line"></div>
        <div class="contact-form__step-indicator" data-step="3">
            <span class="contact-form__step-number">3</span>
            <span class="contact-form__step-label">Contact</span>
        </div>
    </div>

    <!-- Form -->
    <form id="contact-form" class="contact-form" method="post" action="" enctype="multipart/form-data">
        <?php wp_nonce_field('contact_form_submit', 'contact_form_nonce'); ?>
        <input type="hidden" name="action" value="contact_form_submit">

        <!-- Step 1: Category, Problem, COI, COI File -->
        <div class="contact-form__step" data-step="1">
            <div class="contact-form__header">
                <h2 class="contact-form__title">Describe Your Problem</h2>
                <p class="contact-form__subtitle">Please provide details about your appliance issue</p>
            </div>

            <div class="contact-form__fields">
                <!-- Category Select -->
                <div class="contact-form__field">
                    <label for="category" class="contact-form__label">
                        Category <span class="contact-form__required">*</span>
                    </label>
                    <div class="contact-form__select-wrapper">
                        <select name="category" id="category" class="contact-form__select" required>
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo esc_attr($category['value'] ?? $category); ?>">
                                    <?php echo esc_html($category['label'] ?? $category); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="contact-form__select-arrow">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    <span class="contact-form__error" data-field="category"></span>
                </div>

                <!-- Problem Description -->
                <div class="contact-form__field">
                    <label for="problem_description" class="contact-form__label">
                        Problem Description <span class="contact-form__required">*</span>
                    </label>
                    <textarea
                        name="problem_description"
                        id="problem_description"
                        class="contact-form__textarea"
                        rows="5"
                        placeholder="Describe the problem with your appliance..."
                        required
                    ></textarea>
                    <span class="contact-form__error" data-field="problem_description"></span>
                </div>

                <!-- COI Select -->
                <div class="contact-form__field">
                    <label for="coi" class="contact-form__label">
                        Do you have a Certificate of Insurance (COI)? <span class="contact-form__required">*</span>
                    </label>
                    <div class="contact-form__select-wrapper">
                        <select name="coi" id="coi" class="contact-form__select" required>
                            <option value="">Select an option</option>
                            <?php foreach ($coi_options as $option) : ?>
                                <option value="<?php echo esc_attr($option['value']); ?>">
                                    <?php echo esc_html($option['label']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="contact-form__select-arrow">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    <span class="contact-form__error" data-field="coi"></span>
                </div>

                <!-- COI File Upload -->
                <div class="contact-form__field contact-form__field--file">
                    <label for="coi_file" class="contact-form__label">
                        Upload COI Document
                    </label>
                    <div class="contact-form__file-wrapper">
                        <input
                            type="file"
                            name="coi_file"
                            id="coi_file"
                            class="contact-form__file-input"
                            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                        >
                        <label for="coi_file" class="contact-form__file-label">
                            <span class="contact-form__file-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                            </span>
                            <span class="contact-form__file-text">Choose file or drag it here</span>
                            <span class="contact-form__file-name"></span>
                        </label>
                    </div>
                    <span class="contact-form__hint">Accepted formats: PDF, JPG, PNG, DOC, DOCX. Max size: 5MB</span>
                    <span class="contact-form__error" data-field="coi_file"></span>
                </div>
            </div>

            <!-- Step 1 Buttons -->
            <div class="contact-form__actions contact-form__actions--step1">
                <button type="button" class="btn_contact btn--primary contact-form__btn-next" data-next="2">
                    Next
                </button>
            </div>
        </div>

        <!-- Step 2: Date, Appointment Time -->
        <div class="contact-form__step contact-form__step--hidden" data-step="2">
            <div class="contact-form__header">
                <h2 class="contact-form__title">Schedule Appointment</h2>
                <p class="contact-form__subtitle">Choose your preferred date and time</p>
            </div>

            <div class="contact-form__fields">
                <!-- Date -->
                <div class="contact-form__field">
                    <label for="appointment_date" class="contact-form__label">
                        Preferred Date <span class="contact-form__required">*</span>
                    </label>
                    <input
                        type="date"
                        name="appointment_date"
                        id="appointment_date"
                        class="contact-form__input contact-form__input--date"
                        required
                    >
                    <span class="contact-form__error" data-field="appointment_date"></span>
                </div>

                <!-- Appointment Time -->
                <div class="contact-form__field">
                    <label class="contact-form__label">
                        Preferred Time <span class="contact-form__required">*</span>
                    </label>
                    <div class="contact-form__radio-group">
                        <label class="contact-form__radio">
                            <input
                                type="radio"
                                name="appointment_time"
                                value="8am-12pm"
                                required
                            >
                            <span class="contact-form__radio-label">8:00 AM - 12:00 PM</span>
                        </label>
                        <label class="contact-form__radio">
                            <input
                                type="radio"
                                name="appointment_time"
                                value="12pm-4pm"
                            >
                            <span class="contact-form__radio-label">12:00 PM - 4:00 PM</span>
                        </label>
                        <label class="contact-form__radio">
                            <input
                                type="radio"
                                name="appointment_time"
                                value="4pm-8pm"
                            >
                            <span class="contact-form__radio-label">4:00 PM - 8:00 PM</span>
                        </label>
                    </div>
                    <span class="contact-form__error" data-field="appointment_time"></span>
                </div>
            </div>

            <!-- Step 2 Buttons -->
            <div class="contact-form__actions contact-form__actions--step2">
                <button type="button" class="btn_contact btn--outline_contact contact-form__btn-back" data-back="1">
                    Previous
                </button>
                <button type="button" class="btn_contact btn--primary contact-form__btn-next" data-next="3">
                    Next
                </button>
            </div>
        </div>

        <!-- Step 3: Contact Information -->
        <div class="contact-form__step contact-form__step--hidden" data-step="3">
            <div class="contact-form__header">
                <h2 class="contact-form__title">Contact Information</h2>
                <p class="contact-form__subtitle">Please provide your contact details so we can reach you</p>
            </div>

            <div class="contact-form__fields">
                <!-- Full Name -->
                <div class="contact-form__field">
                    <label for="full_name" class="contact-form__label">
                        Full Name <span class="contact-form__required">*</span>
                    </label>
                    <input
                        type="text"
                        name="full_name"
                        id="full_name"
                        class="contact-form__input"
                        placeholder="Enter your full name"
                        required
                    >
                    <span class="contact-form__error" data-field="full_name"></span>
                </div>

                <!-- Address -->
                <div class="contact-form__field">
                    <label for="address" class="contact-form__label">
                        Address <span class="contact-form__required">*</span>
                    </label>
                    <textarea
                        name="address"
                        id="address"
                        class="contact-form__textarea contact-form__textarea--small"
                        rows="3"
                        placeholder="Enter your street address"
                        required
                    ></textarea>
                    <span class="contact-form__error" data-field="address"></span>
                </div>

                <!-- City -->
                <div class="contact-form__field">
                    <label for="city" class="contact-form__label">
                        City <span class="contact-form__required">*</span>
                    </label>
                    <input
                        type="text"
                        name="city"
                        id="city"
                        class="contact-form__input"
                        placeholder="Enter your city"
                        required
                    >
                    <span class="contact-form__error" data-field="city"></span>
                </div>

                <!-- Postcode -->
                <div class="contact-form__field">
                    <label for="postcode" class="contact-form__label">
                        Postcode <span class="contact-form__required">*</span>
                    </label>
                    <input
                        type="text"
                        name="postcode"
                        id="postcode"
                        class="contact-form__input"
                        placeholder="Enter your postcode"
                        required
                    >
                    <span class="contact-form__error" data-field="postcode"></span>
                </div>

                <!-- Phone -->
                <div class="contact-form__field">
                    <label for="phone" class="contact-form__label">
                        Phone Number <span class="contact-form__required">*</span>
                    </label>
                    <input
                        type="tel"
                        name="phone"
                        id="phone"
                        class="contact-form__input"
                        placeholder="+1 (XXX) XXX-XXXX"
                        required
                    >
                    <span class="contact-form__error" data-field="phone"></span>
                </div>

                <!-- Email -->
                <div class="contact-form__field">
                    <label for="email" class="contact-form__label">
                        Email Address <span class="contact-form__required">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="contact-form__input"
                        placeholder="your@email.com"
                        required
                    >
                    <span class="contact-form__error" data-field="email"></span>
                </div>
            </div>

            <!-- Step 3 Buttons -->
            <div class="contact-form__actions contact-form__actions--step3">
                <button type="button" class="btn_contact btn--outline_contact contact-form__btn-back" data-back="2">
                    Previous
                </button>
                <button type="submit" class="btn_contact btn--primary contact-form__btn-submit">
                    Send
                </button>
            </div>
        </div>

        <!-- Success Message -->
        <div class="contact-form__step contact-form__step--hidden" data-step="success">
            <div class="contact-form__success">
                <div class="contact-form__success-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h2 class="contact-form__success-title">Thank You!</h2>
                <p class="contact-form__success-text">
                    Your request has been submitted successfully. Our team will contact you shortly.
                </p>
                <button type="button" class="btn_contact btn--primary contact-form__btn-reset">
                    Submit Another Request
                </button>
            </div>
        </div>

        <!-- Error Message -->
        <div class="contact-form__step contact-form__step--hidden" data-step="error">
            <div class="contact-form__error-message">
                <div class="contact-form__error-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <h2 class="contact-form__error-title">Something Went Wrong</h2>
                <p class="contact-form__error-text">
                    We couldn't submit your request. Please try again later.
                </p>
                <button type="button" class="btn_contact btn--primary contact-form__btn-back" data-back="3">
                    Go Back
                </button>
            </div>
        </div>
    </form>
</div>
