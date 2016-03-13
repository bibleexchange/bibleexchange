const BASE_URL = 'http://localhost/';
const SECURITY_TOKEN = document.getElementById('security-token').value;

const AppConstants = {
	BASE_URL: BASE_URL,
	LOGIN_URL: BASE_URL + 'sessions/create',
	SIGNUP_URL: BASE_URL + 'users',
	SECURITY_TOKEN: SECURITY_TOKEN
};

export default AppConstants;