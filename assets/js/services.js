/**
 * サービス詳細セクションに応じて
 * ナビリンクをハイライトするスクリプト
 */
(() => {
	const navLinks = document.querySelectorAll('.services__nav-link');
	const sections = [...document.querySelectorAll('.services__detail')];

	/* Smooth-scroll */
	navLinks.forEach(link => {
		link.addEventListener('click', e => {
			e.preventDefault();
			const target = document.querySelector(link.getAttribute('href'));
			target?.scrollIntoView({ behavior: 'smooth', block: 'start' });
		});
	});

	/* Intersection Observer */
	const observer = new IntersectionObserver(
		entries => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					navLinks.forEach(l => l.classList.toggle(
						'is-active',
						l.getAttribute('href').slice(1) === entry.target.id
					));
				}
			});
		},
		{
			rootMargin: '-40% 0px -40% 0px'
		}
	);

	sections.forEach(section => observer.observe(section));
})();
