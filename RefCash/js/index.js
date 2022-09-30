
const qs = selector => document.querySelector(selector); //qs function for selecting DOM elements using css like selectors

//Setting footer copyright---------------------

const addFooterCopyRight = () => {
	let d = new Date(), domContainer = qs("#page-footer>#ft-copyright>div>span");
	let currentYear = d.getFullYear();
	domContainer.innerHTML = " &copy; "+currentYear;
}

qs("body").onscroll = () => this.setAttribute('class', 'img-2-animation');

//---------------------------------------------

