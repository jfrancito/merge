@if (session('error'))
    <div id="floating-alert" class="floating-alert show">
        <span>{{ session('error') }}</span>
        <button class="close-btn" onclick="closeFloatingAlert()">&times;</button>
    </div>

    <script>
        function closeFloatingAlert() {
            const alert = document.getElementById('floating-alert');
            alert.classList.remove('show');
            alert.classList.add('hide');
            setTimeout(() => alert.remove(), 500);
        }

        // Desaparece automático a los 4s
        setTimeout(() => {
            closeFloatingAlert();
        }, 4000);
    </script>

    <style>
        .floating-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dc3545; /* rojo error */
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
            font-size: 15px;
            z-index: 9999;
            display: flex;
            align-items: center;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.4s, transform 0.4s;
        }

        .floating-alert.show {
            opacity: 1;
            transform: translateY(0);
        }

        .floating-alert.hide {
            opacity: 0;
            transform: translateY(-10px);
        }

        .floating-alert .close-btn {
            background: transparent;
            border: none;
            color: white;
            font-size: 20px;
            margin-left: 12px;
            cursor: pointer;
            line-height: 1;
        }

        .floating-alert .close-btn:hover {
            color: #ffdddd;
        }
    </style>
@endif


{{-- Validaciones --}}
@if ($errors->any())
    <div id="floating-alert" class="floating-alert show">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="close-btn" onclick="closeFloatingAlert()">&times;</button>
    </div>

    <script>
        function closeFloatingAlert() {
            const alert = document.getElementById('floating-alert');
            alert.classList.remove('show');
            alert.classList.add('hide');
            setTimeout(() => alert.remove(), 500);
        }

        setTimeout(() => {
            closeFloatingAlert();
        }, 4000);
    </script>
@endif
