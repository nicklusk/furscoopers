    </main>

    <footer class="footer" role="contentinfo" itemscope itemtype="https://schema.org/Organization">
        <p>&copy; 2026 <span itemprop="name">Fur Scoopers</span>. All rights reserved. | <span itemprop="url">furscoopers.com</span></p>
        <p itemprop="description">Professional dog waste removal with transparent, flat-rate pricing.</p>
    </footer>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" onclick="scrollToTop()">
        ↑
    </button>

    <!-- Modal for Sign Up Form -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Sign Up for Service</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <?php wp_nonce_field('furscoopers_subscription', 'furscoopers_nonce'); ?>
                    <input type="hidden" name="action" value="furscoopers_signup">
                    <div class="form-section">
                        <h3>Contact Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Service Address</h3>
                        <div class="form-group">
                            <label for="address">Street Address *</label>
                            <input type="text" id="address" name="address" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City *</label>
                                <input type="text" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="zipCode">ZIP Code *</label>
                                <input type="text" id="zipCode" name="zipCode" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gateCode">Gate Code / Access Instructions</label>
                            <textarea id="gateCode" name="gateCode" rows="2" placeholder="Any special instructions for accessing your yard"></textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Service Details</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="serviceFrequency">Service Frequency *</label>
                                <select id="serviceFrequency" name="serviceFrequency" required>
                                    <option value="">Select frequency</option>
                                    <option value="weekly">Weekly ($80/month)</option>
                                    <option value="twice-weekly">Twice Weekly ($140/month)</option>
                                    <option value="monthly">Monthly ($35/month)</option>
                                    <option value="one-time">One-Time Service ($45)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="numDogs">Number of Dogs</label>
                                <select id="numDogs" name="numDogs">
                                    <option value="1">1 Dog</option>
                                    <option value="2">2 Dogs</option>
                                    <option value="3">3 Dogs</option>
                                    <option value="4+">4+ Dogs</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Add-On Services</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="deodorizing" name="deodorizing" value="1">
                                    <label for="deodorizing">Deodorization (+$15)</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="frontYard" name="frontYard" value="1">
                                    <label for="frontYard">Front Yard Service (+$10)</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="startDate">Preferred Start Date</label>
                            <input type="date" id="startDate" name="startDate">
                        </div>
                    </div>


                    <div class="form-section">
                        <h3>Additional Information</h3>
                        <div class="form-group">
                            <label for="specialNotes">Special Instructions or Notes</label>
                            <textarea id="specialNotes" name="specialNotes" rows="3" placeholder="Any special requests, dog behavior notes, or other information we should know"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="submit-modal-btn">Complete Sign Up</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function toggleMobileMenu() {
            const hamburger = document.querySelector('.hamburger');
            const mobileNav = document.getElementById('mobileNav');

            hamburger.classList.toggle('active');
            mobileNav.classList.toggle('active');
        }

        function closeMobileMenu() {
            const hamburger = document.querySelector('.hamburger');
            const mobileNav = document.getElementById('mobileNav');

            hamburger.classList.remove('active');
            mobileNav.classList.remove('active');
        }

        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('span');

            if (answer.classList.contains('active')) {
                answer.classList.remove('active');
                icon.textContent = '+';
            } else {
                // Close all other open FAQs
                document.querySelectorAll('.faq-answer.active').forEach(openAnswer => {
                    openAnswer.classList.remove('active');
                    openAnswer.previousElementSibling.querySelector('span').textContent = '+';
                });

                answer.classList.add('active');
                icon.textContent = '−';
            }
        }

        function openModal() {
            document.getElementById('signupModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('signupModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }


        function submitContactForm(event) {
            event.preventDefault();
            alert('Thank you for your message! We will get back to you within 24 hours.');
            event.target.reset();
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('signupModal');
            if (event.target === modal) {
                closeModal();
            }
        }


        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to header and scroll-to-top button
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            const scrollToTopBtn = document.getElementById('scrollToTop');

            // Header background effect
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = 'white';
                header.style.backdropFilter = 'none';
            }

            // Show/hide scroll to top button
            if (window.scrollY > 300) {
                scrollToTopBtn.classList.add('visible');
            } else {
                scrollToTopBtn.classList.remove('visible');
            }
        });
    </script>
</body>
</html>