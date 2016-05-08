const BASE_URL = 'http://localhost';
var idbSupported = false;
 
if("indexedDB" in window) {
	idbSupported = true;
}

const AppConstants = {
	BASE_URL: BASE_URL,
	LOGIN_URL: BASE_URL + 'sessions/create',
	SIGNUP_URL: BASE_URL + 'users',
	ENTER_KEY_CODE: 13,
	SITE_TITLE: 'Bible Exchange',
	IDB_SUPPORTED: idbSupported
};

export default AppConstants;