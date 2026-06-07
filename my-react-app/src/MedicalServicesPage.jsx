import React from 'react';
import { Link } from 'react-router-dom';
import logo from './assets/logo.png';
import './Home.css';
import './MedicalServicesPage.css'; 

const servicesData = [
    // ... (servicesData is unchanged)
    { name: 'General Medicine', icon: '🩺', description: 'Comprehensive primary care for all ages, focusing on prevention and general health maintenance.' },
    { name: 'Cardiology', icon: '❤️', description: 'Diagnosis and treatment of heart and blood vessel disorders, including heart failure and hypertension.' },
    { name: 'Pediatrics', icon: '👶', description: 'Specialized medical care for infants, children, and adolescents, from wellness checks to treatment of acute illnesses.' },
    { name: 'Dermatology', icon: '✨', description: 'Care for conditions related to the skin, hair, and nails, including acne, eczema, and skin cancer screenings.' },
    { name: 'Gynecology & Obstetrics', icon: '🤰', description: 'Healthcare for women, covering reproductive health, prenatal care, and childbirth.' },
    { name: 'Emergency Care', icon: '🚨', description: 'Immediate medical attention for acute illnesses and injuries, available 24/7.' },
    { name: 'Medical Imaging', icon: '🔬', description: 'Advanced diagnostic tools like X-rays, ultrasounds, and MRIs to visualize the inside of the body.' },
    { name: 'Laboratory Tests', icon: '🧪', description: 'A full range of blood, urine, and other tests crucial for diagnosis and monitoring of health conditions.' },
];

/**
 * Renders the Medical Services page component.
 */
const MedicalServicesPage = () => {
    return (
        <div className="home-page medical-services-page-wrapper">
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
            
            {/* 1. Header Section - Matches the blue banner theme */}
            <div className="blue-header">
                <h1 className="header-title">Our Comprehensive Medical Services</h1>
                <p className="header-subtitle">Your path to well-being starts with expert care.</p>
            </div>

            <div className="services-content-wrapper">
                
                {/* 2. Services Grid */}
                <div className="services-grid">
                    {servicesData.map((service) => (
                        <div key={service.name} className="service-card">
                            <div className="service-icon">{service.icon}</div>
                            <h3 className="service-title">{service.name}</h3>
                            <p className="service-description">{service.description}</p>
                        </div>
                    ))}
                </div>

                {/* 3. Call-to-Action Footer */}
                <div className="footer-cta">
                    <p>Don't see what you're looking for? Contact us to discuss your specific medical needs.</p>
                    
                    {/* 👈 2. REPLACE <button> with <Link> and point 'to' the Contact route */}
                    <Link to="/contact" className="cta-button">
                        Contact Our Clinic
                    </Link>
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

export default MedicalServicesPage; 