window.addEventListener('DOMContentLoaded', (event) => {
	const figureShowPage = document.querySelector('body.figure-show');

	if (figureShowPage) {
		const iframes = document.querySelectorAll('iframe');

		if (iframes) {
			iframes.forEach((iframe) => {
				iframe.addEventListener('load', () => {
					console.log(iframe);
					iframe.addEventListener('click', () => {
						figureShowPage.classList.add('iframe-open');
					});
				});
			});
		}
	}
});
