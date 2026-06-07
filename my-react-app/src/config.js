// API Configuration
// Update this URL based on where your project is located

// Option 1: If project is in XAMPP htdocs (C:\xampp\htdocs\my-react-app\)
// const API_BASE_URL = 'http://localhost/my-react-app/back-end';

// Option 2: If project is on Desktop and you set up a virtual host
// const API_BASE_URL = 'http://localhost/back-end';

// Option 3: If project is directly in htdocs root (C:\xampp\htdocs\)
// const API_BASE_URL = 'http://localhost/back-end';

// Option 4: Current setup - Desktop location (update if needed)
// If you copied project to htdocs, use Option 1
// If you're using a different folder name in htdocs, adjust accordingly
const API_BASE_URL = 'http://localhost/my-react-app/back-end';

export const API_ENDPOINTS = {
    PROCESS_APPOINTMENT: `${API_BASE_URL}/process_appointment.php`,
    TEST_CONNECTION: `${API_BASE_URL}/test_connection.php`
};

export default API_BASE_URL;

