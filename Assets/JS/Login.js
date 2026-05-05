// Toggle between Login and Forgot Password views
function toggleViews(view) {
    const loginView = document.getElementById('loginView');
    const forgotView = document.getElementById('forgotView');
    if (view === 'forgot') {
        loginView.style.display = 'none';
        forgotView.style.display = 'flex';
    } else {
        loginView.style.display = 'flex';
        forgotView.style.display = 'none';
    }
}