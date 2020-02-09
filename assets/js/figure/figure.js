window.addEventListener('DOMContentLoaded', (event) => {
	const figureShowPage = document.querySelector('body.figure-show');
	const figureEditPage = document.querySelector('body.admin-figure-edit');

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

	if (figureEditPage) {
		const formRemoveFigure = figureEditPage.querySelector('#removeFigure');
		const containerToMove = figureEditPage.querySelector('.actions-form');

		if (formRemoveFigure && containerToMove) {
			containerToMove.appendChild(formRemoveFigure);
		}
	}
});
