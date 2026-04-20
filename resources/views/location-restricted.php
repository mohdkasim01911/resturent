<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geo-Fencing System | 5km Restriction</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Normal Content Styles */
        .normal-content {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }

        .header h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
        }

        /* Status Card */
        .status-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .status-title {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .info-value {
            font-size: 1.1rem;
            color: #333;
            word-break: break-all;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin-top: 15px;
        }

        .status-allowed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-blocked {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Content Cards */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .content-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
        }

        .content-card h3 {
            color: #667eea;
            margin-bottom: 15px;
        }

        .content-card p {
            color: #666;
            line-height: 1.6;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 15px;
            transition: transform 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        /* Blocked Content Styles */
        .blocked-content {
            display: none;
            text-align: center;
            padding: 50px 20px;
            animation: fadeIn 0.5s ease;
        }

        .blocked-card {
            background: white;
            border-radius: 20px;
            padding: 50px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .blocked-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .blocked-card h1 {
            color: #dc3545;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .blocked-card p {
            color: #666;
            font-size: 1.1rem;
            margin: 15px 0;
        }

        .distance-info {
            background: #f8d7da;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        /* Custom Alert */
        .custom-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 300px;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 10000;
            animation: slideInRight 0.5s ease;
            display: none;
        }

        .alert-error {
            background: #dc3545;
            color: white;
            border-left: 5px solid #721c24;
        }

        .alert-success {
            background: #28a745;
            color: white;
            border-left: 5px solid #155724;
        }

        .alert-warning {
            background: #ffc107;
            color: #333;
            border-left: 5px solid #856404;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.8rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .blocked-card {
                padding: 30px;
            }
            
            .custom-alert {
                left: 20px;
                right: 20px;
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="spinner"></div>
    </div>

    <!-- Custom Alert -->
    <div id="customAlert" class="custom-alert"></div>

    <!-- Normal Website Content -->
    <div id="normalContent" class="normal-content">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1>🏠 Welcome to Our Website</h1>
                <p>Your trusted platform for amazing services</p>
            </div>

            <!-- Status Card -->
            <div class="status-card">
                <div class="status-title">📍 Location Status Dashboard</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">🎯 Center Point</div>
                        <div class="info-value" id="centerPoint">28.6139, 77.2090</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">📍 Your Location</div>
                        <div class="info-value" id="userLocation">Waiting for location...</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">📏 Distance from Center</div>
                        <div class="info-value" id="distanceValue">-- km</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">⚡ Allowed Radius</div>
                        <div class="info-value">5 Kilometers</div>
                    </div>
                </div>
                <div>
                    <span class="status-badge" id="accessStatus">Checking location...</span>
                </div>
                <button class="btn" onclick="checkLocationAgain()">🔄 Check Location Again</button>
            </div>

            <!-- Content Cards -->
            <div class="content-grid">
                <div class="content-card">
                    <h3>📱 Our Services</h3>
                    <p>We provide high-quality web development, mobile apps, and digital marketing services.</p>
                </div>
                <div class="content-card">
                    <h3>💼 Portfolio</h3>
                    <p>Check out our amazing projects and success stories from happy clients worldwide.</p>
                </div>
                <div class="content-card">
                    <h3>📞 Contact Us</h3>
                    <p>Get in touch with our team for any inquiries or support.</p>
                </div>
                <div class="content-card">
                    <h3>⭐ Testimonials</h3>
                    <p>Read what our clients say about our services and solutions.</p>
                </div>
                <div class="content-card">
                    <h3>🚀 Latest Blog</h3>
                    <p>Stay updated with latest technology trends and insights.</p>
                </div>
                <div class="content-card">
                    <h3>🎓 Training</h3>
                    <p>Join our training programs and boost your skills.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Blocked Content -->
    <div id="blockedContent" class="blocked-content">
        <div class="container">
            <div class="blocked-card">
                <div class="blocked-icon">⛔</div>
                <h1>Access Denied!</h1>
                <p>You are outside the allowed area.</p>
                <div class="distance-info">
                    <p style="margin: 0;">📏 <strong>Your Distance:</strong> <span id="blockedDistance">--</span> km</p>
                    <p style="margin: 10px 0 0 0;">📍 <strong>Allowed Radius:</strong> 5 km</p>
                </div>
                <p>Please come within the 5km radius to access this website.</p>
                <button class="btn" onclick="checkLocationAgain()">🔄 Try Again</button>
                <p style="margin-top: 20px; font-size: 0.9rem;">Contact support if you think this is a mistake.</p>
            </div>
        </div>
    </div>

    <script>
        // ==================== CONFIGURATION ====================
        // Yahan apna center point set karein
        const CENTER_LAT = 28.6139;   // Delhi (example)
        const CENTER_LNG = 77.2090;    // Delhi (example)
        const MAX_RADIUS_KM = 5;       // 5 kilometer restriction
        
        // ==================== HELPER FUNCTIONS ====================
        
        // Show custom alert
        function showAlert(message, type = 'error') {
            const alertBox = document.getElementById('customAlert');
            alertBox.className = `custom-alert alert-${type}`;
            alertBox.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 20px;">${type === 'error' ? '❌' : (type === 'success' ? '✅' : '⚠️')}</span>
                    <span style="flex: 1;">${message}</span>
                    <span style="cursor: pointer; font-size: 20px;" onclick="this.parentElement.parentElement.style.display='none'">✖</span>
                </div>
            `;
            alertBox.style.display = 'block';
            
            // Auto hide after 4 seconds
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 4000);
        }
        
        // Show loading
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }
        
        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }
        
        // Calculate distance using Haversine formula
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Earth's radius in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }
        
        // Format distance
        function formatDistance(distance) {
            if (distance < 1) {
                return `${Math.round(distance * 1000)} meters`;
            }
            return `${distance.toFixed(2)} km`;
        }
        
        // ==================== MAIN FUNCTION ====================
        function checkLocation() {
            showLoading();
            
            // Update center point display
            document.getElementById('centerPoint').innerHTML = `${CENTER_LAT}, ${CENTER_LNG}`;
            
            // Check if geolocation is supported
            if ("geolocation" in navigator) {
                const options = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                };
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Success
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;
                        
                        // Update UI
                        document.getElementById('userLocation').innerHTML = `${userLat.toFixed(6)}, ${userLng.toFixed(6)}`;
                        
                        // Calculate distance
                        let distance = calculateDistance(CENTER_LAT, CENTER_LNG, userLat, userLng);
                        const originalDistance = distance;
                        distance = Math.round(distance * 100) / 100;
                        
                        // Update distance display
                        const distanceText = formatDistance(distance);
                        document.getElementById('distanceValue').innerHTML = distanceText;
                        document.getElementById('blockedDistance').innerHTML = distanceText;
                        
                        // Check restriction
                        if (distance > MAX_RADIUS_KM) {
                            // BLOCK WEBSITE
                            document.getElementById('normalContent').style.display = 'none';
                            document.getElementById('blockedContent').style.display = 'block';
                            
                            const statusEl = document.getElementById('accessStatus');
                            statusEl.innerHTML = '⛔ ACCESS BLOCKED';
                            statusEl.className = 'status-badge status-blocked';
                            
                            // Show alerts
                            showAlert(`⚠️ RESTRICTION! You are ${distanceText} away. Allowed only ${MAX_RADIUS_KM} km!`, 'error');
                            alert(`⛔ ACCESS DENIED!\n\nYou are ${distanceText} away from the center.\nAllowed radius: ${MAX_RADIUS_KM} km\n\nWebsite has been blocked.`);
                            
                            // Log to console
                            console.log('🚫 Website Blocked:', {
                                distance: distanceText,
                                userLocation: `${userLat}, ${userLng}`,
                                timestamp: new Date().toISOString()
                            });
                            
                        } else {
                            // ALLOW WEBSITE
                            document.getElementById('normalContent').style.display = 'block';
                            document.getElementById('blockedContent').style.display = 'none';
                            
                            const statusEl = document.getElementById('accessStatus');
                            statusEl.innerHTML = '✅ ACCESS GRANTED';
                            statusEl.className = 'status-badge status-allowed';
                            
                            // Show success alert (only if not too close to avoid spam)
                            if (distance > 0.1) {
                                showAlert(`✅ Access granted! You are ${distanceText} away.`, 'success');
                            }
                        }
                        
                        hideLoading();
                    },
                    function(error) {
                        // Error
                        let errorMessage = '';
                        let alertMessage = '';
                        
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = 'Permission denied';
                                alertMessage = '❌ PERMISSION DENIED!\n\nYou denied location access.\nWebsite has been blocked.\nPlease allow location access and refresh.';
                                showAlert('❌ Permission denied! Website blocked.', 'error');
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = 'Position unavailable';
                                alertMessage = '❌ LOCATION UNAVAILABLE!\n\nCould not get your location.\nWebsite has been blocked.';
                                showAlert('❌ Location unavailable! Website blocked.', 'error');
                                break;
                            case error.TIMEOUT:
                                errorMessage = 'Timeout';
                                alertMessage = '⏰ TIMEOUT!\n\nLocation request timed out.\nWebsite has been blocked.';
                                showAlert('⏰ Timeout! Website blocked.', 'error');
                                break;
                            default:
                                errorMessage = 'Unknown error';
                                alertMessage = '❌ ERROR!\n\nCould not get your location.\nWebsite has been blocked.';
                                showAlert('❌ Error getting location! Website blocked.', 'error');
                        }
                        
                        // Block website on error
                        document.getElementById('normalContent').style.display = 'none';
                        document.getElementById('blockedContent').style.display = 'block';
                        document.getElementById('accessStatus').innerHTML = '⛔ ACCESS BLOCKED (Location Error)';
                        document.getElementById('accessStatus').className = 'status-badge status-blocked';
                        document.getElementById('userLocation').innerHTML = 'Location unavailable';
                        document.getElementById('distanceValue').innerHTML = '-- km';
                        
                        alert(alertMessage);
                        console.error('Geolocation Error:', errorMessage);
                        hideLoading();
                    },
                    options
                );
            } else {
                // Browser doesn't support geolocation
                document.getElementById('normalContent').style.display = 'none';
                document.getElementById('blockedContent').style.display = 'block';
                document.getElementById('accessStatus').innerHTML = '⛔ BROWSER NOT SUPPORTED';
                document.getElementById('accessStatus').className = 'status-badge status-blocked';
                document.getElementById('userLocation').innerHTML = 'Not supported';
                
                showAlert('❌ Your browser does not support geolocation!', 'error');
                alert('❌ BROWSER NOT SUPPORTED!\n\nYour browser does not support geolocation.\nWebsite has been blocked.\nPlease use a modern browser.');
                hideLoading();
            }
        }
        
        // Check again
        function checkLocationAgain() {
            showAlert('🔄 Re-checking your location...', 'warning');
            setTimeout(() => {
                checkLocation();
            }, 500);
        }
        
        // ==================== INITIALIZE ====================
        // Check location when page loads
        window.addEventListener('load', function() {
            checkLocation();
        });
        
        // Optional: Check location every 30 seconds if user is allowed
        setInterval(function() {
            if (document.getElementById('normalContent').style.display !== 'none') {
                checkLocation();
            }
        }, 30000);
    </script>
</body>
</html>