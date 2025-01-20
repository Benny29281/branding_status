// Data pengguna (Hard-coded)
const users = {
    user: { username: "user", password: "user123", role: "user" },
    admin: { username: "admin", password: "admin123", role: "admin" },
    administrator: { username: "administrator", password: "admin1234", role: "administrator" }
};

// Menangani submit form login
document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('error-message');

    // Cek apakah username dan password cocok
    if (checkLogin(username, password)) {
        // Redirect ke halaman sesuai role
        const role = users[username].role;
        window.location.href = `${role}.html`;
    } else {
        errorMessage.style.display = 'block'; // Tampilkan pesan error jika login gagal
    }
});

// Fungsi untuk cek login
function checkLogin(username, password) {
    return users[username] && users[username].password === password;
}
