import React, { useState } from 'react';
import './Home.css';
import './Appointment.css';
import { API_ENDPOINTS } from './config';

const Appointment = () => {

    const [formData, setFormData] = useState({
        firstName: '',
        lastName: '',
        birthdate: '',
        gender: '',
        requestedService: '',
        preferredDate: '',
        preferredTimeSlot: '',
        email: '',
        phoneNumber: '',
        address: '',
        allergiesHistory: '',
        doctor: '',
        medicalFile: null,
    });

    const [message, setMessage] = useState('');
    const [error, setError] = useState('');
    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleChange = (e) => {
        const { name, value, files } = e.target;
        if (name === 'medicalFile') {
            setFormData({ ...formData, medicalFile: files[0] });
        } else {
            setFormData({ ...formData, [name]: value });
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setMessage('');
        setError('');
        setIsSubmitting(true);

        const data = new FormData();

        data.append('first_name', formData.firstName);
        data.append('last_name', formData.lastName);
        data.append('birthdate', formData.birthdate);
        data.append('gender', formData.gender);
        data.append('requested_service', formData.requestedService);
        data.append('preferred_date', formData.preferredDate);

        // Convert "09:00 - 10:00" → "09:00"
        const timeOnly = formData.preferredTimeSlot.split(' - ')[0];
        data.append('preferred_time', timeOnly);

        data.append('email', formData.email);
        data.append('phone', formData.phoneNumber);
        data.append('address', formData.address);
        data.append('allergies_history', formData.allergiesHistory);
        data.append('selected_doctor', formData.doctor);

        if (formData.medicalFile) {
            data.append('medical_file', formData.medicalFile);
        }

        try {
            console.log('Sending request to backend...');
            console.log('API Endpoint:', API_ENDPOINTS.PROCESS_APPOINTMENT);
            
            const response = await fetch(
                API_ENDPOINTS.PROCESS_APPOINTMENT,
                {
                    method: 'POST',
                    body: data,
                }
            );

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('Non-JSON response:', text);
                throw new Error('Server returned non-JSON response. Check backend PHP errors.');
            }

            const result = await response.json();
            console.log('Result:', result);

            if (result.success) {
                setMessage(result.success);
                setError('');
                // Reset form
                setFormData({
                    firstName: '',
                    lastName: '',
                    birthdate: '',
                    gender: '',
                    requestedService: '',
                    preferredDate: '',
                    preferredTimeSlot: '',
                    email: '',
                    phoneNumber: '',
                    address: '',
                    allergiesHistory: '',
                    doctor: '',
                    medicalFile: null,
                });
                // Reset file input
                const fileInput = document.querySelector('input[type="file"]');
                if (fileInput) fileInput.value = '';
                
                // Scroll to top to show success message
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else if (result.error) {
                setError(result.error);
                setMessage('');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

        } catch (err) {
            console.error('Fetch error:', err);
            console.error('Error message:', err.message);
            setError(`Connection Error: ${err.message}. Please check: 1) XAMPP is running, 2) The backend path is correct (${API_ENDPOINTS.PROCESS_APPOINTMENT}), 3) Check browser console for details.`);
            setMessage('');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } finally {
            setIsSubmitting(false);
        }
    };

    const services = [
        'General Consultation',
        'Pediatric Consultation',
        'Dental Checkup',
        'Physiotherapy Session',
        'Vaccination',
        'Lab Test',
        'Follow-up Appointment',
        'Special Consultation'
    ];

    const doctors = [
        'Any Available Doctor',
        'Dr. Hammadi Mohamed (Chief Physician)',
        'Dr. Bousetta Ahmed (Pediatrician)',
        'Dr. Aissani Meriem (Cardiologist)',
    ];

    const timeSlots = [
        '09:00 - 10:00',
        '10:00 - 11:00',
        '11:00 - 12:00',
        '14:00 - 15:00',
        '15:00 - 16:00',
        '16:00 - 17:00'
    ];

    // Get today's date in YYYY-MM-DD format for min date validation
    const today = new Date().toISOString().split('T')[0];

    return (
        <div className="home-page appointment-page-wrapper">

            <div className="blue-header">
                <h1 className="header-title">Schedule Your Appointment</h1>
                <p className="header-subtitle">
                    Fill out the details below to request your consultation.
                </p>
            </div>

            <div className="appointment-content-container">
                <div className="form-card">
                    <h2 className="form-title">Appointment Request Form</h2>

                    {message && (
                        <div style={{ 
                            padding: '15px', 
                            marginBottom: '20px', 
                            backgroundColor: '#d4edda', 
                            border: '1px solid #c3e6cb', 
                            borderRadius: '5px',
                            color: '#155724',
                            fontWeight: 'bold'
                        }}>
                            ✓ {message}
                        </div>
                    )}
                    
                    {error && (
                        <div style={{ 
                            padding: '15px', 
                            marginBottom: '20px', 
                            backgroundColor: '#f8d7da', 
                            border: '1px solid #f5c6cb', 
                            borderRadius: '5px',
                            color: '#721c24',
                            fontWeight: 'bold'
                        }}>
                            ✗ {error}
                        </div>
                    )}

                    <form
                        onSubmit={handleSubmit}
                        className="appointment-form"
                        encType="multipart/form-data"
                    >

                        <div className="form-section-title">Personal Information</div>

                        <div className="form-group-row">
                            <div className="form-group">
                                <label>First Name <span style={{color: 'red'}}>*</span></label>
                                <input 
                                    type="text" 
                                    name="firstName" 
                                    value={formData.firstName} 
                                    onChange={handleChange} 
                                    required 
                                    disabled={isSubmitting}
                                />
                            </div>

                            <div className="form-group">
                                <label>Last Name <span style={{color: 'red'}}>*</span></label>
                                <input 
                                    type="text" 
                                    name="lastName" 
                                    value={formData.lastName} 
                                    onChange={handleChange} 
                                    required 
                                    disabled={isSubmitting}
                                />
                            </div>
                        </div>

                        <div className="form-group-row">
                            <div className="form-group">
                                <label>Birthdate <span style={{color: 'red'}}>*</span></label>
                                <input 
                                    type="date" 
                                    name="birthdate" 
                                    value={formData.birthdate} 
                                    onChange={handleChange} 
                                    max={today}
                                    required 
                                    disabled={isSubmitting}
                                />
                            </div>

                            <div className="form-group">
                                <label>Gender <span style={{color: 'red'}}>*</span></label>
                                <select 
                                    name="gender" 
                                    value={formData.gender} 
                                    onChange={handleChange} 
                                    required
                                    disabled={isSubmitting}
                                >
                                    <option value="">-- Select --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div className="form-section-title">Contact Information</div>

                        <div className="form-group">
                            <label>Email <span style={{color: 'red'}}>*</span></label>
                            <input 
                                type="email" 
                                name="email" 
                                value={formData.email} 
                                onChange={handleChange} 
                                required 
                                disabled={isSubmitting}
                            />
                        </div>

                        <div className="form-group">
                            <label>Phone Number <span style={{color: 'red'}}>*</span></label>
                            <input 
                                type="tel" 
                                name="phoneNumber" 
                                value={formData.phoneNumber} 
                                onChange={handleChange} 
                                required 
                                disabled={isSubmitting}
                            />
                        </div>

                        <div className="form-group">
                            <label>Address <span style={{color: 'red'}}>*</span></label>
                            <input 
                                type="text" 
                                name="address" 
                                value={formData.address} 
                                onChange={handleChange} 
                                required 
                                disabled={isSubmitting}
                            />
                        </div>

                        <div className="form-section-title">Appointment Details</div>

                        <div className="form-group">
                            <label>Requested Service <span style={{color: 'red'}}>*</span></label>
                            <select 
                                name="requestedService" 
                                value={formData.requestedService} 
                                onChange={handleChange} 
                                required
                                disabled={isSubmitting}
                            >
                                <option value="">-- Select Service --</option>
                                {services.map(s => <option key={s} value={s}>{s}</option>)}
                            </select>
                        </div>

                        <div className="form-group">
                            <label>Select Doctor</label>
                            <select 
                                name="doctor" 
                                value={formData.doctor} 
                                onChange={handleChange}
                                disabled={isSubmitting}
                            >
                                <option value="">-- Select Doctor --</option>
                                {doctors.map(d => <option key={d} value={d}>{d}</option>)}
                            </select>
                        </div>

                        <div className="form-group-row">
                            <div className="form-group">
                                <label>Preferred Date <span style={{color: 'red'}}>*</span></label>
                                <input 
                                    type="date" 
                                    name="preferredDate" 
                                    value={formData.preferredDate} 
                                    onChange={handleChange} 
                                    min={today}
                                    required 
                                    disabled={isSubmitting}
                                />
                            </div>

                            <div className="form-group">
                                <label>Preferred Time Slot <span style={{color: 'red'}}>*</span></label>
                                <select 
                                    name="preferredTimeSlot" 
                                    value={formData.preferredTimeSlot} 
                                    onChange={handleChange} 
                                    required
                                    disabled={isSubmitting}
                                >
                                    <option value="">-- Select Time --</option>
                                    {timeSlots.map(t => <option key={t} value={t}>{t}</option>)}
                                </select>
                            </div>
                        </div>

                        <div className="form-section-title">Medical History & Files</div>

                        <div className="form-group">
                            <label>Allergies / History</label>
                            <textarea 
                                name="allergiesHistory" 
                                value={formData.allergiesHistory} 
                                onChange={handleChange} 
                                rows="3"
                                disabled={isSubmitting}
                                placeholder="Please describe any allergies or relevant medical history..."
                            />
                        </div>

                        <div className="form-group">
                            <label>Upload Medical File (PDF, JPG, PNG - Max 5MB)</label>
                            <input 
                                type="file" 
                                name="medicalFile" 
                                onChange={handleChange} 
                                accept=".pdf,.jpg,.jpeg,.png"
                                disabled={isSubmitting}
                            />
                        </div>

                        <button 
                            type="submit" 
                            className="submit-button"
                            disabled={isSubmitting}
                            style={{
                                opacity: isSubmitting ? 0.6 : 1,
                                cursor: isSubmitting ? 'not-allowed' : 'pointer'
                            }}
                        >
                            {isSubmitting ? 'Submitting...' : 'Submit Appointment Request'}
                        </button>

                    </form>
                </div>
            </div>
        </div>
    );
};

export default Appointment;