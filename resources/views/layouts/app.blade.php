<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'الميثاق')</title>
    <meta name="description"
        content="متخصصة في إلحاق العمالة المصرية بالخارج، تربط الكفاءات المصرية بفرص العمل في الخارج مع ضمان المصداقية والسرعة والأمان.">

    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #174A7C;
            --secondary-color: #174A7C;
            --accent-color: #B89C5A;
            --text-color: #174A7C;
            --light-bg: #ffffff;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--white);
        }

        .navbar {
            background: #174A7C !important;
            box-shadow: 0 2px 10px rgba(23, 74, 124, 0.2);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: #174A7C !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(23, 74, 124, 0.3);
        }

        .navbar-brand:hover .logo-glow {
            opacity: 1;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .nav-link:hover,
        .navbar-nav .nav-link.active,
        .navbar-nav .nav-link:focus {
            color: #174A7C !important;
            background: #B89C5A !important;
            fill: #174A7C !important;
            transform: translateY(-2px);
            border-radius: 6px !important;
        }

        .nav-link:hover i,
        .navbar-nav .nav-link.active i,
        .navbar-nav .nav-link:focus i {
            color: #174A7C !important;
            fill: #174A7C !important;
        }

        .dropdown-item:hover {
            background: rgba(184, 156, 90, 0.1);
            color: #B89C5A;
            transform: translateX(5px);
        }

        .whatsapp-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
            background: #25d366 !important;
        }

        .whatsapp-btn:active {
            transform: translateY(-1px);
        }

        .navbar-brand,
        .navbar-brand *,
        .nav-link,
        .nav-link *,
        .navbar-nav i {
            color: #fff !important;
            fill: #fff !important;
            transition: color 0.3s;
        }

        .hero-section {
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            color: var(--white);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,100 1000,0 1000,100"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .btn-primary {
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        }

        .service-card {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--white);
            font-size: 2rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 50px;
            color: var(--text-color);
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #6b7280;
            text-align: center;
            margin-bottom: 60px;
        }

        .footer {
            background: var(--text-color);
            color: var(--white);
            padding: 50px 0 20px;
        }

        .footer h5 {
            color: var(--accent-color);
            margin-bottom: 20px;
        }

        .social-links a {
            color: var(--white);
            font-size: 1.5rem;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--accent-color);
        }

        .stats-card {
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            color: var(--white);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .stats-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stats-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* تحسينات جديدة لقسم الإحصائيات */
        .stats-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 50%, #c7d2fe 100%);
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%23ffffff" opacity="0.05"><circle cx="20" cy="20" r="2"/><circle cx="80" cy="40" r="1.5"/><circle cx="40" cy="80" r="1"/><circle cx="90" cy="90" r="1.5"/><circle cx="10" cy="60" r="1"/></svg>');
            background-size: 100px 100px;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .stats-card-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .stats-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .stats-card-modern:hover::before {
            left: 100%;
        }

        .stats-card-modern:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.2);
        }

        .stats-icon-modern {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .stats-card-modern:hover .stats-icon-modern {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .stats-number-modern {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            line-height: 1;
        }

        .stats-label-modern {
            font-size: 1.2rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0;
        }

        .stats-subtitle {
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 5px;
        }

        .stats-card-modern .pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 0;
            }
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .section-title-modern {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .section-subtitle-modern {
            font-size: 1.1rem;
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto;
        }

        /* تحسينات جديدة لقسم الخدمات */
        .services-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            position: relative;
            overflow: hidden;
        }

        .services-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%23174A7C" opacity="0.03"><polygon points="50,0 100,50 50,100 0,50"/></svg>');
            background-size: 60px 60px;
            animation: float 25s ease-in-out infinite;
        }

        .service-card-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .service-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .service-card-modern:hover::before {
            left: 100%;
        }

        .service-card-modern:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.2);
        }

        .service-icon-modern {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 2.5rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .service-card-modern:hover .service-icon-modern {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
        }

        .service-title-modern {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .service-description-modern {
            font-size: 1rem;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .service-btn-modern {
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .service-btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .service-btn-modern:hover::before {
            left: 100%;
        }

        .service-btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }

        .service-card-modern .pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 50%;
            animation: pulse 3s infinite;
        }

        .services-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .services-title-modern {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .services-subtitle-modern {
            font-size: 1.2rem;
            color: #6b7280;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .service-card {
                margin-bottom: 30px;
            }
        }

        /* Visa Services Section Styles */
        .visa-services-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
            overflow: hidden;
        }

        .visa-services-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%23174A7C" opacity="0.03"><circle cx="20" cy="20" r="2"/><circle cx="80" cy="40" r="1.5"/><circle cx="40" cy="80" r="1"/><circle cx="90" cy="90" r="1.5"/><circle cx="10" cy="60" r="1"/></svg>');
            background-size: 80px 80px;
            animation: float 25s ease-in-out infinite;
        }

        .visa-card-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .visa-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .visa-card-modern:hover::before {
            left: 100%;
        }

        .visa-card-modern:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.2);
        }

        .visa-icon-modern {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .visa-card-modern:hover .visa-icon-modern {
            transform: scale(1.1) rotate(5deg);
        }

        .visa-region-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .visa-countries-list {
            list-style: none;
            padding: 0;
            margin-bottom: 25px;
        }

        .visa-countries-list li {
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .visa-card-modern:hover .visa-countries-list li {
            color: #374151;
            transform: translateX(5px);
        }

        .visa-btn-modern {
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .visa-btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .visa-btn-modern:hover::before {
            left: 100%;
        }

        .visa-btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
            color: white;
            text-decoration: none;
        }

        .visa-services-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .visa-services-title-modern {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .visa-services-subtitle-modern {
            font-size: 1.2rem;
            color: #6b7280;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Features Section Styles */
        .features-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            position: relative;
            overflow: hidden;
        }

        .features-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%23174A7C" opacity="0.02"><polygon points="50,0 100,50 50,100 0,50"/><circle cx="25" cy="25" r="3"/><circle cx="75" cy="75" r="2"/><circle cx="75" cy="25" r="2"/><circle cx="25" cy="75" r="3"/></svg>');
            background-size: 100px 100px;
            animation: float 30s ease-in-out infinite;
        }

        .feature-card-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .feature-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .feature-card-modern:hover::before {
            left: 100%;
        }

        .feature-card-modern:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.2);
        }

        .feature-icon-modern {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 2.5rem;
            position: relative;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .feature-card-modern:hover .feature-icon-modern {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        }

        .feature-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-description {
            font-size: 1rem;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .feature-card-modern .pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            border: 2px solid rgba(37, 99, 235, 0.3);
            border-radius: 50%;
            animation: pulse 3s infinite;
        }

        .features-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .features-title-modern {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .features-subtitle-modern {
            font-size: 1.2rem;
            color: #6b7280;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* CTA Section Styles */
        .cta-section {
            background: linear-gradient(135deg, #174A7C 0%, #B89C5A 50%, #f093fb 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%23ffffff" opacity="0.1"><circle cx="20" cy="20" r="2"/><circle cx="80" cy="40" r="1.5"/><circle cx="40" cy="80" r="1"/><circle cx="90" cy="90" r="1.5"/><circle cx="10" cy="60" r="1"/><polygon points="50,10 90,50 50,90 10,50"/></svg>');
            background-size: 120px 120px;
            animation: float 25s ease-in-out infinite;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .cta-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 3rem;
            color: white;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        .cta-icon:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.3);
        }

        .cta-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .cta-subtitle {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.95;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .cta-btn-primary {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border: none;
            border-radius: 50px;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.4);
            position: relative;
            overflow: hidden;
        }

        .cta-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .cta-btn-primary:hover::before {
            left: 100%;
        }

        .cta-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(251, 191, 36, 0.6);
            color: #1f2937;
            text-decoration: none;
        }

        .cta-btn-secondary {
            background: linear-gradient(135deg, #10b981, #34d399);
            border: none;
            border-radius: 50px;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
            position: relative;
            overflow: hidden;
        }

        .cta-btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .cta-btn-secondary:hover::before {
            left: 100%;
        }

        .cta-btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.6);
            color: white;
            text-decoration: none;
        }

        .cta-features {
            margin-top: 50px;
        }

        .cta-feature {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            opacity: 0.9;
            transition: all 0.3s ease;
        }

        .cta-feature:hover {
            opacity: 1;
            transform: translateY(-2px);
        }

        .cta-feature i {
            font-size: 1.3rem;
            color: #fbbf24;
        }

        @media (max-width: 768px) {
            .cta-title {
                font-size: 2.2rem;
            }

            .cta-subtitle {
                font-size: 1.1rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .cta-btn-primary,
            .cta-btn-secondary {
                width: 100%;
                max-width: 300px;
            }
        }

        /* Footer Modern Styles */
        .footer-modern {
            background: linear-gradient(135deg, #174A7C 0%, #B89C5A 100%);
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .footer-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%23ffffff" opacity="0.05"><circle cx="20" cy="20" r="2"/><circle cx="80" cy="40" r="1.5"/><circle cx="40" cy="80" r="1"/><circle cx="90" cy="90" r="1.5"/><circle cx="10" cy="60" r="1"/><polygon points="50,10 90,50 50,90 10,50"/></svg>');
            background-size: 100px 100px;
            animation: float 30s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            25% {
                transform: translateY(-10px) rotate(1deg);
            }

            50% {
                transform: translateY(-5px) rotate(-1deg);
            }

            75% {
                transform: translateY(-15px) rotate(0.5deg);
            }
        }

        .footer-content {
            position: relative;
            z-index: 2;
            padding: 60px 0 40px;
        }

        .footer-brand {
            text-align: center;
        }

        .footer-logo {
            margin-bottom: 20px;
        }

        .footer-logo img {
            height: 80px;
            width: auto;
            max-width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .footer-logo img:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .footer-brand-title {
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 15px;
        }

        .footer-description {
            font-size: 1rem;
            line-height: 1.6;
            color: #e0f2fe;
            margin-bottom: 25px;
        }

        .footer-social {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .social-link {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
            color: #ffffff;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        }

        .social-link.whatsapp:hover {
            background: linear-gradient(135deg, #25d366, #128c7e);
            border-color: #25d366;
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
        }

        .footer-section {
            text-align: center;
        }

        .footer-section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #e0f2fe;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
        }

        .footer-links a::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            transition: width 0.3s ease;
        }

        .footer-links a:hover {
            color: #ffffff;
            transform: translateX(5px);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .footer-links a:hover::before {
            width: 100%;
        }

        .footer-section-title i {
            transition: all 0.3s ease;
        }

        .footer-section:hover .footer-section-title i {
            transform: scale(1.2);
            color: #B89C5A;
        }

        .footer-bottom {
            position: relative;
            z-index: 2;
            padding: 30px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(15px);
        }

        .footer-copyright {
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-copyright i {
            color: #fbbf24;
            font-size: 1rem;
        }

        .footer-info {
            display: flex;
            gap: 25px;
            justify-content: flex-end;
            flex-wrap: wrap;
            align-items: center;
        }

        .footer-tax,
        .footer-iso {
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .footer-tax:hover,
        .footer-iso:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.1);
        }

        .footer-brand:hover .footer-brand-title {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        .footer-section:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }

        .footer-tax i,
        .footer-iso i {
            color: #fbbf24;
            font-size: 1rem;
        }

        /* Responsive Footer Styles */
        @media (min-width: 1400px) {
            .footer-content {
                padding: 80px 0 50px;
            }

            .footer-brand-title {
                font-size: 2.2rem;
            }

            .footer-description {
                font-size: 1.1rem;
            }

            .footer-section-title {
                font-size: 1.3rem;
            }

            .footer-links a {
                font-size: 1rem;
            }

            .social-link {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
            }
        }

        @media (max-width: 1200px) {
            .footer-content {
                padding: 50px 0 35px;
            }

            .footer-brand-title {
                font-size: 1.8rem;
            }

            .footer-section-title {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 992px) {
            .footer-content {
                padding: 45px 0 30px;
            }

            .footer-brand-title {
                font-size: 1.6rem;
            }

            .footer-description {
                font-size: 0.95rem;
            }

            .footer-section-title {
                font-size: 1rem;
            }

            .footer-links a {
                font-size: 0.9rem;
            }

            .footer-info {
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .footer-content {
                padding: 40px 0 25px;
            }

            .footer-brand-title {
                font-size: 1.5rem;
            }

            .footer-description {
                font-size: 0.9rem;
                margin-bottom: 20px;
            }

            .footer-section {
                text-align: center;
                margin-bottom: 25px;
            }

            .footer-section-title {
                font-size: 1rem;
                margin-bottom: 15px;
            }

            .footer-links li {
                margin-bottom: 10px;
            }

            .footer-links a {
                font-size: 0.85rem;
            }

            .footer-info {
                justify-content: center;
                margin-top: 15px;
                gap: 15px;
            }

            .footer-copyright {
                justify-content: center;
                margin-bottom: 15px;
                text-align: center;
                font-size: 0.9rem;
            }

            .footer-tax,
            .footer-iso {
                font-size: 0.8rem;
                padding: 6px 12px;
            }

            .social-link {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }

            .footer-social {
                gap: 12px;
            }
        }

        @media (max-width: 576px) {
            .footer-content {
                padding: 35px 0 20px;
            }

            .footer-brand-title {
                font-size: 1.4rem;
            }

            .footer-description {
                font-size: 0.85rem;
                margin-bottom: 18px;
            }

            .footer-section-title {
                font-size: 0.95rem;
                margin-bottom: 12px;
            }

            .footer-links a {
                font-size: 0.8rem;
            }

            .footer-copyright {
                font-size: 0.85rem;
            }

            .footer-tax,
            .footer-iso {
                font-size: 0.75rem;
                padding: 5px 10px;
            }

            .social-link {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }

            .footer-logo img {
                height: 60px;
                padding: 8px;
            }

            .footer-social {
                gap: 10px;
            }

            .footer-info {
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .footer-content {
                padding: 30px 0 15px;
            }

            .footer-brand-title {
                font-size: 1.3rem;
            }

            .footer-description {
                font-size: 0.8rem;
            }

            .footer-section-title {
                font-size: 0.9rem;
            }

            .footer-links a {
                font-size: 0.75rem;
            }

            .footer-copyright {
                font-size: 0.8rem;
            }

            .footer-tax,
            .footer-iso {
                font-size: 0.7rem;
                padding: 4px 8px;
            }

            .social-link {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .footer-logo img {
                height: 50px;
                padding: 6px;
            }

            .footer-social {
                gap: 8px;
            }

            .footer-info {
                gap: 8px;
            }
        }

        @media (max-width: 360px) {
            .footer-content {
                padding: 25px 0 10px;
            }

            .footer-brand-title {
                font-size: 1.2rem;
            }

            .footer-description {
                font-size: 0.75rem;
            }

            .footer-section-title {
                font-size: 0.85rem;
            }

            .footer-links a {
                font-size: 0.7rem;
            }

            .footer-copyright {
                font-size: 0.75rem;
            }

            .footer-tax,
            .footer-iso {
                font-size: 0.65rem;
                padding: 3px 6px;
            }

            .social-link {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
            }

            .footer-logo img {
                height: 45px;
                padding: 5px;
            }

            .footer-social {
                gap: 8px;
            }

            .footer-info {
                gap: 6px;
            }
        }
        }
        }

        @media (max-width: 575.98px) {
            .d-flex.align-items-center.ms-4 {
                display: none !important;
            }
        }

        /* Hero Section Modern Styles */
        .hero-section-modern {
            background: linear-gradient(135deg, #174A7C, #B89C5A);
            min-height: 600px;
            position: relative;
            overflow: hidden;
            padding: 80px 0;
        }

        .hero-section-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%23ffffff" opacity="0.05"><circle cx="20" cy="20" r="2"/><circle cx="80" cy="40" r="1.5"/><circle cx="40" cy="80" r="1"/><circle cx="90" cy="90" r="1.5"/><circle cx="10" cy="60" r="1"/><polygon points="50,10 90,50 50,90 10,50"/></svg>');
            background-size: 120px 120px;
            animation: float 25s ease-in-out infinite;
        }

        .hero-content-modern {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-title-modern {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 25px;
            line-height: 1.2;
            background: linear-gradient(135deg, #ffffff, #f0f9ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle-modern {
            font-size: 1.3rem;
            margin-bottom: 35px;
            color: #e0f2fe;
            line-height: 1.6;
            opacity: 0.95;
        }

        .hero-buttons-modern {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .hero-btn-primary {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border: none;
            border-radius: 50px;
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.4);
            position: relative;
            overflow: hidden;
        }

        .hero-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .hero-btn-primary:hover::before {
            left: 100%;
        }

        .hero-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(251, 191, 36, 0.6);
            color: #1f2937;
            text-decoration: none;
        }

        .hero-btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        }

        .hero-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .hero-features {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .hero-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e0f2fe;
            font-size: 1rem;
            font-weight: 600;
        }

        .hero-feature i {
            color: #fbbf24;
            font-size: 1.2rem;
        }

        .hero-image-container {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .hero-logo-wrapper {
            position: relative;
            display: inline-block;
        }

        .hero-logo {
            height: 280px;
            width: auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .hero-logo:hover {
            transform: scale(1.05);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
        }

        .hero-logo-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            border-radius: 30px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .hero-logo-wrapper:hover .hero-logo-glow {
            opacity: 1;
        }

        .hero-floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }

        .floating-element {
            position: absolute;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            animation: float 6s ease-in-out infinite;
        }

        .element-1 {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .element-2 {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .element-3 {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @media (max-width: 768px) {
            .hero-section-modern {
                padding: 60px 0;
                min-height: 500px;
            }

            .hero-title-modern {
                font-size: 2.5rem;
            }

            .hero-subtitle-modern {
                font-size: 1.1rem;
            }

            .hero-buttons-modern {
                flex-direction: column;
                align-items: center;
            }

            .hero-btn-primary,
            .hero-btn-secondary {
                width: 100%;
                max-width: 300px;
            }

            .hero-features {
                justify-content: center;
                gap: 20px;
            }

            .hero-logo {
                height: 220px;
            }
        }

        body {
            background: #fff !important;
            color: #174A7C !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .section-title,
        .section-title-modern,
        .services-title-modern,
        .features-title-modern,
        .cta-title,
        .footer-brand-title {
            color: #174A7C !important;
        }

        a,
        .nav-link,
        .footer-links a,
        .service-title-modern,
        .feature-title,
        .creative-service-title {
            color: #174A7C !important;
            transition: color 0.3s;
        }

        a:hover,
        .nav-link:hover,
        .footer-links a:hover,
        .service-title-modern:hover,
        .feature-title:hover,
        .creative-service-title:hover {
            color: #B89C5A !important;
        }

        .btn,
        .btn-primary,
        .service-btn-modern,
        .creative-service-btn,
        .cta-btn-primary {
            background: #174A7C !important;
            color: #fff !important;
            border: none !important;
            transition: background 0.3s, color 0.3s;
        }

        .btn:hover,
        .btn-primary:hover,
        .service-btn-modern:hover,
        .creative-service-btn:hover,
        .cta-btn-primary:hover {
            background: #B89C5A !important;
            color: #fff !important;
        }

        .feature-icon-modern,
        .creative-service-icon,
        .cta-icon {
            background: #fff !important;
            color: #174A7C !important;
            border: 2px solid #174A7C33 !important;
            transition: color 0.3s, border-color 0.3s;
        }

        .feature-card-modern:hover .feature-icon-modern,
        .creative-service-card:hover .creative-service-icon,
        .cta-icon:hover {
            color: #B89C5A !important;
            border-color: #B89C5A !important;
        }

        .footer-modern,
        .footer-content {
            background: #fff !important;
            color: #174A7C !important;
        }

        .footer-section-title,
        .footer-brand-title {
            color: #174A7C !important;
        }

        .footer-links a {
            color: #174A7C !important;
        }

        .footer-links a:hover {
            color: #B89C5A !important;
        }

        .golden-line {
            background: #174A7C !important;
            transition: background 0.3s;
        }

        .creative-service-card:hover .golden-line {
            background: #B89C5A !important;
        }

        @media (min-width: 992px) {
            .navbar-nav {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                align-items: center;
                gap: 8px;
                width: auto;
                white-space: nowrap;
            }
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                justify-content: center !important;
                text-align: center !important;
                align-items: center !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    @if (empty($hideHeaderFooter))
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top"
            style="background: #174A7C; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-3 me-4" href="{{ url('/') }}"
                    style="transition: all 0.3s ease;">
                    <div class="logo-container" style="position: relative; display: inline-block;">
                        <img src="{{ asset('images/logo-methaq.png') }}" alt="الميثاق Logo"
                            style="height: 60px; width: auto; background: linear-gradient(135deg, #fff 0%, #f8fafc 100%); border-radius: 18px; padding: 8px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px rgba(0,0,0,0.15); transition: all 0.3s ease;">
                        <div class="logo-glow"
                            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent); border-radius: 18px; opacity: 0; transition: opacity 0.3s ease;">
                        </div>
                    </div>
                    <div class="brand-text">
                        <span
                            style="font-weight: 800; font-size: 1.5rem; background: linear-gradient(45deg, #fff, #f0f9ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">الميثاق</span>
                        <div
                            style="font-size: 0.8rem; color: rgba(255,255,255,0.8); font-weight: 400; margin-top: -2px;">
                            إلحاق العمالة المصرية بالخارج</div>
                    </div>
                </a>
                <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    style="border: 2px solid rgba(255,255,255,0.3); border-radius: 8px; padding: 8px 12px;">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse flex-grow-1" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link d-flex align-items-center gap-1"
                                href="{{ route('home') }}"><i class="fas fa-home"></i><span>الرئيسية</span></a></li>
                        <li class="nav-item"><a class="nav-link d-flex align-items-center gap-1"
                                href="{{ route('jobs') }}"><i class="fas fa-briefcase"></i><span>فرص العمل
                                    بالخارج</span></a></li>
                        <li class="nav-item"><a class="nav-link d-flex align-items-center gap-1"
                                href="{{ route('register') }}"><i class="fas fa-user-plus"></i><span>تسجيل
                                    العمالة</span></a></li>
                        <li class="nav-item"><a class="nav-link d-flex align-items-center gap-1"
                                href="{{ route('companies') }}"><i class="fas fa-building"></i><span>طلبات
                                    الشركات</span></a></li>
                        <li class="nav-item"><a class="nav-link d-flex align-items-center gap-1"
                                href="{{ route('tips') }}"><i class="fas fa-lightbulb"></i><span>نصائح
                                    وإرشادات</span></a></li>
                        <li class="nav-item"><a class="nav-link d-flex align-items-center gap-1"
                                href="{{ route('contact') }}"><i class="fas fa-phone"></i><span>اتصل بنا</span></a>
                        </li>
                    </ul>
                </div>
                <div class="d-none d-md-flex align-items-center ms-4">
                    <a href="https://wa.me/201288000245" target="_blank" class="btn whatsapp-btn"
                        style="background: #008000 !important; border: none; border-radius: 50px; padding: 12px 24px; font-weight: 600; color: white; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(184, 156, 90, 0.3); display: flex; align-items: center; gap: 8px; text-decoration: none;">
                        <i class="fab fa-whatsapp" style="font-size: 1.2rem;"></i>
                        <span>تواصل معنا</span>
                    </a>
                </div>
            </div>
        </nav>
    @endif

    <!-- Main Content -->
    <main @if (!empty($hideHeaderFooter)) style="margin-top:0;" @else style="margin-top: 80px;" @endif>
        @yield('content')
    </main>

    <!-- Footer -->
    @if (empty($hideHeaderFooter))
        <footer class="py-4" style="background: #174A7C; border-top: 1px solid #B89C5A;">
            <div class="container">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-3 mb-2">
                    <a href="https://wa.me/201288000245" target="_blank" class="text-decoration-none"
                        title="واتساب">
                        <i class="fab fa-whatsapp fa-2x" style="color: #25d366;"></i>
                    </a>
                    <a href="https://www.facebook.com/elmethaq.co" target="_blank" class="text-decoration-none"
                        title="فيسبوك">
                        <i class="fab fa-facebook-f fa-2x" style="color: #fff;"></i>
                </div>
                <div class="text-center small" style="color:#fff !important;">
                    <a href="https://www.facebook.com/elmethaq.co" target="_blank" class="text-decoration-none"
                        title="فيسبوك" style="color:#fff !important;">
                        جميع الحقوق محفوظة © 2025
                        <span class="mx-2" style="color:#fff !important;">|</span>
                        <a href="{{ url('privacy') }}" class="text-white text-decoration-underline"
                            style="color:#fff !important;">سياسة الخصوصية</a>
                        <span class="mx-2" style="color:#fff !important;">|</span>
                        <a href="{{ url('delete-account') }}" class="text-white text-decoration-underline"
                            style="color:#fff !important;">طلب حذف الحساب</a>
                    </a>
                </div>
            </div>
        </footer>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // تأثير الهيدر عند التمرير
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // تفعيل تأثيرات القوائم المنسدلة
        document.addEventListener('DOMContentLoaded', function() {
            // إضافة تأثيرات للروابط
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                link.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // تفعيل تأثيرات القائمة المنسدلة
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // تفعيل تأثيرات زر الواتساب
            const whatsappBtn = document.querySelector('.whatsapp-btn');
            if (whatsappBtn) {
                whatsappBtn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });

                whatsappBtn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            }
        });

        // تحسين تجربة المستخدم للهاتف المحمول
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        if (navbarToggler && navbarCollapse) {
            navbarToggler.addEventListener('click', function() {
                setTimeout(() => {
                    if (navbarCollapse.classList.contains('show')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = 'auto';
                    }
                }, 100);
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
