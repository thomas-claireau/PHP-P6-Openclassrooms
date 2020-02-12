window.addEventListener('DOMContentLoaded', (event) => {
	const home = document.querySelector('body.home');

	if (home) {
		// Suppression d'une photo en ajax
		const linkLoadMoreContent = home.querySelector('.actions .load-more');

		if (linkLoadMoreContent) {
			linkLoadMoreContent.addEventListener('click', (e) => {
				e.preventDefault();
				linkLoadMoreContent.classList.add('load');

				fetch(linkLoadMoreContent.getAttribute('href'), {
					method: 'GET',
					headers: {
						'X-Requested-With': 'XMLHttpRequest',
						'Content-Type': 'application/json',
					},
				})
					.then((response) => response.json())
					.then((data) => {
						if (data) {
							data.forEach((item) => {
								const name = data.name ? data.name : '';
							});
						} else {
							alert(data.error);
						}
					})
					.catch((e) => alert(e))
					.finally(() => {
						linkLoadMoreContent.classList.remove('load');
					});
			});
		}
	}
});
