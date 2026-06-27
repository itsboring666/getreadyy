@extends('layouts.front')
@section('title', 'Meet the Developer | GET READY')

@section('content')

<section style="background: var(--bg); padding: 80px 24px; min-height: 70vh; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 600px; width: 100%; background: #111111; padding: 50px 40px; border: 1px solid var(--border); box-shadow: 0 20px 40px rgba(0,0,0,0.6); text-align: center; border-radius: 12px; position: relative; overflow: hidden;">
        
        <div style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: var(--accent); filter: blur(80px); opacity: 0.15; z-index: 0;"></div>
        <div style="position: absolute; bottom: -50px; right: -50px; width: 150px; height: 150px; background: #0077b5; filter: blur(80px); opacity: 0.15; z-index: 0;"></div>

        <div style="position: relative; z-index: 1;">
            <div style="font-size: 11px; letter-spacing: 3px; color: var(--accent); font-family: var(--font); font-weight: 700; margin-bottom: 16px; text-transform: uppercase;">Meet the Developer</div>
            <h1 style="font-family: var(--font-heading); font-size: clamp(32px, 5vw, 48px); color: var(--white); margin-bottom: 24px; line-height: 1.1;">KATHIR CHELVAN</h1>
            
            <p style="font-family: var(--font); font-size: 15px; color: var(--text-secondary); line-height: 1.8; margin-bottom: 40px;">
                The digital architect behind the GET READY platform. Passionate about building seamless, modern, and high-performance e-commerce experiences that connect brands with real people.
            </p>
    
            <div style="display: flex; flex-direction: column; gap: 16px; align-items: center;">
                <a href="https://www.linkedin.com/in/kathirchelvan-ilamparithim-76666828a/" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; max-width: 320px; padding: 14px 24px; background: #0077b5; color: #fff; text-decoration: none; font-family: var(--font); font-size: 12px; font-weight: 700; letter-spacing: 1px; border-radius: 4px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(0, 119, 181, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <i class="fab fa-linkedin" style="font-size: 16px;"></i> CONNECT ON LINKEDIN
                </a>
                
                <a href="https://www.instagram.com/_.kathir_chelvan._?igsh=a252N21pZjU4c2Rn&utm_source=qr" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; max-width: 320px; padding: 14px 24px; background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); color: #fff; text-decoration: none; font-family: var(--font); font-size: 12px; font-weight: 700; letter-spacing: 1px; border-radius: 4px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(220, 39, 67, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <i class="fab fa-instagram" style="font-size: 16px;"></i> FOLLOW ON INSTAGRAM
                </a>
    
                <a href="mailto:kathirkim2006@gmail.com" style="display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; max-width: 320px; padding: 14px 24px; background: #1a1a1a; border: 1px solid #333; color: #fff; text-decoration: none; font-family: var(--font); font-size: 12px; font-weight: 700; letter-spacing: 1px; border-radius: 4px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.borderColor='var(--accent)';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#333';">
                    <i class="fas fa-envelope" style="font-size: 16px;"></i> EMAIL: KATHIRKIM2006@GMAIL.COM
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
