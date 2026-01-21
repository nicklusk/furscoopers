/**
 * Fur Scoopers WordPress Theme JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Scroll to top functionality
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Toggle mobile menu
    function toggleMobileMenu() {
        const hamburger = document.querySelector('.hamburger');
        const mobileNav = document.getElementById('mobileNav');

        if (hamburger && mobileNav) {
            hamburger.classList.toggle('active');
            mobileNav.classList.toggle('active');
        }
    }

    // Close mobile menu
    function closeMobileMenu() {
        const hamburger = document.querySelector('.hamburger');
        const mobileNav = document.getElementById('mobileNav');

        if (hamburger && mobileNav) {
            hamburger.classList.remove('active');
            mobileNav.classList.remove('active');
        }
    }

    // Toggle FAQ
    function toggleFAQ(element) {
        const answer = element.nextElementSibling;
        const icon = element.querySelector('span');

        if (answer && icon) {
            if (answer.classList.contains('active')) {
                answer.classList.remove('active');
                icon.textContent = '+';
            } else {
                // Close all other open FAQs
                document.querySelectorAll('.faq-answer.active').forEach(openAnswer => {
                    openAnswer.classList.remove('active');
                    const openIcon = openAnswer.previousElementSibling.querySelector('span');
                    if (openIcon) {
                        openIcon.textContent = '+';
                    }
                });

                answer.classList.add('active');
                icon.textContent = '−';
            }
        }
    }

    // Open modal
    function openModal() {
        const modal = document.getElementById('signupModal');
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }

    // Close modal
    function closeModal() {
        const modal = document.getElementById('signupModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // Handle signup form submission
    function submitSignupForm(event) {
        event.preventDefault();
        alert('Thank you for signing up! We will contact you within 24 hours to confirm your service details.');
        closeModal();
    }

    // Handle contact form submission
    function submitContactForm(event) {
        event.preventDefault();
        alert('Thank you for your message! We will get back to you within 24 hours.');
        event.target.reset();
    }

    // Format card number input
    function formatCardNumber(input) {
        let value = input.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        input.value = formattedValue;
    }

    // Format expiry date input
    function formatExpiryDate(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        input.value = value;
    }

    // Event Listeners
    
    // Hamburger menu
    const hamburger = document.querySelector('.hamburger');
    if (hamburger) {
        hamburger.addEventListener('click', toggleMobileMenu);
    }

    // Mobile nav links
    document.querySelectorAll('.mobile-nav a').forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    // FAQ questions
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function() {
            toggleFAQ(this);
        });
    });

    // Scroll to top button
    const scrollToTopBtn = document.getElementById('scrollToTop');
    if (scrollToTopBtn) {
        scrollToTopBtn.addEventListener('click', scrollToTop);
    }

    // CTA buttons to open modal
    document.querySelectorAll('.cta-button').forEach(button => {
        if (button.textContent.includes('Sign Up')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });
        }
    });

    // Modal close button
    document.querySelectorAll('.close').forEach(closeBtn => {
        closeBtn.addEventListener('click', closeModal);
    });

    // Modal form submission
    const signupForm = document.querySelector('#signupModal form');
    if (signupForm) {
        signupForm.addEventListener('submit', submitSignupForm);
    }

    // Contact form submission (for non-CF7 forms)
    const contactForm = document.querySelector('.contact-form form');
    if (contactForm && !contactForm.classList.contains('wpcf7-form')) {
        contactForm.addEventListener('submit', submitContactForm);
    }

    // Card number formatting
    const cardNumberInput = document.getElementById('cardNumber');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            formatCardNumber(this);
        });
    }

    // Expiry date formatting
    const expiryInput = document.getElementById('expiry');
    if (expiryInput) {
        expiryInput.addEventListener('input', function() {
            formatExpiryDate(this);
        });
    }

    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('signupModal');
        if (event.target === modal) {
            closeModal();
        }
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = target.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add scroll effects
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.header');
        const scrollToTopBtn = document.getElementById('scrollToTop');

        // Header background effect
        if (header) {
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = 'white';
                header.style.backdropFilter = 'none';
            }
        }

        // Show/hide scroll to top button
        if (scrollToTopBtn) {
            if (window.scrollY > 300) {
                scrollToTopBtn.classList.add('visible');
            } else {
                scrollToTopBtn.classList.remove('visible');
            }
        }
    });

    // Add animation on scroll for elements
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe elements for scroll animations
    document.querySelectorAll('.service-card, .fact-card, .step, .testimonial, .faq-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // Lazy load banner video if present
    const bannerVideo = document.querySelector('.banner-video');
    if (bannerVideo) {
        // Pause video when not in viewport to save bandwidth
        const videoObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.play();
                } else {
                    entry.target.pause();
                }
            });
        }, { threshold: 0.5 });

        videoObserver.observe(bannerVideo);
    }

    // Handle form validation for better UX
    document.querySelectorAll('input[required], textarea[required], select[required]').forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '#d4e6c7';
            }
        });

        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#27ae60';
            }
        });
    });

    // Email validation
    document.querySelectorAll('input[type="email"]').forEach(emailField => {
        emailField.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                this.style.borderColor = '#e74c3c';
                this.setCustomValidity('Please enter a valid email address');
            } else {
                this.style.borderColor = this.value ? '#27ae60' : '#d4e6c7';
                this.setCustomValidity('');
            }
        });
    });

    // Phone number formatting
    document.querySelectorAll('input[type="tel"]').forEach(phoneField => {
        phoneField.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 10) {
                value = `(${value.substring(0, 3)}) ${value.substring(3, 6)}-${value.substring(6, 10)}`;
            }
            this.value = value;
        });
    });

    // Add loading states for form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('input[type="submit"], button[type="submit"]');
            if (submitBtn && !this.classList.contains('wpcf7-form')) {
                const originalText = submitBtn.textContent || submitBtn.value;
                submitBtn.textContent = submitBtn.value = 'Sending...';
                submitBtn.disabled = true;

                // Re-enable after 3 seconds (fallback)
                setTimeout(() => {
                    submitBtn.textContent = submitBtn.value = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    });

    // Initialize pricing calculator if elements exist
    const serviceFrequencySelect = document.getElementById('serviceFrequency');
    if (serviceFrequencySelect) {
        serviceFrequencySelect.addEventListener('change', function() {
            updatePriceCalculation();
        });
    }

    function updatePriceCalculation() {
        const frequency = document.getElementById('serviceFrequency')?.value;
        const deodorizing = document.getElementById('deodorizing')?.checked;
        const frontYard = document.getElementById('frontYard')?.checked;
        
        let basePrice = 0;
        let totalPrice = 0;
        
        // Base pricing
        switch(frequency) {
            case 'weekly':
                basePrice = 80;
                break;
            case 'twice-weekly':
                basePrice = 140;
                break;
            case 'monthly':
                basePrice = 35;
                break;
            case 'one-time':
                basePrice = 45;
                break;
        }
        
        totalPrice = basePrice;
        
        // Add-ons
        if (deodorizing) {
            totalPrice += 15;
        }
        if (frontYard) {
            totalPrice += 10;
        }
        
        // Update price display if element exists
        const priceDisplay = document.getElementById('calculatedPrice');
        if (priceDisplay && frequency) {
            const priceText = frequency === 'one-time' ? `${totalPrice}` : `${totalPrice}/month`;
            priceDisplay.textContent = priceText;
            priceDisplay.style.display = 'block';
        }
    }

    // Add event listeners for add-on checkboxes
    document.querySelectorAll('#deodorizing, #frontYard').forEach(checkbox => {
        checkbox.addEventListener('change', updatePriceCalculation);
    });

    // Keyboard navigation for modal
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('signupModal');
        if (modal && modal.style.display === 'block') {
            if (e.key === 'Escape') {
                closeModal();
            }
            
            // Trap focus within modal
            const focusableElements = modal.querySelectorAll('input, select, textarea, button, [tabindex]:not([tabindex="-1"])');
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];
            
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            }
        }
    });

    // Add enhanced accessibility features
    document.querySelectorAll('.faq-question').forEach(question => {
        question.setAttribute('role', 'button');
        question.setAttribute('aria-expanded', 'false');
        
        question.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
        });
    });

    // Add focus indicators for keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-navigation');
        }
    });

    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-navigation');
    });

    // Initialize any existing Contact Form 7 enhancements
    document.addEventListener('wpcf7mailsent', function(event) {
        // Handle successful form submission
        const formContainer = event.target.closest('.contact-form, .modal-body');
        if (formContainer) {
            // Show success message or redirect
            const successMsg = document.createElement('div');
            successMsg.className = 'success-message';
            successMsg.innerHTML = '<p style="color: #27ae60; font-weight: bold; padding: 1rem; background: #d5f4e6; border-radius: 5px; margin-top: 1rem;">Thank you! We\'ll get back to you within 24 hours.</p>';
            formContainer.appendChild(successMsg);
            
            // Hide success message after 5 seconds
            setTimeout(() => {
                if (successMsg.parentNode) {
                    successMsg.parentNode.removeChild(successMsg);
                }
            }, 5000);
        }
        
        // Close modal if form was in modal
        if (event.target.closest('#signupModal')) {
            setTimeout(closeModal, 2000);
        }
    });

    document.addEventListener('wpcf7invalid', function(event) {
        // Handle form validation errors
        const form = event.target;
        const firstError = form.querySelector('.wpcf7-not-valid');
        if (firstError) {
            firstError.focus();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Add print styles functionality
    window.addEventListener('beforeprint', function() {
        // Hide unnecessary elements when printing
        document.querySelectorAll('.header, .scroll-to-top, .modal').forEach(el => {
            el.style.display = 'none';
        });
    });

    window.addEventListener('afterprint', function() {
        // Restore hidden elements after printing
        document.querySelectorAll('.header, .scroll-to-top').forEach(el => {
            el.style.display = '';
        });
    });

    // Performance optimization: Debounce scroll events
    let scrollTimeout;
    const originalScrollHandler = window.onscroll;
    
    window.addEventListener('scroll', function() {
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        
        scrollTimeout = setTimeout(function() {
            // Throttled scroll logic here
            if (originalScrollHandler) {
                originalScrollHandler();
            }
        }, 16); // ~60fps
    });

    // Add service worker registration if available (for PWA functionality)
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('SW registered: ', registration);
                })
                .catch(function(registrationError) {
                    console.log('SW registration failed: ', registrationError);
                });
        });
    }

    console.log('Fur Scoopers theme JavaScript loaded successfully');
});
        