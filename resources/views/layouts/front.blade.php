<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GET READY — Premium Menswear')</title>
    <meta name="description"
        content="@yield('meta_description', 'Shop premium menswear at GET READY. Tees, shirts, jeans, jackets and more.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Courier+Prime:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/hm-style.css') }}">
    <style>
        /* ── Global Toast Notification System ── */
        #gr-toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .gr-toast {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-width: 300px;
            max-width: 400px;
            padding: 16px 18px;
            border-radius: 0;
            border-left: 4px solid;
            font-family: 'Space Mono', monospace;
            font-size: 12px;
            line-height: 1.5;
            letter-spacing: 0.03em;
            pointer-events: all;
            cursor: default;
            transform: translateX(110%);
            opacity: 0;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease;
            position: relative;
            box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.5);
        }

        .gr-toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .gr-toast.hide {
            transform: translateX(110%);
            opacity: 0;
        }

        .gr-toast-success {
            background: #0d2016;
            border-color: #16a34a;
            color: #86efac;
        }

        .gr-toast-error {
            background: #1a0808;
            border-color: #991b1b;
            color: #fca5a5;
        }

        .gr-toast-warning {
            background: #1a1400;
            border-color: #ca8a04;
            color: #fcd34d;
        }

        .gr-toast-info {
            background: #0a0f1a;
            border-color: #3b82f6;
            color: #93c5fd;
        }

        .gr-toast-icon {
            font-size: 16px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .gr-toast-body {
            flex: 1;
        }

        .gr-toast-title {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 10px;
            margin-bottom: 3px;
            opacity: 0.75;
        }

        .gr-toast-msg {
            font-size: 12px;
        }

        .gr-toast-close {
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            opacity: 0.5;
            font-size: 14px;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
            transition: opacity 0.2s;
        }

        .gr-toast-close:hover {
            opacity: 1;
        }

        .gr-toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            background: currentColor;
            opacity: 0.35;
            animation: gr-toast-shrink 4.5s linear forwards;
        }

        @keyframes gr-toast-shrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

    </style>
    @yield('head')
</head>

<body>
    @include('partials.navbar')

    {{-- ── Global Toast Container ── --}}
    <div id="gr-toast-container" aria-live="polite" aria-atomic="false"></div>

    {{-- Pass PHP flash messages to JS --}}
    <script>
        window.__GR_TOASTS__ = [];
        @if(session('success'))
            window.__GR_TOASTS__.push({ type: 'success', msg: @json(session('success')) });
        @endif
        @if(session('error'))
            window.__GR_TOASTS__.push({ type: 'error', msg: @json(session('error')) });
        @endif
        @if($errors->any())
            @foreach($errors->all() as $err)
                window.__GR_TOASTS__.push({ type: 'error', msg: @json($err) });
            @endforeach
        @endif
        @if(session('warning'))
            window.__GR_TOASTS__.push({ type: 'warning', msg: @json(session('warning')) });
        @endif
        @if(session('info'))
            window.__GR_TOASTS__.push({ type: 'info', msg: @json(session('info')) });
        @endif
        @if(session('status'))
            window.__GR_TOASTS__.push({ type: 'info', msg: @json(session('status')) });
        @endif
    </script>

    <main id="main-content">
        @yield('content')
    </main>
    @include('partials.footer')

    <script>
        /* ── Toast Notification JS ── */
        (function () {
            var icons = { success: 'fas fa-check-circle', error: 'fas fa-times-circle', warning: 'fas fa-exclamation-triangle', info: 'fas fa-info-circle' };
            var labels = { success: 'Success', error: 'Error', warning: 'Notice', info: 'Info' };

            function showToast(type, msg) {
                var container = document.getElementById('gr-toast-container');
                var toast = document.createElement('div');
                toast.className = 'gr-toast gr-toast-' + type;
                toast.setAttribute('role', 'alert');
                toast.innerHTML =
                    '<i class="gr-toast-icon ' + (icons[type] || icons.info) + '"></i>' +
                    '<div class="gr-toast-body"><div class="gr-toast-title">' + (labels[type] || 'Notice') + '</div><div class="gr-toast-msg">' + msg + '</div></div>' +
                    '<button class="gr-toast-close" aria-label="Dismiss"><i class="fas fa-times"></i></button>' +
                    '<div class="gr-toast-progress"></div>';
                container.appendChild(toast);
                requestAnimationFrame(function () { requestAnimationFrame(function () { toast.classList.add('show'); }); });
                var timer = setTimeout(function () { dismiss(toast); }, 4500);
                toast.querySelector('.gr-toast-close').addEventListener('click', function () { clearTimeout(timer); dismiss(toast); });
            }

            function dismiss(toast) {
                toast.classList.remove('show'); toast.classList.add('hide');
                setTimeout(function () { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 450);
            }

            document.addEventListener('DOMContentLoaded', function () {
                (window.__GR_TOASTS__ || []).forEach(function (t, i) { setTimeout(function () { showToast(t.type, t.msg); }, i * 200); });
            });

            window.grToast = showToast;
        })();
    </script>

    @yield('scripts')
</body>

</html>