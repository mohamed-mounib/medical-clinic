# Debug Steps for Connection Error

Follow these steps to identify the issue:

## Step 1: Test Backend Directly

1. Open your browser
2. Go to: `http://localhost/my-react-app/back-end/test_connection.php`
3. Should show: `{"status":"success",...}`

## Step 2: Test POST Request

1. Open browser console (F12)
2. Run this JavaScript:
```javascript
fetch('http://localhost/my-react-app/back-end/test_post.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({test: 'data'})
})
.then(r => r.json())
.then(console.log)
.catch(console.error);
```

3. Should return success message

## Step 3: Check Browser Console

1. Open your React app
2. Open Developer Tools (F12)
3. Go to **Console** tab
4. Submit the appointment form
5. Look for error messages
6. Check the **Network** tab:
   - Find the request to `process_appointment.php`
   - Click on it
   - Check:
     - Status code (should be 200)
     - Response tab (see what PHP returned)
     - Headers tab (check CORS headers)

## Step 4: Check PHP Error Logs

1. Open XAMPP Control Panel
2. Click **Logs** button next to Apache
3. Look for recent errors
4. Or check: `C:\xampp\apache\logs\error.log`

## Step 5: Test with Simple FormData

In browser console, test with a simple request:
```javascript
const formData = new FormData();
formData.append('first_name', 'Test');
formData.append('last_name', 'User');
formData.append('email', 'test@test.com');
formData.append('phone', '1234567890');
formData.append('birthdate', '2000-01-01');
formData.append('gender', 'Male');
formData.append('requested_service', 'General Consultation');
formData.append('preferred_date', '2024-12-31');
formData.append('preferred_time', '10:00');
formData.append('address', 'Test Address');

fetch('http://localhost/my-react-app/back-end/process_appointment.php', {
    method: 'POST',
    body: formData
})
.then(r => r.text())
.then(console.log)
.catch(console.error);
```

## Common Issues & Solutions

### Issue: CORS Error
**Solution:** Already fixed, but verify the origin matches your React dev server port

### Issue: 404 Not Found
**Solution:** 
- Verify path: `http://localhost/my-react-app/back-end/process_appointment.php`
- Check file exists in: `C:\xampp\htdocs\my-react-app\back-end\process_appointment.php`

### Issue: 500 Internal Server Error
**Solution:**
- Check PHP error logs
- Verify database connection in `connection.php`
- Check if database `medical_clinic` exists

### Issue: Network Error / Failed to Fetch
**Possible causes:**
1. Apache not running
2. Wrong URL path
3. Firewall blocking
4. PHP syntax error

**Solution:**
- Restart Apache in XAMPP
- Verify URL in browser: `http://localhost/my-react-app/back-end/test_connection.php`
- Check browser console for specific error

## Quick Fix Checklist

- [ ] XAMPP Apache is running (green)
- [ ] XAMPP MySQL is running (green)
- [ ] Test connection works: `http://localhost/my-react-app/back-end/test_connection.php`
- [ ] File exists: `C:\xampp\htdocs\my-react-app\back-end\process_appointment.php`
- [ ] Database exists: `medical_clinic`
- [ ] Check browser console for specific errors
- [ ] Check Network tab for request details

