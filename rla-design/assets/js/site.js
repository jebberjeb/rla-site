/**
 * RLA New Design: mobile menu and dropdown submenus.
 */
(function () {
	'use strict';

	var body = document.body;
	var toggle = document.querySelector('.rla-nav-toggle');
	var nav = document.getElementById('rla-nav');

	function setMenuOpen(open) {
		if (!toggle) {
			return;
		}
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		body.classList.toggle('rla-nav-open', open);
	}

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			setMenuOpen(toggle.getAttribute('aria-expanded') !== 'true');
		});
	}

	// A toggle button next to each parent menu item, for touch and keyboard.
	var parents = document.querySelectorAll('.rla-nav__list .menu-item-has-children');

	function closeAll(except) {
		Array.prototype.forEach.call(parents, function (li) {
			if (li === except) {
				return;
			}
			li.classList.remove('is-open');
			var btn = li.querySelector(':scope > .rla-subtoggle');
			if (btn) {
				btn.setAttribute('aria-expanded', 'false');
			}
		});
	}

	Array.prototype.forEach.call(parents, function (li, index) {
		var link = li.querySelector(':scope > a');
		var sub = li.querySelector(':scope > .sub-menu');
		if (!link || !sub) {
			return;
		}

		var id = sub.id || 'rla-submenu-' + index;
		sub.id = id;

		var btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'rla-subtoggle';
		btn.setAttribute('aria-expanded', 'false');
		btn.setAttribute('aria-controls', id);

		var label = document.createElement('span');
		label.className = 'screen-reader-text';
		label.textContent = 'Show ' + link.textContent.trim() + ' pages';
		btn.appendChild(label);

		link.insertAdjacentElement('afterend', btn);

		btn.addEventListener('click', function (event) {
			event.stopPropagation();
			var open = !li.classList.contains('is-open');
			closeAll(li);
			li.classList.toggle('is-open', open);
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	});

	document.addEventListener('click', function (event) {
		if (!event.target.closest('.rla-nav__list')) {
			closeAll(null);
		}
	});

	document.addEventListener('keydown', function (event) {
		if (event.key !== 'Escape') {
			return;
		}
		var openItem = document.querySelector('.rla-nav__list .is-open');
		if (openItem) {
			closeAll(null);
			var btn = openItem.querySelector(':scope > .rla-subtoggle');
			if (btn) {
				btn.focus();
			}
		} else if (body.classList.contains('rla-nav-open')) {
			setMenuOpen(false);
			toggle.focus();
		}
	});
})();
