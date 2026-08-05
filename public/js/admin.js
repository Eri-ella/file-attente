import '../css/admin.css';

function togglePassword() {
    document.querySelectorAll('.password-icon').forEach(wrap => {
        const input = wrap.parentElement?.querySelector('input[type="password"], input[type="text"]');
        const eyeOpen = wrap.querySelector('.eye-open, svg.feather-eye');
        const eyeClosed = wrap.querySelector('.eye-closed, svg.feather-eye-off');
        
        if (!input || !eyeOpen) return;
        
        wrap.addEventListener('click', () => {
            const isPwd = input.type === 'password';
            input.type = isPwd ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden', isPwd);
            if (eyeClosed) eyeClosed.classList.toggle('hidden', !isPwd);
        });
    });
}

document.addEventListener('DOMContentLoaded', togglePassword);