import React from 'react';
import { Link } from 'react-router-dom'; // For navigation
import 'bootstrap/dist/css/bootstrap.min.css';
import './Home.css';
import './About.css'; // Import custom CSS

// Import images (replace with actual paths after downloading)
import logo from './assets/logo.png';
import doctor1 from './assets/doctor1.jpg';
import doctor2 from './assets/doctor2.jpg';
import doctor3 from './assets/doctor3.jpg';
import clinicHistory from './assets/clinic-history.jpg';

const About = () => {
  return (
    <div className="home-page about-page">
      {/* Header (Consistent with Home) */}
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

      {/* Page Title */}
      <section className="page-title text-center py-5 bg-primary text-white">
        <div className="container">
          <h2>About Us</h2>
          <p>Learn more about our clinic, our team, and our commitment to your health.</p>
        </div>
      </section>

      {/* Clinic Introduction */}
      <section className="introduction py-5">
        <div className="container">
          <div className="row align-items-center">
            <div className="col-md-6">
              <h3>Who We Are</h3>
              <p>HealthCare Clinic has been a trusted provider of comprehensive medical services since 2003. Located in the heart of the city, we specialize in family medicine, cardiology, pediatrics, and more. Our patient-centered approach ensures personalized care for individuals and families.</p>
              <p>We pride ourselves on using the latest technology and evidence-based practices to deliver high-quality healthcare in a compassionate environment.</p>
            </div>
            <div className="col-md-6">
              <img src={clinicHistory} alt="Clinic Building" className="img-fluid rounded" />
            </div>
          </div>
        </div>
      </section>

      {/* Meet Our Doctors */}
      <section className="doctors py-5 bg-light">
        <div className="container">
          <h3 className="text-center mb-4">Meet Our Doctors</h3>
          <div className="row">
            <div className="col-md-4 text-center">
              <div className="doctor-card p-3 border rounded shadow-sm">
                <img src={doctor1} alt="Dr. John Smith" className="doctor-img mb-3" />
                <h4>Dr. Hammadi Mohamed</h4>
                <p>Chief Physician</p>
                <p>Specializes in internal medicine with 15 years of experience. Passionate about preventive care.</p>
              </div>
            </div>
            <div className="col-md-4 text-center">
              <div className="doctor-card p-3 border rounded shadow-sm">
                <img src={doctor2} alt="Dr. Emily Johnson" className="doctor-img mb-3" />
                <h4>Dr. Bousetta Ahmed</h4>
                <p>Pediatrician</p>
                <p>Expert in child healthcare, focusing on growth and development. Loves working with families.</p>
              </div>
            </div>
            <div className="col-md-4 text-center">
              <div className="doctor-card p-3 border rounded shadow-sm">
                <img src={doctor3} alt="Dr. Michael Lee" className="doctor-img mb-3" />
                <h4>Dr. Aissani Meriem</h4>
                <p>Cardiologist</p>
                <p>Board-certified cardiologist with a focus on heart health and advanced treatments.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Clinic History */}
      <section className="history py-5">
        <div className="container">
          <h3 className="text-center mb-4">Our History</h3>
          <p>Founded in 2003 by Dr. John Smith, HealthCare Clinic started as a small family practice. Over the years, we've expanded to include a team of specialists and state-of-the-art facilities. We've served over 50,000 patients and continue to grow while maintaining our core values of integrity, compassion, and excellence.</p>
          <p>Key milestones include opening our cardiology wing in 2010 and introducing telemedicine services in 2020 to better serve our community during challenging times.</p>
        </div>
      </section>

      {/* Mission and Vision */}
      <section className="mission-vision py-5 bg-primary text-white">
        <div className="container">
          <div className="row">
            <div className="col-md-6">
              <h3>Our Mission</h3>
              <p>To provide accessible, high-quality healthcare that improves the lives of our patients and community, fostering a healthier future for all.</p>
            </div>
            <div className="col-md-6">
              <h3>Our Vision</h3>
              <p>To be the leading medical clinic in the region, recognized for innovation, patient satisfaction, and holistic care.</p>
            </div>
          </div>
        </div>
      </section>

      {/* Footer (Consistent with Home) */}
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

export default About;