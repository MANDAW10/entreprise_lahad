@if(session('success') || session('error') || $errors->any())
    <div class="toast-container" id="toast-container">
        @if(session('success'))
            <div class="toast-message toast-success">
                <i class="fas fa-check-circle"></i>
                <div class="toast-content">{{ session('success') }}</div>
                <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="toast-message toast-error">
                <i class="fas fa-exclamation-circle"></i>
                <div class="toast-content">{{ session('error') }}</div>
                <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
        @endif

        @if($errors->any())
            <div class="toast-message toast-error">
                <i class="fas fa-exclamation-circle"></i>
                <div class="toast-content">
                    <ul style="margin:0; padding-left:1rem;">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const toasts = document.querySelectorAll('.toast-message');
                toasts.forEach(toast => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-20px) scale(0.95)';
                    setTimeout(() => toast.remove(), 300);
                });
            }, 4000);
        });
    </script>
@endif
