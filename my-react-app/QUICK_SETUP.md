# Quick Setup Guide for Desktop Location

Your project is currently at: `C:\Users\LENOVO\Desktop\website\my-react-app\`

## Option 1: Copy to XAMPP htdocs (RECOMMENDED - Easiest)

1. **Copy the project:**
   - Copy the entire `my-react-app` folder
   - Paste it into: `C:\xampp\htdocs\`
   - Final path: `C:\xampp\htdocs\my-react-app\`

2. **No changes needed** - The config is already set for this path!

3. **Test it:**
   - Open: `http://localhost/my-react-app/back-end/test_connection.php`
   - Should show: `{"status":"success"}`

## Option 2: Keep on Desktop (Requires Virtual Host Setup)

If you want to keep the project on Desktop:

1. **Edit `src/config.js`:**
   ```javascript
   // Change this line:
   const API_BASE_URL = 'http://localhost/my-react-app/back-end';
   
   // To match your virtual host (see step 2)
   ```

2. **Set up XAMPP Virtual Host:**
   - Open: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
   - Add this at the end:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "C:/Users/LENOVO/Desktop/website/my-react-app"
       ServerName myreactapp.local
       <Directory "C:/Users/LENOVO/Desktop/website/my-react-app">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
   - Open: `C:\Windows\System32\drivers\etc\hosts` (as Administrator)
   - Add: `127.0.0.1 myreactapp.local`
   - Restart Apache
   - Update `config.js` to: `const API_BASE_URL = 'http://myreactapp.local/back-end';`

## Option 3: Use Different Folder Name in htdocs

If you copied to htdocs with a different name:

1. **Edit `src/config.js`:**
   ```javascript
   // If your folder is named "website" in htdocs:
   const API_BASE_URL = 'http://localhost/website/back-end';
   
   // If your folder is named "clinic" in htdocs:
   const API_BASE_URL = 'http://localhost/clinic/back-end';
   ```

## Current Configuration

The `config.js` file is set to:
```javascript
const API_BASE_URL = 'http://localhost/my-react-app/back-end';
```

This works if your project is at: `C:\xampp\htdocs\my-react-app\`

## Testing

1. **Start XAMPP** (Apache + MySQL)

2. **Test backend:**
   ```
   http://localhost/my-react-app/back-end/test_connection.php
   ```

3. **Test login:**
   ```
   http://localhost/my-react-app/back-end/login.php
   ```

4. **Submit appointment form** from React app

## Troubleshooting

- **404 Error:** Project not in htdocs or wrong folder name
- **CORS Error:** Already fixed in process_appointment.php
- **Connection Error:** Check XAMPP is running and path is correct

## Recommended: Use Option 1

Just copy the project to `C:\xampp\htdocs\my-react-app\` and it will work immediately!

