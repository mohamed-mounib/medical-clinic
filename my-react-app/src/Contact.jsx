import React from 'react';
import { Link } from 'react-router-dom';
import logo from './assets/logo.png';
import './Home.css';
import './Contact.css';


const Contact = () => {
  return (
    <div className="home-page contact-page">
      {/* Header */}
      <header className="header bg-light py-3">
        <div className="container d-flex justify-content-between align-items-center">
          <div className="logo">
            <img src={logo} alt="HealthCare Clinic Logo" className="logo-img" />
          </div>
          <nav className="navbar navbar-expand-lg">
            <ul className="navbar-nav">
              <li className="nav-item"><Link className="nav-link" to="/">Home</Link></li>
              <li className="nav-item"><Link className="nav-link" to="/about">About Us</Link></li>
              <li className="nav-item"><Link className="nav-link" to="/services">Medical Services</Link></li>
              <li className="nav-item"><Link className="nav-link" to="/appointment">Appointment</Link></li>
              <li className="nav-item"><Link className="nav-link" to="/contact">Contact Us</Link></li>
            </ul>
          </nav>
          <div className="header-actions">
            <a href="http://localhost/my-react-app/back-end/login.php" className="btn-login">Login</a>
          </div>
        </div>
      </header>
      <div className="contact-container">
        <h2 className="contact-title">
          CONTACT <span className="highlight">US</span>
        </h2>

        <div className="contact-content">
          <div className="contact-info">
            <h3 className="team-title">OUR TEAM</h3>

            <address className="address-info">
              123 Health St<br />
              Constantine, Algeria
            </address>

            <div className="contact-details">
              <p className="tel">Phone: (+213) 5-6122-7819</p>
              <p className="email">Email: info@healthcareclinic.com</p>
            </div>

            <p className="learn-more">Learn more about our team.</p>

            <button className="explore-button">Explore</button>
          </div>

          <div className="hours-map">
            <div className="hours-card">
              <h3 className="section-title">Opening Hours</h3>
              <ul className="hours-list">
                <li>
                  <span>Monday - Friday</span>
                  <span>08:00 AM – 06:00 PM</span>
                </li>
                <li>
                  <span>Saturday</span>
                  <span>09:00 AM – 02:00 PM</span>
                </li>
                <li>
                  <span>Sunday</span>
                  <span>Closed</span>
                </li>
              </ul>
            </div>

            <div className="map-card">
              <h3 className="section-title">Find Us</h3>
              <div className="map-wrapper">
                <iframe
                  title="HealthCare Clinic Location"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3308.0949315241556!2d6.596010275601295!3d36.36520339854527!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128fb258c6135bee%3A0x34c5b5d4798365a!2sConstantine%2C%20Algeria!5e0!3m2!1sen!2sdz!4v1732110000000!5m2!1sen!2sdz"
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                  allowFullScreen
                ></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
      {/* Footer (Basic, as per context) */}
      <footer className="footer bg-dark text-white py-3" id="contact">
        <div className="container text-center">
          <p>&copy; 2025 HealthCare Clinic. All rights reserved.</p>
          <p>Address: 123 Health St, Constantine, Algeria | Phone: (+213) 5-6122-7819 | Email: info@healthcareclinic.com</p>
          <p>Emergency Hotline: (+213) 5-3356-7891</p>
          <div className="social-links">
            <a href="#" className="text-white me-3">Facebook</a>
            <a href="#" className="text-white me-3">Twitter</a>
            <a href="#" className="text-white">Instagram</a>
          </div>
        </div>
      </footer>
      
    </div>
    
    
  );

};

export default Contact;