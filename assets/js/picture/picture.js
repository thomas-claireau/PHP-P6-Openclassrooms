window.addEventListener('DOMContentLoaded', (event) => {
	const figureEdit = document.querySelector('body.admin-figure-edit');

	if (figureEdit) {
		// Suppression d'une photo en ajax
		const linksRemovePicture = figureEdit.querySelectorAll('.photos [data-delete]');

		if (linksRemovePicture) {
			linksRemovePicture.forEach((link) => {
				link.addEventListener('click', (e) => {
					e.preventDefault();
					fetch(link.getAttribute('href'), {
						method: 'DELETE',
						headers: {
							'X-Requested-With': 'XMLHttpRequest',
							'Content-Type': 'application/json',
						},
						body: JSON.stringify({ _token: link.dataset.token }),
					})
						.then((response) => response.json())
						.then((data) => {
							if (data.success) {
								const imageRemove = link.parentNode.parentNode;

								if (imageRemove) {
									imageRemove.remove();
								}

								const containerPictures = figureEdit.querySelector(
									'.medias .photos'
								);

								if (containerPictures) {
									const allPictures = containerPictures.querySelectorAll(
										'.photo'
									);

									if (allPictures && allPictures.length == 0) {
										containerPictures.remove();
									}
								}
							} else {
								alert(data.error);
							}
						})
						.catch((e) => alert(e));
				});
			});
		}
	}
});
