const accountOCL_button = qs("#account-o-c-l"), accountOCR_button = qs("#account-o-c-r"), signup_div = qs("#signup-div"), login_div = qs("#login-div");


const signup_show = () => {
	signup_div.style.display = "block";
	login_div.style.display = "none";
}
const login_show = () => {
	signup_div.style.display = "none";
	login_div.style.display = "block";
}

accountOCL_button.onclick = () => signup_show();
accountOCR_button.onclick = () => login_show();