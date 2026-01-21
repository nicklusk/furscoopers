        <section id="pricing" class="section">
            <h2>Transparent Pricing</h2>
            <div class="pricing-table">
                <table>
                    <thead>
                        <tr>
                            <th>Service Type</th>
                            <th>Frequency</th>
                            <th>Monthly Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Regular Cleanup</td>
                            <td>Weekly</td>
                            <td class="price">$80/month</td>
                        </tr>
                        <tr>
                            <td>Regular Cleanup</td>
                            <td>Twice Weekly</td>
                            <td class="price">$140/month</td>
                        </tr>
                        <tr>
                            <td>Regular Cleanup</td>
                            <td>Monthly</td>
                            <td class="price">$50/month</td>
                        </tr>
                        <tr>
                            <td>One-Time Cleanup</td>
                            <td>Single Service</td>
                            <td class="price">$60/visit</td>
                        </tr>
                        <tr>
                            <td>Deodorization Add-On</td>
                            <td>Per Treatment</td>
                            <td class="price">+$15</td>
                        </tr>
                        <tr>
                            <td>Front Yard Add-On</td>
                            <td>Per Service</td>
                            <td class="price">+$10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="pricing-note">
                <p><strong>Service Area:</strong> Pricing covers backyards under 0.5 acres, regardless of dog size or number of dogs. Front yard service available for a low flat fee add-on.</p>
            </div>

            <div class="center-button" style="margin-top: 2rem;">
                <button class="cta-button" onclick="openModal()">Sign Up for Service</button>
            </div>


			
            <div class="contact-section">
                <h3>Still Not Sure? Contact Us First</h3>
                <div class="contact-container">
                    <div class="contact-form">
                        <h4>Send Us a Message</h4>
                        <form action="process_form.php" method="POST">
                            <input name="name" id="name" type="text" placeholder="Your Name" required>
                            <input name="Email" id="email" type="email" placeholder="Your Email" required>
                            <input name="phone" id="phone" type="tel" placeholder="Phone Number">
                            <textarea name="message" id="message" placeholder="Your Message" rows="4" required></textarea>
                            <button  onclick="mail();" type="submit" class="contact-submit-btn">Send Message</button>
                        </form>
						<script src="contact_form_js.js"></script>
                    </div>
                    <div class="contact-phone">
                        <h4>Call Us Directly</h4>
                        <div class="phone-number">
                            <span class="phone-icon">📞</span>
                            <a href="tel:9195376714" itemprop="telephone" aria-label="Call Fur Scoopers at (919) 537-6714">(919) 537-6714</a>
                        </div>
                        <p>Speak with our friendly team about your specific needs and get answers to all your questions.</p>
                    </div>
                </div>
            </div>
        </section>